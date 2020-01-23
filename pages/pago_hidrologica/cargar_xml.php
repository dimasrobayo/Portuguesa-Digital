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


     

if (isset($_POST[save])){
    require 'vendor/phpexcel/PHPExcel/IOFactory.php'; //Agregamos la librería 

    //// SUBIR ARCHIVO AL SERVIDOR
    if(isset($_FILES['archivo']) ){
        $name = $_FILES['archivo']['name']; 
        $name_tmp = $_FILES['archivo']['tmp_name'];
        $size = $_FILES['archivo']['size'];
        $type = $_FILES['archivo']['type'];
        $date = date("Y-m-d"); 
    
        $dir_upload='upload_file/pagos_hidrologicas/'; // Nombre del Directorio de las subidas de archivos
        $nombreArchivo = ($dir_upload .'/' .$new_name_file);
        $new_name_file=$name.'.'.$ext_type;

        copy($_FILES['archivo']['tmp_name'],$dir_upload .'/'.$name); 
        $upload_menssage="Archivo Adjuntado con éxito.";
        $nombreArchivo = $dir_upload .'/'.$name;

        

        $objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
        //Asigno la hoja de calculo activa
        $objPHPExcel->setActiveSheetIndex(0);
        //Obtengo el numero de filas del archivo
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        for ($i = 2; $i <= $numRows; $i++) {
            $cedula_rif = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $n_cliente = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $fecha_emision = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $monto_factura = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $n_factura = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            $periodo_facturado = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

            $query="insert into deuda_hidrologica (cedula_rif, n_cliente, fecha_emision, monto_factura, n_factura, periodo_facturado) values ('$cedula_rif','$n_cliente','$fecha_emision','$monto_factura','$n_factura','$periodo_facturado')";
            $result = pg_query($query)or die(pg_last_error());
            $result_insert=pg_fetch_array($result);
            pg_free_result($result);
            $error="bien";
        }
    }else{
        $upload_menssage="Ticket Sin Archivo Adjunto.";
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

 <script type="text/javascript">
    function isXls(input)
    {
        var value = input.value;
        var res = value.substr(value.lastIndexOf('.')) == '.xls';
            if (!res) {
                input.value = "";
            }
        return res;
    }
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div align="center">
                <font color="red" style="text-decoration:blink;">
                    <?php $error_accion_ms[$error_cod]?>
                </font>
            </div>  

            <div class="panel-heading">
                <h4 class="text-primary"><strong> CARGAR XML DE HIDROLOGICA: </strong></h4>
            </div>
            
<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->
            
            <div class="form-group" align="center"> 
                <h3 class="info">	
                    <font size="2">						
                        <h1>Datos Cargados y Procesados con &Eacute;xito</h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=pagos_hidrologica_view";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=pagos_hidrologica_view" name="Continuar"> Continuar </a>]
                    </font>
                </h3>
            </div>
            
<?php }else{ ?>   <!-- Mostrar formulario Original --> 
                    
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>ARCHIVO A CARGAR</label>
                                <input type="file" id="archivo" name="archivo" onchange="return isXml(this)"/>
                                <label class="text-danger">el archivo es en formato XLS</label>
                            </div>

                            <button type="submit" id="save" name="save" class="btn btn-default btn-primary">CARGAR</button>
                            <a href="index2.php?view=pagos_hidrologica_view" class="btn btn-default">
                                Salir
                            </a>
                        </div>
                    </form>  
                </div>
            </div>

<?php } ?>

        </div> 
    </div> 
</div>