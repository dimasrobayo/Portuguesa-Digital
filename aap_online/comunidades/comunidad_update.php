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
    $pagina=$pag.'?view='.$type;

    //se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?>

<?php //seccion para recibir los datos y modificarlos.
    if (isset($_GET['idcom'])){
        $datos_modificar= $_GET['idcom'];

        $query="SELECT * FROM comunidades,parroquias,municipios,estados WHERE comunidades.idcom='$datos_modificar' and comunidades.codest='$cod_estado' and comunidades.codmun='$cod_municipio' and   comunidades.codpar=parroquias.codpar and comunidades.codmun=parroquias.codmun and comunidades.codest=parroquias.codest and parroquias.codest=municipios.codest and parroquias.codmun=municipios.codmun and municipios.codest=estados.codest";
        $result = pg_query($query)or die(pg_last_error());
        $resultados=pg_fetch_array($result);
        pg_free_result($result);
    }
?> 

<?php 
    if (isset($_POST[save])) {
        $idcom= $_POST['idcom'];	
        $comunidad=$_POST['comunidad'];

        $error="bien";	
        $query="SELECT update_comunidad($idcom,'$comunidad')";
        $result = pg_query($query)or die(pg_last_error());
        pg_close($db_conexion);	//exit;	   
    }//fin del procedimiento modificar.
?>

<div align="center" class="centermain">
    <div class="main">  
        <table class="admincomunidad" width="100%">
            <tr>
                <th>
                    COMUNIDAD:
                </th>
            </tr>
        </table>
        
        <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
            <input id="idcom" name="idcom" value="<?php echo $datos_modificar; ?>" type="hidden"/>
            <table class="adminform" border="0" width="100%">
                <tr>
                    <th colspan="2" align="center">
                        <img src="images/edit.png" width="16" height="16" alt="Editar Registro">
                        MODIFICAR DATOS DE LA COMUNIDAD
                    </th>
                </tr>
                <?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->
                <tr>
                    <td colspan="2" align="center">
                        <div align="center"> 
                            <h3 class="info">	
                                <font size="2">						
                                    Datos Modificados con &eacute;xito 
                                    <br />
                                    <script type="text/javascript">
                                        function redireccionar(){
                                            window.location="?view=comunidades";
                                        }  
                                        setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                                    </script> 						
                                    [<a href="?view=comunidades" name="Continuar"> Continuar </a>]
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
                    <td class="titulo" colspan="2" height="18"  align="left"><b>Datos de la Comunidad:</b></td>
                </tr>
 		 
                <tr>
                    <td colspan="2">
                        <table class="borded" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>						
                            <tr>
                                <td width="15%" align="right">
                                    ESTADO: <font color="Red">(*)</font>
                                </td>
                                <td>
                                    <input type="hidden" id="codestado" name="codestado"  value="<?php echo $cod_estado;?>" />
                                    <select id="codest" disabled="true"  name="codest" class="validate[required]" onchange="cargarContenidoMunicipio();" onclick="cargarContenidoMunicipio();"  >
                                        <option value="">----</option>
                                        <?php 
//                                            $consulta_sql=mysql_query("SELECT * FROM estados order by codest") or die('La consulta fall&oacute;: ' . pg_last_error());
                                            $consulta_sql=pg_query("SELECT * FROM estados order by codest") or die('La consulta fall&oacute;: ' . pg_last_error());
//                                            while ($array_consulta= mysql_fetch_array($consulta_sql)){
                                            while ($array_consulta=  pg_fetch_array($consulta_sql)){
                                                if ($error!=""){
                                                    if ($array_consulta[1]==$codest){
                                                        echo '<option value="'.$array_consulta[1].'" selected="selected">'.$array_consulta[2].'</option>';
                                                    }else {
                                                        echo '<option value="'.$array_consulta[1].'">'.$array_consulta[2].'</option>';
                                                    }
                                                }else {
                                                    if ($array_consulta[1]==$cod_estado){
                                                        echo '<option value="'.$array_consulta[1].'" selected="selected">'.$array_consulta[2].'</option>';
                                                    }else {
                                                        echo '<option value="'.$array_consulta[1].'">'.$array_consulta[2].'</option>';
                                                    }
                                                }
                                            }
                                            pg_free_result($consulta_sql);
//                                            mysql_free_result($consulta_sql);
                                        ?>
                                    </select>
                                </td>	
                            </tr>
						
                            <tr>
                                <td width="15%" align="right">
                                    MUNICIPIO: <font color="Red">(*)</font>
                                </td>
                                <td>
                                    <div id="contenedor2">
                                        <input type="hidden" id="codmunicipio" name="codmunicipio"  value="<?php echo $cod_municipio;?>" />
                                        <?php										
                                            if ($error!=""){
                                                echo '<select name="codmun" disabled="true"  id="codmun" class="validate[required]" onChange="cargarContenidoParroquia();" onClick="cargarContenidoParroquia();>';
                                                echo '<option value="">----</option>';
                                                $consultax1="SELECT * from municipios where codest='$codest' order by codmun";
//                                                $ejec_consultax1=mysql_query($consultax1);
//                                                while($vector=mysql_fetch_array($ejec_consultax1)){                                                
                                                $ejec_consultax1=pg_query($consultax1);
                                                while($vector=pg_fetch_array($ejec_consultax1)){
                                                    if ($vector[2]==$codmun){
                                                        echo '<option value="'.$vector[2].'" selected="selected">'.$vector[3].'</option>';
                                                    }else {
                                                        echo '<option value="'.$vector[2].'">'.$vector[3].'</option>';
                                                    }
                                                }
                                                echo '</select>';
                                                pg_free_result($ejec_consultax1);	
//                                                mysql_free_result($ejec_consultax1);	
                                            }else {
                                                echo '<select name="codmun" disabled="true" id="codmun" class="validate[required]" onChange="cargarContenidoParroquia();">';
                                                echo '<option value="">----</option>';
                                                $consultax1="SELECT * from municipios where codest='$cod_estado' order by codmun";
//                                                $ejec_consultax1=mysql_query($consultax1);
//                                                while($vector=mysql_fetch_array($ejec_consultax1)){
                                                $ejec_consultax1=pg_query($consultax1);
                                                while($vector=pg_fetch_array($ejec_consultax1)){
                                                    if ($vector[2]==$cod_municipio){
                                                        echo '<option value="'.$vector[2].'" selected="selected">'.$vector[3].'</option>';
                                                    }else {
                                                        echo '<option value="'.$vector[2].'">'.$vector[3].'</option>';
                                                    }
                                                }
                                                echo '</select>';
//                                                mysql_free_result($ejec_consultax1);
                                                pg_free_result($ejec_consultax1);
                                            }	
                                        ?>															
                                    </div>
                                </td>	
                            </tr>
					
                            <tr >
                                <td width="15%" align="right">
                                    PARROQUIA: <font color="Red">(*)</font>
                                </td>
                                <td>		
                                    <div id="contenedor3">
                                        <input type="hidden" id="codmunicipio" name="codmunicipio"  value="<?php echo $cod_municipio;?>" />
                                        <?php 
                                            if ($error!=""){
                                                echo '<select name="codpar" id="codpar" disabled="true" class="validate[required]" ';
                                                echo '<option value="">----</option>';
                                                $consultax1="SELECT * from parroquias where codest='$codest' and codmun='$codmun' order by codpar";
//                                                $ejec_consultax1=mysql_query($consultax1);
//                                                while($vector=mysql_fetch_array($ejec_consultax1)){
                                                $ejec_consultax1=pg_query($consultax1);
                                                while($vector=pg_fetch_array($ejec_consultax1)){
                                                    if ($vector[3]==$codpar){
                                                        echo '<option value="'.$vector[3].'" selected="selected">'.$vector[4].'</option>';
                                                    }else {
                                                        echo '<option value="'.$vector[3].'">'.$vector[4].'</option>';
                                                    }
                                                }
                                                echo '</select>';
//                                                mysql_free_result($ejec_consultax1);	
                                                pg_free_result($ejec_consultax1);	
                                            }else {
                                                echo '<select name="codpar" id="codpar" disabled="true" class="validate[required]" ';
                                                echo '<option value="">----</option>';
                                                $consultax1="SELECT * from parroquias where codest='$cod_estado' and codmun='$cod_municipio' order by codpar";
//                                                $ejec_consultax1=mysql_query($consultax1);
//                                                while($vector=mysql_fetch_array($ejec_consultax1)){
                                                $ejec_consultax1=pg_query($consultax1);
                                                while($vector=pg_fetch_array($ejec_consultax1)){
                                                    if ($vector[3]==$resultados[codpar]){
                                                        echo '<option value="'.$vector[3].'" selected="selected">'.$vector[4].'</option>';
                                                    }else {
                                                        echo '<option value="'.$vector[3].'">'.$vector[4].'</option>';
                                                    }
                                                }
                                                echo '</select>';
//                                                mysql_free_result($ejec_consultax1);																		
                                                pg_free_result($ejec_consultax1);																		
                                            } 
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%" align="right">
                                    COMUNIDAD: <font color="Red">(*)</font>
                                </td>
                                <td>
                                    <input  type="text" id="comunidad" name="comunidad" value="<?php if ($error!='') echo $comunidad; else echo $resultados[descom];?>" class="validate[required] text-input" size="30" maxlength="50"/>
                                </td>
                            </tr>
                        </tbody>
                        </table>	
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="botones" align="center" >			
                        <input type="submit" class="button" name="save" value="  Guardar  " >
                        <input  class="button" type="button" onclick="javascript:window.location.href='?view=comunidades'" value="Cerrar" name="cerrar" />  
                    </td>													
                </tr> 
            <?php }  ?>	
        </table>
    </form>     
    <br>	 
    </div>
</div>

