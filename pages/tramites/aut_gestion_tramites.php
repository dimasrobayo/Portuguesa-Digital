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

    if (isset($_GET['cod_unidad'])){
    	$datos_unidad= $_GET['cod_unidad'];

	$query="SELECT * FROM unidades WHERE cod_unidad = '$datos_unidad'";
    	$result = pg_query($query)or die(pg_last_error());
	$resultado=pg_fetch_array($result);
        pg_free_result($result);
        
	$query="SELECT * FROM tramites,categorias,unidades WHERE tramites.cod_categoria=categorias.cod_categoria AND tramites.cod_unidad=unidades.cod_unidad AND tramites.cod_unidad = '$datos_unidad' ORDER BY cod_tramite";
        $result = pg_query($query)or die(pg_last_error());
        
    $datos_consultaT = pg_query("SELECT * FROM tramites,categorias,unidades WHERE tramites.cod_categoria=categorias.cod_categoria AND tramites.cod_unidad=unidades.cod_unidad AND tramites.cod_unidad = '$datos_unidad' ORDER BY cod_tramite" ) or die(pg_last_error());
    $totalFilas=pg_num_rows($datos_consultaT);
    $totalPaginas=intval($totalFilas/25);

    }
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
                    <a href="index2.php?view=unidades" class="btn btn-default btn-default">Salir</a>
                </div>
        							
                <div style="float:right;">
                    <a href="reportes/imprimir_lista_tramites_unidades.php?cod_unidad=<?php echo $resultado[cod_unidad];?>" target="_blank" class="btn btn-default btn-warning">Imprimir</a>
                </div>
                <div style="float:right;">
                     <a href="index2.php?view=tramite_add&cod_unidad=<?php echo $resultado[cod_unidad];?>" class="btn btn-default btn-primary">Agregar</a>
                </div>
                <h4 class="text-primary"><strong> TRAMITES DEL DEPARTAMENTO/UNIDAD </strong></h4>                
            </div>


            <div class="panel-body">
                <div class="col-lg-6">
                    <label>CODIGO</label>
                    <input  type="text" id="horarioc" name="horarioc" value="<?php echo $resultado[cod_unidad]; ?>" class="form-control" size="50" maxlength="200"/>
                    <label>SIGLAS:</label>
                    <input  type="text" id="horarioc" name="horarioc" value="<?php echo $resultado['siglas_unidad']; ?>" class="form-control" size="50" maxlength="200"/>
                </div>

                <div class="col-lg-6">
                    <label>NOMBRE:</label>
                    <input  type="text" id="horarioc" name="horarioc" value="<?php echo $resultado['nombre_unidad']; ?>" class="form-control" size="50" maxlength="200"/>
                    <label>RESPONSABLE:</label>
                    <input  type="text" id="horarioc" name="horarioc" value="<?php echo $resultado['responsable_unidad']; ?>" class="form-control" size="50" maxlength="200"/>
                </div>

<!--Estructura de Tabla de Contenidos Estados de Tramites-->
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Categoria</th>
                            <th>Tramite</th>	
                            <th>Descripci&oacute;n Tramite</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
<?php
$xxx=0;
while($resultados = pg_fetch_array($result)) {
	$xxx=$xxx+1;
?>
                    <tr class="gradeA">
                        <td  align="center">
                             <?php echo $resultados[cod_tramite];?>
                        </td>

                        <td>
                            <?php echo $resultados[descripcion_categoria];?>
                        </td>

                        <td>
                            <?php echo $resultados[nombre_tramite];?>
                        </td>

                        <td>
                            <?php echo $resultados[descripcion_tramite];?>
                        </td>

                        <?php if ($resultados[status_tramite]=='0') {
                            $ico=4;
                        } else {
                            $ico=3;
                        }
                        ?>
                        
                        <td width="15%" align="center"> 
                            <a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?view=tramite_drop&cod_tramite=<?php echo $resultados[cod_tramite];?>&cod_unidad=<?php echo $resultados[cod_unidad];?>" title="Pulse para eliminar el registro">
                                <img border="0" src="images/borrar28.png" alt="borrar">
                            </a>
                            <a href="index2.php?view=tramite_update&cod_tramite=<?php echo $resultados[cod_tramite];?>" title="Pulse para Modificar los datos registrados">
                                <img border="0" src="images/modificar.png" alt="actualizar">
                            </a>
                            <a href="index2.php?view=tramite_scaler&cod_tramite=<?php echo $resultados[cod_tramite];?>" title="Pulse para Escalar el Tramite y Solicitudes Dependientes">
                                <img border="0" src="images/traslado.png" alt="actualizar">
                            <a onclick="return confirm('CONFIRMAR CAMBIO DE STATUS A ESTE TRAMITE ?');" href="index2.php?view=tramite_status&unidad=<?php echo $resultados[cod_unidad];?>&status=<?php echo $resultados[status_tramite];?>&cod_tramite=<?php echo $resultados[cod_tramite];?>" title="Pulse para Cambiar STATUS del Tramite">
                                <img border="0" src="images/<?php echo $ico;?>.png" alt="activar/desactivar">
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
