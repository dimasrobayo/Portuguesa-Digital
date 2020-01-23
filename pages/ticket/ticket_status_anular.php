<?php
    // chequear si se llama directo al script.
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="../images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    if ($_SERVER['HTTP_REFERER'] == "")	{
        echo "<script type='text/javascript'>window.location.href='index.php'</script>";
        exit;
    }
	
    $server=$_SERVER['SERVER_NAME']; // nombre del servidor web
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $view=$_GET["view"];	
    $pagina=$pag.'?view='.$view;

     //Conexion a la base de datos
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass")or die(pg_last_error());
    
    
    if (isset($_GET['cod_ticket'])){
        $cod_ticket=strtoupper($_GET['cod_ticket']);
        
        $query="SELECT * FROM ticket,tramites,solicitantes,estados_tramites,unidades,categorias". 
                " WHERE ticket.cod_ticket='$cod_ticket' AND ticket.cod_estado_tramite=estados_tramites.cod_estado_tramite ".
                " AND ticket.cedula_rif=solicitantes.cedula_rif AND ticket.cod_tramite=tramites.cod_tramite ".
                " AND tramites.cod_categoria=categorias.cod_categoria AND tramites.cod_unidad=unidades.cod_unidad";
        $result = pg_query($query)or die(pg_last_error());
        $total_result_ticket= pg_num_rows($result);
        $resultados_ticket=pg_fetch_array($result);	
        pg_free_result($result);
        
        if ($total_result_ticket){
            $query="SELECT * FROM detalles_ticket,estados_tramites,unidades". 
                    " WHERE detalles_ticket.cod_detalle_ticket='$resultados_ticket[cod_subticket]' AND detalles_ticket.cod_estado_tramite=estados_tramites.cod_estado_tramite ".
                    " AND detalles_ticket.cod_unidad=unidades.cod_unidad";
            $result = pg_query($query)or die(pg_last_error());
            $resultados_subticket=pg_fetch_array($result);	
            pg_free_result($result);
        }
        
    }
        
    if (isset($_POST[save])){   // Insertar Datos del formulario
        $cod_ticket=strtoupper($_POST['cod_ticket']);
        $situacion_actual=strtoupper($_POST['situacion_actual']);
        $actuacion=strtoupper($_POST['actuacion']);
        $observaciones=strtoupper($_POST['observaciones']);
//        $fecha_cita_programada=implode('-',array_reverse(explode('/',$_POST['fecha_cita_programada']))); 
//        $hora_cita_programada=date_format(date_create($_POST['hora_cita_programada']), 'H:i');
        
        $fecha_atencion=date('Y-m-d'); 
        $hora_atencion=date('H:i');
        
        $cod_unidad=$_POST['cod_unidad'];
        $cod_estado_tramite=7;
//        $monto_autorizado=$_POST["monto_autorizado"];
        $user=$_SESSION[user];
        
//        $thorad=$_POST['thorad'];
//        $tminutosd=$_POST['tminutosd'];
//        $hora_desde=date("H:i", mktime($thorad,$tminutosd,0));
        
        
        //CONSULTAR DATOS DE LA EMPRESA
        $query="SELECT * FROM empresa where rif_empresa = '$id_empresa'";
        $result = pg_query($query)or die(pg_last_error());
        $resultados_empresa=pg_fetch_array($result);	
        pg_free_result($result);

        $send_sms=$resultados_empresa[send_sms];
        $send_email=$resultados_empresa[send_email];
        $sms=$resultados_empresa[sms_anular_ticket];
        // FIN CONSULTA DE EMPRESA

       
        $error="bien";
//        $query="insert into detalles_ticket (cod_ticket,cod_estado_tramite,cod_unidad,fecha_cita_programada,hora_cita_programada,fecha_atencion,hora_atencion,situacion_actual,actuacion,monto_autorizado,observaciones,user_login) values ('$cod_ticket','$cod_estado_tramite','$cod_unidad','$fecha_cita_programada','$hora_cita_programada','$fecha_atencion','$hora_atencion','$situacion_actual','$actuacion','$monto_autorizado','$observaciones','$user') RETURNING cod_detalle_ticket";
        $query="insert into detalles_ticket (cod_ticket,cod_estado_tramite,cod_unidad,fecha_atencion,hora_atencion,situacion_actual,actuacion,observaciones,user_login) values ('$cod_ticket','$cod_estado_tramite','$cod_unidad','$fecha_atencion','$hora_atencion','$situacion_actual','$actuacion','$observaciones','$user') RETURNING cod_detalle_ticket";
        $result = pg_query($query)or die(pg_last_error());
        $result_insert_detalle=pg_fetch_row($result);
        $cod_subticket = $result_insert_detalle[0];
        pg_free_result($result);

        if ($result_insert_detalle[0]){
            $query="update ticket set cod_estado_tramite='$cod_estado_tramite', cod_subticket='$cod_subticket' where cod_ticket='$cod_ticket'";
            $result = pg_query($query)or die(pg_last_error());
            
            
            $query="SELECT * FROM ticket,tramites,solicitantes,estados_tramites,unidades,categorias". 
                " WHERE ticket.cod_ticket='$cod_ticket' AND ticket.cod_estado_tramite=estados_tramites.cod_estado_tramite ".
                " AND ticket.cedula_rif=solicitantes.cedula_rif AND ticket.cod_tramite=tramites.cod_tramite ".
                " AND tramites.cod_categoria=categorias.cod_categoria AND tramites.cod_unidad=unidades.cod_unidad";
            $result = pg_query($query)or die(pg_last_error());
            $total_result_ticket= pg_num_rows($result);
            $resultados_ticket=pg_fetch_array($result);	
            pg_free_result($result);

            if ($total_result_ticket){
                $query="SELECT * FROM detalles_ticket,estados_tramites,unidades". 
                        " WHERE detalles_ticket.cod_detalle_ticket='$resultados_ticket[cod_subticket]' AND detalles_ticket.cod_estado_tramite=estados_tramites.cod_estado_tramite ".
                        " AND detalles_ticket.cod_unidad=unidades.cod_unidad";
                $result = pg_query($query)or die(pg_last_error());
                $resultados_subticket=pg_fetch_array($result);	
                pg_free_result($result);
            }
            
            //// ENVIAR EMAIL A SOLICITANTE
            if($send_email==1){
                if($resultados_ticket[email]!="") {
                    $fecha=date_format(date_create($resultados_subticket['fecha_cita_programada']), 'd/m/Y');
                    $hora= date_format(date_create($resultados_subticket['hora_cita_programada']), 'g:i A.');
                    
                    $fecha_atencion=date_format(date_create($resultados_subticket['fecha_atencion']), 'd/m/Y');
                    $hora_atencion= date_format(date_create($resultados_subticket['hora_atencion']), 'g:i A.');
                    
                    require ("aut_sys_config_email_gmail.inc.php"); //consultar datos de variable
                    $body="Saludos de la Oficina de Atención al Soberano,<br><br> ".
                            " Se ha Actualizado su Solicitud en el Sistema de Atención Al Ciudadano (SAC). <br> ".
                            " A continuación los detalles: <br><br> ".
                            " <strong>Ticket Nro.:</strong> ".str_pad($cod_ticket,10,"0",STR_PAD_LEFT)."<br> ".
                            " <strong>Descripción de la Solicitud:</strong> $resultados_ticket[descripcion_ticket]<br> ".
                            " <strong>Monto de la Solicitud:</strong> $resultados_ticket[monto_solicitud]<br><br>".
                            " <strong>Estado actual del Tramite:</strong> $resultados_ticket[descripcion_estado_tramite]<br><br>".
                            " <strong>Fecha y Hora de Atención:</strong> $fecha_atencion $hora_atencion <br>".
                            " <strong>Situación Actual:</strong> $resultados_subticket[situacion_actual]<br>".
                            " <strong>Actuación:</strong> $resultados_subticket[actuacion]<br><br>".
                            " <a href=\"$ip_server/$dir_name/reportes/imprimir_tac_online.php?cod_ticket=$cod_ticket\" target=\"_blank\"> ".
                            " Pulse aquí para visualizar el Ticket</a><br><br>".
                            " No responda a este mensaje ya que ha sido generado automáticamente para su información.";						
                    $mail->Subject    = "Ticket Nro.: ".str_pad($cod_ticket,10,"0",STR_PAD_LEFT);
                    $mail->AltBody    = "Detalles Actualizacion del Ticket de Solicitud!"; // optional, comment out and test
                    $mail->MsgHTML($body);						
                    $mail->AddAddress($resultados_ticket[email], $resultados_ticket[nombre_solicitante]);
                    $mail->Send();
                    $mail->ClearAddresses();
                }
            }
            //// ENVIAR SMS AL SOLICITANTE
            if($send_sms==1){
                //INFORMACION PARA EL ENVIO DE SMS
                $destino=$resultados_ticket[telefono_movil];
                $sms=$sms.'; Ticket Nro.: '.$cod_ticket;
                $creatorId=$_SESSION['user'];

                //Conexion a la base de datos
                require("conexion_sms/aut_config.inc.php");
                $db_conexion=pg_connect("host=$sql_host_sms dbname=$sql_db_sms user=$sql_usuario_sms password=$sql_pass_sms");	

                $dest = preg_replace("/\s+/", "", $destino);
                $dest = str_replace("(", "", $dest);
                $dest = str_replace(")-", "", $dest);

                $total_send=0;
                if ( strlen($dest)==11 and ((stristr($dest, '0414') or stristr($dest, '0424') or stristr($dest, '0426') or stristr($dest, '0416') or stristr($dest, '0412') ))){
                    $error="bien";	
                    $query="SELECT insert_outbox('$dest','$sms','$creatorId')";								
                    $result = pg_query($query)or die(pg_last_error());
                    if(pg_affected_rows($result)){ 
                        $total_send++;	
                    }
                    pg_free_result($result);
                }

            }// FIN ENVIO SMS   
        }
    }
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
<!--aqui es donde esta el diseño del formulario-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div align="center">
                <font color="red" style="text-decoration:blink;">       
                    <?php echo $div_menssage;?>
                </font>
            </div>

            <div class="panel-heading">
                ANULAR TICKET
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1><?php echo 'Ticket Nro.: '.$cod_ticket.' Actualizado con &eacute;xito';?></h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=gestion_tickets<?php echo '&cod_ticket='.$cod_ticket;?>";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=gestion_tickets<?php echo '&cod_ticket='.$cod_ticket;?>" name="Continuar"> Continuar </a>]
                    </font>                             
                </h3>
            </div>
        
<?php	}else	{ 	?>   <!-- Mostrar formulario Original --> 

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input class="inputbox" type="hidden" id="cod_unidad" name="cod_unidad" value="<?php echo $resultados_subticket['cod_unidad']; ?>"/>
                        <input class="inputbox" type="hidden" id="cod_ticket" name="cod_ticket" value="<?php echo $resultados_ticket['cod_ticket']; ?>"/>
                        <div class="col-lg-12">
                            <div class="form-group" align="right">
                                <?php
                                    if($resultados_ticket['prioridad_ticket']==1){
                                        echo '<label class="radio-inline">
                                                <input id="prioridad"  class="validate[required] radio" name="prioridad" value="1" disabled="true" checked="true" type="radio"> NORMAL
                                            </label>

                                            <label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="2" disabled="true"  type="radio"> <font color="ffd200">ALTA</font>
                                            </label>
                                            <label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="3" disabled="true" type="radio"> <font color="Red">URGENTE</font>
                                            </label>';

                                    }elseif($resultados_ticket['prioridad_ticket']==2){
                                        echo '<label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="1" disabled="true" type="radio"> NORMAL
                                            </label>

                                            <label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="2"  disabled="true" checked="true" type="radio"> <font color="ffd200">ALTA</font>
                                            </label>

                                            <label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="3" disabled="true" type="radio"> <font color="Red">URGENTE</font>
                                            </label>';
                                    }else{
                                        echo '<label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="1" disabled="true" type="radio"> NORMAL
                                            </label>

                                            <label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="2" disabled="true"  type="radio"> <font color="ffd200">ALTA</font>
                                            </label>
                                            
                                            <label class="radio-inline">
                                                <input id="prioridad" class="validate[required] radio" name="prioridad" value="3" disabled="true" checked="true" type="radio"> <font color="Red">URGENTE</font>
                                            </label>';
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <h1>INF TICKET</h1>
                            <div class="form-group">
                                <label>NRO. TICKET</label>
                                <input type="text" id="cod_tac" name="cod_tac" readonly="true" value="<?php echo str_pad($resultados_ticket['cod_ticket'],10,"0",STR_PAD_LEFT);?>" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label>FECHA EMISIÓN</label>
                                <input type="text" id="fecha_registro_ticket" name="fecha_registro_ticket" readonly="true" value="<?php echo date_format(date_create($resultados_ticket['fecha_registro']), 'd/m/Y');?>" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>FECHA ASIGNACÓN</label>
                                <input type="text" id="fecha_registro" name="fecha_registro" readonly="true" value="<?php echo date_format(date_create($resultados_subticket['fecha_registro']), 'd/m/Y');?>" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label>ULTIMA UNIDAD ENCARGADA</label>
                                <input  readonly="readonly"  type="text" id="nombre_unidad_ult" readonly="true" name="nombre_unidad_ult" value="<?php echo $resultados_subticket[nombre_unidad];?>" class="form-control" size="50" maxlength="50"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <h1>ANULAR TICKET</h1>
                            <div class="form-group">
                                <label>SITUACIÓN ACTUAL</label>
                                <textarea class="form-control"  name="situacion_actual" id="situacion_actual" cols="84" rows="2"  >SU SOLICITUD FUE ANULADA Y NO PUEDE SER COMPLETADA CON EXITO</textarea>
                            </div>

                            <div class="form-group">
                                <label>ACTUACIÓN</label>
                                <textarea class="form-control" placeholder="ESCRIBA AQUI LAS RAZONES POR LA QUE SE HACE NECESARIO PROGRAMAR CITA PARA LA ATENCIÓN DEL REQUERIMIENTO"   name="actuacion" id="actuacion" rows="2" ><?php echo $resultados_ticket['descripcion_ticket']?></textarea> 
                            </div>

                            <div class="form-group">
                                <label>OBSERVACIONES</label>
                                <textarea  name="observaciones" id="observaciones" class="form-control" rows="2" ></textarea> 
                            </div>
                        </div>
                        <button type="submit" name="save" class="btn btn-default">Enviar</button>
                        <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=gestion_tickets&cod_ticket=<?php echo $cod_ticket;?>'" value="Cerrar" name="cerrar" />
                    </form>
                </div>
            </div>
<?php } ?> 
        </div>
    </div>
</div>