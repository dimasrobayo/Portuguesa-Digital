<?php
    // chequear si se llama directo al script.
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="../images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    if ($_SERVER['HTTP_REFERER'] == "") {
        echo "<script type='text/javascript'>window.location.href='index.php?view=login&msg_login=5'</script>";
//        echo "<script type='text/javascript'>window.location.href='index.php'</script>";
        exit;
    }

    $server=$_SERVER['SERVER_NAME']; // nombre del servidor web
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $view=$_GET["view"];    
    $pagina=$pag.'?view='.$view;
    $cedula_usuario=$_SESSION['id'];

    //Conexion a la base de datos
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $datos_consulta = pg_query("SELECT * FROM estado_mayor, usuarios where usuarios.id_estado_mayor = estado_mayor.id_estado_mayor and usuarios.cedula_usuario = '$cedula_usuario'") or die(pg_last_error());
    $resultado=pg_fetch_array($datos_consulta); 
    pg_free_result($resultado); 
?> 

<?php 
    if (isset($_POST[save])) {   // Insertar Datos del formulario
        $id_estado_mayor = ($_POST['id_estado_mayor']);
        $lo_discutido = ($_POST['lo_discutido']);
        $posible_solucion = ($_POST['posible_solucion']);
        $fecha_ejecucion = ($_POST['fecha_ejecucion']);
        $responsable = ($_POST['responsable']);
        $unidad_medida = ($_POST['unidad_medida']);
        $meta_planificada = ($_POST['meta_planificada']);
        $monto_estimado = ($_POST['monto_estimado']);

        $query="insert into em_planificacion (lo_discutido, posible_solucion, fecha_ejecucion, responsable, unidad_medida, meta_planificada, monto_estimado, id_estado_mayor) values ('$lo_discutido', '$posible_solucion', '$fecha_ejecucion', '$responsable', '$unidad_medida', '$meta_planificada', '$monto_estimado', '$id_estado_mayor')";
        $result = pg_query($query)or die(pg_last_error());
        $error="bien";
    }//fin del add        
?>
<!-- sincronizar mensaje cuando de muestra al usuario -->
<?php if($div_menssage) { ?>                    
    <script type="text/javascript">
        function ver_msg(){
            Effect.Fade('msg');
        }  
        setTimeout ("ver_msg()", 5000); //tiempo de espera en milisegundos
    </script>
<?php } ?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div align="center">
                <font color="red" style="text-decoration:blink;">
                    <?php $error_accion_ms[$error_cod]?>
                </font>
            </div>  

            <div class="panel-heading">
                <h4 class="text-primary"><strong> PLANIFICACION: <?php echo $resultado[nombre_estado_mayor]; ?> </strong></h4>
            </div>
                
<?php if ((isset($_POST[save])) and ($error=="bien")){  ?> <!-- Mostrar Mensaje -->
                
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos registrados con &eacute;xito</h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=planificacion";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=planificacion" name="Continuar"> Continuar </a>]
                        </font>                         
                </h3>
            </div>
                
<?php }else{ ?>   <!-- Mostrar formulario Original --> 
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" id="id_estado_mayor" name="id_estado_mayor" value="<?php echo $resultado[id_estado_mayor]; ?>">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>RESPONSABLE</label>
                                <input type="text" class="form-control" id="responsable" name="responsable">
                            </div>
                            
                            <div class="form-group" autofocus="true">
                                <label>LO DISCUTIDO</label>
                                <textarea class="form-control" name="lo_discutido" id="lo_discutido" cols="70" rows="3"><?php echo $lo_discutido;?></textarea>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>POSIBLE SOLUCION</label>
                                <textarea class="form-control" name="posible_solucion" id="posible_solucion" cols="70" rows="3"><?php echo $posible_solucion;?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>FECHA DE EJECUCION</label>
                                <input class="form-control" value="<?php echo date('d/m/Y');?>" type="date" id="fecha_ejecucion" name="fecha_ejecucion"/>
                            </div>
                            
                            <div class="form-group">
                                <label>UNIDAD DE MEDIDA</label>
                                <input type="text" class="form-control" id="unidad_medida" name="unidad_medida">
                            </div>

                            <div class="form-group">
                                <label>PLANIFICADA</label>
                                <input type="text" class="form-control" id="meta_planificada" name="meta_planificada">
                            </div>

                            <div class="form-group">
                                <label>MONTO ESTIMADO</label>
                                <input type="text" class="form-control" id="monto_estimado" name="monto_estimado" value="0,00">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" id="save" name="save" class="btn btn-default btn-primary">Guardar</button>
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=planificacion'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div>
<?php }  ?>
        </div>
    </div>
</div>
