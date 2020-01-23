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
                <h4 class="text-primary"><strong> ESTADISTICA DE ORDENES MENSUALES </strong></h4>
            </div>
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="?view=est_ord_mensuales" id="QForm" name="QForm" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="form-group col-lg-6" autofocus="true">
                                    <label>SELECCIONA EL MES</label>
                                    <select name="month" id="month" class="form-control">
                                        <?php 
                                        $consulta_sql=pg_query("SELECT date_part('month',fecha_registro) AS year FROM ordenes  group by date_part('month',fecha_registro) order by date_part('month',fecha_registro) ASC");                                
                                        while ($array_consulta=pg_fetch_array($consulta_sql)){
                                            if ($year!=""){
                                                if ($array_consulta[0]==$year){
                                                    echo '<option value="'.$array_consulta[0].'" selected="selected">'.$array_consulta[0].'</option>';
                                                }else {
                                                    echo '<option value="'.$array_consulta[0].'">'.$array_consulta[0].'</option>';
                                                }
                                            }else {
                                                echo '<option value="'.$array_consulta[0].'">'.$array_consulta[0].'</option>';
                                            }
                                        }
                                        pg_free_result($consulta_sql);                                  
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6" autofocus="true">
                                    <label>SELECCIONA EL AÑO</label>
                                    <select name="year" id="year" class="form-control">
                                        <?php 
                                        $consulta_sql=pg_query("SELECT date_part('year',fecha_registro) AS year FROM ordenes  group by date_part('year',fecha_registro) order by date_part('year',fecha_registro) DESC");                                
                                        while ($array_consulta=pg_fetch_array($consulta_sql)){
                                            if ($year!=""){
                                                if ($array_consulta[0]==$year){
                                                    echo '<option value="'.$array_consulta[0].'" selected="selected">'.$array_consulta[0].'</option>';
                                                }else {
                                                    echo '<option value="'.$array_consulta[0].'">'.$array_consulta[0].'</option>';
                                                }
                                            }else {
                                                echo '<option value="'.$array_consulta[0].'">'.$array_consulta[0].'</option>';
                                            }
                                        }
                                        pg_free_result($consulta_sql);                                  
                                        ?>
                                    </select>
                                </div>	
                            </div>	
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  GENERAR  " >
                            <input class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=tipo_solicitantes'" value="Cerrar" name="cerrar" />  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
