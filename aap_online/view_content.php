<?php
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    
    switch ($view){
        // SECCION ENTRADA
        CASE "inicio": 
            include("solicitudes/solicitud_online.php");
            break;

	///////////// SOLICITUDES /////////////////		
        case "solicitud_online": 
            include("solicitudes/solicitud_online.php");
            break;
	case "solicitud_online_add": 
            include("solicitudes/solicitud_online_add.php");
            break;
	case "consultar_solicitud": 
            include("solicitudes/solicitud_online_view.php");
            break;

        // POR DEFECTO CUANDO VIEW NO POSEE VALOR SE LLAMA AL FORMULARIO DE AUNTENTICACION
        default: 
            include("solicitudes/solicitud_online.php");
//            include("panel.php");
	
        
    }
?>
