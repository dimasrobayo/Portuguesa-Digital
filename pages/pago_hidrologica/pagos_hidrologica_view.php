<?php
    // chequear si se llama directo al script.
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="../images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    if ($_SERVER['HTTP_REFERER'] == "") {
        echo "<script type='text/javascript'>window.location.href='index.php?view=login&msg_login=5'</script>";
//        echo "<script type='text/javascript'>window.location.href='index.php'</script>";
        exit;
    }
    
    $redir=$_SERVER['HTTP_REFERER']; // Ruta para redireccionar a la pagina que nos llamo
    $pag=$_SERVER['PHP_SELF'];  // el NOMBRE y ruta de esta misma p�ina.
    $type=$_GET["view"];
    $pagina=$pag.'?view='.$type;

    //Conexion a la base de datos
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div align="center">
                <font color="red" style="text-decoration:blink;">
                    <?php $error_accion_ms[$error_cod]?>
                </font>
            </div>  

            <div class="panel-heading">
                <h4 class="text-primary"><strong> ADMINISTRACION DE PAGOS DE LA HIDROLOGICA </strong> </h4>
            </div>

            <div class="panel-body">
                <div class="row">
                    <form method="POST" action="?view=pago_hidrologica_adm" id="QForm" name="QForm">
                    	<div class="col-lg-12">
                            <div class="form-group" autofocus="true">
                                <label>C&Eacute;DULA/RIF</label>
                                <input id="cedula_rif" autofocus name="cedula_rif" class="form-control" type="text" placeholder="Escriba la primera letra en Mayuscula" />
                            </div>
                            <button type="submit" id="buscar" name="buscar" class="btn btn-primary">Buscar Cliente</button>
                            <a href="index2.php?view=cargar_xml" class="btn btn-success">
                              Cargar Deudas
                            </a>
                            <a href="reportes/balances_pagos_hidro.php" type="submit" id="reporte_hidro" name="reporte_hidro" class="btn btn-warning">Balance Pagos</a>
                            <a onclick="return confirm('Esta seguro que desea eliminar el registro?');" href="index2.php?view=pago_drop_all" type="submit" id="borrar" name="borrar" class="btn btn-danger">Borrar Deudas</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/js/jquery.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.js"></script>

<script type="text/javascript" >
    jQuery(function($) {
          $.mask.definitions['~']='[JEVGDCH]';
          //$('#fecha_nac').mask('99/99/9999');
          //$('#fecha_deposito').mask('99/99/9999');
          $('#telefono').mask('(9999)-9999999');
          $('#celular').mask('(9999)-9999999');
          $('#telefono_trabajo').mask('(9999)-9999999');
          $('#telefono_fax').mask('(9999)-9999999');
          $('#rif').mask('~-9999?9999-9',{placeholder:" "});
          $('#cedula_rif').mask('~-9999?99999',{placeholder:" "});
          //$('#phoneext').mask("(999) 999-9999? x99999");
          //$("#tin").mask("99-9999999");
          //$("#ssn").mask("999-99-9999");
          //$("#product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("Ha escrito lo siguiente: "+this.val());}});
          //$("#eyescript").mask("~9.99 ~9.99 999");
          
       });  
</script>