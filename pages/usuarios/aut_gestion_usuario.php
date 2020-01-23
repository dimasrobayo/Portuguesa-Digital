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
    
    if(!$_GET["page"]){
        $page=0;
    }else{
        $page=$_GET["page"];
    }
    $pag=$_SERVER['PHP_SELF'];

    $type=$_GET["view"];
    $pagina=$pag.'?view='.$view;

    //Conexion a la base de datos
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $datos_consulta = pg_query("SELECT * FROM usuarios,unidades,niveles_acceso WHERE usuarios.nivel_acceso=niveles_acceso.codigo_nivel and  usuarios.cod_unidad=unidades.cod_unidad order by usuarios.cedula_usuario" ) or die(pg_last_error());

    $datos_consultaT = pg_query("SELECT * FROM usuarios,unidades,niveles_acceso WHERE usuarios.nivel_acceso=niveles_acceso.codigo_nivel and  usuarios.cod_unidad=unidades.cod_unidad order by usuarios.cedula_usuario" ) or die(pg_last_error());
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
                        <a href="index2.php?view=usuarios_add" class="btn btn-default btn-primary">Agregar</a>
                </div>
                <h4 class="text-primary"><strong> USUARIOS DEL SISTEMA </strong></h4> 
            </div>


            <div class="panel-body">
<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
                <div class="table-responsive">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                        <thead>
                            <tr>
                                <th align="center" width="10%">
                                    Código
                                </th>

                                <th align="center" width="6%">
                                    Login
                                </th>

                                <th width="15%" align="center">
                                    Nombre y Apellido
                                </th>

                                <th width="18%" align="center">
                                    Nivel Acceso
                                </th>

                                <th width="18%" align="center">
                                    Unidad/Dependencia
                                </th>

                                <th width="15%" align="center">
                                    Ùltimo Acceso
                                </th>

                                <th width="18%" align="center">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

<?php
    while($resultados = pg_fetch_array($datos_consulta))
    {
?>

                        <tr class="gradeA">
                            <td  align="center">
                                 <?php echo $resultados[cedula_usuario];?>
                            </td>
                            <td>
                                 <?php echo $resultados[usuario];?>
                            </td>

                            <td>
                                <?php echo $resultados[nombre_usuario];?> <?php echo " "; ?> <?php echo $resultados[apellido_usuario];?>
                            </td>

                            <td>
                                 <?php echo $resultados[nombre_nivel];?>
                            </td>

                            <td>
                                <?php echo $resultados[nombre_unidad];?>
                            </td>

                            <td  align="center">
                                <?php echo date_format(date_create($resultados['fecha_ultimoacceso']), 'd/m/Y g:i A.') ;?> 
                            </td>
                            
                            <td align="center"> 
                                <a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?view=usuarios_drop&cedula=<?php echo $resultados[cedula_usuario];?>" title="Pulse para eliminar el registro">
                                    <img border="0" src="images/borrar28.png" alt="borrar">
                                </a>
                                <a href="index2.php?view=usuarios_update&cedula=<?php echo $resultados[cedula_usuario];?>" title="Pulse para Modificar los datos personales">
                                    <img border="0" src="images/modificar.png" alt="borrar">
                                </a>  
                                <a href="index2.php?view=usuarios_update_clave&cedula=<?php echo $resultados[cedula_usuario];?>" title="Pulse para Cambio de Clave">
                                    <img border="0" src="images/modificar_clave.png" alt="borrar">
                                </a>
                                <a href="index2.php?view=usuarios_update_nivel&cedula=<?php echo $resultados[cedula_usuario];?>" title="Pulse para Modificar el Nivel de Acceso">
                                    <img border="0" src="images/nivel_acceso.png" alt="borrar">
                                </a>
                                <a href="index2.php?view=usuario_sms&cedula_usuario=<?php echo $resultados[cedula_usuario];?>" title="Pulse para Modificar los datos registrados">
                                    <img border="0" src="images/sms.png" alt="borrar">
                                </a>
                                <a onclick="return confirm('Esta seguro que desea Bloquear o Desbloquear el Usuario?');" href="index2.php?view=usuarios_unlock&cedula=<?php echo $resultados[cedula_usuario];?>&status=<?php echo $resultados[status];?>" title="Pulse para bloquear o desbloquear el registro">
                                    <img border="0" src="images/<?php echo $resultados[status];?>.png" alt="borrar">
                                </a>
                                <a href="index2.php?view=usuarios_permisos&cedula_usuario=<?php echo $resultados[cedula_usuario];?>" title="Pulse para Gestionar Permisos">
                                    <img border="0" src="images/permisos.png" alt="borrar">
                                </a>
                            </td>
                        </tr>

<?php } ?>
            
                    </table>
                </div>
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

<!-- DataTables JavaScript -->
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function() {
    $('#dataTables-usuarios').DataTable();
});
</script>

<?php
pg_free_result($datos_consulta);
pg_free_result($datos_consultaT);
pg_close();
?>
