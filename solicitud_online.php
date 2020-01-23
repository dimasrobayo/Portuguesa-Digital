<?php
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

    if (isset($_POST[save])){   // Insertar Datos del formulario
        $cedula_rif=$_POST['cedula_rif'];
        $cedula_rif_insert = preg_replace("/\s+/", "", $cedula_rif);
        $cedula_rif_insert = str_replace("-", "", $cedula_rif_insert);
        $nombre_usuario=strtoupper($_POST["nombre_usuario"]);
        $apellido_usuario=strtoupper($_POST["apellido_usuario"]);
        $fecha_nac=implode('-',array_reverse(explode('/',$_POST['fecha_nac']))); 
        $sexo_usuario=$_POST['sexo'];
        $telefono_movil=$_POST['telefono_movil'];
        $email=$_POST['email'];
        $usuario=$_POST['usuario'];
        $password=$_POST['password'];
        $codcom=$_POST['codcom'];
        $direccion=$_POST['direccion'];
        $nivel_acceso=$_POST['nivel_acceso'];
        $status_usuario=$_POST['status_usuario'];
        $unidad_usuario=$_POST['unidad_usuario'];
        $tipo_solicitante=$_POST['tipo_solicitante'];

        $nombreapellido= ($nombre_usuario .' ' .$apellido_usuario);

        $query="SELECT * FROM $sql_tabla WHERE usuario='$usuario'";
        $result = pg_query($query)or die(pg_last_error());
        $total_encontrados = pg_num_rows ($result);
        pg_free_result($result);

        if ($total_encontrados != 0){
                $error="Error";
                $div_menssage='<div align="left"><h3 class="error"><font color="#CC0000" style="text-decoration:blink;">Error: El Usuario ya est&aacute; registrado.</font></h3></div>';	
        }else {	
            $query="SELECT * FROM $sql_tabla WHERE cedula_usuario='$cedula_insert'";
            $result = pg_query($query)or die(pg_last_error());
            $result_user = pg_fetch_array($result);
            pg_free_result($result);
            
            if ($result_user[0]) {
                $error="Error";
                $div_menssage='<div align="left"><h3 class="error"><font color="#CC0000" style="text-decoration:blink;">Error: Ya Existe un Registro con la misma C&eacute;dula: <font color="blue">'.$result[0].'</font>; por favor verifique los datos!</font></h3></div>';				
            }else {	
                $error="bien";	
                $usuario=stripslashes($usuario);
                $passmd5=md5($password);
                
                $query = "insert into usuarios (cedula_usuario, nombre_usuario, apellido_usuario, usuario, pass, nivel_acceso, status, cod_unidad, email_usuario, telefono_movil) values ('$cedula_rif_insert','$nombre_usuario','$apellido_usuario','$usuario','$passmd5',$nivel_acceso, '$status_usuario', $unidad_usuario, '$email_usuario', '$telefono_movil')";
                $result = pg_query($query)or die(pg_last_error());
				$result_insert=pg_fetch_array($result);
		        pg_free_result($result);

                /*$query_solicitante="insert into solicitantes (cedula_rif, cod_tipo_solicitante, nombre_solicitante, sexo_solicitante, fecha_nac, direccion_habitacion, telefono_movil, email, idcom) values ('$cedula_rif_insert', $tipo_solicitante, '$nombreapellido','$sexo_usuario','$fecha_nac','$direccion','$telefono_movil','$email',$codcom)";
		        $result_solicitante = pg_query($query_solicitante)or die(pg_last_error());
		        $result_insert=pg_fetch_array($result_solicitante);
		        pg_free_result($result_solicitante);*/

                if ($result_insert[0]==1){
		            $error="bien";
		        }else{
		            $error="Error";
		            $div_menssage='<div align="left">
		                    <h3 class="error">
		                        <font color="red" style="text-decoration:blink;">
		                            Error: La Cedula ó RIF Ya existe Registrada, por favor verifique los datos!
		                        </font>
		                    </h3>
		                </div>';
		        }					
            }					
        }								    
    }
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Portuguesa Digital</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="css/css_index/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	<!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrapValidator.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
<!-- Wrapper -->
<div id="wrapper">
	<!-- Main -->
	<div id="main">
		<div class="inner">
			<div class="row">
			    <div class="col-lg-12">
					<div class="panel-body">
						<header id="header">
							<a href="index.php" class="logo">
								<img src="images/logo.jpg">
							</a>
							<ul class="icons">
								<li>
									<a href="#" class="icon fa-twitter">
										<span class="label">Twitter</span>
									</a>
								</li>

								<li>
									<a href="#" class="icon fa-facebook">
										<span class="label">Facebook</span>
									</a>
								</li>
								
								<li>
									<a href="#" class="icon fa-instagram">
										<span class="label">Instagram</span>
									</a>
								</li>
								<li>
									<a href="index1.php" class="button">LOGIN</a>
								</li>

								<li>
									<a href="registrate.php" class="button">REGISTRATE</a>
								</li>
							</ul>
						</header>

			            <div class="row">
							<form id="QForm" name="QForm" method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">
								<input class="form-control" type="hidden" id="nivel_acceso" name="nivel_acceso" value="6" />
								<input class="form-control" type="hidden" id="status_usuario" name="status_usuario" value="1" />
								<input class="form-control" type="hidden" id="unidad_usuario" name="unidad_usuario" value="51" />
								<input class="form-control"  type="hidden" id="tipo_solicitante" name="tipo_solicitante" value="14" />
								<div class="col-lg-12">
				                    <h1>REGISTRATE GRATIS</h1>
				                </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

					            <div class="form-group" align="center"> 
					                <h3 class="info">   
					                    <font size="2">                     
					                        <h1>Datos registrados con &eacute;xito</h1>
					                        <br />
					                        <script type="text/javascript">
					                            function redireccionar(){
					                                window.location="?view=solicitante_load_view<?php echo '&cedula_rif='.$cedula_rif;?>";
					                            }  
					                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
					                        </script> 						
					                        [<a href="?view=solicitante_load_view<?php echo '&cedula_rif='.$cedula_rif;?>" name="Continuar"> Continuar </a>]
					                    </font>							
					                </h3>
					            </div>

<?php }else{ ?>   <!-- Mostrar formulario Original --> 

			    				<div class="col-lg-4">
			    					<div class="form-group" autofocus="true">
			                            <label>C&Eacute;DULA / RIF</label>
			                            <input size="10" class="form-control"  type="text" id="cedula_rif" name="cedula_rif" />
			                        </div>

			                        <div class="form-group">
			                            <label>NOMBRE DEL USUARIO</label>
			                            <input size="10" class="form-control"  type="text" id="nombre_usuario" name="nombre_usuario" />
			                        </div>

			                        <div class="form-group">
			                            <label>APELLIDOS DEL USUARIO</label>
			                            <input size="10" class="form-control"  type="text" id="apellido_usuario" name="apellido_usuario" />
			                        </div>

			                        <div class="form-group">
			                            <label>FECHA DE NACIMIENTO</label>
			                            <input class="form-control" name="fecha_nac" type="date" value="<?php if ($error!="") echo implode('/',array_reverse(explode('-',$fecha_nac)));?>"  id="fecha_nac"  size="10" maxlength="10" onKeyPress="ue_formatofecha(this,'/',patron,true);"  />
			                        </div>

			                        <div class="form-group">
			                            <label>SEXO DEL USUARIO</label>
			                            <select id="sexo" name="sexo" class="form-control" size="1">
		                                    <?php
		                                        if($error!="") {
		                                            if($sexo=="1") {
		                                                echo '<option value="'.$sexo.'" selected="selected">MASCULINO</option>';
		                                            }elseif($sexo=="2") {
		                                                echo '<option value="'.$sexo.'" selected="selected">FEMENINO</option>';
		                                            }else{
		                                                echo '<option value="'.$sexo.'" selected="selected">NO APLICA</option>';
		                                            }
		                                        }                               
		                                    ?>
		                                    <option value="" >---</option>
		                                    <option value="1">MASCULINO</option>
		                                    <option value="2">FEMENINO</option> 
		                                    <option value="3">NO APLICA</option>
		                                </select>
			                        </div>
								</div>

								<div class="col-lg-4">
									<div class="form-group">
			                            <label>TELEFONO MOVIL</label>
			                            <input size="10" class="form-control"  type="text" id="telefono_movil" name="telefono_movil" />
			                        </div>

			                        <div class="form-group">
			                            <label>E-MAIL</label>
			                            <input class="form-control" placeholder="minombre@ejemplo.com" title="Ej.: minombre@ejemplo.com" type="text" id="email" name="email" size="50" value="<?php echo $result_solicitantes[email];?>" maxlength="50"/> 
			                        </div>

			                        <div class="form-group">
			                            <label>USUARIO</label>
			                            <input size="10" class="form-control"  type="text" id="usuario" name="usuario" />
			                        </div>

			                        <div class="form-group">
			                            <label>PASSWORD</label>
			                            <input size="10" class="form-control"  type="text" id="password" name="password" />
			                        </div>

			                        <div class="form-group">
			                            <label>CONFIRMAR PASSWORD</label>
			                            <input size="10" class="form-control"  type="text" id="confirmar_password" name="confirmar_password" />
			                        </div>
								</div>

								<div class="col-lg-4">
									<div class="form-group">
		                                <label>ESTADO</label>
		                                <select id="codest" name="codest" class="form-control" onchange="cargarContenidoMunicipio();" onclick="cargarContenidoMunicipio();"  >
		                                    <option value="">----</option>
		                                    <?php 
		                                        $consulta_sql=pg_query("SELECT * FROM estados order by codest") or die('La consulta fall&oacute;: ' . pg_last_error());
		                                        while ($array_consulta=  pg_fetch_array($consulta_sql)){
		                                            if ($array_consulta[1]==$result_solicitantes[codest]){
		                                                echo '<option value="'.$array_consulta[1].'" selected="selected">'.$array_consulta[2].'</option>';
		                                            }else {
		                                                echo '<option value="'.$array_consulta[1].'">'.$array_consulta[2].'</option>';
		                                            }
		                                        }
		                                        pg_free_result($consulta_sql);
		                                    ?>
		                                </select>
		                            </div>

		                            <div class="form-group">
		                                <label>MUNICIPIO</label>
		                                <div id="contenedor2">
		                                    <select name="codmun" id="codmun" class="form-control" onChange="cargarContenidoParroquia();">
		                                        <option value="">----</option>
		                                        <?php                                       
		                                            $consultax1="SELECT * from municipios where codest='$result_solicitantes[codest]' order by codmun";
		                                            $ejec_consultax1=pg_query($consultax1);
		                                            while($vector=pg_fetch_array($ejec_consultax1)){
		                                                if ($vector[2]==$result_solicitantes[codmun]){
		                                                    echo '<option value="'.$vector[2].'" selected="selected">'.$vector[3].'</option>';
		                                                }else {
		                                                    echo '<option value="'.$vector[2].'">'.$vector[3].'</option>';
		                                                }
		                                            }
		                                            pg_free_result($ejec_consultax1);
		                                        ?>
		                                    </select>
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label>PARROQUIA</label>
		                                <div id="contenedor3">
		                                    <select name="codpar" id="codpar" class="form-control" onchange="cargarContenidoComunidad();" >
		                                        <option value="">----</option>
		                                        <?php 
		                                            $consultax1="SELECT * from parroquias where codest='$result_solicitantes[codest]' and codmun='$result_solicitantes[codmun]' order by codpar";
		                                            $ejec_consultax1=pg_query($consultax1);
		                                            while($vector=pg_fetch_array($ejec_consultax1)){
		                                                if ($vector[3]==$result_solicitantes[codpar]){
		                                                    echo '<option value="'.$vector[3].'" selected="selected">'.$vector[4].'</option>';
		                                                }else {
		                                                    echo '<option value="'.$vector[3].'">'.$vector[4].'</option>';
		                                                }
		                                            }
		                                            pg_free_result($ejec_consultax1);                                                                       
		                                        ?>
		                                    </select>
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label>COMUNIDAD</label>
		                                <div id="contenedor4">
		                                    <select name="codcom" id="codcom" class="form-control">
		                                        <option value="">----</option>
		                                        <?php 
		                                            $consultax1="SELECT * from comunidades where codest='$result_solicitantes[codest]' and codmun='$result_solicitantes[codmun]' and codpar='$result_solicitantes[codpar]'  order by descom";
		                                            $ejec_consultax1=pg_query($consultax1);
		                                            while($vector=pg_fetch_array($ejec_consultax1)){
		                                                if ($vector[0]==$result_solicitantes[idcom]){
		                                                    echo '<option value="'.$vector[0].'" selected="selected">'.$vector[5].'</option>';
		                                                }else {
		                                                    echo '<option value="'.$vector[0].'">'.$vector[5].'</option>';
		                                                }
		                                            }
		                                            pg_free_result($ejec_consultax1);                                                                       
		                                        ?>
		                                    </select>
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label>DIRECCI&Oacute;N DE HABITACI&Oacute;N</label>
		                                <textarea class="form-control" name="direccion" id="direccion" rows="2" onkeyup=""><?php echo $result_solicitantes[direccion_habitacion];?></textarea>
		                            </div>
								</div>

								<div class="col-lg-12" align="right">
		                            <input type="submit" class="button" name="save" value="  REGISTRARSE  " >
		                            <input  class="button" type="button" onclick="javascript:window.location.href='index.php'" value="Cerrar" name="cerrar" /> 
		                        </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }  ?> 

	<!-- Scripts -->
	<script src="js/js_index/jquery.min.js"></script>
	<script src="js/js_index/skel.min.js"></script>
	<script src="js/js_index/util.js"></script>
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="js/js_index/main.js"></script>

	<!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrapValidator.min.js"></script>

    <!-- validation bootstrap -->
    <script src="vendor/validation/validation.js"></script>

        <!-- script del jquery, ajax y funciones javascript-->
    <script src="vendor/validation/ajax.js"></script>
    <script src="vendor/validation/lib_javascript.js"></script>

    <script src="vendor/js/jquery.js"></script>
    <script src="vendor/maskedinput/jquery.maskedinput.js"></script>

    <script type="text/javascript" >
	jQuery(function($) {
	      $.mask.definitions['~']='[JEVGDCH]';
	      //$('#fecha_nac').mask('99/99/9999');
	      $('#telefono').mask('(9999)-9999999');
	      $('#celular').mask('(9999)-9999999');
	      $('#cedula_rif').mask('~-9999?99999',{placeholder:" "});
	});
</script>
</body>
</html>