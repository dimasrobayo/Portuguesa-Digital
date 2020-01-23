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
    if (isset($_POST['cedula_rif'])or($_GET['cedula_rif'])){ // Recibir los Datos 
        $cedula_rif=strtoupper($_POST['cedula_rif']);
        $cedula = preg_replace("/\s+/", "", $cedula_rif);
        $cedula = str_replace("-", "", $cedula);

        $datos_consulta = pg_query("SELECT * FROM peajes, usuarios WHERE peajes.cedula_rif = usuarios.cedula_usuario and peajes.cedula_rif='$cedula' order by peajes.id_peaje LIMIT 25 OFFSET '$page'") or die("No se pudo realizar la consulta a la Base de datos");
        $datos_consultaT = pg_query("SELECT * FROM peajes, usuarios WHERE peajes.cedula_rif = usuarios.cedula_usuario order by peajes.id_peaje") or die("No se pudo realizar la consulta a la Base de datos");
    }
    $totalFilas=pg_num_rows($datos_consultaT);
    $totalPaginas=intval($totalFilas/25);

    $query_recarga = pg_query("SELECT sum(monto_operacion) FROM peajes, usuarios WHERE peajes.cedula_rif = usuarios.cedula_usuario and peajes.cedula_rif='$cedula' and peajes.tipo_operacion='RECARGA'") or die("No se pudo realizar la consulta a la Base de datos");
    $recarga=pg_fetch_array($query_recarga);

    $query_pago = pg_query("SELECT sum(monto_operacion) FROM peajes, usuarios WHERE peajes.cedula_rif = usuarios.cedula_usuario and peajes.cedula_rif='$cedula' and peajes.tipo_operacion='PAGO'") or die("No se pudo realizar la consulta a la Base de datos");
    $pago=pg_fetch_array($query_pago);

    $saldo_usuario=$recarga[0]-$pago[0];

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
                    <a href="index2.php?view=pagos_peaje_view" class="btn btn-default">
                        Salir
                    </a>
                </div>

                <div style="float:right;">
                    <a href="index2.php?view=peaje_add_adm&cedula_rif=<?php echo $cedula;?>" class="btn btn-default btn-primary">
                        Pagar
                    </a>
                </div>

                <h4 class="text-primary">
                    <strong> ADMINISTRACION DE PAGOS DE PEAJES - <?php echo number_format($saldo_usuario, 2, ',', '.');?></strong>
                </h4> 
            </div>

<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th width="10%">CI CLIENTE</th>
                            <th width="25%">NOMBRE APELLIDO</th>
                            <th width="18%">FECHA OPERACION</th>
                            <th width="20%">MONTO OPERACION</th>
                            <th width="20%">TIPO OPERACION</th>
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
                                <?php echo $resultados[id_peaje];?>
                            </td>

                            <td>
                                <?php echo $resultados[nombre_usuario];?>
                            </td>

                            <td>
                                <?php echo $resultados[fecha_operacion];?>
                            </td>

                            <td align="center">
                                <?php echo number_format($resultados[monto_operacion], 2, ',', '.');?>
                            </td>

                            <td align="center">
                                <?php echo $resultados[tipo_operacion];?>
                            </td>
                        </tr>
                    </tbody>

<?php } ?>

                    <tfoot>
                    <tr align="center">
                        <th colspan="8" align="center">
                            <div id="cpanel">
                                <form method="GET" action="index2.php">
                                    <input type="hidden" name="view" value="gestion_tickets_load">
                                <select name="page">
                                    <div style="float:left;">
                                        <div class="icon">
                                            <?php $j=0;  $p=0;
                                            for ($i = 0; $i <= $totalPaginas; $i++) {
                                                $j=$i+1;

                                                ?>
                                                <option value="<?php echo $p; ?>"><?php echo $j; ?></option>
                                                    
                                             <?php $p=$p+30;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </select>
                                <input type="submit" name="paginar" value="->" class="btn btn-primary"> 
                                </form> 
                            </div>

                        </th>
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