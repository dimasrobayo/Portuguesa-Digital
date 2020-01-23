<?php
    // chequear si se llama directo al script.
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="../../images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    if ($_SERVER['HTTP_REFERER'] == "")	{
        echo "<script type='text/javascript'>window.location.href='index.php?view=login&msg_login=5'</script>";
//        echo "<script type='text/javascript'>window.location.href='index.php'</script>";
        exit;
    }
    $redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$type;

    //Conexion a la base de datos
    include("../conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?>

<?php 
if (isset($_POST[save])){
    $codest = $_POST['codest'];
    $codmun = $_POST['codmun'];
    $codpar = $_POST['codpar'];
    $codcom = $_POST['codcom'];
    $standar_length = 160;
    $texto=$_POST['texto'];
    $creatorId=$_POST['nombre_usuario'];
    $senddateoption=$_POST['senddateoption'];
    
    if (($codest=="todos")){
        require("../conexion_sms/aut_config.inc.php");
        $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
        $query="SELECT telefono_movil FROM solicitantes WHERE telefono_movil<>'' order by solicitantes.cedula_rif";
        $datos_consulta=pg_query($query) or die('La consulta fall&oacute;: ' . pg_last_error());
        
        while($resultados = pg_fetch_array($datos_consulta))
        {
            $destino = $resultados[telefono_movil];

            //aqui es donde inicia el envio por grupo
            $array_cell=explode(',', $destino);
            foreach ($array_cell as $dest)
            {
                str_replace('.','',$dest);
                if ( strlen($dest)==11 and ((stristr($dest, '0414') or stristr($dest, '0424') or stristr($dest, '0426') or stristr($dest, '0416') or stristr($dest, '0412') )))
                {
                    $datoom=date('Y').date('m').date('d').date('H').date('i').date('s');
                    $send = pg_query("SELECT insert_outbox('$dest','$texto','$creatorId')") or die('La consulta fall&oacute;: ' . pg_last_error());   
                    $result_insert=pg_fetch_array($send);   
                    pg_free_result($send);
                    $resultado_insert=$result_insert[0];
                    $error="bien";
                }
            }
            unset ($GLOBALS);
            //unset ($_POST['cant']);
            //unset($_POST['cant']);
            $sms="";
            $cel="";
            $dest="";
        }

    }elseif (($codest<>"todos") AND ($codmun=="todos")){
        $query="SELECT telefono_movil FROM solicitantes, comunidades, parroquias, municipios, estados WHERE telefono_movil<>'' and estados.codest=municipios.codest and parroquias.codest=municipios.codest and parroquias.codmun=municipios.codmun and comunidades.codest=parroquias.codest and comunidades.codmun=parroquias.codmun and comunidades.codpar=parroquias.codpar and comunidades.idcom = solicitantes.idcom and estados.codest='$codest' order by solicitantes.cedula_rif";
        $consulta=pg_query($query) or die('La consulta fall&oacute;: ' . pg_last_error());
        $total_registros= pg_num_rows($consulta);

    }elseif (($codest<>"todos") AND ($codmun<>"todos")){
        $query="SELECT telefono_movil FROM solicitantes, comunidades, parroquias, municipios, estados WHERE telefono_movil<>'' and estados.codest=municipios.codest and parroquias.codest=municipios.codest and parroquias.codmun=municipios.codmun and comunidades.codest=parroquias.codest and comunidades.codmun=parroquias.codmun and comunidades.codpar=parroquias.codpar and comunidades.idcom = solicitantes.idcom and municipios.codmun='$codmun' order by solicitantes.cedula_rif";
        $consulta=pg_query($query) or die('La consulta fall&oacute;: ' . pg_last_error());
        $total_registros= pg_num_rows($consulta);

    }elseif(($codest<>"todos") AND ($codmun<>"todos") AND ($codpar=="todos")){
         $query="SELECT telefono_movil FROM solicitantes, comunidades, parroquias, municipios, estados WHERE telefono_movil<>'' and estados.codest=municipios.codest and parroquias.codest=municipios.codest and parroquias.codmun=municipios.codmun and comunidades.codest=parroquias.codest and comunidades.codmun=parroquias.codmun and comunidades.codpar=parroquias.codpar and comunidades.idcom = solicitantes.idcom and estados.codest='$codest' and municipios.codmun='$codmun' order by solicitantes.cedula_rif";
        $consulta=pg_query($query) or die('La consulta fall&oacute;: ' . pg_last_error());
        $total_registros= pg_num_rows($consulta);
    }
}//fin del add        
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
                <h4 class="text-primary"><strong> ENVIO DE SMS MASIVO </strong></h4>
            </div>

<?php if ((isset($_POST[save])) and ($error=="bien")) {	?> 

            <div class="form-group" align="center"> 
                <h3 class="info">   
                    <font size="2">                     
                        <h1>Datos registrados con &eacute;xito</h1>
                        <br />
                        <script type="text/javascript">
                            function redireccionar(){
                                window.location="?view=sms_grupo";
                            }  
                            setTimeout ("redireccionar()", 3000); //tiempo de espera en milisegundos
                        </script>                       
                        [<a href="?view=sms_grupo" name="Continuar"> Continuar </a>]
                    </font>                         
                </h3>
            </div>

<?php }else{ ?>

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="<?php echo $pagina?>" id="QForm" name="QForm" enctype="multipart/form-data">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>ESTADO</label>
                                <select id="codest" name="codest" class="form-control" onchange="cargarContenidoMunicipio();" onclick="cargarContenidoMunicipio();"  >
                                    <option value="">----</option>
                                    <option value="todos">TODOS</option>
                                    <?php 
                                        $consulta_sql=pg_query("SELECT * FROM estados order by codest") or die('La consulta fall&oacute;: ' . pg_last_error());
                                        while ($array_consulta=  pg_fetch_array($consulta_sql)){
                                            if ($array_consulta[1]==$cod_estado){
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
                                <select name="codmun" id="codmun" class="form-control" onChange="cargarContenidoParroquia();">
                                    <option value="">----</option>
                                    <option value="todos">TODOS</option>
                                    <?php                                       
                                        $consultax1="SELECT * from municipios where codest='$cod_estado' order by codmun";
                                        $ejec_consultax1=pg_query($consultax1);
                                        while($vector=pg_fetch_array($ejec_consultax1)){
                                            if ($vector[2]==$cod_municipio){
                                                echo '<option value="'.$vector[2].'" selected="selected">'.$vector[3].'</option>';
                                            }else {
                                                echo '<option value="'.$vector[2].'">'.$vector[3].'</option>';
                                            }
                                        }
                                        pg_free_result($ejec_consultax1);
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>PARROQUIA</label>
                                <select name="codpar" id="codpar" class="form-control" onchange="cargarContenidoComunidad();" >
                                    <option value="">----</option>
                                    <option value="todos">TODOS</option>
                                    <?php 
                                        $consultax1="SELECT * from parroquias where codest='$cod_estado' and codmun='$cod_municipio' order by codpar";
                                        $ejec_consultax1=pg_query($consultax1);
                                        while($vector=pg_fetch_array($ejec_consultax1)){
                                            echo '<option value="'.$vector[3].'">'.$vector[4].'</option>';
                                        }
                                        pg_free_result($ejec_consultax1);                                                                       
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>COMUNIDAD</label>
                                <div id="contenedor4">          
                                    <select name="codcom" id="codcom" class="form-control">
                                        <option value="">----</option>
                                        <option value="todos">TODOS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>MENSAJE</label>
                                <div id="contenedor4">          
                                    <textarea class="form-control" name="texto" id="texto" rows="5" cols="55" maxlength="140"></textarea>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-default btn-primary" name="save" value="  Enviar  " >
                            <input  class="btn btn-default" type="button" onclick="javascript:window.location.href='?view=home'" value="Cerrar" name="cerrar" />
                        </div>

                <tr>
                    <td colspan="2" class="botones" align="center" >			
                          
                    </td>													
                </tr> 
            </table>
        </form>     
            <?php
            }
            ?> 
    </div>
</div>
        
<script type="text/javascript">
    var dtabs=new ddtabcontent("divsG")
    dtabs.setpersist(true)
    dtabs.setselectedClassTarget("link") //"link" or "linkparent"
    dtabs.init()
</script>
