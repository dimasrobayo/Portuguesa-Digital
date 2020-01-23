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

    //Conexion a la base de datos
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

if (isset($_GET['id_deuda'])){
    $datos_modificar= $_GET['id_deuda'];

    //se le hace el llamado a la funcion de insertar.   
    $datos_consulta = pg_query("SELECT * FROM deuda_hidrologica, usuarios WHERE deuda_hidrologica.cedula_rif = usuarios.cedula_usuario and deuda_hidrologica.id_deuda = '$datos_modificar' order by deuda_hidrologica.id_deuda") or die("No se pudo realizar la consulta a la Base de datos");

    $resultados1=pg_fetch_array($datos_consulta);
    pg_free_result($datos_consulta);
    pg_close();
}

if (isset($_POST[save])){
    $id_deuda = $_POST["id_deuda"];
    $CardHolder     = trim($_POST["CardHolder"]);
    $CardHolderId   = trim($_POST["CardHolderId"]);
    $CardNumber     = trim($_POST["CardNumber"]);
    $CVC            = trim($_POST["CVC"]);
    $ExpirationDate = trim($_POST["ExpirationDate"]);
    $Amount         = trim($_POST['Amount']);
    $StatusId       = trim($_POST['StatusId']);
    $Description    = "PAGO DE HIDROLOGICA";


    // https://www.chriswiegman.com/2014/05/getting-correct-ip-address-php/
    function get_ip() {
        if ( function_exists( 'apache_request_headers' ) ) {
            $headers = apache_request_headers();
        } else {
            $headers = $_SERVER;
        }
        if (array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
            $the_ip = $headers['X-Forwarded-For'];
        }elseif (array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )) {
            $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
        }else {
            $the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
        }
        return $the_ip;
    }

    $url = 'https://api.instapago.com/payment';
    $fields = array(
        "KeyID"             => "E23D8BB6-43D3-4C16-81A6-8D7C1545EF06", //required
        "PublicKeyId"       => "f35022b2d2ac45daa07f0e6c6ea54113", //required
        "Amount"            => $Amount, //required
        "Description"       => "Un cobro de prueba", //required
        "CardHolder"        => $CardHolder, //required
        "CardHolderId"      => $CardHolderId, //required
        "CardNumber"        => $CardNumber, //required
        "CVC"               => $CVC, //required
        "ExpirationDate"    => $ExpirationDate, //required
        "StatusId"          => $StatusId, //required
        "IP"                => get_ip() //required
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $obj = json_decode($server_output);
    $code = $obj->code;
    $msgerror = '';
    switch($code){
        case 400:
            $msgerror= 'Error al validar los datos enviados..';
            break;
        case 401:
            $msgerror= 'Error de autenticación, ha ocurrido un error con las llaves utilizadas..';
            break;
        case 403:
            $msgerror= 'Pago Rechazado por el banco..';
            break;
        case 500:
            $msgerror= 'Ha Ocurrido un error interno dentro del servidor..';
            break;
        case 503:
            $msgerror= 'Ha Ocurrido un error al procesar los parámetros de entrada. Revise los datos enviados y vuelva a intentarlo..';
            break;
        case 201:
            $msg_banco  = $obj->message;
            $voucher  = $obj->voucher;
            $voucher = html_entity_decode($voucher);
            $id_pago  = $obj->id;
            $reference  = $obj->reference;
            break;
        default:
            $msgerror='Error inesperado, Imposible determinar. Contacte al Administrador';
            break;
    }
    if(!empty($msgerror)){
        echo'
            <div class="alert alert-danger" role="alert"><p>'.$msgerror.'</p></div>';
        die();
    }else{
        echo'
        <div class="panel panel-primary">
            <div class="panel-heading"><h4>Respuesta de la Transacción</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <h3>Respuesta del Banco</h3>
                            <p>
                                <strong>Mensaje del Banco</strong>: '.$msg_banco.'<br/>
                                <strong>ID del Pago</strong>: '.$id_pago.'<br/>
                                <strong>ID Referencia</strong>: '.$reference.'<br/>
                            </p>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                            <h3>Voucher</h3>
                            '.$voucher.'
                        </div>
                        <div class="col-lg-12">
                            <a href="?view=pago_hidrologica" class="btn btn-primary" name="Continuar"> Continuar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        $query="update deuda_hidrologica SET pagado='$Amount', fecha_pago='now', status_deuda='1', id_pago='$id_pago', id_referencia='$reference' WHERE id_deuda=$id_deuda";
        $result = pg_query($query)or die(pg_last_error());
        $result_insert=pg_fetch_array($result);
        pg_free_result($result);
        $error="bien";
    }

    
}//fin del add        
?>

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

            
            
<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->
            

            
<?php }else{ ?>   <!-- Mostrar formulario Original --> 

            <div class="panel-heading">
                <h4 class="text-primary"><strong> SERVICIO DE LA HIDROLOGICA: <?php echo $_SESSION['username']?> - <?php echo $resultados1[periodo_facturado]; ?> </strong></h4>
            </div>
                    
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input class="form-control" type="hidden" id="StatusId" name="StatusId" value="2" />
                        <input class="form-control" type="hidden" id="id_deuda" name="id_deuda" value="<?php echo $resultados1[id_deuda]; ?>" />
                        <div class="col-lg-12">
                            <div class="form-group col-lg-6">
                                <label>N DE TARJETA</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" id="CardNumber" name="CardNumber" value="4111111111111111" required/>
                                    <span class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>TIPO DE TARJETA</label>
                                <select id="tipo_tarjeta" name="tipo_tarjeta" size="0" class="form-control" required>
                                    <option value="">----</option>          
                                    <option value="visa">VISA</option>  
                                    <option value="mastercard">MARTERCARD</option>  
                                </select> 
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group col-lg-6">
                                <label>COD. SEGURIDAD</label>
                                <input class="form-control" type="pass" id="CVC" name="CVC" required/>  
                            </div>

                            <div class="form-group col-lg-6">
                                <label>TARJETA HABIENTE</label>
                                <div class="input-group">
                                    <input class="form-control" type="pass" id="CardHolder" name="CardHolder" required />
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>FECHA DE VENCIMIENTO</label>
                                <div class="input-group">
                                    <input class="form-control" type="year" id="ExpirationDate" name="ExpirationDate" placeholder="MM/YYYY" required/>
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group col-lg-6">
                                <label>CEDULA O RIF</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" id="CardHolderId" name="CardHolderId" required/>
                                    <span class="input-group-addon">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>MONTO A PAGAR</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" id="Amount" name="Amount" value="<?php echo $resultados1[monto_factura]; ?>" readonly />
                                    <span class="input-group-addon">
                                        <i class="fa fa-money"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="save" name="save" class="btn btn-default btn-primary">enviar</button>
                        <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=orden'" value="Cerrar" name="cerrar" />
                        </div>
                    </form>  
                </div>
            </div>

<?php } ?>

        </div> 
    </div> 
</div>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/js/jquery.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.js"></script>

<script type="text/javascript" >
    jQuery(function($) {
          $.mask.definitions['~']='[/]';
          $('#ExpirationDate').mask('99~9999');
       });
</script>