<?php
    define('INCLUDE_CHECK',true); // Activamos como Principal, para verificar los de mas formularios como dependientes.
//    require ("aut_sys_config.inc.php"); //consultar datos de variables
//    require("conexion/aut_config.inc.php"); //validar sessiones del usuario
    
    require("conexion/aut_verifica.inc.php"); //validar sessiones del usuario
    require ("funciones.php"); // llamado de funciones de la pagina
    //Conexion a la base de datos
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
    
    if (isset($_GET["view"])){
        $view=$_GET["view"];        
    }   
    // Error reporting:
    error_reporting(E_ALL^E_NOTICE);

    $cedula_usuario=$_SESSION['id'];
    $cod_unidad=$_SESSION['cod_unidad'];

//calculando porcentaje de ordenes completas
    $query = "SELECT COUNT(*) FROM ordenes, usuarios WHERE ordenes.cedula_usuario_orden = usuarios.cedula_usuario and ordenes.cedula_usuario_orden='$cedula_usuario'";
    $result = pg_query($query)or die(pg_last_error());
    $ordenes_totales=pg_fetch_row($result);  
    pg_free_result($result);

    $query = "SELECT COUNT(*) FROM ordenes, usuarios WHERE ordenes.cedula_usuario_orden = usuarios.cedula_usuario and ordenes.cedula_usuario_orden='$cedula_usuario' and ordenes.status_orden=2";
    $result = pg_query($query)or die(pg_last_error());
    $completadas=pg_fetch_row($result);  
    pg_free_result($result);

    $orden_eficiencia=(number_format(($completadas[0]*100)/($ordenes_totales[0])));

//calculando porcentaje de solicitudes normales completadas
    $query="SELECT COUNT(*) FROM ticket,detalles_ticket WHERE ticket.cod_ticket=detalles_ticket.cod_ticket and detalles_ticket.cod_unidad=$cod_unidad and ticket.prioridad_ticket = 1";               
    $result = pg_query($query)or die(pg_last_error());  
    $total_ticket_normal=pg_fetch_row($result);  
    pg_free_result($result);

    $query="SELECT COUNT(*) FROM ticket,detalles_ticket WHERE ticket.cod_ticket=detalles_ticket.cod_ticket and detalles_ticket.cod_unidad=$cod_unidad and ticket.prioridad_ticket = 1 and detalles_ticket.cod_estado_tramite=6";               
    $result = pg_query($query)or die(pg_last_error());  
    $ticket_normal_completado=pg_fetch_row($result);  
    pg_free_result($result);

    $prioridad_normal=(number_format(($ticket_normal_completado[0]*100)/($total_ticket_normal[0])));

//calculando porcentaje de solicitudes altas completadas
    $query="SELECT COUNT(*) FROM ticket,detalles_ticket WHERE ticket.cod_ticket=detalles_ticket.cod_ticket and detalles_ticket.cod_unidad=$cod_unidad and ticket.prioridad_ticket = 2";               
    $result = pg_query($query)or die(pg_last_error());  
    $total_ticket_alta=pg_fetch_row($result);  
    pg_free_result($result);

    $query="SELECT COUNT(*) FROM ticket,detalles_ticket WHERE ticket.cod_ticket=detalles_ticket.cod_ticket and detalles_ticket.cod_unidad=$cod_unidad and ticket.prioridad_ticket = 2 and detalles_ticket.cod_estado_tramite=6";               
    $result = pg_query($query)or die(pg_last_error());  
    $ticket_alta_completado=pg_fetch_row($result);  
    pg_free_result($result);

    $prioridad_alta=(number_format(($ticket_alta_completado[0]*100)/($total_ticket_alta[0])));

//calculando porcentaje de solicitudes urgente completadas
    $query="SELECT COUNT(*) FROM ticket,detalles_ticket WHERE ticket.cod_ticket=detalles_ticket.cod_ticket and detalles_ticket.cod_unidad=$cod_unidad and ticket.prioridad_ticket = 3";               
    $result = pg_query($query)or die(pg_last_error());  
    $total_ticket_urgente=pg_fetch_row($result);  
    pg_free_result($result);

    $query="SELECT COUNT(*) FROM ticket,detalles_ticket WHERE ticket.cod_ticket=detalles_ticket.cod_ticket and detalles_ticket.cod_unidad=$cod_unidad and ticket.prioridad_ticket = 3 and detalles_ticket.cod_estado_tramite=6";               
    $result = pg_query($query)or die(pg_last_error());  
    $ticket_urgente_completado=pg_fetch_row($result);  
    pg_free_result($result);

    $prioridad_urgente=(number_format(($ticket_urgente_completado[0]*100)/($total_ticket_urgente[0])));

//top 3 de ordenes
    $query="SELECT * FROM ordenes,usuarios WHERE ordenes.cedula_usuario_orden=usuarios.cedula_usuario AND ordenes.status_orden=1 AND ordenes.cedula_usuario_orden='$cedula_usuario' order by id_orden desc fetch first 3 rows only"; 
    $result = pg_query($query)or die(pg_last_error()); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Language" content="es-VE">
    <meta http-equiv="Content-Script-Type" content="text/javascript">       
    <link rel="shortcut icon" href="images/favicon.png" />
    <title><?php echo $sistema_name;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrapValidator.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index2.php"><?php echo $sistema_name;?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> 
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-messages">

<?php
while($top_ordenes = pg_fetch_array($result))
{
    $id_orden=$top_ordenes[id_orden];
?>

                        <li>
                            <?php echo '<a href="?view=responder_orden&id_orden='.$id_orden.'">';?>
                                <div>
                                    <strong><?php echo $top_ordenes['nombre_usuario'];?></strong>
                                    <span class="pull-right text-muted">
                                        <em><?php echo $top_ordenes['fecha_registro'];?></em>
                                    </span>
                                </div>

                                <div><?php echo $top_ordenes['descripcion_orden'];?></div>
                            </a>
                        </li>

                        <li class="divider"></li>

<?php } ?>

                        <li>
                            <a class="text-center" href="?view=ordenes">
                                <strong>Leer Mas Ordenes</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> 
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Tareas</strong>
                                        <span class="pull-right text-muted"><?php echo $orden_eficiencia .'% Complete'?></span>
                                    </p>

                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $orden_eficiencia?>%">
                                            <span class="sr-only"><?php echo $orden_eficiencia .'% Complete'?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Prioridad Normales</strong>
                                        <span class="pull-right text-muted"><?php echo $prioridad_normal .'% Complete'?></span>
                                    </p>

                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prioridad_normal?>%">
                                            <span class="sr-only"><?php echo $prioridad_normal .'% Complete'?> (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Prioridad Alta</strong>
                                        <span class="pull-right text-muted"><?php echo $prioridad_alta .'% Complete'?></span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prioridad_alta?>%">
                                            <span class="sr-only"><?php echo $prioridad_alta .'% Complete'?> (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Prioridad Urgentes</strong>
                                        <span class="pull-right text-muted"><?php echo $prioridad_urgente .'% Complete'?></span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prioridad_urgente?>%">
                                            <span class="sr-only"><?php echo $prioridad_urgente .'% Complete'?> (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a class="text-center" href="?view=gestion_tickets_load">
                                <strong>Ver todos mis Solicitudes</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> 
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="index2.php?view=usuarios_setting_perfil&cedula=<?php echo $_SESSION['id'];?>">
                                <i class="fa fa-user fa-fw"></i><?php echo $_SESSION['username']?>
                            </a>
                        </li>

                        <li>
                            <a href="index2.php?view=usuarios_setting_clave&cedula=<?php echo $_SESSION['id'];?>"><i class="fa fa-gear fa-fw"></i> Settings
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="index.php?view=logoff&user=<?php echo $_SESSION['id']?>">
                                <i class="fa fa-sign-out fa-fw"></i> Logout
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <?php include ('view_menu.php');?> 
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <?php include ('view_tareas.php');?>

            <?php include ('view_content.php');?> 
        </div>
        <!-- /#page-wrapper -->

<!-- BEGIN JIVOSITE CODE {literal} -->
        <script type='text/javascript'>
            (function(){ 
                var widget_id = 'IRYYzxyuww';
                var d=document;
                var w=window;
                function l(){
                    var s = document.createElement('script'); 
                    s.type = 'text/javascript'; 
                    s.async = true; 
                    s.src = '//code.jivosite.com/script/widget/'+widget_id; 
                    var ss = document.getElementsByTagName('script')[0]; 
                    ss.parentNode.insertBefore(s, ss);
                }
                if(d.readyState=='complete'){
                    l();
                }else{
                    if(w.attachEvent){
                        w.attachEvent('onload',l);
                    }else{
                        w.addEventListener('load',l,false);
                    }
                }
            })();
        </script>
<!-- {/literal} END JIVOSITE CODE -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrapValidator.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.php"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- validation bootstrap -->
    <script src="vendor/validation/validation.js"></script>

    <!-- script del jquery, ajax y funciones javascript-->
    <script src="vendor/validation/ajax.js"></script>
    <script src="vendor/validation/lib_javascript.js"></script>
</body>

</html>
