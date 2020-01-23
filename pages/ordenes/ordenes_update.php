<?php //seccion de mensajes del sistema.
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
    
    $server=$_SERVER['SERVER_NAME']; // nombre del servidor web
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $view=$_GET["view"];	
    $pagina=$pag.'?view='.$view;

    //Conexion a la base de datos
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    if (isset($_GET['id_orden'])){
        $datos_modificar= $_GET['id_orden'];

        //se le hace el llamado a la funcion de insertar.	
        $datos_consulta = pg_query("SELECT * FROM ordenes, usuarios WHERE ordenes.cedula_usuario_orden = usuarios.cedula_usuario and ordenes.id_orden = '$datos_modificar' order by ordenes.id_orden") or die("No se pudo realizar la consulta a la Base de datos");

        $resultados1=pg_fetch_array($datos_consulta);
        pg_free_result($datos_consulta);
        pg_close();
    }
 
    if (isset($_POST[save])){//se resive los datos a ser modificados
        $id_orden = $_POST['id_orden'];
        $cedula_usuario = $_POST['cedula_usuario_orden'];
        $descripcion_orden = $_POST['descripcion_orden'];
        $fecha_culminacion = $_POST['fecha_culminacion'];
        $prioridad = $_POST['prioridad'];
        $status_orden = $_POST['status_orden'];

        //se le hace el llamado a la funcion de insertar.
        $query = "SELECT update_orden($id_orden,'$cedula_usuario','$descripcion_orden','$fecha_culminacion',$prioridad,$status_orden)";		
        $result = pg_query($query)or die(pg_last_error());
        $result_update=pg_fetch_array($result);
        pg_free_result($result);

        $error="bien";
    }//fin del procedimiento modificar.
?>

<!-- sincronizar mensaje cuando de muestra al usuario -->
<?php if($div_menssage) { ?>					
	<script type="text/javascript">
		function ver_msg(){
                    Effect.Fade('msg');
		}  
		setTimeout ("ver_msg()", 5000); //tiempo de espera en milisegundos
	</script>
 <?php } ?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div align="center">
                <font color="red" style="text-decoration:blink;">		
                    <?php echo $div_menssage;?>
                </font>
            </div>

            <div class="panel-heading">
                <h4 class="text-primary"><strong> ACTUALIZAR DATOS DE LA ORDEN </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){  ?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos Actualizado con &eacute;xito</h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=ordenes";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=ordenes" name="Continuar"> Continuar </a>]
                    </font>                         
                </h3>
            </div> 

<?php }else{ ?>   <!-- Mostrar formulario Original --> 

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input class="form-control" value="<?php echo $resultados1[id_orden]; ?>" type="hidden" id="id_orden" name="id_orden"/>
                        <input class="form-control" value="<?php echo $resultados1[status_orden]; ?>" type="hiddent" id="status_orden" name="status_orden"/>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>FECHA A CUMPLIR</label>
                                <input class="form-control" value="<?php echo $resultados1[fecha_culminacion]; ?>" type="date" id="fecha_culminacion" name="fecha_culminacion"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" align="right">
                                <?php
                                    if($resultados1['prioridad']==1){
                                        echo '<label class="radio-inline"><input id="prioridad"  class="validate[required] radio" name="prioridad" value="1"  checked="true" type="radio"> NORMAL</label>';
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="2"   type="radio"><font color="ffd200">ALTA</font></label>';
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="3"  type="radio"><font color="Red">URGENTE</font></label>';
                                    }elseif($resultados1['prioridad']==2){
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="1"  type="radio"> NORMAL</label>';
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="2"   checked="true" type="radio"><font color="ffd200">ALTA</font></label>';
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="3"  type="radio"><font color="Red">URGENTE</font></label>';
                                    }else{
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="1"  type="radio"> NORMAL</label>';
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="2" type="radio"><font color="ffd200">ALTA</font></label>';
                                        echo '<label class="radio-inline"><input id="prioridad" class="validate[required] radio" name="prioridad" value="3" checked="true" type="radio"><font color="Red">URGENTE</font></label>';
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>ASIGNAR A</label>
                                <select id="cedula_usuario_orden" name="cedula_usuario_orden" size="0" class="form-control">
                                    <option value="<?php echo $resultados1[cedula_usuario_orden]; ?>">--Seleccionar para Modificar--</option>          
                                        <?php
                                            $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
                                            $consulta=pg_query("select usuarios.cedula_usuario, usuarios.nombre_usuario, usuarios.apellido_usuario from usuarios where usuarios.recibir_orden=1 order by usuarios.nombre_usuario");
                                            while ($array_consulta=pg_fetch_array($consulta)) {
                                                 echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].' '.$array_consulta[2].'</option>';
                                            }
                                            pg_free_result($consulta);
                                        ?>
                                </select>   
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>DESCRIPCION DE LA ORDEN</label>
                                <textarea class="form-control" name="descripcion_orden" id="descripcion_orden" cols="70" rows="3"><?php echo $resultados1[descripcion_orden]; ?></textarea>
                            </div>
                            <button type="submit" id="save" name="save" class="btn btn-default btn-primary">enviar</button>
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=punto_cuenta'" value="Cerrar" name="cerrar" />
                        </div>
                    </form>  
                </div>
            </div>

<?php } ?> 

        </div>
    </div>
</div>