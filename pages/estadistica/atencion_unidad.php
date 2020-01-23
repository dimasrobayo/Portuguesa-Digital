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
                <h4 class="text-primary"><strong> ESTADISTICA DE ATENCION POR UNIDAD </strong></h4>
            </div>
                
            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="?view=est_aten_unidad" id="QForm" name="QForm" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>SELECCIONA LA UNIDAD</label>
                                <select name="cod_unidad" id="cod_unidad" class="form-control">
                                    <option selected="selected" value="">---</option>
                                    <?php 
                                        $consulta_sql=pg_query("SELECT * FROM unidades where status_unidad=1 order by nombre_unidad");
                                        while ($array_consulta=pg_fetch_array($consulta_sql)){                                                                                                                                              
                                            echo '<option value="'.$array_consulta[0].'">'.$array_consulta[2].'</option>';                                                                          
                                        }                                                                                                                                                       
                                        pg_free_result($consulta_sql);                              
                                    ?>              
                                </select> 
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
