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

    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?>

<?php //seccion para recibir los datos y modificarlos.
    if (isset($_GET['cod_categoria'])){
    	$datos_modificar= $_GET['cod_categoria'];

	$query="SELECT * FROM categorias where cod_categoria = $datos_modificar";
        $result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result);	
        pg_free_result($result);  	
    }
?> 

<?php 
    if (isset($_POST[save])) {
    	$codigo = trim($_POST['cod_categoria']);
    	$descripcion = trim($_POST['descripcion']);
        $status = $_POST['status'];
        $cat_online = $_POST["cate_online"];
        
        // Consultamos si existe la descripcion
        $query = "SELECT * FROM categorias WHERE cod_categoria='$codigo'";
        $result = pg_query($query)or die(pg_last_error());
        $resultado_categoria=pg_fetch_array($result);
        pg_free_result($result);
        
        if($resultado_categoria[descripcion_categoria]!=$descripcion){
            // Consultamos si existe la descripcion
            $query = "SELECT * FROM categorias WHERE descripcion_categoria='$descripcion'";
            $result = pg_query($query)or die(pg_last_error());
            $resultado_load=pg_fetch_array($result);
            pg_free_result($result);
            
            if (!$resultado_load[0]) {
                //se le hace el llamado a la funcion de editar
                $query="UPDATE categorias SET descripcion_categoria='$descripcion', status_categoria=$status, status_categoria_online=$cat_online WHERE cod_categoria=$codigo;";
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
            $query="UPDATE categorias SET descripcion_categoria='$descripcion', status_categoria_online=$cat_online WHERE cod_categoria=$codigo;";
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
                <h4 class="text-primary"><strong> ACTUALIZAR DATOS DE LA CATEGORIA </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2"> 					
                        <h1>Datos Actualizado con &eacute;xito</h1>
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=categorias";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=categorias" name="Continuar"> Continuar </a>]
                    </font>							
                </h3>
            </div>

<?php	}else{ 	?>   <!-- Mostrar formulario Original --> 

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input id="cod_categoria" name="cod_categoria" value="<?php if ($error!="") echo $codigo; else  echo $resultado[cod_categoria]; ?>" type="hidden"/>
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>DESCRIPCIÓN DE LA CATEGORIA</label>
                                <input  type="text" id="descripcion" name="descripcion" value="<?php if ($error!="") echo $descripcion; else  echo $resultado[descripcion_categoria]; ?>" class="form-control" size="50" maxlength="50"/>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>STATUS DE LA CATEGORIA</label>
                                <?php
                                    if($resultado[status_categoria]==1){
                                        echo '<div class="radio">
                                            <label>
                                                <input type="radio" id="status" name="status" value="1" checked="true">ACTIVAR
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="status" name="status" value="0">DESACTIVAR
                                            </label>
                                        </div>';
                                    }else {
                                        echo '<div class="radio">
                                            <label>
                                                <input type="radio" id="status" name="status" value="1">ACTIVAR
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="status" name="status" value="0" checked="true">DESACTIVAR
                                            </label>
                                        </div>';
                                    }
                                ?>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>NOTIFICAR SI QUIERE ESTA CATEGORIA DISPONIBLE ON-LINE</label>
                                <?php
                                    if($resultado[status_categoria_online]==1){
                                        echo '<div class="radio">
                                            <label>
                                                <input type="radio" id="cate_online" name="cate_online" value="1" checked="true">ACTIVAR
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="cate_online" name="cate_online" value="0">DESACTIVAR
                                            </label>
                                        </div>';
                                    }else {
                                        echo '<div class="radio">
                                            <label>
                                                <input type="radio" id="cate_online" name="cate_online" value="1">ACTIVAR
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="cate_online" name="cate_online" value="0" checked="true">DESACTIVAR
                                            </label>
                                        </div>';
                                    }
                                ?>
                            </div>          
                            <button type="submit" id="save" name="save" class="btn btn-default btn-primary">Guardar</button>
                            <input class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=categorias'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div>
<?php }  ?>
        </div>	 
    </div>
</div>