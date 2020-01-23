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
    
    if (isset($_GET['cedula_usuario'])){ // Recibir los Datos 
        $datos_modificar= $_GET['cedula_usuario'];

        $query_consulta="SELECT COUNT(*) from permisos where cedula_usuario='$datos_modificar'";
        $result_consulta = pg_query($query_consulta)or die(pg_last_error());
        $result_valida=pg_fetch_row($result_consulta);
        pg_free_result($result_consulta);

        if ($result_valida[0]==0){
            $query="SELECT * FROM usuarios where usuarios.cedula_usuario = '$datos_modificar'";
            $result = pg_query($query)or die(pg_last_error());
            $result_usuarios=pg_fetch_array($result);   
            pg_free_result($result);
        }else{
            $query="SELECT * FROM usuarios, permisos where usuarios.cedula_usuario=permisos.cedula_usuario and usuarios.cedula_usuario = '$datos_modificar'";
            $result = pg_query($query)or die(pg_last_error());
            $result_usuarios=pg_fetch_array($result);   
            pg_free_result($result);
        }
    }

    if (isset($_POST[save])) {
        $cedula_rif=strtoupper($_POST['cedula']);
        $cedula = preg_replace("/\s+/", "", $cedula_rif);
        $cedula = str_replace("-", "", $cedula);
        $recibir_orden =$_POST['recibir_orden'];
        $solicitar_punto = $_POST['solicitar_punto'];
        $administra_pago_hidrologica = $_POST['administra_pago_hidrologica'];
        $modifica_ticket_completados = $_POST['modifica_ticket_completados'];
        $visualiza_estadisticas = $_POST['visualiza_estadisticas'];
        $mensajeria_masiva = $_POST['mensajeria_masiva'];
        $visualiza_reportes = $_POST['visualiza_reportes'];
        $visualiza_herramientas = $_POST['visualiza_herramientas'];

        $genera_ordenes = $_POST['genera_ordenes'];
        $administrar_punto = $_POST['administrar_punto'];
        $configurar_sistema = $_POST['configurar_sistema'];
        $usuarios_sistema = $_POST['usuarios_sistema'];
        $estados_tramites = $_POST['estados_tramites'];
        $categorias = $_POST['categorias'];
        $unidades = $_POST['unidades'];
        $tipo_solicitantes = $_POST['tipo_solicitantes'];
        $comunidades = $_POST['comunidades'];
        $profesiones = $_POST['profesiones'];
        $entes_publicos = $_POST['entes_publicos'];
        $partidos_politicos = $_POST['partidos_politicos'];
        $mis_archivos = $_POST['mis_archivos'];
        $pagos_servicios = $_POST['pagos_servicios'];
        $atencion_portugueseno = $_POST['atencion_portugueseno'];
        $genera_solicitudes = $_POST['genera_solicitudes'];
        $registra_solicitantes = $_POST['registra_solicitantes'];
        $administra_estado_mayor = $_POST['administra_estado_mayor'];
        $gestiona_estado_mayor = $_POST['gestiona_estado_mayor'];

        $query_consulta="SELECT COUNT(*) from permisos where cedula_usuario='$cedula'";
        $result_consulta = pg_query($query_consulta)or die(pg_last_error());
        $result_valida=pg_fetch_row($result_consulta);
        pg_free_result($result_consulta);

        if ($result_valida[0]==0){
            $query="insert into permisos (cedula_usuario, recibir_orden, solicitar_punto, administra_pago_hidrologica, modifica_ticket_completados, visualiza_estadisticas, mensajeria_masiva, visualiza_reportes, visualiza_herramientas, genera_ordenes, administrar_punto, configurar_sistema, usuarios_sistema, estados_tramites, categorias, unidades, tipo_solicitantes, comunidades, profesiones, entes_publicos, partidos_politicos, mis_archivos, pagos_servicios, atencion_portugueseno, genera_solicitudes, registra_solicitantes, administra_estado_mayor, gestiona_estado_mayor) values ('$cedula', $recibir_orden, $solicitar_punto, $administra_pago_hidrologica, $modifica_ticket_completados, $visualiza_estadisticas, $mensajeria_masiva, $visualiza_reportes, $visualiza_herramientas, $genera_ordenes, $administrar_punto, $configurar_sistema, $usuarios_sistema, $estados_tramites, $categorias, $unidades, $tipo_solicitantes, $comunidades, $profesiones, $entes_publicos, $partidos_politicos, $mis_archivos, $pagos_servicios, $atencion_portugueseno, $genera_solicitudes, $registra_solicitantes, $administra_estado_mayor, $gestiona_estado_mayor)";
            $result = pg_query($query)or die(pg_last_error());
            $result_insert_detalle=pg_fetch_row($result);
            $cod_subticket = $result_insert_detalle[0];
            pg_free_result($result);
        $visualiza_herramientas = $_POST['visualiza_herramientas'];
        $visualiza_herramientas = $_POST['visualiza_herramientas'];    $error="bien";
        }else{
            $query="update permisos set recibir_orden='$recibir_orden', solicitar_punto='$solicitar_punto', administra_pago_hidrologica='$administra_pago_hidrologica', modifica_ticket_completados='$modifica_ticket_completados', visualiza_estadisticas='$visualiza_estadisticas', mensajeria_masiva='$mensajeria_masiva', visualiza_reportes='$visualiza_reportes', visualiza_herramientas='$visualiza_herramientas', genera_ordenes='$genera_ordenes', administrar_punto='$administrar_punto', configurar_sistema='$configurar_sistema', usuarios_sistema='$usuarios_sistema', estados_tramites='$estados_tramites', categorias='$categorias', unidades='$unidades', tipo_solicitantes='$tipo_solicitantes', comunidades='$comunidades', profesiones='$profesiones', entes_publicos='$entes_publicos', partidos_politicos='$partidos_politicos', mis_archivos='$mis_archivos', pagos_servicios='$pagos_servicios', atencion_portugueseno='$atencion_portugueseno', genera_solicitudes='$genera_solicitudes', registra_solicitantes='$registra_solicitantes', administra_estado_mayor='$administra_estado_mayor', gestiona_estado_mayor='$gestiona_estado_mayor' where cedula_usuario='$cedula'";
            $result = pg_query($query)or die(pg_last_error());
            $result_insert_detalle=pg_fetch_row($result);
            $cod_subticket = $result_insert_detalle[0];
            pg_free_result($result);
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
                <h4 class="text-primary"><strong> PERMISOS DEL USUARIO: <?php echo $result_usuarios[nombre_usuario] .' ' .$result_usuarios[apellido_usuario];?> </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")){	?> <!-- Mostrar Mensaje -->

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                         
                        <h1>Datos Modificados con &eacute;xito</h1> 
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=usuarios";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=usuarios" name="Continuar"> Continuar </a>]
                    </font>							
                </h3>
            </div>

<?php	} else{ 	?>   <!-- Mostrar formulario Original -->
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <input id="cedula" name="cedula" value="<?php echo $result_usuarios[cedula_usuario]; ?>" readonly="true" type="hidden"/>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Configurar Datos del Sistema</label>
                                <select class="form-control" id="configurar_sistema" name="configurar_sistema">
                                    <?php
                                    if($result_usuarios[configurar_sistema]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Usuario del Sistema</label>
                                <select class="form-control" id="usuarios_sistema" name="usuarios_sistema">
                                    <?php
                                    if($result_usuarios[usuarios_sistema]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Estados de los Tramites</label>
                                <select class="form-control" id="estados_tramites" name="estados_tramites">
                                    <?php
                                    if($result_usuarios[estados_tramites]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Categorias</label>
                                <select class="form-control" id="categorias" name="categorias">
                                    <?php
                                    if($result_usuarios[categorias]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Unidades</label>
                                <select class="form-control" id="unidades" name="unidades">
                                    <?php
                                    if($result_usuarios[unidades]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tipo de Solicitantes</label>
                                <select class="form-control" id="tipo_solicitantes" name="tipo_solicitantes">
                                    <?php
                                    if($result_usuarios[tipo_solicitantes]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Comunidades</label>
                                <select class="form-control" id="cominidades" name="comunidades">
                                    <?php
                                    if($result_usuarios[comunidades]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Profesiones</label>
                                <select class="form-control" id="profesiones" name="profesiones">
                                    <?php
                                    if($result_usuarios[profesiones]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Entes Publicos</label>
                                <select class="form-control" id="entes_publicos" name="entes_publicos">
                                    <?php
                                    if($result_usuarios[entes_publicos]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Partidos Politicos</label>
                                <select class="form-control" id="partidos_politicos" name="partidos_politicos">
                                    <?php
                                    if($result_usuarios[partidos_politicos]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Visualiza Estadisticas</label>
                                <select class="form-control" id="visualiza_estadisticas" name="visualiza_estadisticas">
                                    <?php
                                    if($result_usuarios[visualiza_estadisticas]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Visualiza Punto de Cuenta</label>
                                <select class="form-control" id="solicitar_punto" name="solicitar_punto">
                                    <?php
                                        if($result_usuarios[solicitar_punto]==1) {
                                            echo '<option value="'.$result_usuarios[solicitar_punto].'" selected="selected">Activar</option>';
                                            echo '<option value="0">Desactivar</option>';
                                        }elseif($result_usuarios[solicitar_punto]==0){
                                            echo '<option value="'.$result_usuarios[solicitar_punto].'" selected="selected">Desactivar</option>';
                                            echo '<option value="1">Activar</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Genera Punto de Cuenta</label>
                                <select class="form-control" id="administrar_punto" name="administrar_punto">
                                    <?php
                                    if($result_usuarios[administrar_punto]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Visualiza Ordenes</label>
                                <select class="form-control" id="recibir_orden" name="recibir_orden">
                                    <?php
                                    if($result_usuarios[recibir_orden]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Genera Orden</label>
                                <select class="form-control" id="genera_ordenes" name="genera_ordenes">
                                    <?php
                                    if($result_usuarios[genera_ordenes]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Administrador de Estado Mayor</label>
                                <select class="form-control" id="administra_estado_mayor" name="administra_estado_mayor">
                                    <?php
                                    if($result_usuarios[administra_estado_mayor]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Gestiona Estado Mayor</label>
                                <select class="form-control" id="gestiona_estado_mayor" name="gestiona_estado_mayor">
                                    <?php
                                    if($result_usuarios[gestiona_estado_mayor]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Mis Archivos</label>
                                <select class="form-control" id="mis_archivos" name="mis_archivos">
                                    <?php
                                    if($result_usuarios[mis_archivos]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Pagos de Servicios</label>
                                <select class="form-control" id="pagos_servicios" name="pagos_servicios">
                                    <?php
                                    if($result_usuarios[pagos_servicios]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Administar Pagos Hidrologica</label>
                                <select class="form-control" id="administra_pago_hidrologica" name="administra_pago_hidrologica">
                                    <?php
                                    if($result_usuarios[administra_pago_hidrologica]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Atencion al Portugueseño</label>
                                <select class="form-control" id="atencion_portugueseno" name="atencion_portugueseno">
                                    <?php
                                    if($result_usuarios[atencion_portugueseno]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Genera Solicitudes</label>
                                <select class="form-control" id="genera_solicitudes" name="genera_solicitudes">
                                    <?php
                                    if($result_usuarios[genera_solicitudes]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Registra Solicitantes</label>
                                <select class="form-control" id="registra_solicitantes" name="registra_solicitantes">
                                    <?php
                                    if($result_usuarios[registra_solicitantes]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Modifica Ticket Completados</label>
                                <select class="form-control" id="modifica_ticket_completados" name="modifica_ticket_completados">
                                    <?php
                                    if($result_usuarios[modifica_ticket_completados]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Mensajeria Masiva</label>
                                <select class="form-control" id="mensajeria_masiva" name="mensajeria_masiva">
                                    <?php
                                    if($result_usuarios[mensajeria_masiva]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Visualiza Reportes</label>
                                <select class="form-control" id="visualiza_reportes" name="visualiza_reportes">
                                    <?php
                                    if($result_usuarios[visualiza_reportes]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Visualiza Herramientas</label>
                                <select class="form-control" id="visualiza_herramientas" name="visualiza_herramientas">
                                    <?php
                                    if($result_usuarios[visualiza_herramientas]==0) {
                                        echo '<option value="0" selected="selected">Desactivar</option>';
                                        echo '<option value="1">Activar</option>';
                                    }else{
                                        echo '<option value="1" selected="selected">Activar</option>';
                                        echo '<option value="0">Desactivar</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	

                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Guardar  " >
                            <input class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=home'" value="Cerrar" name="cerrar" /> 
                        </div>
                    </td>
                </tr>
            <?php }  ?>	
        </table>
    </form>     
    <br>	 
    </div>
</div>