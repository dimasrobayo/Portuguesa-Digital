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
    
    $server=$_SERVER['SERVER_NAME']; // nombre del servidor web
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $view=$_GET["view"];
    $pagina=$pag.'?view='.$view;

    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
    
    if (isset($_GET['id_orden'])){ // Recibir los Datos 
        $datos_modificar= $_GET['id_orden'];

        $query="SELECT * FROM ordenes, usuarios WHERE ordenes.cedula_usuario_orden = usuarios.cedula_usuario and ordenes.id_orden=$datos_modificar order by ordenes.id_orden";
        $result = pg_query($query)or die(pg_last_error());
        $result_usuarios=pg_fetch_array($result);	
        pg_free_result($result);
    }

    if (isset($_POST[save])) {
        $id_orden = $_POST['id_orden'];
        $accion_tomada = $_POST['accion_tomada'];
        $status_orden = 2;
        $error="bien";	

        //CONSULTAR DATOS DE LA EMPRESA
        $query="SELECT * FROM empresa where rif_empresa = '$id_empresa'";
        $result = pg_query($query)or die(pg_last_error());
        $resultados_empresa=pg_fetch_array($result);    
        pg_free_result($result);

        $send_sms=$resultados_empresa[send_sms];
        $send_email=$resultados_empresa[send_email];
        $sms=$resultados_empresa[sms_responder_orden];
	

        $query="SELECT update_responder_orden($id_orden,'now()','$accion_tomada',$status_orden)";
        $result = pg_query($query)or die(pg_last_error());
        $result_update=pg_fetch_row($result);
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
            $dir_upload='upload_file/ordenes/'; // Nombre del Directorio de las subidas de archivos
            $new_name_file=$id_orden.'.'.$ext_type;

            if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
                if( $ext_correcta && $size <= $upload_max ){
                    if( $_FILES['archivo']['error'] > 0 ){
                      $upload_menssage= 'Error: ' . $_FILES['archivo']['error'].'.';
                    }else{
                       move_uploaded_file($_FILES['archivo']['tmp_name'],$dir_upload .'/'.$new_name_file); 
                       $upload_menssage="Archivo Adjuntado con éxito.";
                       $upload_ok=1;

                       $query="update ordenes set name_file_upload='$new_name_file' where id_orden='$id_orden'";
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

        //// ENVIAR SMS AL SOLICITANTE
        if($send_sms==1){
            //INFORMACION PARA EL ENVIO DE SMS
            $query="select usuarios.telefono_movil from usuarios where usuarios.nivel_acceso = 0";
            $consulta_usuario = pg_query($query)or die(pg_last_error());

            $sms=$sms.'; Orden Nro.: '.$id_orden;
            $creatorId=$_SESSION['user'];

            //Conexion a la base de datos
            require("conexion_sms/aut_config.inc.php");
            $db_conexion=pg_connect("host=$sql_host_sms dbname=$sql_db_sms user=$sql_usuario_sms password=$sql_pass_sms");  

            $total_send=0;
            while($result_usuario = pg_fetch_array($consulta_usuario))
            {
                $destino=$result_usuario[telefono_movil];
                $dest = preg_replace("/\s+/", "", $destino);
                $dest = str_replace("(", "", $dest);
                $dest = str_replace(")-", "", $dest);
                if ( strlen($dest)==11 and ((stristr($dest, '0414') or stristr($dest, '0424') or stristr($dest, '0426') or stristr($dest, '0416') or stristr($dest, '0412') ))){
                    $error="bien";  
                    $query="SELECT insert_outbox('$dest','$sms','$creatorId')";                             
                    $result = pg_query($query)or die(pg_last_error());
                    if(pg_affected_rows($result)){ 
                        echo $total_send++; 
                    }
                    pg_free_result($result);
                }
            }
        }// FIN ENVIO SMS 
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
                <h4 class="text-primary"><strong> RESPONDER ORDEN </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                         
                        <h1>Orden Ejecutada con &eacute;xito</h1> 
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

<?php	} else{ 	?>   <!-- Mostrar formulario Original -->

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input id="id_orden" name="id_orden" value="<?php echo $result_usuarios[id_orden]; ?>" readonly="true" type="hidden"/>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>FECHA A CUMPLIR</label>
                                <input class="form-control" readonly="true" value="<?php echo $result_usuarios[fecha_culminacion]; ?>" type="date" id="fecha_culminacion" name="fecha_culminacion"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group" align="right">
                                <?php
                                    if($result_usuarios['prioridad']==1){
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad"  class="validate[required] radio" name="prioridad" value="1"  checked="true" type="radio"> NORMAL</label>';
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="2"   type="radio"><font color="ffd200">ALTA</font></label>';
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="3"  type="radio"><font color="Red">URGENTE</font></label>';
                                    }elseif($result_usuarios['prioridad']==2){
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="1"  type="radio"> NORMAL</label>';
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="2"   checked="true" type="radio"><font color="ffd200">ALTA</font></label>';
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="3"  type="radio"><font color="Red">URGENTE</font></label>';
                                    }else{
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="1"  type="radio"> NORMAL</label>';
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="2" type="radio"><font color="ffd200">ALTA</font></label>';
                                        echo '<label class="radio-inline"><input readonly="true" id="prioridad" class="validate[required] radio" name="prioridad" value="3" checked="true" type="radio"><font color="Red">URGENTE</font></label>';
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>ASIGNAR A</label>
                                <input autofocus="true" value="<?php echo $result_usuarios[nombre_usuario];?> <?php echo $result_usuarios[apellido_usuario]; ?>" class="form-control" readonly type="text" id="nombre" name="nombre" maxlength="50" size="25"/>   
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>DESCRIPCION DE LA ORDEN</label>
                                <textarea class="form-control" readonly="true" name="descripcion_orden" id="descripcion_orden" cols="70" rows="3"><?php echo $result_usuarios[descripcion_orden]; ?></textarea>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>ACCION TOMADA</label>
                                <textarea class="form-control" name="accion_tomada" id="accion_tomada" cols="70" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label>ADJUNTAR ARCHIVO</label>
                                <input type="file" id="archivo" name="archivo">
                            </div>
                            
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Responder  " >
                            <input class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=orden'" value="Cerrar" name="cerrar" /> 
                        </div>	
                    </form>
                </div>
            </div>

<?php }  ?>	

        </div>
    </div>
</div> 
        
<script type="text/javascript">
	var dtabs=new ddtabcontent("divsG")
	dtabs.setpersist(true)
	dtabs.setselectedClassTarget("link") //"link" or "linkparent"
	dtabs.init()
</script>
