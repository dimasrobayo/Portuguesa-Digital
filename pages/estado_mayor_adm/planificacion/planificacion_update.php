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

    $redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$type;
    $cedula_usuario=$_SESSION['id'];

    //Conexion a la base de datos
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $datos_consulta = pg_query("SELECT * FROM estado_mayor, usuarios where usuarios.id_estado_mayor = estado_mayor.id_estado_mayor and usuarios.cedula_usuario = '$cedula_usuario'") or die(pg_last_error());
    $resultado_em=pg_fetch_array($datos_consulta); 
    pg_free_result($resultado_em);
?>

<?php //seccion para recibir los datos y modificarlos.
    if (isset($_GET['id_planificacion'])){
        $datos_modificar= $_GET['id_planificacion'];

    $query="SELECT * FROM em_planificacion where id_planificacion = $datos_modificar";
        $result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result); 
        pg_free_result($result);    
    }
?> 

<?php 
    if (isset($_POST[save])) {
        $id_estado_mayor = ($_POST['id_estado_mayor']);
        $id_planificacion = $_POST['id_planificacion'];
        $lo_discutido = ($_POST['lo_discutido']);
        $posible_solucion = ($_POST['posible_solucion']);
        $fecha_ejecucion = ($_POST['fecha_ejecucion']);
        $responsable = ($_POST['responsable']);
        $unidad_medida = ($_POST['unidad_medida']);
        $meta_planificada = ($_POST['meta_planificada']);
        $monto_estimado = ($_POST['monto_estimado']);
        
        //se le hace el llamado a la funcion de editar
        $query="UPDATE em_planificacion SET lo_discutido='$lo_discutido', posible_solucion='$posible_solucion', fecha_ejecucion='$fecha_ejecucion', responsable='$responsable', unidad_medida='$unidad_medida', meta_planificada='$meta_planificada', monto_estimado='$monto_estimado' WHERE id_planificacion='$id_planificacion';";
        $result = pg_query($query)or die(pg_last_error());
        $error="bien";
    }//fin del procedimiento modificar.
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
                    <?php echo $div_menssage;?>
                </font>
            </div>

            <div class="panel-heading">
                <h4 class="text-primary"><strong> ACTUALIZAR PLANIFICACION: <?php echo $resultado_em[nombre_estado_mayor]; ?> </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){  ?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos registrados con &eacute;xito</h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=planificacion_adm";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=planificacion_adm" name="Continuar"> Continuar </a>]
                        </font>                         
                </h3>
            </div>

<?php   }else{  ?>   <!-- Mostrar formulario Original --> 

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" id="id_estado_mayor" name="id_estado_mayor" value="<?php echo $resultado[id_estado_mayor]; ?>">
                        <input type="hidden" class="form-control" id="id_planificacion" name="id_planificacion" value="<?php echo $resultado[id_planificacion]; ?>">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>RESPONSABLE</label>
                                <input type="text" class="form-control" id="responsable" name="responsable" value="<?php if ($error!="") echo $responsable; else  echo $resultado[responsable]; ?>">
                            </div>
                            
                            <div class="form-group" autofocus="true">
                                <label>LO DISCUTIDO</label>
                                <textarea class="form-control" name="lo_discutido" id="lo_discutido" cols="70" rows="3"><?php echo $resultado[lo_discutido]; ?></textarea>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>POSIBLE SOLUCION</label>
                                <textarea class="form-control" name="posible_solucion" id="posible_solucion" cols="70" rows="3"><?php echo $resultado[posible_solucion]; ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>FECHA DE EJECUCION</label>
                                <input class="form-control" value="<?php echo $resultado[fecha_ejecucion]; ?>" type="date" id="fecha_ejecucion" name="fecha_ejecucion"/>
                            </div>
                            
                            <div class="form-group">
                                <label>UNIDAD DE MEDIDA</label>
                                <input type="text" class="form-control" id="unidad_medida" name="unidad_medida" value="<?php echo $resultado[unidad_medida]; ?>">
                            </div>

                            <div class="form-group">
                                <label>PLANIFICADA</label>
                                <input type="text" class="form-control" id="meta_planificada" name="meta_planificada" value="<?php echo $resultado[meta_planificada]; ?>">
                            </div>

                            <div class="form-group">
                                <label>MONTO ESTIMADO</label>
                                <input type="text" class="form-control" id="monto_estimado" name="monto_estimado" value="<?php echo $resultado[monto_estimado]; ?>">
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