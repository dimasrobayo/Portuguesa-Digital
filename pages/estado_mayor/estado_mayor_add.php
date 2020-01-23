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

    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?> 

<?php 
    if (isset($_POST[save])) {   // Insertar Datos del formulario
        $nombre_estado_mayor = ($_POST['nombre_estado_mayor']);
        $descripcion = ($_POST['descripcion']);
        $cedula_res_regional = ($_POST['cedula_res_regional']);
        $cedula_res_nacional = trim($_POST['cedula_res_nacional']);
        
        // Consultamos si existe la descripcion
        $query = "SELECT * FROM estado_mayor WHERE nombre_estado_mayor='$nombre_estado_mayor'";
        $result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result);
        pg_free_result($result);                        

        if (!$resultado[0]) {
            $query="insert into estado_mayor (nombre_estado_mayor, descripcion, cedula_res_regional, cedula_res_nacional) values ('$nombre_estado_mayor', '$descripcion', '$cedula_res_regional', '$cedula_res_nacional')";
            $result = pg_query($query)or die(pg_last_error());
            
            if(pg_affected_rows($result)){
                $error="bien";
            }
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
                <h4 class="text-primary"><strong> ESTADO MAYOR </strong></h4>
            </div>
                
<?php if ((isset($_POST[save])) and ($error=="bien")){  ?> <!-- Mostrar Mensaje -->
                
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos registrados con &eacute;xito</h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=estado_mayor";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=estado_mayor" name="Continuar"> Continuar </a>]
                        </font>                         
                </h3>
            </div>
                
<?php }else{ ?>   <!-- Mostrar formulario Original --> 
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>NOMBRE DEL ESTADO MAYOR</label>
                                <input  type="text" id="nombre_estado_mayor" name="nombre_estado_mayor" value="<?php if ($error!='') echo $nombre_estado_mayor;?>" class="form-control" size="50" maxlength="50"/>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>DESCRIPCIÓN</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="70" rows="3"><?php echo $descripcion;?></textarea>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>RESPONSABLE REGIONAL</label>
                                <select id="cedula_res_regional" name="cedula_res_regional" size="0" class="form-control">
                                    <option value="">----</option>          
                                        <?php
                                            $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
                                            $consulta=pg_query("select usuarios.cedula_usuario, usuarios.nombre_usuario, usuarios.apellido_usuario from usuarios where usuarios.recibir_orden=1 order by usuarios.nombre_usuario");
                                            while ($array_consulta=pg_fetch_array($consulta)) {
                                                 echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].' '.$array_consulta[2].'</option>';
                                            }
                                            pg_free_result($consulta);
                                        ?>
                                </select> 
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>RESPONSABLE NACIONAL</label>
                                <select id="cedula_res_nacional" name="cedula_res_nacional" size="0" class="form-control">
                                    <option value="">----</option>          
                                        <?php
                                            $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
                                            $consulta=pg_query("select usuarios.cedula_usuario, usuarios.nombre_usuario, usuarios.apellido_usuario from usuarios where usuarios.recibir_orden=1 order by usuarios.nombre_usuario");
                                            while ($array_consulta=pg_fetch_array($consulta)) {
                                                 echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].' '.$array_consulta[2].'</option>';
                                            }
                                            pg_free_result($consulta);
                                        ?>
                                </select> 
                            </div>

                            <button type="submit" id="save" name="save" class="btn btn-default btn-primary">Guardar</button>
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=estado_mayor'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div>
<?php }  ?>
        </div>
    </div>
</div>
