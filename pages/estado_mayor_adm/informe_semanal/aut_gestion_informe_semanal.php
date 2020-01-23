<?php
    // chequear si se llama directo al script.
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="../images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    if ($_SERVER['HTTP_REFERER'] == "")	{
        echo "<script type='text/javascript'>window.location.href='index.php?view=login&msg_login=5'</script>";
//        echo "<script type='text/javascript'>window.location.href='index.php'</script>";
        exit;
    }
    
    $redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.

    if(!$_GET["page"]){
        $page=0;
    }else{
        $page=$_GET["page"];
    }

    $pag=$_SERVER['PHP_SELF'];
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$type;
    $cedula_usuario=$_SESSION['id'];

    //Conexion a la base de datos
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $datos_consulta = pg_query("SELECT * FROM estado_mayor, em_informe_semanal, usuarios where em_informe_semanal.id_estado_mayor = estado_mayor.id_estado_mayor and usuarios.id_estado_mayor = estado_mayor.id_estado_mayor order by em_informe_semanal.id_informe") or die(pg_last_error());
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div align="center">
                <font color="red" style="text-decoration:blink;">
                    <?php $error_accion_ms[$error_cod]?>
                </font>
            </div> 

            <div class="panel-heading">
                <div style="float:right;">
                    <a href="index2.php?view=home" class="btn btn-default btn-default">Salir</a>
                </div>
                
                <div style="float:right;">
                    <a href="index2.php?view=informe_semanal_add" class="btn btn-default btn-primary">Agregar</a>
                </div>
                <h4 class="text-primary"><strong> INFORME SEMANAL - ESTADOS MAYORES </strong></h4>                              
            </div>

            <div class="panel-body">
<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th>Estado Mayor</th>
                            <th>Informe</th>
                            <th>Semana</th>
                            <th>Mes</th>
    		                <th>Acciones</th>
                        </tr>
                    </thead>
<?php
$xxx=0;
while($resultados = pg_fetch_array($datos_consulta)) {
	$xxx=$xxx+1;
?>

                    <tr class="gradeA">
                        <td>
                            <?php echo $resultados[nombre_estado_mayor];?>
                        </td>

                        <td>
                            <?php echo $resultados[nombre_informe];?>
                        </td>

                        <td>
                            <?php echo $resultados[semana_informe];?>
                        </td>

                        <td>
                            <?php echo $resultados[mes_informe];?>
                        </td>

                        <td align="center">
                            <?php
                            if($resultados[path]!=""){
                                $dir_upload='upload_file/informe_semanal/'; // Nombre del Directorio de las subidas de archivos
                                $archivo = $dir_upload.$resultados[path];                                                        
                                if (file_exists($archivo)){
                                    echo '<a href="'.$archivo.'" download="'.$archivo.'" target="_blank" title="Descargar Archivo para Visualizar">
                                            <img src="images/download28.png" name="Image_Encab"  border="0"/>
                                        </a>';
                                }
                            }
                            ?>
                        </td>
                    </tr>

<?php } ?>
                   
                </table>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript 
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script> -->

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>

<script>
$(document).ready(function() {
    $('#dataTables-gestion').DataTable();
});
</script>

<?php
pg_free_result($datos_consulta);
pg_close();
?>
