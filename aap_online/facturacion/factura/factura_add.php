<?php  // el NOMBRE y ruta de esta misma pagina.
    $redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$type;

    //Conexion a la base de datos
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $iva=$var_iva;
    $consulta=pg_query("insert into facturatmp (fecha_factura,hora_factura) values ('now()','now()') RETURNING n_factura") or die('La consulta fall&oacute;: ' . pg_last_error());
    $result_consulta=pg_fetch_row($consulta);
    $codfacturatmp = $result_consulta[0];

?>

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

        <table class="adminfactura">
            <tr>
                <th class="adminfactura">
                    FACTURACIÓN
                </th>
            </tr>
        </table>
        <!-- formulario para buscar al cliente registrado -->			
        <form id="facturacion" name="facturacion" method="POST" action="index2.php?view=factura_save" onSubmit="return validar_form_enviado();" enctype="multipart/form-data">  				
            <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp?>" type="hidden">
            <input id="iva" name="iva" value="<?php echo $iva?>" type="hidden">
            <input id="status_modif_fp" name="status_modif_fp" value="0" type="hidden" >
            
            <table class="adminform" border="0" width="100%">
                <tr bgcolor="#55baf3">
                    <th colspan="2">
                        DATOS DEL CLIENTE
                    </th>
                </tr>
			
                <?php if ((isset($_POST[save])) and ($error=="bien")) { ?> 
                
                <tr>
                    <td colspan="2" align="center">
                        <div align="center"> 
                            <h3 class="info">	
                                <font size="2">						
                                    Datos registrados con &eacute;xito 
                                    <br />
                                    <script type="text/javascript">
                                        function redireccionar(){
                                            window.location="?view=factura";
                                        }  
                                        setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                                    </script> 						
                                    [<a href="?view=factura" name="Continuar"> Continuar </a>]
                                </font>							
                            </h3>
                        </div> 
                    </td>
                </tr>
			
                <?php }else{ ?> 
                	
                <tr>
                    <td colspan="2" height="16" align="left">
                        <span> Los campos con <font color="Red" style="bold">(*)</font> son obligatorios</span>
                    </td>
                </tr>
                
                <tr>
                    <td width="15.3%" >
                        CEDULA/RIF DEL CLIENTE: <font color="Red">(*)</font>
                    </td>
                    <td width="84.8%">
                        <table width="100%"  border="0" >
                            <tbody>
                                <tr>
                                    <td width="12%">
                                       <div align="left">
                                           <input id="cedula_solicitante" name="cedula_solicitante" autofocus="true" type="text"  value=""  size="10" maxlength="12" onblur="cargarContenidoPersona();"/>
                                           <!--<input  class="button" type="button" onClick="cargarContenidoPersona();" value="Buscar" name="Buscar" />--> 
                                           <!--<input id="cedula_rif" name="cedula_rif" autofocus="true" type="text"  value=""  size="10" maxlength="12" onblur="cargarContenedorColaborador();"/>-->
                                            <a href="javascript: ue_buscarcliente();"><img src="images/busqueda.png" alt="Buscar" title="Buscar Colaborador" width="15" height="15" border="0"></a>
                                            <img src="images/ayuda.png" width="16" height="16" alt="Ayuda" onmouseover="muestraAyuda(event, 'Cédula RIF','Ingrese la Cédula ó RIF.   Ej.: Cedula:V-123456 ó RIF:J-12345678-0', ' (Campo Requerido)')">														
                                        </div>
                                    </td>
                                    <td width="30%">
                                        <div id="ContenedorPersonaAdd" align="left">

                                        </div>
                                    </td>
                                    <td align="right">
                                        TIPO FACTURA:
                                        <select id="tipo_factura" name="tipo_factura"  class="inputbox validate[required]" size="1">
                                            <option value="1">CONTADO</option>
                                            <option value="2">CREDITO</option>																						
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--&nbsp;-->
<!--                        <input id="cedula_solicitante" name="cedula_solicitante" class="validate[required,minSize[5]] text-input" type="text"  value=""  size="10" maxlength="12" onblur="cargarContenidoPersona();"/> 
                        <img src="images/ver.png" width="16" height="16" onClick="cargarContenidoPersona()" onMouseOver="style.cursor=cursor">-->
                    </td>
		</tr>
                
		<tr>
                    <td colspan="2">
                        <div id="ContenedorPersonas"> 
                            <table class="adminform"  border="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="15%">
                                            NOMBRE DEL CLIENTE:
                                        </td>

                                        <td width="85%">
                                            <input type="hidden" id="nombre_solicitante" name="nombre_solicitante" value="" />
                                            <input readonly="true" type="text" id="nombre_apellido" name="nombre_apellido" maxlength="50" size="50" />																	
                                        
                                            TIPO CLIENTE:
                                        
                                            <input readonly="true" type="text" id="tipo_solicitante" name="tipo_solicitante"  maxlength="50" size="50" />																	
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            DIRECCION:
                                        </td>

                                        <td>
                                            <input readonly="true" type="text" id="direccion" name="direccion" maxlength="90" size="90" />																	
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
		</tr>
            </table>
        </form>
        
        <br/>
            
        <form id="formulario_lineas" name="formulario_lineas" method="post" action="facturacion/factura/frame_lineas.php" target="frame_lineas">
            <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>" type="hidden">
            <input id="iva" name="iva" value="<?php echo $iva?>" type="hidden">
            
            <input type="hidden" id="cedula_personal" name="cedula_personal" value="<?php echo $resultados[cedula_personal]?>">	
            
            <table class="adminform" border="0" width="100%">
                <tr>
                    <th class="rowformleft" colSpan="2" width="100%"  height="16">
                        <span>CONCEPTOS A FACTURAR</span> 				
                    </th>
                </tr>
                
                <tr id="periodo">
                    <td colspan="2">
                        <table  class="adminform" width="100%" cellspacing=0 cellpadding=0 border=1 >
                            <tr>
                                <td width="15%" >
                                    <input type="text" placeholder="Código Concepto" id="codigo_concepto" name="codigo_concepto" maxlength="25" size="23" onblur="cargarContenedorConcepto()"/>
                                    <a href="javascript: ventanaconceptos();"><img src="images/busqueda.png" alt="Buscar" title="Buscar Concepto" width="15" height="15" border="0"></a>
                                    <!--<img src="images/ver.png" width="16" height="16" onClick="ventanaconceptos()" onMouseOver="style.cursor=cursor" id="buscar_concepto" name="buscar_concepto">-->
                                    </td>
                                <td width="80%">
                                    <div id="ContenedorConcepto">
                                        <input id="status_stock" name="stock_stock" value="" type="hidden">
                                        <input id="stock" name="stock" value="" type="hidden">
                                        <input id="cantidad_factura" name="cantidad_factura" value="" type="hidden">
                                        DESCRIPCION:
                                        <input type="text" id="descripcion_concepto" name="descripcion_concepto" readonly="true"  size="50"/>       		
                                        &nbsp;&nbsp;&nbsp;

                                        PRECIO:
                                        <input type="text" id="costo_unitario" style="text-align:right" name="costo_unitario" readonly="true" size="12">	
                                        &nbsp;&nbsp;&nbsp;

                                        CANTIDAD:
                                        <input type="text" id="cantidad" style="text-align:right" name="cantidad" size="6" value="1" onfocus="actualizar_importe()" onkeyup="actualizar_importe()">	
                                        &nbsp;&nbsp;&nbsp;

                                        MONTO:
                                        <input type="text" style="text-align:right" id="total" name="total" size="12" readonly="true">
                                        &nbsp;&nbsp;&nbsp;


                                    </div>
                                </td>
                                <td align="center">
                                    <input  class="button" type="button" onClick="validar()" value="Agregar" name="agregar" /> 
                                   <!--<img src="../images/botonagregar.jpg" width="72" height="22" border="1" onClick="validar()" onMouseOver="style.cursor=cursor" title="Agregar articulo">-->
                                </td>
                            </tr>
                        </table>
                    </td>
                    
                </tr>
                
                

                <tr>
                    <td colspan="2">
                        <div id="frmBusqueda">
<!--                            <table class="fuente8" width="100%" cellspacing=0 cellpadding=0 border=0 id="Table1">
                                <tr class="cabeceraTabla">
                                    <td class="aCentro" width="5%"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ITEM</td>
                                    <td align="center" width="5%">&nbsp;REFERENCIA</td>
                                    <td align="center" width="35%">DESCRIPCION</td>
                                    <td align="center" width="6%">&nbsp;&nbsp;&nbsp;CANTIDAD</td>
                                    <td align="center" width="6%">&nbsp;&nbsp;&nbsp;PRECIO</td>
                                    <td align="center" width="6%">MONTO</td>
                                    <td align="center" width="3%">&nbsp;</td>
                                </tr>
                            </table>-->
                            <table class="adminform" width="100%" cellspacing=0 cellpadding=0 border=1 >
                                <tr>
                                    <td align="center" width="5%" height="12"  class="botones"  ><strong>ITEM</strong></td>
                                    <td align="center" width="10%" height="10"  class="botones"  ><strong>REFERENCIA </strong></td>
                                    <td align="center" width="35%" height="12"  class="botones"  ><strong>DESCRIPCIÓN DEL CONCEPTO</strong></td>
                                    <td align="center" width="6%" height="12"  class="botones"  ><strong>CANTIDAD</strong></td>
                                    <td align="center" width="6%" height="12"  class="botones"  ><strong>PRECIO</strong></td>
                                    <td align="center" width="6%" height="12"  class="botones"  ><strong>MONTO</strong></td>
                                    <td align="center" width="3%" height="12"  class="botones"  >&nbsp;</td>
                                </tr>
                            </table>

                            <div id="lineaResultado">
                                <iframe width="100%" height="160" id="frame_lineas" name="frame_lineas" frameborder="0">
                                    <ilayer width="100%" height="160" id="frame_lineas" name="frame_lineas"></ilayer>
                                </iframe>
                            </div>
                        </div>
                    </td>	
                </tr>

                <tr>
                    <td  colspan="2"   height="16">
                        <hr size="1" width="100%" color="black" noshade>				
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" >
                        <!--<table  width="100%" border=1 cellpadding=0 cellspacing=0 class="fuente8">-->
                        <table  width="100%" border=1 cellpadding=0 cellspacing=0 class="adminform">
                            <tr>
                                <td width="20%" >
                                    <div id="cpanel">
                                        <div style="float:left;">
                                            <div class="icon">
                                                <a href="#">
                                                    <img src="images/factura.png"  onClick="validar_cabecera()" border="0" onMouseOver="style.cursor=cursor">
                                                    <span>Facturar</span>
                                                </a>
                                            </div>
                                        </div>								
                                    </div>

                                    <div id="cpanel">
                                        <div style="float:left;">
                                            <div class="icon">
                                                <a href="index2.php?view=factura">
                                                    <img src="images/cpanel.png" alt="salir" align="middle"  border="0" />
                                                    <span>Salir</span>
                                                </a>
                                            </div>
                                        </div>								
                                    </div>
                                </td>
                                <td width="58%" >
                                    <table width="100%" border=0 align="left" cellpadding=3 cellspacing=0 class="adminform">
                                            <tr>
                                                <td colspan="3" align="left" width="5%" height="12"  class="botones"  ><font size="3"><strong>DATOS FORMA DE PAGO</strong></font></td>
                                            </tr>
                                            <tr>
                                                <td width="20%" ><font size="2"><strong>TOTAL EFECTIVO:</strong></font></td>
                                                <td width="20%" align="right">
                                                    <div align="left">
                                                    <input  style=" height:17px; font-size:18px;  text-align:right"  name="total_efectivo" type="text" id="total_efectivo" size="10" value=0.00 align="right" readonly> 
                                                    <strong>Bs.</strong>
                                                    </div>
                                                </td>
                                                <td width="60%" rowspan="2">
                                                    <table class="adminform" border="0" cellpadding="0" cellspacing="1" width="100%">
                                                        <tbody>												
                                                            <tr>

                                                                <td width="15%"   rowspan="2"  align="center">
                                                                    <div id="cpanelicon">
                                                                        <div style="float:left;">
                                                                            <div class="icon">
                                                                                <a href="javascript: ue_forma_pago();">
                                                                                    <img src="images/pagos.png" alt="Forma de Pago" align="middle" title="Llenar forma de pago"  border="0" />
                                                                                    <span>Registrar Pago</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>								
                                                                    </div>
                                                                    <!--<a href="javascript: ue_forma_pago();"><img src="images/pagos.png" alt="Buscar" width="50" title="Llenar forma de pago"  border="0"></a>-->
                                                                </td>
                                                                 <td width="85%"   rowspan="2" style="padding: 0px;" >
                                                                     <div id="div_total_letras">
                                                                         <strong>TOTAL LETRAS:</strong>	
                                                                         
                                                                    </div>
                                                                </td>
                                                                <td   >
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td >
                                                                </td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="busqueda"><font size="2"><strong>TOTAL DEPÓSITO:</strong></font></td>
                                                <td align="right" colspan="1">
                                                    <div align="left">
                                                    <input style=" height:17px; font-size:18px;  text-align:right" name="total_deposito" type="text" id="total_deposito" size="10" align="right" value=0.00 readonly> 
                                                    <strong>Bs.</strong>  
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="busqueda"><font size="2"><strong>TOTAL CHEQUE:</strong></font></td>
                                                <td align="right" >
                                                    <div align="left">
                                                    <input style=" height:18px; font-size:18px;  text-align:right" name="total_cheque" type="text" id="total_cheque" size="10" align="right" value=0.00 readonly> 
                                                    <strong>Bs.</strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <table class="adminform" border="0" cellpadding="0" cellspacing="1" width="100%">
                                                        <tbody>												
                                                            <tr  >
                                                                <td>
                                                                    <font size="3"><strong>TOTAL PAGO:</strong></font> 
                                                                    <input  style="height:18px; font-size:18px; color:green;  text-align:right" placeholder="0.00" type="text" id="total_pago"  name="total_pago"  maxlength="10" size="10" value="0.00" readonly/>	
                                                                </td>
                                                                <td>
                                                                    <font size="3"><strong>CAMBIO:</strong></font> 
                                                                    <input  style="height:18px; font-size:18px; color:red;  text-align:right" placeholder="0.00" type="text" id="total_cambio"  name="total_cambio"  maxlength="10" size="10" value="0.00" readonly/>	
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                </td>

                                <td width="22%">			  	
                                    <div id="frmBusqueda">
                                        <table width="100%" border=0 align="left" cellpadding=3 cellspacing=0 class="adminform">
                                            <tr>
                                                <td colspan="2" align="center" width="5%" height="12"  class="botones"  ><font size="3"><strong>TOTAL FACTURA</strong></font></td>
                                            </tr>
                                            <tr>
                                                
                                                <td width="42%" ><font size="2"><strong>SUB-TOTAL:</strong></font></td>
                                                <td width="58%" align="right">
                                                    <div align="left">
                                                    <input  style=" height:20px; font-size:18px;  text-align:right"  name="subtotal" type="text" id="subtotal" size="10" value=0.00 align="right" readonly> 
                                                    <strong>Bs.</strong>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="busqueda"><font size="2"><strong>IVA: (<?php echo $var_iva ?>&#37;)</strong></font></td>
                                                <td align="right">
                                                    <div align="left">
                                                    <input style=" height:20px; font-size:18px;  text-align:right" name="totalimpuestos" type="text" id="totalimpuestos" size="10" align="right" value=0.00 readonly> 
                                                    <strong>Bs.</strong>  
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="busqueda"><font size="2"><strong>TOTAL FACTURA:</strong></font></td>
                                                <td align="right">
                                                    <div align="left">
                                                    <input style=" height:20px; font-size:18px;  background-color: #BBBBBB;  text-align:right" name="preciototal" type="text" id="preciototal" size="10" align="right" value=0.00 readonly> 
                                                    <strong>Bs.</strong>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>													
                    <td colspan="2" class="botones" align="center" >
                        &nbsp;
                    </td>													
                </tr> 
                
            </table>
        </form>
        <?php } ?> 
    </div>
</div>

<script type="text/javascript" >
    jQuery(function($) {
        $.mask.definitions['~']='[JEVGDCHjevgdch]';
        //$('#fecha_nac').mask('99/99/9999');
        //$('#fecha_deposito').mask('99/99/9999');
        $('#telefono').mask('(9999)-9999999');
        $('#celular').mask('(9999)-9999999');
        $('#telefono_trabajo').mask('(9999)-9999999');
        $('#telefono_fax').mask('(9999)-9999999');
        $('#rif').mask('~-9999?9999-9',{placeholder:" "});
        $('#cedula_solicitante').mask('~-9999?99999',{placeholder:" "});
        //$('#phoneext').mask("(999) 999-9999? x99999");
        //$("#tin").mask("99-9999999");
        //$("#ssn").mask("999-99-9999");
        //$("#product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("Ha escrito lo siguiente: "+this.val());}});
        //$("#eyescript").mask("~9.99 ~9.99 999");
    });
    
    function ue_forma_pago()	{
       var mensaje="";
        var codfacturatmp=document.facturacion.codfacturatmp.value;
        var total_factura=document.getElementById("preciototal").value;
        var status_modif_fp=document.facturacion.status_modif_fp.value;
        if (document.getElementById("preciototal").value==0.00) mensaje+="  - Debe Registrar un Concepto\n";
        if (mensaje!="") {
            alert("Atencion, se han detectado las siguientes Errores:\n\n"+mensaje);
        } else {
            window.open("facturacion/factura/forma_pago.php?codfacturatmp="+codfacturatmp+"&status_modif_fp="+status_modif_fp+"&totalfactura="+total_factura,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=420,height=430,left=50,top=50,location=no,resizable=no");
        }
    }
    
    function ue_buscarcliente()	{
		document.facturacion.cedula_solicitante.value="";											
		document.facturacion.nombre_solicitante.value="";											
		document.facturacion.tipo_solicitante.value="";											
		document.facturacion.direccion.value="";											
                window.open("facturacion/factura/cliente_load.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,height=310,left=50,top=50,location=no,resizable=no");
	} 
    
    function ue_cliente_add()	{
           var mensaje="";
            var cedula_rif=document.facturacion.cedula_solicitante.value;
            var cedula_rif=cedula_rif.toUpperCase();
            window.open("facturacion/factura/cliente_add.php?cedula_rif="+cedula_rif,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=800,height=350,left=50,top=50,location=no,resizable=no");
	} 
</script>