<?php
	session_start();

	if (!isset($_SESSION["consultor"])){
		echo "
			<script type='text/javascript'>
				location.href='index.php';
			</script>
		";		
	}else{
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
	<body class="body-consultor">
		<?php 
			require_once("includes/encabezado_consultor.php");
		?>
		<!-- ==================================================== CARRUSEL ==================================================== -->
		<div class="container margen-superior-consultor">
			<div id="carouselExampleSlidesOnly" class="carousel slide img-slide-dimensiones" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-100 img-slide-dimensiones" src="imagenes/pic_1.jpg" alt="First slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-slide-dimensiones" src="imagenes/pic_2.jpg" alt="Second slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-slide-dimensiones" src="imagenes/pic_3.jpg" alt="Third slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-slide-dimensiones" src="imagenes/pic_4.jpg" alt="Fourth slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-slide-dimensiones" src="imagenes/pic_5.jpg" alt="Fourth slide">
					</div>
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