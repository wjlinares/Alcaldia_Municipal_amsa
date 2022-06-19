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

		<div class="container margen-superior-actualizar-oferta">
			<p class="lead text-center textoGrisClaro">ACTUALIZANDO DOCUMENTO DE <mark class="titulos">ACUERDO MUNICIPAL...</mark></p>
			<hr>
			<form action="" method="POST" enctype="multipart/form-data" class="mt-4">
				<div class="row">
					<div class="col-lg-5 alineacionDeImagenes">
						<img src="imagenes/actualizar.png" alt="Icono Comodato" width=235 height=230>
					</div>
					<div class="col-lg-7 mt-3">
						<div class="row">
							<div class="col-lg-8">
								<label for="donacionAsociada" class="textoGrisClaro">Actualizar a esta Oferta de Donaci&oacute;n:</label>
								<select name="donacionAsociada" id="donacionAsociada" class="form-control form-control-sm" required>
									<option value="">Seleccionar Donaci&oacute;n</option>
									<!-- Estos options se generarán de manera automática -->
									<?php
										$registros = $crud->ObtenerListadoNombresOfertaDonacion();
										foreach ($registros as $registro) {
											echo "
												<option value='".$registro['idDocumento']."'>".$registro['nombreOfertaDonacion']."</option>
											";
										}
									?>
								</select>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-lg-8">
								<label for="imgAcuerdo" class="textoGrisClaro">Seleccionar Acuerdo:</label>
								<input type="file" class="form-control form-control-sm padding-inputFile" name="imgAcuerdo" id="imgAcuerdo" onchange="ValidarAcuerdo()" required>
								<br>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary btn-sm">Agregar</button>
									<button type="button" class="btn btn-secondary btn-sm btnCancelar" data-dismiss='modal' onclick="VolverAInmuebles()">Cancelar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
			</form>
		</div>
		
		<script type="text/javascript" src='js/main.js'></script>
		<script type="text/javascript">
			function VolverAInmuebles(){
				window.location.href = "inmuebles_donaciones.php";
			}
		</script>

	</body>

	<?php

		if (isset($_POST["donacionAsociada"])) {
			$idDocumento = $_POST["donacionAsociada"];

			// Procesando la imagen del Acuerdo:
		if (is_uploaded_file($_FILES["imgAcuerdo"]["tmp_name"])) {
			$imgAcuerdo = $_FILES["imgAcuerdo"];
			
			$archivoTemporalAcuerdo = $imgAcuerdo["tmp_name"];
			$nombreRealAcuerdo = $imgAcuerdo["name"];

			$ubicacionMasNombreAcuerdo = "documentos/$nombreRealAcuerdo";

            $acuerdoExistente = false;
			if (file_exists($ubicacionMasNombreAcuerdo)) {
                unlink($ubicacionMasNombreAcuerdo);
                $acuerdoExistente = true;
            }
            
            if (!$acuerdoExistente) {
                $acuerdoAEliminar = $crud->ObtenerimgAcuerdoPorIdDocumento($idDocumento);
                $acuerdo = mysqli_fetch_assoc($acuerdoAEliminar);
                unlink($acuerdo["imgAcuerdo"]);
            }

			if (move_uploaded_file($archivoTemporalAcuerdo, $ubicacionMasNombreAcuerdo)) {
				$crud->ActualizarAcuerdo($ubicacionMasNombreAcuerdo,$idDocumento);
				$_SESSION["acuerdoActualizado"] = true;
				echo "
					<script type='text/javascript'>
						location.href='inmuebles_donaciones.php';
					</script>
				";
			}
		}

		}
	?>

</html>

<?php
	}
?>