<?php
	
    //Conexion a la base de datos
    require("conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");

	$consulta = "SELECT * FROM usuarios,unidades,niveles_acceso WHERE usuarios.nivel_acceso=niveles_acceso.codigo_nivel and  usuarios.cod_unidad=unidades.cod_unidad order by usuarios.cedula_usuario";
	$registro = pg_query("SELECT * FROM usuarios,unidades,niveles_acceso WHERE usuarios.nivel_acceso=niveles_acceso.codigo_nivel and  usuarios.cod_unidad=unidades.cod_unidad order by usuarios.cedula_usuario" ) or die(pg_last_error());
	
	$tabla = "";
	
	while($row = pg_fetch_array($registro)){		

		$editar = '<a href=\"edicionUsuario.php?a='.$row['Login'].'&b='.$row['Password'].'&c='.$row['Nombre'].'&d='.$row['TipoLogin'].'&e='.$row['status'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a>';
		$eliminar = '<a href=\"actionDelete.php?id='.$row['Login'].'\" onclick=\"return confirm(\'¿Seguro que desea eliminiar este usuario?\')\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Eliminar\" class=\"btn btn-danger\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>';
		
		$tabla.='{
				  "cedula_usuario":"'.$row['cedula_usuario'].'",
				  "login":"'.$row['usuario'].'",
				  "nombre_usuario":"'.$row['nombre_usuario'].'",
				  "nombre_nivel":"'.$row['nombre_nivel'].'",
				  "nombre_unidad":"'.$row['nombre_unidad'].'",
				  "fecha_ultimoacceso":"'.$row['fecha_ultimoacceso'].'",
				  "acciones":"'.$editar.$eliminar.'"
				},';		
	}	

	//eliminamos la coma que sobra
	$tabla = substr($tabla,0, strlen($tabla) - 1);

	echo '{"data":['.$tabla.']}';	

?>