<?php //ENRUTTADOR

    $redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$view;

    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?> 

<?php 
    $query="select * from solicitantes where telefono_fijo<>''";
    $result_solicitantes = pg_query($query)or die(pg_last_error());
    $total=0;
    
    while($resultados = pg_fetch_array($result_solicitantes)) {
        if ($resultados[0]){
            strlen($str);
            if(strlen($resultados['telefono_fijo'])==10){

                $telefono=str_pad($resultados['telefono_fijo'],11,"0",STR_PAD_LEFT);
                $telefono=substr_replace($telefono,'(',0,0);
                $telefono=substr_replace($telefono,')',5,0);
                $telefono=substr_replace($telefono,'-',6,0);
                
                if (stristr($telefono, '0414') or stristr($telefono, '0424') or stristr($telefono, '0426') or stristr($telefono, '0416') or stristr($telefono, '0412')){
                    if ($resultados['telefono_movil']==''){
                        $query="update solicitantes set telefono_fijo='', telefono_movil='$telefono' where cedula_rif='$resultados[cedula_rif]'";
                        $result = pg_query($query) or die(pg_last_error());
                    }else{
                        $query="update solicitantes set telefono_fijo='' where cedula_rif='$resultados[cedula_rif]'";
                        $result = pg_query($query) or die(pg_last_error());
                    }
                }else{
                    $query="update solicitantes set telefono_fijo='$telefono' where cedula_rif='$resultados[cedula_rif]'";
                    $result = pg_query($query) or die(pg_last_error());

                    $total++;
                }
                
            }else{
                $query="update solicitantes set telefono_fijo='' where cedula_rif='$resultados[cedula_rif]'";
                $result = pg_query($query) or die(pg_last_error());
            }
        }
    }
    
?> 

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
                    <h4 class="text-primary"><strong> SOLICITANTES </strong></h4>
            </div>
        
            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2"> 
                        <h1><?php echo 'Se ejecutaron '.$total.' Modificaciones de Mantenimiento en Tickets'; ?></h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=home";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script> 						
                        [<a href="?view=home" name="Continuar"> Continuar </a>]
                    </font>							
                </h3>
            </div> 
        </div>
    </div>
</div>
