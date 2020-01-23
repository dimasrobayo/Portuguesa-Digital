<?php 
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
    if (isset($_POST['codfacturatmp'])){
        $codfacturatmp=$_POST["codfacturatmp"];
        $cedula_solicitante=strtoupper($_POST['cedula_solicitante']);
        $cedula_rif_fac = preg_replace("/\s+/", "", $cedula_solicitante);
        $cedula_rif_fac = str_replace("-", "", $cedula_rif_fac); 
        $iva=$_POST["iva"];
        $cedula_usuario=$_SESSION['id'];
        $tipo_factura = $_POST["tipo_factura"];
        $status = 1;

        $query="insert into factura (cedula_rif,fecha_factura,hora_factura,iva,cedula_usuario,tipo_factura,status) values ('$cedula_rif_fac','now()','now()','$iva','$cedula_usuario','$tipo_factura','$status') RETURNING n_factura";
        $result_insert_factura=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());	
        $result_insert = pg_fetch_row($result_insert_factura);
        $codfactura = $result_insert[0];

        if(pg_affected_rows($result_insert_factura)){
            $query="SELECT * FROM detalle_facturatmp WHERE n_factura='$codfacturatmp'";
            $result_detalle_factura=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());	

            while($resultados = pg_fetch_array($result_detalle_factura)){
                
                $codconcepto=$resultados[codigo_concepto];
                $cantidad=$resultados[cantidad];
                $monto_concepto=$resultados[monto_concepto];
                
                $query="SELECT * FROM concepto_factura where codigo_concepto='$codconcepto'";
                $result=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());	
                $resultados_concepto=pg_fetch_array($result);
                pg_free_result($result);
                
                $status_stock=$resultados_concepto[status_stock];
                $stock = $resultados_concepto[stock];
                $stock_update=($stock-$cantidad);
                
                $query="INSERT INTO detalle_factura (codigo_concepto,n_factura,cantidad,monto_concepto) VALUES ('$codconcepto','$codfactura','$cantidad','$monto_concepto')";
                $result_insert_detalle_factura=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());	
                
                if(pg_affected_rows($result_insert_detalle_factura)){
                    if($status_stock==1){
                        $query="UPDATE concepto_factura SET codigo_concepto='$codconcepto',stock='$stock_update' WHERE codigo_concepto='$codconcepto'";
                        $result=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());
                        pg_free_result($result);
                    }
                }
            }
            
            $query="SELECT * FROM facturatmp WHERE n_factura='$codfacturatmp'";
            $result=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());
            $result_facturatmp = pg_fetch_array($result);
            pg_free_result($result);

            $status_fp_efectivo=$result_facturatmp[status_fp_efectivo];
            $status_fp_deposito=$result_facturatmp[status_fp_deposito];
            $status_fp_cheque=$result_facturatmp[status_fp_cheque];

            $monto_efectivo=$result_facturatmp["monto_efectivo"];
            $nro_deposito=$result_facturatmp["nro_deposito"];
            $cod_banco_deposito=$result_facturatmp["cod_banco"];
            $cod_cuenta_banco=$result_facturatmp["cod_cuenta_banco"];
            $fecha_deposito=$result_facturatmp["fecha_deposito"];
            $monto_deposito=$result_facturatmp["monto_deposito"];
            $nro_cheque=$result_facturatmp["nro_cheque"];
            $cod_banco_cheque=$result_facturatmp["cod_banco_cheque"];
            $monto_cheque=$result_facturatmp["monto_cheque"];

            $query="UPDATE factura SET status_fp_efectivo='$status_fp_efectivo', ".
                " monto_efectivo='$monto_efectivo',status_fp_deposito='$status_fp_deposito',cod_banco_deposito='$cod_banco_deposito',cod_cuenta_banco='$cod_cuenta_banco',nro_deposito='$nro_deposito',fecha_deposito='$fecha_deposito',monto_deposito='$monto_deposito', ".
                " status_fp_cheque='$status_fp_cheque',cod_banco_cheque='$cod_banco_cheque',nro_cheque='$nro_cheque',monto_cheque='$monto_cheque' ".
                " WHERE n_factura='$codfactura'";
            $result=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());
            pg_free_result($result);
            
            $query="DELETE FROM facturatmp WHERE n_factura='$codfacturatmp'";
            $result=pg_query($query) or die('La consulta fall&oacute;:' . pg_last_error());
            pg_free_result($result);
        }
    }
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

        <br><br>       

        <table width="100%" class="adminform" align="center">
            <tr>
                <th colspan="2" align="center">
                    Registro de Factura
                </th>
            </tr> 
            
            <tr>
                <td colspan="2" align="center">
                    <div align="center"> 
                        <h3 class="info">	
                            <font size="2">						
                                Factura Nro: <?php echo $codfactura;?> Registrado con &eacute;xito
                                <br />
                                <script type="text/javascript">
                                    function redireccionar(){
                                        window.location="?view=factura";
                                    }
                                    setTimeout ("redireccionar()", 10000); //tiempo de espera en milisegundos
                                </script> 						
                                <!--[<a href="?view=factura" name="factura"> Continuar </a>]-->
                            </font>							
                        </h3>
                    </div> 
                </td>
            </tr>
            
            <tr align="center">
                <td width="100%" valign="top" align="center">
                    <div id="cpanel">
                        <div style="float:right;">
                            <div class="icon">
                                <a href="index2.php?view=factura">
                                    <img src="images/factura.png" alt="salir" align="middle"  border="0" />
                                    <span>Gestor de Datos</span>
                                </a>
                            </div>
                        </div>
                        <div style="float:right;">
                            <div class="icon">
                                <a href="reportes/imprimir_factura.php?codfactura=<?php echo $codfactura;?>" target="_blank">
                                    <img src="images/printer.png" alt="Imprimir" align="middle"  border="0" />
                                    <span>Imprimir</span>
                                </a>
                            </div>
                        </div>
                        <div style="float:right;">
                            <div class="icon">
                                <a href="index2.php?view=factura_add">
                                    <img src="images/facturanueva.png" alt="agregar" align="middle"  border="0" />
                                    <span>Facturar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>	
       <br />     
    </div>
</div>
