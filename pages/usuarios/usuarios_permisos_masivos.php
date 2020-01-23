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
    $pagina=$pag.'?view='.$view;

    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    if (isset($_POST[save])) {
        $codigo_nivel=$_POST['codigo_nivel'];

        $query="SELECT * FROM $sql_tabla WHERE nivel_acceso = $codigo_nivel";
        $result = pg_query($query)or die(pg_last_error());
        $total_encontrados = pg_fetch_array($result);
        pg_free_result($result);
        
            
        if ($result_user[0]) {
            $error="Error";
            $div_menssage='<div align="left"><h3 class="error"><font color="#CC0000" style="text-decoration:blink;">Error: Ya Existe un Registro con la misma C&eacute;dula: <font color="blue">'.$result[0].'</font>; por favor verifique los datos!</font></h3></div>';				
        }else {	
            $error="bien";	
            $usuario=stripslashes($usuario);
            $passmd5=md5($password);
            
            $query = "insert into usuarios (cedula_usuario, nombre_usuario, apellido_usuario, usuario, pass, nivel_acceso, status, cod_unidad, solicitar_punto, recibir_orden, email_usuario, telefono_movil) values ('$cedula_insert','$nombre','$apellido','$usuario','$passmd5',$nivel_acceso, $status,$unidad,$solicitar_punto,$recibir_orden,'$email_usuario','$telefono_movil')";
            $result = pg_query($query)or die(pg_last_error());
            if(pg_affected_rows($result)){
                $error="bien";
            }					
        }
    } //fin del add        
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
                    <?php $error_accion_ms[$error_cod]?>
                </font>
            </div>  

            <div class="panel-heading">
                <h4 class="text-primary"><strong> PERMISOS POR GRUPOS DE USUARIOS </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos Registrados con &eacute;xito</h1>
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
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>Grupos de Usuarios</label>
                                <select id="codigo_nivel" name="codigo_nivel" size="0" class="form-control">
                                    <option value="">----</option>          
                                    <?php
                                        $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
                                        $consulta=pg_query("select * from niveles_acceso order by codigo_nivel");
                                        while ($array_consulta=pg_fetch_array($consulta)) {
                                            if( $array_consulta[0]==$codigo_nivel){
                                                echo '<option selected="selected" value="'.$array_consulta[0].'">'.$array_consulta[1].'</option>';
                                            }else{
                                                echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].'</option>';
                                            }
                                        }
                                        pg_free_result($consulta);
                                    ?>
                                </select>
                            </div>

                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Guardar  " >
                            <input class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=usuarios'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div>
                
<?php }  ?>

        </div>
    </div>
</div>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/js/jquery.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.js"></script>

<script type="text/javascript" >
    jQuery(function($) {
          $.mask.definitions['~']='[JEVGDCH]';
          //$('#fecha_nac').mask('99/99/9999');
          //$('#fecha_deposito').mask('99/99/9999');
          $('#telefono').mask('(9999)-9999999');
          $('#telefono_movil').mask('99999999999');
          $('#rif').mask('~-9999?9999-9',{placeholder:" "});
          $('#cedula').mask('~-9999?99999',{placeholder:" "});
       });  
</script>