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

    if (isset($_GET['cod_estado_tramite'])){
    	$datos_modificar= $_GET['cod_estado_tramite'];

	$query="SELECT * FROM estados_tramites where cod_estado_tramite = $datos_modificar";
        $result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result);	
        pg_free_result($result);   	
    }

    if (isset($_POST[save])) {
    	$codigo = trim($_POST['cod_estado_tramite']);
    	$descripcion = trim($_POST['descripcion']);
        $siglas = trim($_POST['siglas']);
        $etramite = trim($_POST['etramite']);
        $tetramite = trim($_POST['tetramite']);
        
        // Consultamos si existe la descripcion
        $query = "SELECT * FROM estados_tramites WHERE cod_estado_tramite='$codigo'";
        $result = pg_query($query)or die(pg_last_error());
        $resultado_estado_tramite=pg_fetch_array($result);
        pg_free_result($result);
        
        if($resultado_estado_tramite[descripcion_estado_tramite]!=$descripcion){
            // Consultamos si existe la descripcion
            $query = "SELECT * FROM estados_tramites WHERE descripcion_estado_tramite='$descripcion'";
            $result = pg_query($query)or die(pg_last_error());
            $resultado_load=pg_fetch_array($result);
            pg_free_result($result);
            
            if (!$resultado_load[0]) {
                //se le hace el llamado a la funcion de editar
                $query="SELECT update_edo_tramite($codigo,'$siglas','$descripcion','$etramite',$tetramite)";
                $result = pg_query($query)or die(pg_last_error());
                $error="bien";
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
            
        }else{
           //se le hace el llamado a la funcion de editar
            $query="SELECT update_edo_tramite($codigo,'$siglas','$descripcion','$etramite',$tetramite)";
            $result = pg_query($query)or die(pg_last_error());
            $error="bien";
        }
        
    }//fin del procedimiento modificar.
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
                    <?php echo $div_menssage;?>
                </font>
            </div>

            <div class="panel-heading">
                <h4 class="text-primary"><strong> ACTUALIZAR DATOS DEL ESTADO DEL TRAMITE </strong></h4>
            </div>
<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2"> 					
                        <h1>Datos Actualizado con &eacute;xito</h1>
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=edos_tramites";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=edos_tramites" name="Continuar"> Continuar </a>]
                    </font>                         
                </h3>
            </div> 
<?php	}else{ 	?>   <!-- Mostrar formulario Original --> 
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input value="<?php echo $resultado[cod_estado_tramite]; ?>" type="hidden" id="cod_estado_tramite" name="cod_estado_tramite">
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>C&Oacute;DIGO</label>
                                <input class="form-control" disabled value="<?php echo $resultado[cod_estado_tramite]; ?>" type="text" id="cod_estado_tramite1" name="cod_estado_tramite1">
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>SIGLAS</label>
                                <input  type="text" id="siglas" name="siglas" value="<?php if ($error!="") echo $siglas; else   echo $resultado[siglas_estado_tramite]; ?>" onkeyup="" class="form-control" size="5" maxlength="5"/>
                            </div>

                            <div class="form-group">
                                <label>ESTADO</label>
                                <input  type="text" id="etramite" name="etramite" value="<?php if ($error!="") echo $etramite; else   echo $resultado[estado_tramite]; ?>" onkeyup="" class="form-control" size="5" maxlength="5"/> 
                            </div>

                            <div class="form-group">
                                <label>DESCRIPCI&Oacute;N</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="70" rows="3"><?php  if ($error!="") echo $descripcion; else   echo $resultado[descripcion_estado_tramite]; ?></textarea> 
                            </div>
                                
                            <div class="form-group">
                                <label>TIPO DE ESTADO</label><? $resultados[tipo_estado_tramite];?>
                                <select class="form-control" id="tetramite" name="tetramite">
                                    <?php
                                        if($resultado[tipo_estado_tramite]=="1") {
                                            echo '<option value="'.$resultado[tipo_estado_tramite].'" selected="selected">Asignado</option>';
                                            echo '<option value="2">Completado</option>';
                                            echo '<option value="3">Cancelado</option>';
                                        }elseif($resultado[tipo_estado_tramite]=="2"){
                                            echo '<option value="'.$resultado[tipo_estado_tramite].'">Completado</option>';
                                            echo '<option value="1">Asignado</option>';
                                            echo '<option value="3">Cancelado</option>';
                                        }
                                        else{
                                            echo '<option value="'.$resultado[tipo_estado_tramite].'">Cancelado</option>';
                                            echo '<option value="1">Asignado</option>';
                                            echo '<option value="2">Completado</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" id="save" name="save" class="btn btn-default btn-primary">Guardar</button>
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=edos_tramites'" value="Cerrar" name="cerrar" />
                        <div>
                    </form>
                </div>
            </div>
<?php } ?> 
        </div> 
    </div>   
</div>