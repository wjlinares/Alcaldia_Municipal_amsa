<?php
	session_start();

	if (!isset($_SESSION["administrador"])) {
		echo "
			<script type='text/javascript'>
				location.href='index.php';
			</script>
		";		
	}else{
?>

<?php
	require_once("includes/crud.php");
	$crud = new Crud();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>AMSA</title>
		<link rel="icon" href="imagenes/iconoAmsa.ico">
		<link rel="stylesheet" href="estilos/bootstrap.min.css">
		<link rel="stylesheet" href="estilos/estilos.css">
		<link rel="stylesheet" href="estilos/sweetalert2.min.css">
		<script type='text/javascript' src='js/sweetalert2.min.js'></script>
		<meta name='viewport' content="width='device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1'">
	</head>
	<body>
		<?php
			require_once("includes/encabezado_administrador.php");
			require_once("includes/seguridad.php");
			require_once("includes/crud.php");
			$crud = new Crud();
		?>

		<div class="container margen-superior-asignar-documentos">
			<p class="lead text-center textoGrisClaro">ASOCIANDO DOCUMENTOS...</p>
			<hr>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-4 alineacionDeImagenes">
						<img src="imagenes/escritura.png" alt="Icono Escrituras" width=250 height=250>
					</div>
					<div class="col-lg-8">
						<div class="row">
							<div class="col-lg-5 mt-3">
								<div class="row">
									<div class="col-lg-12">
										<label for="inmueble" class="textoGrisClaro">Asociar a este Inmueble:</label>
										<select name="inmueble" id="inmueble" onchange="agregarInmuebleAImput()" class="form-control form-control-sm" required>
											<option value="" selected>Seleccionar Inmueble...</option>
											<!-- Estos options se generarán de manera automática -->
											<?php
												$registros = $crud->ObtenerSoloInmuebles("inmuebles");
												foreach ($registros as $registro) {
													echo "
														<option value='".$registro['idInmueble']."'>".$registro['nombreInmueble']."</option>
													";
												}
											?>
										</select>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-lg-12">
										<label for="nombreOfertaDonacion" class="textoGrisClaro">Nombre de la Oferta de Donaci&oacute;n:</label>
										<input type="text" class="form-control form-control-sm padding-inputFile" name="nombreOfertaDonacion" id="nombreOfertaDonacion" readonly>
									</div>
								</div>

							</div>

							<div class="col-lg-7 mt-3">
								<div class="row">
									<div class="col-lg-12">
										<label for="imgOferta" class="textoGrisClaro">Seleccionar Oferta de Donaci&oacute;n:</label>
										<input type="file" class="form-control form-control-sm padding-inputFile" name="imgOferta" id="imgOferta" onchange="ValidarOfertaDonacion()" required>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-lg-12">
										<label for="imgAcuerdo" class="textoGrisClaro">Seleccionar Acuerdo:</label>
										<input type="file" class="form-control form-control-sm padding-inputFile" name="imgAcuerdo" id="imgAcuerdo" onchange="ValidarAcuerdo()" required>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-lg-12">
										<label for="imgEscritura" class="textoGrisClaro">Seleccionar Escritura:</label>
										<input type="file" class="form-control form-control-sm padding-inputFile" name="imgEscritura" id="imgEscritura" onchange="ValidarEscritura()" required>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<br>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm">Agregar</button>
					<button type="button" class="btn btn-secondary btn-sm btnCancelar" data-dismiss='modal' onclick="VolverAInmuebles()">Cancelar</button>
				</div>
			</form>
		</div>

		<script type="text/javascript" src='js/main.js'></script>
		<!-- Función por si se cancela el agregado del Acuerdo y la Escritura -->
		<script type="text/javascript">
			function VolverAInmuebles(){
				window.location.href = "inmuebles_donaciones.php";
			}
		</script>
	</body>
	<?php

		if (isset($_POST["inmueble"])) {

			$idInmueble = $_POST["inmueble"];
			$nombreOfertaDonacion = $_POST["nombreOfertaDonacion"];

			// Verificando si ya existen documentos asociados a éste inmueble
			$documentoExistente = $crud->ObtenerNombreOfertaDonacion($nombreOfertaDonacion);

			if (mysqli_num_rows($documentoExistente) >= 1) {
				echo '
					<script type="text/javascript">
						swal("¡ADVERTENCIA!", "Este inmueble ya posee documentación asociada.", "warning");
					</script>
				';
			}else{

				$imgOferta = $_FILES["imgOferta"];
				$imgAcuerdo = $_FILES["imgAcuerdo"];
				$imgEscritura = $_FILES["imgEscritura"];

				// Procesando la imagen de la donacion:
				if ((is_uploaded_file($_FILES["imgOferta"]["tmp_name"])) && (is_uploaded_file($_FILES["imgAcuerdo"]["tmp_name"])) && (is_uploaded_file($_FILES["imgEscritura"]["tmp_name"]))) {

					$imgOferta = $_FILES["imgOferta"];
					$imgAcuerdo = $_FILES["imgAcuerdo"];
					$imgEscritura = $_FILES["imgEscritura"];

					$archivoTemporalOferta = $imgOferta["tmp_name"];
					$nombreRealOferta = $imgOferta["name"];

					$archivoTemporalAcuerdo = $imgAcuerdo["tmp_name"];
					$nombreRealAcuerdo = $imgAcuerdo["name"];

					$archivoTemporalEscritura = $imgEscritura["tmp_name"];
					$nombreRealEscritura = $imgEscritura["name"];

					$ubicacionMasNombreOferta = "documentos/$nombreRealOferta";
					$ubicacionMasNombreAcuerdo = "documentos/$nombreRealAcuerdo";
					$ubicacionMasNombreEscritura = "documentos/$nombreRealEscritura";

					if (file_exists($ubicacionMasNombreOferta)) {
						$idUnicoOferta = time();
						$ubicacionMasNombreOferta = "documentos/$idUnicoOferta-$nombreRealOferta";
					}
					if (file_exists($ubicacionMasNombreAcuerdo)) {
						$idUnicoAcuerdo = time();
						$ubicacionMasNombreAcuerdo = "documentos/$idUnicoAcuerdo-$nombreRealAcuerdo";
					}
					if (file_exists($ubicacionMasNombreEscritura)) {
						$idUnicoEscritura = time();
						$ubicacionMasNombreEscritura = "documentos/$idUnicoEscritura-$nombreRealEscritura";
					}

					if ((move_uploaded_file($archivoTemporalOferta, $ubicacionMasNombreOferta)) && (move_uploaded_file($archivoTemporalAcuerdo, $ubicacionMasNombreAcuerdo)) && (move_uploaded_file($archivoTemporalEscritura, $ubicacionMasNombreEscritura))) {
						$crud->InsertarDocumentos("documentos",$nombreOfertaDonacion,$ubicacionMasNombreOferta,$ubicacionMasNombreAcuerdo,$ubicacionMasNombreEscritura,$idInmueble);
						$_SESSION["documentacionAsignada"] = true;
						echo "
							<script type='text/javascript'>
								location.href='inmuebles_donaciones.php?confirm=true';
							</script>
						";
					}
				}

			}

		}
	?>

</html>

<?php
	}
?>