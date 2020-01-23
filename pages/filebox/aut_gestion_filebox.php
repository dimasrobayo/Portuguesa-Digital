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

    $year= date('Y-m-d');
    $total_archivo = 1;
    $condicion = 1;
    $cedula_usuario_a=$_SESSION['id'];
    if (isset($_POST['year'])){
        $year=$_POST['year'];
        $total_puntos = 0;  
        echo $cedula_usuario=$_POST['cedula_usuario'];
        $condicion=$_POST['condicion']; 
    }

if($_SESSION['nivel']==0){
    if(($total_archivo==1) OR ($cedula_usuario=='')){
        $query="SELECT * FROM archivos, usuarios WHERE archivos.fecha_creacion='$year' AND archivos.cedula_usuario = usuarios.cedula_usuario order by archivos.codigo_archivo LIMIT 10 OFFSET '$page'";
        $result = pg_query($query)or die(pg_last_error());

        $query2="SELECT * FROM archivos, usuarios WHERE archivos.fecha_creacion='$year' AND archivos.cedula_usuario = usuarios.cedula_usuario order by archivos.codigo_archivo";
        $datos_consultaT = pg_query($query2) or die(pg_last_error());

        $totalFilas=pg_num_rows($datos_consultaT);
        $totalPaginas=intval($totalFilas/10);
    }elseif($total_archivo==0){
        $query="SELECT * FROM punto_cuenta, usuarios WHERE date_part('year',punto_cuenta.fecha_punto)= '$year' AND punto_cuenta.condicion=$condicion AND punto_cuenta.cedula_usuario='$cedula_usuario' AND punto_cuenta.cedula_usuario = usuarios.cedula_usuario AND punto_cuenta.condicion<>0 order by punto_cuenta.id_punto LIMIT 10 OFFSET '$page'";
    $result = pg_query($query)or die(pg_last_error());

    $query2="SELECT * FROM punto_cuenta, usuarios WHERE date_part('year',punto_cuenta.fecha_punto)= '$year' AND punto_cuenta.condicion=$condicion AND punto_cuenta.cedula_usuario='$cedula_usuario' AND punto_cuenta.cedula_usuario = usuarios.cedula_usuario AND punto_cuenta.condicion<>0 order by punto_cuenta.id_punto";
    $datos_consultaT = pg_query($query2) or die(pg_last_error());

    $totalFilas=pg_num_rows($datos_consultaT);
    $totalPaginas=intval($totalFilas/10);
    }
}else{
    $query="SELECT * FROM archivos, usuarios WHERE archivos.fecha_creacion='$year' AND archivos.cedula_usuario = usuarios.cedula_usuario order by archivos.codigo_archivo LIMIT 10 OFFSET '$page'";
    $result = pg_query($query)or die(pg_last_error());

    $query2="SELECT * FROM archivos, usuarios WHERE archivos.fecha_creacion='$year' AND archivos.cedula_usuario = usuarios.cedula_usuario order by archivos.codigo_archivo";
    $datos_consultaT = pg_query($query2) or die(pg_last_error());

    $totalFilas=pg_num_rows($datos_consultaT);
    $totalPaginas=intval($totalFilas/10);
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
                <div style="float:right;" class="btn-group">
                    <a href="index2.php?view=home" class="btn btn-default">Salir</a>
                </div>

                <div style="float:right;" class="btn-group">
                    <a href="index2.php?view=punto_cuenta_add" class="btn btn-default btn-success">Agregar Carpeta</a>
                </div>

                <div style="float:right;" class="btn-group">
                    <a href="index2.php?view=punto_cuenta_add" class="btn btn-default btn-primary">Agregar Archivo</a>
                </div>

                <h4 class="text-primary"><strong> MY NUBE </strong></h4> 
            </div>

            <br>

            <form name="punto_cuenta_load" method="POST" action="" enctype="multipart/form-data"> 
                <div class="col-lg-4">              
                    <div class="form-group">
                        <label>FECHAS:</label>   
                        <select name="year" id="year" onchange="javascript: submit_punto_cuenta_load();" class="form-control">
                            <?php 
                            $consulta_sql=pg_query("SELECT fecha_creacion FROM archivos order by fecha_creacion) ASC");                                
                            while ($array_consulta=pg_fetch_array($consulta_sql)){
                                if ($year!=""){
                                    if ($array_consulta[0]==$year){
                                        echo '<option value="'.$array_consulta[0].'" selected="selected">'.$array_consulta[0].'</option>';
                                    }else {
                                        echo '<option value="'.$array_consulta[0].'">'.$array_consulta[0].'</option>';
                                    }
                                }else {
                                    echo '<option value="'.$array_consulta[0].'">'.$array_consulta[0].'</option>';
                                }
                            }
                            pg_free_result($consulta_sql);                                  
                            ?>
                        </select> 
                    </div> 
                </div>      

                <div class="col-lg-4">
<?php if(($_SESSION['nivel']==0)){ ?>
                    <div class="form-group">
                        <label>CARPETAS:</label>  
                        <select name="cedula_usuario" id="cedula_usuario" class="form-control" onchange="javascript: submit_punto_cuenta_load();">
                            <option selected="selected" value="">TODAS LOS PRESENTANTES</option>
                            <?php 
                                $consulta_sql=pg_query("SELECT * FROM archivos, usuarios where usuarios.cedula_usuario=archivos.cedula_usuario order by usuarios.nombre_usuario");
                                while ($array_consulta=pg_fetch_array($consulta_sql)){
                                    if ($cedula_usuario==$array_consulta[0]){ 
                                        echo '<option selected="selected" value="'.$array_consulta[0].'">'.$array_consulta[1].' '.$array_consulta[2].'</option>';
                                    }else{
                                        echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].' '.$array_consulta[2].'</option>';
                                    }
                                }
                                pg_free_result($consulta_sql);                              
                            ?>              
                        </select> 
                    </div>
<?php }?>
                </div> 

                <div class="form-group col-lg-4">
                    <label>CONDICION:</label>
                    <select name="condicion" id="condicion" class="form-control" onchange="javascript: submit_punto_cuenta_load();" >
                        <?php
                            if($condicion=="1") {
                                echo '<option value="1" selected="selected">PRIVADOS</option>';
                                echo '<option value="2" >COMPARTIDOS</option>';
                            }elseif($condicion=="2") {
                                echo '<option value="1" >PRIVADOS</option>';
                                echo '<option value="2" selected="selected">COMPARTIDOS</option>';
                            }else{
                                echo '<option value="1" >PRIVADOS</option>';
                                echo '<option value="2" >COMPARTIDOS</option>';
                            }                                                                               
                        ?>
                    </select> 
                </div> 
            </form>

<!--Estructura de Tabla de Contedinos de la Tabla usuario-->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-gestion">
                    <thead>
                        <tr>
                            <th width="8%">COD</th>
                            <th width="35%">ASUNTO</th>
                            <th>PRESENTANTE</th>
                            <th>FECHA</th>
                            <th width="15%">ACCIONES</th>
                        </tr>
                    </thead>
<?php
$xxx=0;
while($resultados = pg_fetch_array($result))
{
	$xxx=$xxx+1;
?>
                    
                    <tbody>
                        <tr class="gradeA">
                            <td>
                                <?php echo $resultados[id_punto];?>
                            </td>

                            <td>
                                <?php echo $resultados[asunto];?>
                            </td>

                            <td>
                                <?php echo $resultados[nombre_usuario];?><?php echo " "?><?php echo $resultados[apellido_usuario];?>
                            </td>

                            <td>
                                <?php echo $resultados[fecha_punto];?>
                            </td>

                            <td align="center"> 
                                <?php if(($_SESSION['nivel']<>0)AND($resultados[condicion]==0)){
                                    echo '<a href="index2.php?view=punto_cuenta_drop&id_punto='.$resultados[id_punto].'" title="Pulse para eliminar el registro">
                                        <img border="0" src="images/borrar28.png" alt="borrar">
                                    </a>';

                                    echo '<a href="index2.php?view=punto_cuenta_update&id_punto='.$resultados[id_punto].'" title="Pulse para Modificar Los Datos">
                                        <img border="0" src="images/modificar.png" alt="borrar">
                                    </a>';
                                    
                                    echo '<a href="index2.php?view=enviar_punto&id_punto='.$resultados[id_punto].'" title="Pulse para Enviar el Punto">
                                        <img border="0" src="images/enviar.png" alt="borrar">
                                    </a>';
                                };?>

                                <?php if(($_SESSION['nivel']<>0)AND($resultados[condicion]==1)){
                                    echo '<font color="Red">ENVIADO</font>';
                                    };?>

                                    <?php if(($_SESSION['nivel']<>0)AND($resultados[condicion]==2)){
                                    echo '<a href="reportes/imprimir_punto_cuenta.php?id_punto='.$resultados[id_punto].'" title="Pulse para Imprimir" target="true">
                                        <img border="0" src="images/printer.png" alt="borrar">
                                    </a>';
                                };?>

                                <?php if(($_SESSION['nivel']==0)AND($resultados[condicion]==0)){
                                    echo '<font color="Red">CREANDO</font>';
                                    };?>

                                    <?php if(($_SESSION['nivel']==0)AND($resultados[condicion]==1)){
                                    echo '<a href="index2.php?view=responder_punto_cuenta&id_punto='.$resultados[id_punto].'" title="Pulse para Dar Respuesta">
                                        <img border="0" src="images/aprobar.png" alt="borrar">
                                    </a>';

                                    if($resultados[decision]<>""){
                                        echo '<a href="index2.php?view=notificar_punto_cuenta&id_punto='.$resultados[id_punto].'" title="Pulse para Dar Notificar">
                                            <img border="0" src="images/notificar.png" alt="borrar">
                                        </a>';
                                    }
                                };?>

                                <?php if(($_SESSION['nivel']==0)AND($resultados[condicion]==2)){
                                    echo '<a href="reportes/imprimir_punto_cuenta.php?id_punto='.$resultados[id_punto].'" title="Pulse para Imprimir" target="true">
                                        <img border="0" src="images/printer.png" alt="borrar">
                                    </a>';
                                };?>

                                <?php 
                                    if($resultados[name_file_upload]!=""){
                                        $dir_upload='upload_file/punto_cuenta/'; // Nombre del Directorio de las subidas de archivos
                                        $archivo = $dir_upload.$resultados[name_file_upload];                                                        
                                        if (file_exists($archivo)){
                                            echo '<a href="'.$archivo.'" download="'.$archivo.'" target="_blank" title="Descargar Archivo para Visualizar">
                                                    <img src="images/download28.png" name="Image_Encab"  border="0"/>
                                                </a>';
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>

<?php } ?>
                    <tfoot>
                    <tr align="center">
                        <th colspan="7" align="center">
                            <div id="cpanel">
                                <form method="GET" action="index2.php">
                                    <input type="hidden" name="view" value="punto_cuenta">
                                <select name="page">
                                    <div style="float:left;">
                                    <div class="icon">
                                <?php $j=0;  $p=0;
                                for ($i = 0; $i <= $totalPaginas; $i++) {
                                    $j=$i+1;

                                    ?>
                                    <option value="<?php echo $p; ?>"><?php echo $j; ?></option>
                                        
                                 <?php $p=$p+10;
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->


<?php
pg_free_result($datos_consulta);
pg_close();
?>