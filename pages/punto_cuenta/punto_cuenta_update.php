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

    if (isset($_GET['id_punto'])){
        $datos_modificar= $_GET['id_punto'];

        //se le hace el llamado a la funcion de insertar.	
        $datos_consulta = pg_query("SELECT * FROM punto_cuenta, usuarios WHERE punto_cuenta.cedula_usuario = usuarios.cedula_usuario and punto_cuenta.id_punto = '$datos_modificar' order by punto_cuenta.id_punto") or die("No se pudo realizar la consulta a la Base de datos");

        $resultados1=pg_fetch_array($datos_consulta);
        pg_free_result($datos_consulta);
        pg_close();
    }
 
    if (isset($_POST[save])){//se resive los datos a ser modificados
        $cedula_usuario = strtoupper($_POST['cedula_usuario']);
        $id_punto = $_POST['id_punto'];
        $fecha_punto = $_POST['fecha_punto'];
        $asunto = $_POST['asunto'];
        $sintesis = $_POST['sintesis']; 

        //se le hace el llamado a la funcion de insertar.	
        $query = "SELECT update_punto_cuenta($id_punto,'$cedula_usuario','$fecha_punto','$asunto','$sintesis')";		
        $result = pg_query($query)or die(pg_last_error());
        $result_update=pg_fetch_array($result);
        pg_free_result($result);

        $error="bien";

        //// SUBIR ARCHIVO AL SERVIDOR
        if(isset($_FILES['archivo']) ){
            $name = $_FILES['archivo']['name']; 
            $name_tmp = $_FILES['archivo']['tmp_name'];
            $size = $_FILES['archivo']['size'];
            $type = $_FILES['archivo']['type'];

            $ext_permitidas = array('jpg','jpeg','gif','png','pdf','doc','xml','docx','xlsx','txt');
            $part_name = explode('.', $name);
            $ext_type=$part_name[1]; // Optenemos el tipo del archivo 
            $ext_correcta = in_array($ext_type, $ext_permitidas);

            $upload_max = 10000 * 2048; // Tamaño maximo del Archivo en Kb. (1 Mb)
            $dir_upload='upload_file/punto_cuenta/'; // Nombre del Directorio de las subidas de archivos
            $new_name_file=$id_punto.'.'.$ext_type;

            if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
                if( $ext_correcta && $size <= $upload_max ){
                    if( $_FILES['archivo']['error'] > 0 ){
                      $upload_menssage= 'Error: ' . $_FILES['archivo']['error'].'.';
                    }else{
                       move_uploaded_file($_FILES['archivo']['tmp_name'],$dir_upload .'/'.$new_name_file); 
                       $upload_menssage="Archivo Adjuntado con éxito.";
                       $upload_ok=1;

                       $query="update punto_cuenta set name_file_upload='$new_name_file' where id_punto='$id_punto'";
                       $result = pg_query($query)or die(pg_last_error());
                    }

                }else{
                    $upload_menssage="Formato ó Tamaño del Archivo es inválido.";
                }
            }else{
                $upload_menssage="Sin Archivo Seleccionado que Subir.";
            }
        }else{
            $upload_menssage="Punto de Cuenta Sin Archivo Adjunto.";
        }
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
                <h4 class="text-primary"><strong> ACTUALIZAR DATOS DEL PUNTO DE CUENTA </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){  ?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos Actualizado con &eacute;xito</h1>
                        <h1> <?php echo $upload_menssage; ?> </h1>
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=punto_cuenta";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=punto_cuenta" name="Continuar"> Continuar </a>]
                    </font>                         
                </h3>
            </div> 

<?php }else{ ?>   <!-- Mostrar formulario Original --> 

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input class="form-control" value="<?php echo $resultados1[id_punto]; ?>" type="hidden" id="id_punto" name="id_punto"/>
                        <input class="form-control" value="<?php echo $resultados1[cedula_usuario]; ?>" type="hidden" id="cedula_usuario" name="cedula_usuario"/>
                        <input class="form-control" value="<?php echo $resultados1[fecha_punto]; ?>" type="hidden" id="fecha_punto" name="fecha_punto"/>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>FECHA DE SOLICITUD</label>
                                <input class="form-control" value="<?php echo $resultados1[fecha_punto]; ?>" type="text" id="fecha" name="fecha" readonly/>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>PRESENTANTE</label>
                                <label></label>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>ASUNTO</label>
                                <textarea class="form-control" name="asunto" id="asunto" cols="70" rows="3"><?php echo $resultados1[asunto]; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>SINTESIS</label>
                                <textarea class="form-control" name="sintesis" id="sintesis" cols="70" rows="3"><?php echo $resultados1[sintesis]; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>ADJUNTAR ARCHIVO</label>
                                <input type="file" id="archivo" name="archivo">
                            </div>

                            <button type="submit" id="save" name="save" class="btn btn-default">enviar</button>
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=punto_cuenta'" value="Cerrar" name="cerrar" />
                        </div>
                    </form>  
                </div>
            </div>

<?php } ?> 

        </div>
    </div>
</div>