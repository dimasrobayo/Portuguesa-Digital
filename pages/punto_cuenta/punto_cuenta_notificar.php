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
    
    if (isset($_GET['id_punto'])){ // Recibir los Datos 
        $datos_modificar= $_GET['id_punto'];

        $query="SELECT * FROM punto_cuenta, usuarios WHERE punto_cuenta.cedula_usuario = usuarios.cedula_usuario and punto_cuenta.id_punto=$datos_modificar order by punto_cuenta.id_punto";
        $result = pg_query($query)or die(pg_last_error());
        $result_usuarios=pg_fetch_array($result);	
        pg_free_result($result);
    }

    if (isset($_POST[save])) {
        $id_punto = $_POST['id_punto'];
        $condicion=2;	

        //CONSULTAR DATOS DE LA EMPRESA
        $query="SELECT * FROM empresa where rif_empresa = '$id_empresa'";
        $result = pg_query($query)or die(pg_last_error());
        $resultados_empresa=pg_fetch_array($result);    
        pg_free_result($result);

        $send_sms=$resultados_empresa[send_sms];
        $send_email=$resultados_empresa[send_email];
        $sms=$resultados_empresa[sms_notificar_punto];
        // FIN CONSULTA DE EMPRESA

	    $query="SELECT update_notificar_punto($id_punto,$condicion)";
        $result = pg_query($query)or die(pg_last_error());
        $result_update=pg_fetch_array($result);
        pg_free_result($result);

        //// ENVIAR SMS AL SOLICITANTE
        if($send_sms==1){
            //INFORMACION PARA EL ENVIO DE SMS
            $query="select usuarios.telefono_movil from punto_cuenta, usuarios where punto_cuenta.cedula_usuario = usuarios.cedula_usuario and id_punto='$id_punto'";
            $result = pg_query($query)or die(pg_last_error());
            $result_usuario=pg_fetch_array($result); 
            $destino=$result_usuario[telefono_movil];

            $sms=$sms.'; Punto de Cuenta Nro.: '.$id_punto;
            $creatorId=$_SESSION['user'];

            //Conexion a la base de datos
            require("conexion_sms/aut_config.inc.php");
            $db_conexion=pg_connect("host=$sql_host_sms dbname=$sql_db_sms user=$sql_usuario_sms password=$sql_pass_sms");  

            $dest = preg_replace("/\s+/", "", $destino);
            $dest = str_replace("(", "", $dest);
            echo $dest = str_replace(")-", "", $dest);

            $total_send=0;
            if ( strlen($dest)==11 and ((stristr($dest, '0414') or stristr($dest, '0424') or stristr($dest, '0426') or stristr($dest, '0416') or stristr($dest, '0412') ))){
                $error="bien";  
                $query="SELECT insert_outbox('$dest','$sms','$creatorId')";                             
                $result = pg_query($query)or die(pg_last_error());
                if(pg_affected_rows($result)){ 
                    echo $total_send++; 
                }
                pg_free_result($result);
            }
        }// FIN ENVIO SMS  
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
                <h4 class="text-primary"><strong> NOTIFICADO PUNTO DE CUENTA </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                         
                        <h1>Punto de Cuenta Notificado con &eacute;xito</h1> 
                        <br />
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

<?php	} else{ 	?>   <!-- Mostrar formulario Original -->

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input id="id_punto" name="id_punto" value="<?php echo $result_usuarios[id_punto]; ?>" readonly="true" type="hidden"/>
                        <div class="col-lg-12">
                            <div class="form-group" align="right">
                                <?php
                                if($result_usuarios[decision]==1){
                                echo '<label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="1" checked="true" type="radio"> 
                                    APROBADO
                                </label>

                                <label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="2" type="radio"> 
                                    <font color="RED">NEGADO</font>
                                </label>
                                <label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="3" type="radio">
                                    <font color="blue">DEFERIDO</font>
                                </label>';
                                }elseif ($result_usuarios[decision]==2) {
                                echo '<label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="1" type="radio"> 
                                    APROBADO
                                </label>

                                <label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="2" checked="true" type="radio"> 
                                    <font color="RED">NEGADO</font>
                                </label>

                                <label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="3" type="radio">
                                    <font color="blue">DEFERIDO</font>
                                </label>';
                                }else{
                                echo '<label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="1" type="radio"> 
                                    APROBADO
                                </label>

                                <label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="2" type="radio"> 
                                    <font color="RED">NEGADO</font>
                                </label>

                                <label class="radio-inline">
                                    <input id="decision" name="decision" readonly="true" value="3" checked="true" type="radio">
                                    <font color="blue">DEFERIDO</font>
                                </label>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>Nombres</label>
                                <input autofocus="true" value="<?php echo $result_usuarios[nombre_usuario];?> <?php echo " "?> <?php echo $result_usuarios[apellido_usuario]; ?>" class="form-control" readonly type="text" id="nombre" name="nombre" maxlength="50" size="25"/>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>ASUNTO</label>
                                <textarea class="form-control" readonly="true" name="asunto" id="asunto" cols="70" rows="3"><?php echo $result_usuarios[asunto]; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>SINTESIS</label>
                                <textarea class="form-control" name="sintesis" id="sintesis" readonly="true" cols="70" rows="3"><?php echo $result_usuarios[sintesis]; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>INSTRUCION</label>
                                <textarea class="form-control" name="instruccion" id="instruccion" readonly="true" cols="70" rows="3"><?php echo $result_usuarios[instruccion];?></textarea>
                            </div>
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Notificar  " >
                            <input class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=punto_cuenta'" value="Cerrar" name="cerrar" /> 
                        </div>	
                    </form>
                </div>
            </div>

<?php }  ?>	

        </div>
    </div>
</div>