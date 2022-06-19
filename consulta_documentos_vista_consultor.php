<?php
	session_start();

	if (!isset($_SESSION["consultor"])) {
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
	<body>
		<?php
			require_once("includes/encabezado_consultor.php");
			require_once("includes/otras_funciones.php");
			require_once("includes/crud.php");
			$crud = new Crud();
		?>
		<?php
			if ($_GET["id"] != "") {
				$idInmueble = $_GET["id"];
				$nombreOfertaDonacion = $crud->ObtenerNombreOfertaDonacionPorId($idInmueble);
				$nombreOferta = mysqli_fetch_assoc($nombreOfertaDonacion);
			}
		?>

		<div class="container margen-superior-consulta-documentos">
			<?php 
				if (mysqli_num_rows($nombreOfertaDonacion) == 1) {
					echo "
						<p class='lead text-center titulos'>DOCUMENTOS ASOCIADOS AL INMUEBLE: <span class='text-warning text-uppercase'>".$nombreOferta['nombreOfertaDonacion']."</span></p>
					";
				}else{
					$nombreInmueble = $crud->ObtenerNombreInmueblePorId($idInmueble);
					$inmueble = mysqli_fetch_assoc($nombreInmueble);
					echo "
						<p class='lead text-center titulos'>NO SE ENCONTRARON DOCUMENTOS ASOCIADOS AL INMUEBLE: <span class='text-warning text-uppercase'>".$inmueble['nombreInmueble']."</span></p>
					";
				}
			?>
			<hr>
			<div class="row justify-content-center mb-4">
					<a href="inmuebles_vista_consultor.php" class='textoGrisClaro text-uppercase'>&laquo; Volver a inmuebles &raquo;</a>
			</div>
			<?php
				if ($_GET["id"] != "") {
					$idInmueble = $_GET["id"];
					$registrosDocumentos = $crud->ObtenerDocumentos($idInmueble);
					$documentos = mysqli_fetch_assoc($registrosDocumentos);

					// Oteniendo los Comodatos asociados:
					$registrosComodatos = $crud->ObtenerComodatosPorId($documentos['idDocumento']);
				}
			?>
		</div>

		<div class="container-fluid mt-2 text-center mb-5">
			<div class="row">
				<!-- ==================== CARD OFERTA DE DONACIÓN =========================== -->
				<?php
					foreach ($registrosDocumentos as $donacion) {
						// Extrayendo el nombre del archivo de imagen:
						$nombreDonacion = multiexplode(array("/","."),$donacion['imgOferta']);
						echo "
							<div class='col-lg-3'>
								<div class='card'>
									<img src='".$donacion['imgOferta']."' class='img-fluid card-img-top'>
									<div class='card-block py-3 px-3'>
										<h5 class='card-title tituloParrafosCards'>OFERTA DE DONACI&Oacute;N</h5>
										<p class='card-text text-center nombreDocumentos tituloParrafosCards'>".$nombreDonacion[1]."</p>
									</div>
									<div class='card-footer'>
										<a href='donacion_pdf.php?imgDonacion=".$donacion['imgOferta']."' class='btn btn-secondary btn-block' target='_blank'>Ver o Descargar</a>
									</div>
								</div>
							</div>
						";
					}
				?>
				<!-- ==================== CARD ACUERDO =========================== -->
				<?php
					foreach ($registrosDocumentos as $acuerdo) {
						// Extrayendo el nombre del archivo de imagen:
						$nombreAcuerdo = multiexplode(array("/","."),$acuerdo['imgAcuerdo']);
						echo "
							<div class='col-lg-3'>
								<div class='card'>
									<img src='".$acuerdo['imgAcuerdo']."' class='img-fluid card-img-top'>
									<div class='card-block py-3 px-3'>
										<h5 class='card-title tituloParrafosCards'>ACUERDO</h5>
										<p class='card-text text-center nombreDocumentos tituloParrafosCards'>".$nombreAcuerdo[1]."</p>
									</div>
									<div class='card-footer'>
										<a href='acuerdo_pdf.php?imgAcuerdo=".$acuerdo['imgAcuerdo']."' class='btn btn-secondary btn-block' target='_blank'>Ver o Descargar</a>
									</div>
								</div>
							</div>
						";
					}
				?>
				<!-- ==================== CARD ESCRITURA =========================== -->
				<?php
					foreach ($registrosDocumentos as $escritura) {
						// Extrayendo el nombre del archivo de imagen:
						$nombreEscritura = multiexplode(array("/","."),$escritura['imgEscritura']);
						echo "
							<div class='col-lg-3'>
								<div class='card'>
									<img src='".$escritura['imgEscritura']."' class='img-fluid card-img-top'>
									<div class='card-block py-3 px-3'>
										<h5 class='card-title tituloParrafosCards'>ESCRITURA</h5>
										<p class='card-text text-center nombreDocumentos tituloParrafosCards'>".$nombreEscritura[1]."</p>
									</div>
									<div class='card-footer'>
										<a href='escritura_pdf.php?imgEscritura=".$escritura['imgEscritura']."' class='btn btn-secondary btn-block' target='_blank'>Ver o Descargar</a>
									</div>
								</div>
							</div>
						";
					}

				?>
				<!-- ==================== CARD COMODATOS =========================== -->
				<?php

					if (mysqli_num_rows($registrosDocumentos) >= 1) {
						
						$contadorComodatos = 0;
						foreach ($registrosComodatos as $comodato) {
							$contadorComodatos++;
							if ($contadorComodatos == 1) {
								// Extrayendo el nombre del archivo de imagen:
								$nombreComodato = multiexplode(array("/","."),$comodato['imgComodato']);
								echo "
									<div class='col-lg-3'>
										<div class='card'>
											<img src='".$comodato['imgComodato']."' class='img-fluid card-img-top'>
											<div class='card-block py-3 px-3'>
												<h5 class='card-title tituloParrafosCards'>COMODATO</h5>
												<p class='card-text text-center nombreDocumentos tituloParrafosCards'>".$nombreComodato[1]."</p>
											</div>
											<div class='card-footer'>
												<a href='comodato_pdf.php?imgComodato=".$comodato['imgComodato']."' class='btn btn-secondary btn-block' target='_blank'>Ver o Descargar</a>
											</div>
										</div>
									</div>
								";
							}else{
								// Extrayendo el nombre del archivo de imagen:
								$nombreComodato = multiexplode(array("/","."),$comodato['imgComodato']);
								echo "
									<div class='col-lg-3 mt-3'>
										<div class='card'>
											<img src='".$comodato['imgComodato']."' class='img-fluid card-img-top'>
											<div class='card-block py-3 px-3'>
												<h5 class='card-title tituloParrafosCards'>COMODATO</h5>
												<p class='card-text text-center nombreDocumentos tituloParrafosCards'>".$nombreComodato[1]."</p>
											</div>
											<div class='card-footer'>
												<a href='comodato_pdf.php?imgComodato=".$comodato['imgComodato']."' class='btn btn-secondary btn-block' target='_blank'>Ver o Descargar</a>
											</div>
										</div>
									</div>
								";
							}
							
						}
					}

				?>
			</div>
		</div>
	</body>
</html>

<?php
	}
?>