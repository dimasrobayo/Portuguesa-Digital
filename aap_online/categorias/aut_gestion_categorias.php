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
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $datos_consulta = pg_query("SELECT * FROM categorias order by cod_categoria") or die(pg_last_error());
?>

<div align="center" class="centermain">
    <div>  
        <div align="center">
            <font color="red" style="text-decoration:blink;">
                <?php $error_accion_ms[$error_cod]?>
            </font>
        </div>

        <table class="admincategorias">
            <tr>
                <th>
                    CATEGORIAS:                    
                </th>
            </tr>
        </table>

        <br>

<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
        <table class="display" id="tabla">
        <thead>
            <tr bgcolor="#55baf3">
                <th align="center" width="12%">
                    C&oacute;digo
                </th>

                <th width="55%" align="center">
                    Descripci&oacute;n Categoria
                </th>
		
                <th width="12%" align="center">
                    Acciones
                </th>
            </tr>
        </thead>

<?php
$xxx=0;
while($resultados = pg_fetch_array($datos_consulta)) {
	$xxx=$xxx+1;
?>

            <tr class="row0">
                <td  align="center">
                     <?php echo $resultados[cod_categoria];?>
                </td>

                <td>
                    <?php echo $resultados[descripcion_categoria];?>
                </td>
                
                <?php if ($resultados[status_categoria]=='0') {
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
                    
                    <a onclick="return confirm('CONFIRMAR CAMBIO DE STATUS A ESTA CATEGORIA ?');" href="index2.php?view=categoria_status&status=<?php echo $resultados[status_categoria];?>&cod_categoria=<?php echo $resultados[cod_categoria];?>" title="Pulse para Cambiar STATUS de la Unidad">
                        <img border="0" src="images/<?php echo $ico;?>.png" alt="borrar">
                    </a>
                    
                </td>
            </tr>
<?php
}
?>

            <tfoot>
                <tr align="center">
                    <th colspan="3" align="center">
                        <div id="cpanel">
                            <div style="float:right;">
                                <div class="icon">
                                    <a href="index2.php?view=home">
                                        <img src="images/cpanel.png" alt="salir" align="middle"  border="0" />
                                        <span>Salir</span>
                                    </a>
                                </div>
                            </div>
							
                            <div style="float:right;">
                                <div class="icon">
                                    <a href="reportes/imprimir_lista_categorias.php" target="_blank">
                                        <img src="images/printer.png" alt="agregar" align="middle"  border="0" />
                                        <span>Imprimir</span>
                                    </a>
                                </div>
                            </div>
                    
                            <div style="float:right;">
                                <div class="icon">
                                    <a href="index2.php?view=categoria_add">
                                        <img src="images/nuevo.png" alt="agregar" align="middle"  border="0" />
                                        <span>Agregar</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php
pg_free_result($datos_consulta);
pg_close();
?>
