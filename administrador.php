<?php
	session_start();

	if (!isset($_SESSION["administrador"])) 
	{
		echo "
			<script type='text/javascript'>
				location.href='index.php';
			</script>
		";		
	}
	else
	{
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>AMSA</title>
		<link rel="icon" href="imagenes/iconoAmsa.ico">
		<link rel="stylesheet" href="estilos/bootstrap.min.css">
		<link rel="stylesheet" href="estilos/estilos.css">
		<meta name='viewport' content="width='device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1'">
	</head>
	<body>
		<?php 
			require_once("includes/encabezado_administrador.php");
		?>

		<div class="container contenedorAdministrador margen-superior-administrador">
			<div class="row">
				<div class="col-lg-6 col-img-administrador">
					<img src="imagenes/imgAdmin.png" alt="Imagen" class="imgAdmin">
				</div>
				<div class="col-lg-6 col-texto-administrador">
					<p class="text-center display-4 textoGrisClaro" style='border-bottom:1px dotted lightgray;'>BIENVENIDO</p>
				</div>
			</div>
		</div>

		<?php 
			require_once("includes/pie_pagina.php");
		?>
	</body>
</html>

<?php
	}
?>