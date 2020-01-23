<?php //ENRUTTADOR

if (isset($_GET['error']))
	$redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
	$pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
	$type=$_GET["type"];
	$pagina=$pag.'?type='.$type;

//Conexion a la base de datos
$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_empresa password=$sql_pass");
?>

<?php //seccion para recibir los datos y borrar.
if (isset($_GET['borrar'])){

	//se le hace el llamado al archivo de conexion y luego se realiza el enlace.	
	require("conexion_sms/aut_config.inc.php");
	$db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");	

	$consulta = pg_query("SELECT * FROM sentitems") or die(pg_last_error());
	$total_registros = pg_num_rows ($consulta);
	pg_free_result($consulta);
	$error="bien";	

	if ($total_registros == 0)
	{
		$error="malo";	
	}
	else 
	{
		$error="bien";
		//se le hace el llamado a la funcion de insertar.	
		$result_borrar=pg_query("SELECT drop_sentitems") or die(pg_last_error());
		pg_close();
	}
}
?> 

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
                <h4 class="text-primary"><strong> VACIAR BUZON DE ENVIADOS</strong></h4>
            </div>
            
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">
                        <?php
                            if ($error=="bien"){	
                                echo '<h1>Datos Eliminados con &eacute;xito</h1>';
                            }else{
                                echo '<h1>Imposible Eliminar el Registro</h1>';
                            }
                        ?>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=sms_enviados";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=sms_enviados" name="Continuar"> Continuar </a>]
                    </font>							
                </h3>
            </div> 
        </div>
    </div>
</div>