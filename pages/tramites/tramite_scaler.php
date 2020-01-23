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

    if (isset($_GET['cod_tramite'])){
    	$datos_modificar= $_GET['cod_tramite'];
        
	$query="SELECT * FROM tramites,unidades where tramites.cod_unidad=unidades.cod_unidad AND tramites.cod_tramite = $datos_modificar";
    	$result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result);	
    }

    if (isset($_POST[save])) {
    	$codigo = $_POST['ctramite'];
    	$cod_unidad_new = $_POST['cod_unidad_new'];
        $unidad=$_POST['unidad'];

        
//se le hace el llamado a la funcion  de editar
//	$query="SELECT update_tramite('$codigo','$categoria','$tramite','$descripcion','$unidad','$otorga','$costor','$costoh','$entregar','$entregah','$horarioc','$horarioe','$observaciones')";
	$query="UPDATE tramites SET cod_unidad=$cod_unidad_new WHERE cod_tramite=$codigo;";
        $result = pg_query($query)or die(pg_last_error());
        pg_free_result($result);
        $error="bien";
        
        $query="SELECT * FROM tramites,unidades where tramites.cod_unidad=unidades.cod_unidad AND tramites.cod_tramite = $codigo";
    	$result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result);
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
                <h4 class="text-primary"><strong> ESCALAR TRAMITE A DEPARTAMENTO/UNIDAD </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2"> 					
                        <h1>Datos registrados con &eacute;xito</h1> 
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=tramites&cod_unidad=<?php echo $unidad;?>";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=tramites&cod_unidad=<?php echo $unidad;?>" name="Continuar"> Continuar </a>]
                    </font>							
                </h3>
            </div> 
                   
<?php	}else{ 	?>   <!-- Mostrar formulario Original --> 

            <div>
                <td width="300"><b>UNIDAD ACTUAL:</b> <?php echo $resultado['nombre_unidad']; ?></td>
            </div>  

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input id="ctramite" name="ctramite" value="<?php echo $resultado[cod_tramite]; ?>" type="hidden"/>
                        <input id="unidad" name="unidad" value="<?php echo $resultado[cod_unidad]; ?>" type="hidden"/>
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>NOMBRE DEL TRAMITE</label>
                                <input  type="text" id="tramite" autofocus="true" name="tramite" value="<?php echo $resultado['nombre_tramite'];?>" onkeyup="" class="form-control" readonly="true"/>
                            </div>

                            <div class="form-group" autofocus="true">
                                <label>UNIDAD A REASIGNAR</label>
                                <select id="cod_unidad_new" name="cod_unidad_new" size="0" class="form-control">
                                    <option value="">----</option>          
                                        <?php
                                            
                                            $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
                                            $consulta=pg_query("select * from unidades order by nombre_unidad");
                                            while ($array_consulta=pg_fetch_array($consulta)) {
                                                echo '<option value="'.$array_consulta[0].'">'.$array_consulta[2].'</option>';
                                            }
                                            pg_free_result($consulta);
                                        ?>
                                </select>
                            </div>
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Guardar  " >
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=tramites&cod_unidad=<?php echo $resultado[cod_unidad];?>'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div> 
                                
<?php }  ?>	

        </div>	 
    </div>
</div>