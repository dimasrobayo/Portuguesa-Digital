<!-- Bootstrap Core CSS -->
<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../../vendor/bootstrap/css/bootstrapValidator.min.css" rel="stylesheet">

<?php

    require("../../conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?> 

<?php 
    if (isset($_POST[save])) {   // Insertar Datos del formulario
        $descripcion = trim($_POST['descripcion']);

        // Consultamos si existe la descripcion
        $query = "SELECT * FROM denuncia WHERE denuncia='$descripcion'";
        $result = pg_query($query)or die(pg_last_error());
        $resultado=pg_fetch_array($result);
        pg_free_result($result);						

        if (!$resultado[0]) {

            $query="insert into denuncia (denuncia) values ('$descripcion')";
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
    }//
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
                    <h4 class="text-primary"><strong> DENUNCIA ANONIMA </strong></h4>
            </div>
<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->
                
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2"> 					
                        <h1>Datos registrados con &eacute;xito </h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=denuncia";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=denuncia" name="Continuar"> Continuar </a>]
                    </font>							
                </h3>
            </div> 
                
<?php	}else{ 	?>   <!-- Mostrar formulario Original --> 
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>DESCRIBE TU DENUNCIA</label>
                                <textarea type="text" id="descripcion" name="descripcion" value="<?php if ($error!='') echo $descripcion;?>" class="form-control"></textarea>
                            </div>      
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Guardar  " >
                            <input class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=tipo_solicitantes'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div>

<?php }  ?>

        </div>
    </div>
</div>
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