<?php
    // chequear si se llama directo al script.
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="../../images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
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
    require("conexion_sms/aut_config.inc.php");
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
    
   
    if (isset($_GET['cedula_usuario'])){ // Recibir los Datos 
        $cedula_usuario= $_GET['cedula_usuario'];

        $query="select * from usuarios where usuarios.cedula_usuario='$cedula_usuario'";
        $result = pg_query($query)or die(pg_last_error());
        $result_solicitantes=pg_fetch_array($result);	
        pg_free_result($result);
    }

    if (isset($_POST[save])){   // Insertar Datos del formulario
        $cedula_usuario=$_POST['cedula_usuario'];		
        $destino=$_POST['telefono_movil'];
        $sms=$_POST['texto'];
        $creatorId=$_SESSION['username'];
        
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
            if(pg_affected_rows($result)){ // Verificamos y Cargamos la auditoria
                $total_send++;	
            }
            pg_free_result($result);
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

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div align="center">
                <font color="red" style="text-decoration:blink;">       
                    <?php echo $div_menssage;?>
                </font>
            </div>

            <div class="panel-heading">
                <h4 class="text-primary"><strong> MENSAJE DE TEXTO</strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                         
                        <h1>Mensaje de Texto Enviado con &eacute;xito</h1> 
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=usuarios";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=usuarios" name="Continuar"> Continuar </a>]
                    </font>							
                </h3>
            </div> 

            <?php	}else{ 	?>   <!-- Mostrar formulario Original --> 
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                    <input type="hidden" id="cedula_usuario" name="cedula_usuario"  value="<?php echo $result_solicitantes['cedula_usuario'];?>" />
                    <input type="hidden" id="telefono_movil" name="telefono_movil"  value="<?php echo $result_solicitantes['telefono_movil'];?>" />
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>C&Eacute;DULA / RIF:</label>
                                <?php  echo substr_replace($result_solicitantes['cedula_usuario'],'-',1,0); ?>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>NOMBRE DEL SOLICITANTE:</label>
                                <?php echo $result_solicitantes[nombre_usuario]; echo " "; echo $result_solicitantes[apellido_usuario];?>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>EMAIL:</label>
                                <?php echo $result_solicitantes['email_usuario'];?>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>TELEFONO MOVIL:</label>
                                <a color="red"><h1 style="font-size:1.8em;"><?php echo $result_solicitantes[telefono_movil];?></h1></a>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>MENSAJE DE TEXTO:</label>
                                <textarea class="form-control" name="texto" id="texto" rows="5" cols="55"></textarea>
                            </div>

                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Enviar  " >
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=usuarios'" value="Cerrar" name="cerrar" /> 
                        </div>
                    </form>
                </div>
            </div>
                <?php 
                    if ($status_dispositivo==1){
                        $comando='ls /dev/ | grep '.$puerto_dev;
                        $comd = popen ($comando,'r');
                        $excute = fread($comd, 2096);

                        if(!ereg($puerto_dev, $excute)){
                            echo '<tr><td colspan="2"><div align="center"><font size="2" color="red">El Dispositivo no se encuentra conectado o no esta disponible, por favor revise la conexión del equipo (Los mensajes serán enviados al ser conectado el Dispositivo).</font></div></td></tr>';
                        }  
                    }
                ?>

                <tr>
                    <td colspan="2" class="botones" align="center" >			
                         
                    </td>													
                </tr> 
            <?php }  ?>	
        </table>
    </form>     
    <br>	 
    </div>
</div> 
        
<script type="text/javascript">
	var dtabs=new ddtabcontent("divsG")
	dtabs.setpersist(true)
	dtabs.setselectedClassTarget("link") //"link" or "linkparent"
	dtabs.init()
</script>		

<script type="text/javascript" >
	jQuery(function($) {
	      $.mask.definitions['~']='[JVGjvg]';
	      //$('#fecha_nac').mask('99/99/9999');
      
	      $('#telefono').mask('(9999)-9999999');
	      $('#celular').mask('(9999)-9999999');
	      
	});
</script>

