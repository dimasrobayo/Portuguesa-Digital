<?php //ENRUTTADOR

    $redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$view;

    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?> 

<?php 
//    $query="update solicitantes set telefono_movil='4145741800' where cedula_rif='V17004011'";
//    $result = pg_query($query) or die(pg_last_error());
//    
    $query="select * from solicitantes where telefono_movil<>''";
    $result_solicitantes = pg_query($query)or die(pg_last_error());
    $total=0;
    
    while($resultados = pg_fetch_array($result_solicitantes)) {
        if ($resultados[0]){
            strlen($str);
            if(strlen($resultados['telefono_movil'])==10){
                substr_replace($resultados['cedula_rif'],'-',1,0);

                $telefono=str_pad($resultados['telefono_movil'],11,"0",STR_PAD_LEFT);
                $telefono=substr_replace($telefono,'(',0,0);
                $telefono=substr_replace($telefono,')',5,0);
                $telefono=substr_replace($telefono,'-',6,0);
                
                if (stristr($telefono, '0414') or stristr($telefono, '0424') or stristr($telefono, '0426') or stristr($telefono, '0416') or stristr($telefono, '0412')){
                    $query="update solicitantes set telefono_movil='$telefono' where cedula_rif='$resultados[cedula_rif]'";
                    $result = pg_query($query) or die(pg_last_error());

                    $total++;
                }else{
                    $query="update solicitantes set telefono_movil='' where cedula_rif='$resultados[cedula_rif]'";
                    $result = pg_query($query) or die(pg_last_error());
                }
                
            }else{
                $query="update solicitantes set telefono_movil='' where cedula_rif='$resultados[cedula_rif]'";
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

<div align="center" class="centermain">
    <div class="main">  
        <table class="adminclientes" width="100%">
            <tr>
                <th>
                    <h4 class="text-primary"><strong> SOLICITANTES </strong></h4>
                </th>
            </tr>
        </table>
        
        <table class="adminform" border="0" width="100%">
            <tr>
                <th colspan="2" align="center">
                    <img src="images/delete.png" width="16" height="16" alt="Eliminar Registro">
                    EJCUTANDO MANTENIMIENTO DE TICKETS TMP
                </th>
            </tr>
            
            <tr>
                <td colspan="2" align="center">
                    <div align="center"> 
                        <h3 class="info">	
                            <font size="2">
                                <?php
                                    echo 'Se ejecutaron '.$total.' Modificaciones de Mantenimiento en Tickets';
                                ?>
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
                </td>
            </tr>
        </table>
        <br>
    </div>
</div>
