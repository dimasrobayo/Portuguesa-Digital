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
    
    if (isset($_GET[vehiculo])){
        $vehiculo=$_GET[vehiculo];
        
        $query="SELECT * FROM vehiculo_solicitante,solicitantes,marca_vehiculo WHERE vehiculo_solicitante.id_vehiculo=$vehiculo AND vehiculo_solicitante.cedula_rif=solicitantes.cedula_rif AND vehiculo_solicitante.cod_marca=marca_vehiculo.cod_marca";        
        $resulta = pg_query($query)or die(pg_last_error());
        $result_consulta=pg_fetch_array($resulta);
        pg_free_result($resulta);
        
        $error="";
    }
	
    if (isset($_POST[save])){
        $vehiculo=$_POST[vehiculo];
        $placa=$_POST['placa'];
        $marca=$_POST['marca'];
        $modelo=$_POST['modelo'];
        $year=$_POST[year];
        $color=$_POST['color'];
        $serialc=$_POST['serial_carro'];
        $serial=$_POST['serial'];
        
        // Consultamos si se modifico la carroceria para ver si existe
        if ($serial!=$serialc) {
            
            $query = "SELECT * FROM vehiculo_solicitante WHERE serial_carroceria='$serialc'";
            $result = pg_query($query)or die(pg_last_error());
            $result_insert=pg_fetch_array($result);
            pg_free_result($result);
        
            if ($result_insert[0]==0){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                $error="bien";
                $query="UPDATE vehiculo_solicitante SET cod_marca='$marca', modelo='$modelo', placa='$placa', year=$year, color='$color', serial_carroceria='$serialc' WHERE id_vehiculo=$vehiculo";
                $result = pg_query($query) or die('La consulta fall&oacute;: ' . pg_last_error());
                $resultado_carro=  pg_fetch_array($result);
            }else{
                $error="Error";
                $div_menssage='<div align="left"><h3 class="error"><font color="#CC0000" style="text-decoration:blink;">Error: Ya Existe un Vehiculo con el Nro de carroceria.: <font color="blue">'.$serialc.'</font>; para otro solicitante: <font color="blue">'.$result_consulta[nombre_solicitante].'</font>; por favor verifique los datos!</font></h3></div>';				
            }
        }else{
            $error="bien";
            $query="UPDATE vehiculo_solicitante SET cod_marca='$marca', modelo='$modelo', placa='$placa', year=$year, color='$color', serial_carroceria='$serialc' WHERE id_vehiculo=$vehiculo";
            $result = pg_query($query) or die('La consulta fall&oacute;: ' . pg_last_error());
            $resultado_carro=  pg_fetch_array($result);
        }
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<html>
    <head>
        <title>Mensaje</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="Content-Language" content="es-VE">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <link rel="shortcut icon" href="../images/favicon.ico" />
        
        <!-- styles form-->
        <!--<link rel="stylesheet" href="../../css/template_portada.css" type="text/css" />-->
        <link rel="stylesheet" href="../css/general_portada.css" type="text/css" />
        <!--<link rel="stylesheet" type="text/css" href="../../css/styles_general.css" media="screen" />-->
        <link rel="stylesheet" href="../css/styles_nuevo.css" type="text/css"/>
        <!--<link rel="stylesheet" href="../../css/template.css" type="text/css" />-->
        <link rel="stylesheet" href="../css/template_portada.css" type="text/css" />

        <!-- script del jquery, ajax y funciones javascript-->
        <script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>   
       <script language="javascript" src="../js/ajax.js"></script>
        <script type="text/javascript" src="../js/lib_javascript.js"></script>
        <script type="text/javascript" language="JavaScript1.2" src="../js/funciones.js"></script>
        <!-- <script type="text/javascript" language="JavaScript1.2" src="../js/disabled_keys.js"></script> -->

        <!-- script de la mascaras -->
        <script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
        
        <!-- styles y script del calendario Fecha -->	
        <link type="text/css" rel="stylesheet" href="../js/calendario_cat/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
        <script type="text/javascript" src="../js/calendario_cat/dhtmlgoodies_calendar_cat.js?random=20060118"></script>

        <!-- styles y script Validaciones -->

        <link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/LiveValidation.css" type="text/css" media="screen" />	
        <script src="../js/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
        <script src="../js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>	
        <script type="text/javascript" SRC="../js/livevalidation_standalone.js"></script>    	

    <!-- script de efectos -->	
        <script src="../js/prototype.js" type="text/javascript"></script>
        <script src="../js/scriptaculous.js" type="text/javascript"></script>
        <script src="../js/unittest.js" type="text/javascript"></script> 
        
        <!-- Token Input -->
      <script type="text/javascript" src="../js/tokeninput/src/jquery.tokeninput.min.js"></script>
      <link rel="stylesheet" href="../js/tokeninput/styles/token-input.css" type="text/css" />
      <link rel="stylesheet" href="../js/tokeninput/styles/token-input-facebook.css" type="text/css" />
      
      <script type="text/javascript" charset="utf-8">            
            jQuery(document).ready(function(){          
              jQuery("#QForm").validationEngine();          
            });
            
            
       </script>
        <script language="JavaScript">
            function aceptar(cedula) {
                opener.document.QForm.cedula_rif.value=cedula;
                close();
            }
        </script>
      
        
    </head>
<body style="background-color: #f9f9f9;" >
<?php if($div_menssage) { ?>					
    <script type="text/javascript">
            function ver_msg(){
                    Effect.Fade('msg');
            }  
            setTimeout ("ver_msg()", 5000); //tiempo de espera en milisegundos
    </script>
 <?php } ?>
    
    <table class="container_contenido_cat" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tbody>  			
            <tr>
                <td>
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input id="vehiculo" name="vehiculo" value="<?php echo $result_consulta[id_vehiculo];?>" type="hidden"/>
                        <input id="serial" name="serial" value="<?php echo $result_consulta['serial_carroceria'];?>" type="hidden"/>
                    <table class="adminform_cat" width="100%"  align="center">
                        <tbody>
                            <tr>
                                <th align="center">
                                    ACTUALIZACIÓN DE VEHICULOS
                                </th>
                            </tr>
                            
                            <?php if (isset($_POST[save])) {	?> <!-- Mostrar Mensaje -->

                            <tr>
                                <td colspan="2" align="center">
                                    <div align="center"> 
                                        <h3 class="info">	
                                            <font size="2">						
                                                <?php
                                                    if ($error=="bien"){	
                                                        echo 'Datos Modificador con &eacute;xito';
                                                    }else{
                                                        echo $div_menssage;
                                                    }
                                                ?>
                                                <br />
                                                <script type="text/javascript">
                                                    function redireccionar(){
                                                        window.location="?view=vehiculos";
                                                    }  
                                                    setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                                                </script> 						
                                                [<a href="?view=vehiculos" name="Continuar"> Continuar </a>]
                                            </font>							
                                        </h3>
                                    </div> 
                                </td>
                            </tr>

                            <?php }else{ 	?>   <!-- Mostrar formulario Original --> 
                            <tr>
                                <td>
                                    <table class="adminform" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <?php if($div_menssage) { ?>
                                            <tr>
                                                <td colspan="2" id="msg" align="center">		
                                                    <?php echo $div_menssage;?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                               <td  colspan="2"   height="18">
                                                   <span> Los campos con <font color="Red" style="bold">(*)</font> son obligatorios</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="titulo" colspan="2" height="18"  align="left"><b>Datos Principales:</b></td>
                                            </tr>
                                            <tr>
                                                <td width="15%" height="22">
                                                    Transportista:
                                                </td>
                                                <td width="75%" height="22">
                                                    <input class="validate[required] text-input" readonly="true" type="text" id="cliente" name="cliente" value="<?php echo $result_consulta[cedula_rif]." -- ".$result_consulta[nombre_solicitante];?>"  size="35"/>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="titulo" colspan="2" height="18"  align="left"><b>Información del Vehículo:</b></td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <table class="borded" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td width="15%" height="22">
                                                                    NÚMERO PLACA: <font color="Red">(*)</font>
                                                                </td>
                                                                <td  width="75%"  height="22">					
                                                                    <table border="0" >
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <input class="validate[required] text-input" autofocus="true" type="text" id="placa" name="placa" value="<?php echo $result_consulta['placa'];?>"  size="20" maxlength="15"/>	
                                                                                </td>
                                                                                <td width="25%" height="22">
                                                                                    MARCA: 
                                                                                </td>
                                                                                <td>
                                                                                    <div id="marca_vehiculo" >  
                                                                                        <select id="marca" name="marca" class="inputbox validate[required]" size="1">
                                                                                            <option value="">---</option>
                                                                                            <?php 
                                                                                                $consulta_sql=pg_query("SELECT * FROM marca_vehiculo ");
                                                                                                while ($array_consulta=pg_fetch_array($consulta_sql)){
                                                                                                    if ($array_consulta[0]==$result_consulta[cod_marca]){
                                                                                                        echo '<option value="'.$array_consulta[0].'"  selected="selected">'.$array_consulta[1].'</option>';
                                                                                                    }else{
                                                                                                        echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].'</option>';
                                                                                                    }
                                                                                                }
                                                                                                pg_free_result($consulta_sql);								
                                                                                            ?>																												
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                                <td>
                                                                                    <a href="javascript: ue_marca_add();"><img src="images/agregar.png" alt="Buscar" title="Registrar Marca" width="20" height="20" border="0"></a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td  width="15%" height="22">
                                                                    MODELO: <font color="Red">(*)</font>
                                                                </td>
                                                                <td  width="75%"  height="22">					
                                                                    <table border="0" >
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <input size="10" class="inputbox validate[required]"  type="text" id="modelo" name="modelo"  value="<?php echo $result_consulta['modelo'];?>" />
                                                                                </td>
                                                                                <td width="25%" height="22">
                                                                                    AÑO: <font color="Red">(*)</font>
                                                                                </td>
                                                                                <td>
                                                                                    <select id="year" name="year" class="validate[required]" size="1">
                                                                                            <?php 
                                                                                                echo '<option value="'.$result_consulta[year].'" selected="selected">'.$result_consulta[year].'</option>';
                                                                                                echo '<option value="">---</option>';			
                                                                                                for ($i=date("Y"); $i>=1950; $i--){																						
                                                                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                                }
                                                                                            ?>																																										
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td  width="15%" height="22">
                                                                    COLOR: <font color="Red">(*)</font>
                                                                </td>
                                                                <td  width="75%"  height="22">					
                                                                    <table border="0" >
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <input class="inputbox validate[required]" type="text" id="color" name="color" value="<?php echo $result_consulta['color'];?>"  size="30" maxlength="30"/>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>	
                                                            <tr>
                                                                <td  width="15%" height="22">
                                                                    SERIAL CARROCERIA: <font color="Red">(*)</font>
                                                                </td>
                                                                <td  width="75%"  height="22">					
                                                                    <table border="0" >
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <input class="validate[required] text-input" type="text" id="serial_carro" name="serial_carro" value="<?php echo $result_consulta['serial_carroceria'];?>"  size="30" maxlength="30"/>
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
                                                    <input id="submit"  class="button" type="submit" name="save" value="Enviar" />									
                                                    <input  class="button" type="button" onclick="javascript:window.location.href='?view=vehiculos'" value="Cerrar" name="cerrar" />  
                                                </td>		
                                            </tr>	
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </form> 
                </td>	 				 			  
            </tr>
        </tbody>
    </table>
    <script type="text/javascript" >
        function ue_marca_add()	{
            var mensaje="";
            miPopup = window.open("ticket/marca_vehiculo_add.php?status=1","miwin","width=550,height=200,scrollbars=yes,left=50,top=50,location=no,resizable=no");
            miPopup.focus();
        } 	
        
        function marca_add(){
            cargarContenidoMarcaVehiculo();
        } 	   
    </script>
    
  		  	
</body>
    
    
    
    
</html>
    
    
        