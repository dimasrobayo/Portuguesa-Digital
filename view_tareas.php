<?php 
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
    switch ($_SESSION['nivel']){	
        case 0: //panel de analista de super root
            include("pages/tareas/tareas_super_root.php");
            break;

        case 1: //panel de analista de Administrador Genral
            include("pages/tareas/tareas_super_root.php");
            break;

        case 2: //panel de analista de administrador de unidad
            include("pages/tareas/tareas_super_root.php");
            break;

        case 3: //panel de analista de usuaruio general de unidad
            include("pages/tareas/tareas_super_root.php");
            break;

        case 4: //panel de analista de administrador de atencion
            include("pages/tareas/tareas_super_root.php");
            break;

        case 5: //panel de analista de atencion
            include("pages/tareas/tareas_super_root.php");
            break;

        case 6: //panel de analista de ciudadano
            include("pages/tareas/tareas_ciudadano.php");
            break;
    }	
?>