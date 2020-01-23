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
    
    if (isset($_POST[save])){   // Insertar Datos del formulario
        $tipo_tramite=$_POST["tipo_tramite"];

        $query="SELECT ticket.name_file_upload FROM ticket,tramites,solicitantes,estados_tramites,unidades,categorias WHERE ticket.cod_tramite='$tipo_tramite' AND ticket.name_file_upload<>'' AND ticket.cod_estado_tramite=estados_tramites.cod_estado_tramite AND ticket.cedula_rif=solicitantes.cedula_rif AND ticket.cod_tramite=tramites.cod_tramite AND tramites.cod_categoria=categorias.cod_categoria AND tramites.cod_unidad=unidades.cod_unidad";
        $result = pg_query($query)or die(pg_last_error());

        while($resultados_ticket = pg_fetch_array($result)) {
                $root = "upload_file/";
                $file = "$resultados_ticket[name_file_upload]";
                echo $path = $root.$file;
                $type = '';
             
            if (is_file($path)) {
                    $size = filesize($path);
                    if (function_exists('mime_content_type')) {
                    $type = mime_content_type($path);
                } else if (function_exists('finfo_file')) {
                    $info = finfo_open(FILEINFO_MIME);
                    $type = finfo_file($info, $path);
                    finfo_close($info);
                }
                if ($type == '') {
                    $type = "application/force-download";
                }
                // Definir headers
                header("Content-Type: $type");
                header("Content-Disposition: attachment; filename=$file");
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: " . $size);
                // Descargar archivo
                readfile($path);
            } else {
             die("El archivo no existe.");
            }
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
        <table class="gestionreportes" width="100%">
            <tr>
                <th>
                    GESTIÓN DE DESCARGAS
                </th>
            </tr>
        </table>
	    					
        <form id="QForm" name="QForm" method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">
            <table class="adminform" border="0" width="100%">
                <tr>
                    <th colspan="2" align="center">
                        <img src="images/iconos/ver_detalle.png" width="16" height="16" alt="Nuevo Registro">
                        DESCARGAR ARCHIVOS POR TIPO DE TRAMITE
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
                                            window.location="?view=solicitante_load_view<?php echo '&cedula_rif='.$cedula_rif;?>";
                                        }  
                                        setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                                    </script> 						
                                    [<a href="?view=solicitante_load_view<?php echo '&cedula_rif='.$cedula_rif;?>" name="Continuar"> Continuar </a>]
                                </font>							
                            </h3>
                        </div> 
                    </td>
                </tr>

                <?php	}else{ 	?>   <!-- Mostrar formulario Original --> 
                
                <tr>
                   <td  colspan="2"   height="18">
                       <span> Los campos con <font color="Red" style="bold">(*)</font> son obligatorios</span>
                    </td>
                </tr>

                <tr>
                    <td class="titulo" colspan="2" height="18"  align="left">
                        <b>Información Básica del Reporte:</b>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <table class="borded" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="15%"> 
                                       TIPO DE TRAMITE: <font color="Red">(*)</font>
                                    </td>

                                    <td>
                                        <table class="borded" border="0" >
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div id="tipo_tramite">
                                                            <select name="tipo_tramite" id="tipo_tramite" class="validate[required]">
                                                                <option selected="selected" value="">---</option>
                                                                <?php 
                                                                    $consulta_sql=pg_query("SELECT cod_tramite, nombre_tramite FROM tramites order by nombre_tramite");
                                                                    while ($array_consulta=pg_fetch_array($consulta_sql)){              
                                                                        echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].'</option>';  
                                                                    }                                       
                                                                    pg_free_result($consulta_sql);                              
                                                                ?>              
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="15%"> 
                                       AÑO: <font color="Red">(*)</font>
                                    </td>

                                    <td>
                                        <table class="borded" border="0" >
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="year" id="year" onchange="javascript: submit_ticket_load();" >
                                                            <?php 
                                                            $consulta_sql=pg_query("SELECT date_part('year',fecha_registro) AS year FROM ticket  group by date_part('year',fecha_registro) order by date_part('year',fecha_registro) DESC");								
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
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>	
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" class="botones" align="center" >			
                        <input type="submit" class="button" name="save" value="  DESCARGAR  " >
                        <input  class="button" type="button" onclick="javascript:window.location.href='?view=home'" value="Cerrar" name="cerrar" />  
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

