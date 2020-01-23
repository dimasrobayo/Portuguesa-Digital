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

if (isset($_GET['cedula_rif'])){
    $datos_modificar= $_GET['cedula_rif'];

    //se le hace el llamado a la funcion de insertar.   
    $datos_consulta = pg_query("SELECT * FROM peajes, usuarios WHERE peajes.cedula_rif = usuarios.cedula_usuario and peajes.cedula_rif = '$datos_modificar'") or die("No se pudo realizar la consulta a la Base de datos");
    $resultados1=pg_fetch_array($datos_consulta);
    pg_free_result($datos_consulta);

    $query_recarga = pg_query("SELECT sum(monto_operacion) FROM peajes, usuarios WHERE peajes.cedula_rif = usuarios.cedula_usuario and peajes.cedula_rif='$datos_modificar' and peajes.tipo_operacion='RECARGA'") or die("No se pudo realizar la consulta a la Base de datos");
    $recarga=pg_fetch_array($query_recarga);

    $query_pago = pg_query("SELECT sum(monto_operacion) FROM peajes, usuarios WHERE peajes.cedula_rif = usuarios.cedula_usuario and peajes.cedula_rif='$datos_modificar' and peajes.tipo_operacion='PAGO'") or die("No se pudo realizar la consulta a la Base de datos");
    $pago=pg_fetch_array($query_pago);

    $saldo_usuario=$recarga[0]-$pago[0];
    pg_close();
}


if (isset($_POST[save])){
    $cedula_rif     = $_POST["cedula_rif"];
    $Amount         = $_POST['Amount'];
    $tipo_operacion = "PAGO";

    $query="insert into peajes (cedula_rif, tipo_operacion, monto_operacion) values ('$cedula_rif', '$tipo_operacion', '$Amount')";
    $result = pg_query($query)or die(pg_last_error());
    $result_insert=pg_fetch_array($result);
    pg_free_result($result);
    $error="bien";    
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
            
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Pago Registrado con &Eacute;xito</h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=pagos_peaje_view";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=pagos_peaje_view" name="Continuar"> Continuar </a>]
                    </font>                         
                </h3>
            </div> 
            
<?php }else{ ?>   <!-- Mostrar formulario Original --> 

            <div class="panel-heading">
                <h4 class="text-primary">
                    <strong> SERVICIO DE PEAJE: <?php echo $resultados1[nombre_usuario] .' ' .$resultados1[apellido_usuario];?> - <?php echo number_format($saldo_usuario, 2, ',', '.'); ?></strong>
                </h4>
            </div>
                    
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input class="form-control" type="hidden" id="cedula_rif" name="cedula_rif" value="<?php echo $resultados1[cedula_rif]; ?>"/>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>MONTO A PAGAR</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" id="Amount" name="Amount"/>
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