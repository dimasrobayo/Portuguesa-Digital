<?php
    // chequear si se llama directo al script.
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="../images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    if ($_SERVER['HTTP_REFERER'] == "") {
        echo "<script type='text/javascript'>window.location.href='index.php?view=login&msg_login=5'</script>";
//        echo "<script type='text/javascript'>window.location.href='index.php'</script>";
        exit;
    }

    $server=$_SERVER['SERVER_NAME']; // nombre del servidor web
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $view=$_GET["view"];    
    $pagina=$pag.'?view='.$view;
    $cedula_usuario=$_SESSION['id'];

    //Conexion a la base de datos
    include("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    $query_user = pg_query("SELECT * FROM estado_mayor, usuarios where usuarios.id_estado_mayor = estado_mayor.id_estado_mayor and usuarios.cedula_usuario = '$cedula_usuario'") or die(pg_last_error());
    $resultado_user=pg_fetch_array($query_user); 
    pg_free_result($result_user); 
?> 

<?php 
    if (isset($_POST[save])) {   // Insertar Datos del formulario
        $id_estado_mayor = ($_POST['id_estado_mayor']);
        $nombre_informe = ($_POST['nombre_informe']);
        $semana_informe = ($_POST['semana_informe']);
        $mes_informe = ($_POST['mes_informe']);
 

        $query="insert into em_informe_semanal (nombre_informe, semana_informe, mes_informe, id_estado_mayor) values ('$nombre_informe','$semana_informe', '$mes_informe','$id_estado_mayor') RETURNING id_informe";
        $result = pg_query($query)or die(pg_last_error());
        $result_insert=pg_fetch_row($result);
        $id_informe = $result_insert[0];
        pg_free_result($result);
        $error="bien"; 

        //// SUBIR ARCHIVO AL SERVIDOR
        if(isset($_FILES['archivo']) ){
            $name = $_FILES['archivo']['name']; 
            $name_tmp = $_FILES['archivo']['tmp_name'];
            $size = $_FILES['archivo']['size'];
            $type = $_FILES['archivo']['type'];

            $ext_permitidas = array('ppt','pptx');
            $part_name = explode('.', $name);
            $ext_type=$part_name[1]; // Optenemos el tipo del archivo 
            $ext_correcta = in_array($ext_type, $ext_permitidas);

            $upload_max = 1000000 * 2048; // Tamaño maximo del Archivo en Kb. (1 Mb)
            $dir_upload='upload_file/informe_semanal/'; // Nombre del Directorio de las subidas de archivos
            $new_name_file=$id_informe.'.'.$ext_type;

            if (is_uploaded_file($_FILES['archivo']['tmp_name'])){
                if( $ext_correcta && $size <= $upload_max ){
                    if( $_FILES['archivo']['error'] > 0 ){
                      $upload_menssage= 'Error: ' . $_FILES['archivo']['error'].'.';
                    }else{
                       move_uploaded_file($_FILES['archivo']['tmp_name'],$dir_upload .'/'.$new_name_file); 
                       $upload_menssage="Archivo Adjuntado con éxito.";
                       $upload_ok=1;

                       $query="update em_informe_semanal set path='$new_name_file' where id_informe='$id_informe'";
                       $result = pg_query($query)or die(pg_last_error());
                    }

                }else{
                    $upload_menssage="Formato ó Tamaño del Archivo es inválido.";
                }
            }else{
                $upload_menssage="Sin Archivo Seleccionado que Subir.";
            }
        }else{
            $upload_menssage="Informe Semanal Sin Archivo Adjunto.";
        }
    }//fin del add        
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
                <h4 class="text-primary"><strong> INFORME SEMANAL - ESTADO MAYOR </strong></h4>
            </div>
                
<?php if ((isset($_POST[save])) and ($error=="bien")){  ?> <!-- Mostrar Mensaje -->
                
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos registrados con &eacute;xito</h1>
                        <h1> <?php echo $upload_menssage; ?> </h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=informe_semanal";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=informe_semanal" name="Continuar"> Continuar </a>]
                        </font>                         
                </h3>
            </div>
                
<?php }else{ ?>   <!-- Mostrar formulario Original --> 
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input  type="hidden" id="id_estado_mayor" name="id_estado_mayor" value="<?php echo $resultado_user[id_estado_mayor]; ?>" readonly="true" />
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>NOMBRE DEL ESTADO MAYOR</label>
                                <input  type="text" id="nombre_estado_mayor" name="nombre_estado_mayor" value="<?php echo $resultado_user[nombre_estado_mayor]; ?>" class="form-control" size="50" maxlength="50" readonly="true" />
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>NOMBRE DEL ESTADO MAYOR</label>
                                <input  type="text" id="nombre_informe" name="nombre_informe" class="form-control" size="50" maxlength="50" />
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>SEMANA DEL INFORME</label>
                                <select id="semana_informe" name="semana_informe" size="0" class="form-control">
                                    <option value="">--SELECCIONE LA SEMANA--</option>
                                    <option value="1">SEMANA 1</option>
                                    <option value="2">SEMANA 2</option>
                                    <option value="3">SEMANA 3</option>
                                    <option value="4">SEMANA 4</option>
                                    <option value="5">SEMANA 5</option>
                                </select> 
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>MES DEL INFORME</label>
                                <select id="mes_informe" name="mes_informe" size="0" class="form-control">
                                    <option value="">--SELECCIONE EL MES--</option>
                                    <option value="1">ENERO</option>
                                    <option value="2">FEBRERO</option>
                                    <option value="3">MARZO</option>
                                    <option value="4">ABRIL</option>
                                    <option value="5">MAYO</option>
                                    <option value="6">JUNIO</option>
                                    <option value="7">JULIO</option>
                                    <option value="8">AGOSTO</option>
                                    <option value="9">SEPTIEMBRE</option>
                                    <option value="10">OCTUBRE</option>
                                    <option value="11">NOVIEMBRE</option>
                                    <option value="12">DICIEMBRE</option>
                                </select> 
                            </div>

                            <div class="form-group">
                                <label>Archivo del Informe</label>
                                <input type="file" id="archivo" name="archivo">
                                <p class="help-block">(.ppt, .pptx, m&aacute;ximo 8mb)</p>
                            </div>

                            <button type="submit" id="save" name="save" class="btn btn-default btn-primary">Guardar</button>
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=informe_semanal'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div>
<?php }  ?>
        </div>
    </div>
</div>
