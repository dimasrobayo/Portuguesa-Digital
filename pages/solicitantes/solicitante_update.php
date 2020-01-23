<script>
    jQuery( document ).ready(function( $ ) {
        $.fn.selectOption = function() {
           return this.each(function() { //para cada combo box ejecutamos la siguiente funcion 
              id = $(this).attr('id');
              //el "selected" se podria cambiar por "title" u otro atributo si queremos un html mas valido
              val = $(this).attr('set');
              //si no hay un id, agregamos uno temporalmente
              if(!id) {
                 id = 'fake_id';
                 $(this).attr('id', 'fake_id');
                 fakeId = true;
              } else {
                 fakeId = false;
              }
              if(val) {
                 //y aqui lo mas importante, utilizamos el selector de jquery para buscar el option que necesita
                 //el atributo selected y agregarselo...
                 $('#' + id + ' option[value='+val+']').attr('selected', 'selected');
              }
              //eliminamos el id temporal en caso de haberlo utilizado
              if(fakeId) {
                  $(this).removeAttr('id');
              }
           });
        }

        window.onload = function() {
            var cedula = $("#cedula_rif").val();
            validarGetName(cedula); //SE CARGAR LA FUNCIÓN AL CARGAR LA PÁGINA
        };

        function validarGetName(cedulaRif){
            var naci = cedulaRif.substring(0, 1); //OBTIENE LA NACIONALIDAD
            var ced = cedulaRif.substring(2, 12); //OBTIENE LA CEDULA O RIF SEA EL CASO
            switch(naci){ //IDENTIFICAR SI ES RIF O CEDULA
                case ('J' || 'G'):
                    getSENIAT(naci,ced);
                break;
                case ('V' || 'E'):
                    getCNE(naci,ced);
                break;
            }
        }


        function getSENIAT(n,c) {
            $.ajax({
                url: "library/Rif.php",
                type: 'POST',
                data: 'rif='+n+'-'+c,
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    if(obj.code_result<0){ //NO OBTUVO RESULTADOS CON EL RIF, SE INSERTA EL NOMBRE MANUAL
                        document.getElementById("nombreapellido").readOnly = false;
                    } else {
                        $('input[name="nombreapellido"]').val(obj.seniat.nombre); //SE ASIGNA LOS NOMBRES OBTENIDOS DEL RIF
                        document.getElementById("nombreapellido").readOnly = false;
                    }
                }
            })
        }

        function getCNE(n,c){
            $.ajax({
                url: "library/getCNE.php",
                type: 'POST',
                data: 'nacionalidad='+n+'&cedula='+c,
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.inscrito == "NO") { // SINO EXISTE EN EL CNE, SE CALCULA EL RIF Y SE ENVIA A GETSENIAT
                        $.ajax({
                            url: "library/setRif.php",
                            type: 'POST',
                            data: 'nacionalidad='+n+'&cedula='+c,
                            success: function(data) {
                                var naci = data.substring(0, 1);
                                var ced1 = data.substring(1, 9)+"-"+data.substring(9, 10);
                                getSENIAT(naci,ced1); //SE ENVIA A GETSENIAT
                            }
                        });
                    } else { // SI EXISTE EL REGISTRO ASIGNA EL NOMBRE, ESTADO, MUNICIPIO Y PARROQUIA
                        document.getElementById("nombreapellido").readOnly = false;
                        $('input[name="nombreapellido"]').val(obj.nombres+" "+obj.apellidos);
                        var estado, parroquia, municipio;
                        estado = obj.cvestado.substring(5,20);
                        municipio = obj.cvmunicipio.substring(4,20);
                        parroquia = obj.cvparroquia.substring(4,20);
                        //console.log("ESTADO: "+estado);
                        //console.log("MUNICIPIO: "+municipio);
                        //console.log("PARROQUIA: "+parroquia);

                        setTimeout(function() {
                            $.ajax({
                                url: "library/localidad.php",
                                type: 'POST',
                                data: 'estado='+estado,
                                success: function(data) {
                                    //console.log("1. "+data);
                                    $('#codest').attr('set',data);
                                    $("#codest").selectOption();
                                    cargarContenidoMunicipio();
                                }   
                            });
                        }, 0);

                        setTimeout(function() {
                            $.ajax({
                                url: "library/localidad.php",
                                type: 'POST',
                                data: 'municipio='+municipio,
                                success: function(data) {
                                    //console.log("2. "+data);
                                    $('#codmun').attr('set',data);
                                    $("#codmun").selectOption();
                                    cargarContenidoParroquia();
                                }   
                            });
                        }, 200);

                        setTimeout(function() {
                            $.ajax({
                                url: "library/localidad.php",
                                type: 'POST',
                                data: 'parroquia='+parroquia,
                                success: function(data) {
                                    $("#codmun").selectOption();
                                    //console.log("3. "+data);
                                    $('#codpar').attr('set',data);
                                    $("#codpar").selectOption();
                                    cargarContenidoComunidad();
                                }   
                            });
                        }, 500);
                    } //FIN ELSE
                } //FIN DEL SUCCES AJAX
            }); //FIN AJAX
        }
    });
</script>

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
?> 

<?php   
    if (isset($_GET['cedula_rif'])){ // Recibir los Datos 
        $cedula_rif= $_GET['cedula_rif'];

        $query="select * from solicitantes,comunidades where solicitantes.cedula_rif='$cedula_rif' AND solicitantes.idcom=comunidades.idcom";
        $result = pg_query($query)or die(pg_last_error());
        $result_solicitantes=pg_fetch_array($result);	
        pg_free_result($result);
    }
?> 

<?php 
    if (isset($_POST[save])){   // Insertar Datos del formulario
        $cedula_rif=$_POST['cedula_rif'];		
        $cod_tipo_solicitante=$_POST['cod_tipo_solicitante'];
        $nombreapellido=strtoupper($_POST["nombreapellido"]);
        $sexo=$_POST['sexo'];
        $fecha_nac=implode('-',array_reverse(explode('/',$_POST['fecha_nac']))); 
        $direccion=$_POST['direccion'];
        $telefono=$_POST['telefono'];
        $celular=$_POST['celular'];
        $email=$_POST['email'];
        $codcom=$_POST['codcom'];
        $empleado_publico=$_POST['empleado_publico'];
        $ente_publico=$_POST['ente_publico'];
        $miembro_partido=$_POST['miembro_partido'];
        $nombre_partido=$_POST['nombre_partido'];
        $profesion_solicitante=$_POST['profesion_solicitante'];
        $miembro_clp=$_POST['miembro_clp'];
        $miembro_ubch=$_POST['miembro_ubch'];
        $miembro_umujer=$_POST['miembro_umujer'];
        $miembro_francisco=$_POST['miembro_francisco'];
        $miembro_mincomuna=$_POST['miembro_mincomuna'];
        $pregonero=$_POST['pregonero'];
        
        $query="SELECT update_solicitante('$cedula_rif', '$cod_tipo_solicitante', '$nombreapellido', '$sexo', '$fecha_nac', '$direccion', '$telefono', '$celular', '$email', '$codcom', '$empleado_publico', '$ente_publico', '$miembro_partido', '$nombre_partido', '$profesion_solicitante', '$miembro_clp', '$miembro_ubch', '$miembro_umujer', '$miembro_francisco','$miembro_mincomuna', '$pregonero', 'now()')";
        $result = pg_query($query)or die(pg_last_error());
        $result_update=pg_fetch_array($result);
        pg_free_result($result);
        
        $error="bien";
    }
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
                <h4 class="text-primary"><strong> MODIFICAR DATOS DEL SOLICITANTE </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){  ?> <!-- Mostrar Mensaje -->

            <tr>
                <td colspan="2" align="center">
                    <div align="center"> 
                        <h3 class="info">   
                            <font size="2">                     
                                <h1>Datos Modificados con &eacute;xito</h1>
                                <br />
                                <script type="text/javascript">
                                    function redireccionar(){
                                        window.location="?view=solicitante_load_view<?php echo '&cedula_rif='.substr_replace($cedula_rif,'-',1,0);?>";
                                    }  
                                    setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                                </script>                       
                                [<a href="?view=solicitante_load_view<?php echo '&cedula_rif='.substr_replace($cedula_rif,'-',1,0);?>" name="Continuar"> Continuar </a>]
                            </font>                         
                        </h3>
                    </div> 
                </td>
            </tr>

<?php   }else{  ?>   <!-- Mostrar formulario Original --> 
	    					
            <div class="panel-body">
                <div class="row">
                    <form id="QForm" name="QForm" method="POST" action="<?php echo $pagina?>" enctype="multipart/form-data">
                        <input type="hidden" id="cedula_rif" name="cedula_rif"  value="<?php echo $result_solicitantes['cedula_rif'];?>" />
                        <div class="col-lg-6">
                            <div class="form-group" autofocus="true">
                                <label>C&Eacute;DULA / RIF</label>
                                <input size="10" class="form-control"  readonly="readonly" type="text" name="cedula1"  value="<?php  echo substr_replace($result_solicitantes['cedula_rif'],'-',1,0); ?>" />
                            </div>

                            <div class="form-group">
                                <label>TIPO DE SOLICITANTE</label>
                                <select id="cod_tipo_solicitante" name="cod_tipo_solicitante" class="form-control">   
                                    <option value="">----</option>                          
                                    <?php 
                                        $consulta_sql=pg_query("SELECT * FROM tipo_solicitantes");
                                        while ($array_consulta=pg_fetch_array($consulta_sql)){
                                            if ($array_consulta[0]==$result_solicitantes['cod_tipo_solicitante']){
                                                    echo '<option value="'.$array_consulta[0].'" selected="selected">'.$array_consulta[1].'</option>';
                                            }else {
                                                    echo '<option value="'.$array_consulta[0].'">'.$array_consulta[1].'</option>';
                                            }
                                        }
                                        pg_free_result($consulta_sql);
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>NOMBRE DEL SOLICITANTE</label>
                                <input class="form-control" type="text" id="nombreapellido"  name="nombreapellido" value="<?php echo $result_solicitantes[nombre_solicitante];?>" onkeyup="" size="50" maxlength="50"/>
                            </div>

                            <div class="form-group">
                                <label>SEXO</label>
                                <select id="sexo" name="sexo"  class="form-control" size="1">
                                    <?php
                                        if($result_solicitantes[sexo_solicitante]=="1") {
                                            echo '<option value="'.$result_solicitantes[sexo_solicitante].'" selected="selected">MASCULINO</option>';
                                            echo '<option value="2">FEMENINO</option>';
                                            echo '<option value="3">NO APLICA</option>';
                                        }elseif($result_solicitantes[sexo_solicitante]=="2") {
                                            echo '<option value="1">MASCULINO</option>';
                                            echo '<option value="'.$result_solicitantes[sexo_solicitante].'" selected="selected">FEMENINO</option>';
                                            echo '<option value="3">NO APLICA</option>';
                                        }else{
                                            echo '<option value="1">MASCULINO</option>';
                                            echo '<option value="2">FEMENINO</option>';
                                            echo '<option value="'.$result_solicitantes[sexo_solicitante].'" selected="selected">NO APLICA</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>FECHA NATAL/CONSTITUCIÓN</label>
                                <input class="form-control"  name="fecha_nac" type="date" value="<?php echo $result_solicitantes['fecha_nac'];?>"  id="fecha_nac"  size="10" maxlength="10" onKeyPress="ue_formatofecha(this,'/',patron,true);"  />
                            </div>

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
                                <textarea class="form-control" name="direccion" id="direccion" rows="5" onkeyup=""><?php echo $result_solicitantes[direccion_habitacion];?></textarea>
                            </div>

                            <div class="form-group">
                                <label>TEL&Eacute;FONO HAB.</label>
                                <input class="form-control" placeholder="(0212)-1234567" title="Ej.: (0212)-1234567" id="telefono" type="text" name="telefono" size="15" value="<?php echo $result_solicitantes[telefono_fijo];?>" maxlength="15"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>TEL&Eacute;FONO CEL.</label>
                                <input class="form-control" placeholder="(0414)-1234567" title="Ej.: (0414)-1234567" id="celular" type="text" name="celular" size="15" value="<?php echo $result_solicitantes[telefono_movil];?>" maxlength="15"/>
                            </div>
                            
                            <div class="form-group">
                                <label>CORREO ELECTR&Oacute;NICO</label>
                                <input class="form-control" placeholder="minombre@ejemplo.com" title="Ej.: minombre@ejemplo.com" type="text" id="email" name="email" size="50" value="<?php echo $result_solicitantes[email];?>" maxlength="50"/> 
                            </div>

                            <div class="form-group">
                                <label>EMPLEADO PUBLICO</label>
                                <select id="empleado_publico" name="empleado_publico" class="form-control">
                                    <?php
                                        if($result_solicitantes[empleado_publico]=="0") {
                                            echo '<option value="'.$result_solicitantes[empleado_publico].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[empleado_publico]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[empleado_publico].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>ENTE PUBLICO</label>
                                <select name="ente_publico" id="ente_publico" class="form-control">
                                    <option value="<?php echo $result_solicitantes[ente_publico];?>"><?php echo $result_solicitantes[ente_publico];?></option>
                                    <option value="empresa_privada">EMPRESA PRIVADA</option>
                                    <?php                                       
                                        $consultax1="SELECT * from ente_publico order by id_ente";
                                        $ejec_consultax1=pg_query($consultax1);
                                        while($vector=pg_fetch_array($ejec_consultax1)){
                                            if ($vector[0]==$id_ente){
                                                echo '<option value="'.$vector[1].'" selected="selected">'.$vector[1].'</option>';
                                            }else {
                                                echo '<option value="'.$vector[1].'">'.$vector[1].'</option>';
                                            }
                                        }
                                        pg_free_result($ejec_consultax1);
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>PROFESION</label>
                                <select name="profesion_solicitante" id="profesion_solicitante" class="form-control">
                                    <option value="<?php echo $result_solicitantes[nombre_profesion];?>"><?php echo $result_solicitantes[nombre_profesion];?></option>
                                    <?php                                       
                                        $consultax1="SELECT * from profesion order by id_profesion";
                                        $ejec_consultax1=pg_query($consultax1);
                                        while($vector=pg_fetch_array($ejec_consultax1)){
                                            if ($vector[0]==$id_ente){
                                                echo '<option value="'.$vector[1].'" selected="selected">'.$vector[1].'</option>';
                                            }else {
                                                echo '<option value="'.$vector[1].'">'.$vector[1].'</option>';
                                            }
                                        }
                                        pg_free_result($ejec_consultax1);
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>MIEMBRO DE PARTIDO POLITICO</label>
                                <select id="miembro_partido" name="miembro_partido" class="form-control">
                                    <?php
                                        if($result_solicitantes[miembro_partido]=="0") {
                                            echo '<option value="'.$result_solicitantes[miembro_partido].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[miembro_partido]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[miembro_partido].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>MIEMBRO DE PARTIDO POLITICO</label>
                                <select name="nombre_partido" id="nombre_partido" class="form-control">
                                    <option value="<?php echo $result_solicitantes[nombre_partido];?>"><?php echo $result_solicitantes[nombre_partido];?></option>
                                    <?php                                       
                                        $consultax1="SELECT * from partido_politico order by id_partido";
                                        $ejec_consultax1=pg_query($consultax1);
                                        while($vector=pg_fetch_array($ejec_consultax1)){
                                            if ($vector[0]==$id_ente){
                                                echo '<option value="'.$vector[1].'" selected="selected">'.$vector[1].'</option>';
                                            }else {
                                                echo '<option value="'.$vector[1].'">'.$vector[1].'</option>';
                                            }
                                        }
                                        pg_free_result($ejec_consultax1);
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>JEFE DE CLP</label>
                                <select id="miembro_clp" name="miembro_clp" class="form-control">
                                    <?php
                                        if($result_solicitantes[miembro_clp]=="0") {
                                            echo '<option value="'.$result_solicitantes[miembro_clp].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[miembro_clp]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[miembro_clp].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>MIEMBRO DE UBCH</label>
                                <select id="miembro_ubch" name="miembro_ubch" class="form-control">
                                    <?php
                                        if($result_solicitantes[miembro_ubch]=="0") {
                                            echo '<option value="'.$result_solicitantes[miembro_ubch].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[miembro_ubch]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[miembro_ubch].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>MIEMBRO DE UNAMUJER</label>
                                <select id="miembro_umujer" name="miembro_umujer" class="form-control">
                                    <?php
                                        if($result_solicitantes[miembro_umujer]=="0") {
                                            echo '<option value="'.$result_solicitantes[miembro_umujer].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[miembro_umujer]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[miembro_umujer].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>MIEMBRO FRENTE FRANCISCO MIRANDA</label>
                                <select name="miembro_francisco" id="miembro_francisco" class="form-control">
                                    <?php
                                        if($result_solicitantes[miembro_francisco]=="0") {
                                            echo '<option value="'.$result_solicitantes[miembro_francisco].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[miembro_francisco]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[miembro_francisco].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>MIEMBRO MINCOMUNA</label>
                                <select name="miembro_mincomuna" id="miembro_mincomuna" class="form-control">
                                    <?php
                                        if($result_solicitantes[miembro_mincomuna]=="0") {
                                            echo '<option value="'.$result_solicitantes[miembro_mincomuna].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[miembro_mincomuna]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[miembro_mincomuna].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>PREGONERO</label>
                                <select name="pregonero" id="pregonero" class="form-control">
                                    <?php
                                        if($result_solicitantes[pregonero]=="0") {
                                            echo '<option value="'.$result_solicitantes[pregonero].'" selected="selected">NO</option>';
                                            echo '<option value="1">SI</option>';
                                        }elseif($result_solicitantes[pregonero]=="1") {
                                            echo '<option value="0">NO</option>';
                                            echo '<option value="'.$result_solicitantes[pregonero].'" selected="selected">SI</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Guardar  " >
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=solicitante_load_view'" value="Cerrar" name="cerrar" /> 
                        </div>
                    </form>
                </div>
            </div>
        <?php }  ?>		 
    </div>
</div>	

<script type="text/javascript" >
	jQuery(function($) {
        $.mask.definitions['~']='[JEVGDCH]';
        $('#telefono').mask('(9999)-9999999');
        $('#celular').mask('(9999)-9999999');
	});
</script>

