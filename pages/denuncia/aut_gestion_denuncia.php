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
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
	
    //codigo para colocar la hora.
    $hora=date("h").":".date("i")." ".date("a");

if (!isset($_GET['accion']))
{
    $datos_consulta = pg_query("SELECT * FROM denuncia LIMIT 25 OFFSET '$page'") or die("No se pudo realizar la consulta a la Base de datos");
    $datos_consultaT = pg_query("SELECT * FROM denuncia") or die("No se pudo realizar la consulta a la Base de datos");
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
                    <a href="index2.php?view=home" class="btn btn-default">
                        Salir
                    </a>
                </div>

                <div style="float:right;">
                    <a href="index2.php?view=denuncia_add" class="btn btn-default btn-primary">
                        Denunciar
                    </a>
                </div>

                <h4 class="text-primary"><strong> DENUNCIAS ANONIMAS </strong></h4> 
            </div>

<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th width="10%">CODIGO</th>
                            <th width="80%">DENUNCIA</th>
                            <th width="10%">ACCIONES</th>
                        </tr>
                    </thead>
<?php
$xxx=0;
while($resultados = pg_fetch_array($datos_consulta))
{
	$xxx=$xxx+1;
?>
                    <tbody>
                        <tr class="gradeA">
                            <td align="center">
                                <?php echo $resultados[cod_denuncia];?>
                            </td>

                            <td>
                                <?php echo $resultados[denuncia];?>
                            </td>

                            <td align="center"> 
                                <a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?view=comunidad_drop&idcomunidad=<?php echo $resultados[idcom];?>" title="Pulse para eliminar el registro">
                                    <img border="0" src="images/borrar28.png" alt="borrar">
                                </a>
                                
                                <a href="index2.php?view=comunidad_update&idcom=<?php echo $resultados[idcom];?>&estado=<?php echo $resultados[idest];?>&munic=<?php echo $resultados[idmun];?>&parroq=<?php echo $resultados[idpar];?>" title="Pulse para Modificar los datos registrados">
                                    <img border="0" src="images/modificar.png" alt="borrar">
                                </a>  
                            </td>
                        </tr>
                    </tbody>

<?php } ?>

                    <tfoot>
                        <tr align="center">
                            <th colspan="8" align="center">
                                <div id="cpanel">
                                    <?php $j=0;  $p=0;
                                    for ($i = 0; $i <= $totalPaginas; $i++) {
                                        $j=$i+1;

                                        ?>
                                        <div style="float:left;">
                                        <div class="icon">
                                            <a href="index2.php?view=categorias&page=<?php echo $p; ?>" class="btn btn-primary">
                                                <?php echo $j; ?>
                                            </a>
                                        </div>
                                    </div> <?php $p=$p+25;
                                    }
                                    ?>
                                </div>
                            </th>
                        </tr>

                        <tr>
                            <th colspan="7" >
                                <p class="text-primary"><?php echo $page; ?>
                                <small class="text-muted"> de </small> 
                                <?php echo $totalFilas; ?>
                                <small class="text-muted"> registros </small>
                                </p>
                            </th>
                        </tr>
                    </tfoot>
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


<?php
pg_free_result($datos_consulta);
pg_close();
}
?>