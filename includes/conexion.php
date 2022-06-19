<?php
	// Datos de inicio y credenciales:
	// ============================================================================================
	$servidor = "localhost"; // Servidor
	$usuario = "root"; // Usuario de acceso a la base de datos.
	$clave = ""; // Password de conexión al servidor.
	$db = "db_amsa_alcaldia"; // Base de datos en la que se realizarán las peticiones SQL

	// Realizando la conexión:
	$conexion = mysqli_connect($servidor,$usuario,$clave,$db);

	// Verificando la conexión:
	if (!$conexion) {
		echo "<b>Error de conexión en el servidor.</b>";
		echo "<hr>";
		echo mysqli_connect_error();
		mysqli_connect_close($conexion);
	}

?>

