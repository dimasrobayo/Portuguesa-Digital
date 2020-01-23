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
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$type;
	
    //Conexion a la base de datos
    require("conexion_sms/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host_sms dbname=$sql_db_sms user=$sql_usuario_sms password=$sql_pass_sms");

    if(!$_GET["page"]){
        $page=0;
    }else{
        $page=$_GET["page"];
    }

    $datos_consulta = pg_query("SELECT * FROM sentitems") or die("No se pudo realizar la consulta a la Base de datos");

    $datos_consultaT =pg_query("SELECT * FROM sentitems") or die(pg_last_error());
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
                    <a href="index2.php?view=home" class="btn btn-default">Salir</a>
                </div>

                <div style="float:right;">
                    <a href="reportes/imprimir_enviados.php" target="_blank" class="btn btn-default btn-warning">Imprimir</a>
                </div>

                <div style="float:right;">
                    <a href="index2.php?view=enviados_drop" name="borrar" class="btn btn-default btn-danger">Borrar</a>
                </div>
                <h4 class="text-primary"><strong> SMS ENVIADOS </strong></h4> 
            </div>

            <div class="panel-body">
<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th>Enviado a</th>
                            <th>Fecha</th>
                            <th>Mensaje</th>
                            <th>Status</th>
                        </tr>
                    </thead>

<?php
while($resultados = pg_fetch_array($datos_consulta)){
?>

                    <tr class="gradeA">
                        <td>
                            <?php echo $resultados[DestinationNumber];?>
                        </td>

                        <td>
                            <?php echo $resultados[SendingDateTime];?>
                        </td>

                        <td>
                            <?php echo $resultados[TextDecoded];?>
                        </td>

                        <td>
                            <?php if ($resultados[Status]=="SendingError"){
                                echo "Error";
                            }
                            else {	echo "Enviados";}
                            ?>
                        </td>
                    </tr>

<?php }?>

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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function() {
    $('#dataTables-gestion').DataTable();
});
</script>

<?php
pg_free_result($datos_consulta);
pg_close();
?>