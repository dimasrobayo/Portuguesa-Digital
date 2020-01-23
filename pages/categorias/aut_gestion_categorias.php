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

    //Conexion a la base de datos
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $datos_consulta = pg_query("SELECT * FROM categorias order by cod_categoria") or die(pg_last_error());

    $datos_consultaT = pg_query("SELECT * FROM categorias order by cod_categoria") or die(pg_last_error());
    $totalFilas=pg_num_rows($datos_consultaT);
    $totalPaginas=intval($totalFilas/25);
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
                    <a href="reportes/imprimir_lista_categorias.php" target="_blank" class="btn btn-default btn-warning">Imprimir</a>
                </div>
                <div style="float:right;">
                    <a href="index2.php?view=categoria_add" class="btn btn-default btn-primary">Agregar</a>
                </div>
                <h4 class="text-primary"><strong> CATEGORIAS </strong></h4>                              
            </div>

            <div class="panel-body">
<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Descripci&oacute;n Categoria</th>
                            <th>Status</th>
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
                            <?php echo $resultados[cod_categoria];?>
                        </td>

                        <td>
                            <?php echo $resultados[descripcion_categoria];?>
                        </td>

                        <td>
                            <?php if ($resultados[status_categoria]=='0') {
                                echo "Desactivado";
                            }else{
                                echo "Activo";
                            }
                            ?>
                        </td>
                
                        <?php if ($resultados[status_categoria_online]=='0') {
                                  $ico=4;
                              } else {
                                  $ico=3;
                              }
                        ?>

                        <td align="center"> 
                            <a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?view=categoria_drop&cod_categoria=<?php echo $resultados[cod_categoria];?>" title="Pulse para eliminar el registro">
                                <img border="0" src="images/borrar28.png" alt="borrar">
                            </a>
                            <a href="index2.php?view=categoria_update&cod_categoria=<?php echo $resultados[cod_categoria];?>" title="Pulse para Modificar los datos registrados">
                                <img border="0" src="images/modificar.png" alt="borrar">
                            </a> 
                            
                            <a onclick="return confirm('CONFIRMAR ACTIVAR/DESACTIVAR ONLINE A ESTA CATEGORIA ?');" href="index2.php?view=categoria_status&status_online=<?php echo $resultados[status_categoria_online];?>&cod_categoria=<?php echo $resultados[cod_categoria];?>" title="Pulse para Cambiar STATUS de la Unidad">
                                <img border="0" src="images/<?php echo $ico;?>.png" alt="borrar">
                            </a>
                            
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
