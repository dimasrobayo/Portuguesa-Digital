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

    $type=$_GET["view"];
    $pagina=$pag.'?view='.$type;

    //Conexion a la base de datos
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $datos_consulta = pg_query("SELECT * FROM estados_tramites order by cod_estado_tramite") or die(pg_last_error());

    $datos_consultaT = pg_query("SELECT * FROM estados_tramites order by cod_estado_tramite") or die(pg_last_error());
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
                        <a href="reportes/imprimir_lista_etramites.php" target="_blank" class="btn btn-default  btn-warning">Imprimir</a>
                </div>
                <div style="float:right;">
                        <a href="index2.php?view=edo_tramite_add" class="btn btn-default btn-primary">Agregar</a>
                </div>
                <h4 class="text-primary"><strong> ESTADOS DE TRAMITES </strong></h4>
            </div>

<!--Estructura de Tabla de Contenidos Estados de Tramites-->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Siglas</th>
                            <th>Estado</th>
                            <th>Descripci&oacute;n Estado</th>
                            <th>Tipo Estado</th>
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
                            <?php echo $resultados[cod_estado_tramite];?>
                        </td>

                        <td>
                            <?php echo $resultados[siglas_estado_tramite];?>
                        </td>

                        <td>
                             <?php echo $resultados[estado_tramite];?>
                        </td>
                        
                        <td>
                            <?php echo $resultados[descripcion_estado_tramite];?>
                        </td>
                        
                        <td>
                            <?php 
                                if($resultados[tipo_estado_tramite]==1) {
                                    echo '<font color="gree">';
                                    $tetramite="Asignado";
                                } elseif($resultados[tipo_estado_tramite]==2) {
                                    echo '<font color="blue">';
                                    $tetramite="Completado";
                                }
                                else {
                                    echo '<font color="red">';
                                    $tetramite="Cancelado";
                                }
                                echo $tetramite.'</font>';
                            ?>
                        </td>

                        <td align="center"> 
                            <a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?view=edo_tramite_drop&cod_estado_tramite=<?php echo $resultados[cod_estado_tramite];?>" title="Pulse para eliminar el registro">
                                <img border="0" src="images/borrar28.png" alt="borrar">
                            </a>
                            <a href="index2.php?view=edo_tramite_update&cod_estado_tramite=<?php echo $resultados[cod_estado_tramite];?>" title="Pulse para Modificar los datos registrados">
                                <img border="0" src="images/modificar.png" alt="borrar">
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
