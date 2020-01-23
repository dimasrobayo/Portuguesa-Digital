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
?> 

<?php 
    if (isset($_GET['id_profesion'])){
    	$datos_modificar= $_GET['id_profesion'];	

	$query="SELECT * FROM profesion where id_profesion = $datos_modificar";
        $result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result);	
        pg_free_result($result);  	
    }
?> 

<?php 
    if (isset($_POST[save])) {
    	$id_profesion = trim($_POST['id_profesion']);
    	$nombre_profesion = trim($_POST['nombre_profesion']);
    
	// Consultamos si existe la descripcion
        $query = "SELECT * FROM profesion WHERE id_profesion=$id_profesion";
        $result = pg_query($query)or die(pg_last_error());
        $resultado_ente=pg_fetch_array($result);
        pg_free_result($result);
        
        if($resultado_ente[nombre_profesion]!=$nombre_profesion){
            // Consultamos si existe la descripcion
            $query = "SELECT * FROM profesion WHERE nombre_profesion='$nombre_profesion'";
            $result = pg_query($query)or die(pg_last_error());
            $resultado_load=pg_fetch_array($result);
            pg_free_result($result);
            
            if (!$resultado_load[0]) {
                //se le hace el llamado a la funcion de editar
                $query="SELECT update_profesion($id_profesion,'$nombre_profesion')";
                $result = pg_query($query)or die(pg_last_error());
                $error="bien";
            } else {
                $error="Error";
                $div_menssage='<div align="left">
                            <h3 class="error">
                                <font color="red" style="text-decoration:blink;">
                                    Error: Ya Existe un Registro con la descripcion: <font color="blue">'.$descripcion.'</font>; por favor verifique los datos!
                                </font>
                            </h3>
                        </div>';	
            }
            
        }else{
            //se le hace el llamado a la funcion de editar
            $query="SELECT update_profesion($id_profesion,'$nombre_profesion')";
            $result = pg_query($query)or die(pg_last_error());
            $error="bien";
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

<div align="center" class="centermain">
    <div class="main"> 
	<table border="0" width="100%" align="center">
            <tbody>			
                <tr>
                    <td  id="msg" align="center">		
                        <?php echo $div_menssage;?>
                    </td>
                </tr>
            </tbody>
        </table>  
        <table class="profesion_solicitante" width="100%">
            <tr>
                <th>
                    PROFESION:
                </th>
            </tr>
        </table>
        
        <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
            <table class="adminform" border="0" width="100%">
                <tr bgcolor="#55baf3">
                    <th colspan="2">
                        <img src="images/edit.png" width="16" height="16" alt="Editar Registro">
                        MODIFICAR DATOS DE PROFESION
                    </th>
                </tr>

		<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

                <tr>
                    <td colspan="2" align="center">
                        <div align="center"> 
                            <h3 class="info">	
                                <font size="2">						
                                    Datos registrados con &eacute;xito 
                                    <br />
                                    <script type="text/javascript">
                                        function redireccionar(){
                                            window.location="?view=profesion_solicitante";
                                        }  
                                        setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                                    </script> 						
                                    [<a href="?view=profesion_solicitante" name="Continuar"> Continuar </a>]
                                </font>							
                            </h3>
                        </div> 
                    </td>
                </tr>

                <?php	}else{ 	?>   <!-- Mostrar formulario Original --> 

                <tr>
                    <td colspan="2" height="16" align="left">
                        <span> Los campos con <font color="Red" style="bold">(*)</font> son obligatorios</span>
                    </td>
                </tr>
                <tr>
                    <td class="titulo" colspan="2" height="18"  align="left"><b>Datos del tipo de Solicitante:</b></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table class="borded" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
				            <tr>
                    			<td width="15%">
                        			CÓDIGO: <font color="Red">(*)</font>
                    			</td>		
			                    <td width="75%">
                        			<input id="id_profesion" name="id_profesion" value="<?php if ($error!="") echo $id_profesion; else echo $resultado[id_profesion]; ?>" readonly="true" class="inputbox" type="text"/>
                    			</td>                       
                		    </tr>
			
                		    <tr>
                    			<td width="15%">
                        			PROFEISON: <font color="Red">(*)</font>
                    			</td>	
                    			<td>
                                    <input  type="text" id="nombre_profesion" name="nombre_profesion" value="<?php if ($error!="") echo $nombre_profesion; else echo $resultado[nombre_profesion]; ?>" class="validate[required] text-input" size="80" maxlength="80"/>			
                    			</td>			
                            </tr>
                            </tbody>
                        </table>	
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="botones" align="center" >			
                        <input type="submit" class="button" name="save" value="  Guardar  " >
                        <input  class="button" type="button" onclick="javascript:window.location.href='?view=profesion_solicitante'" value="Cerrar" name="cerrar" />  
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
