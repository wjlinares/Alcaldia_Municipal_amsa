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
			require_once("includes/crud.php");
			$crud = new Crud();
		?>
		<!-- ========== PETICIÓN PARA TOMAR LOS DATOS DE LA DB EN BASE AL ID PROPORCIONADO POR GET ========== -->
		<?php 
			$idInmueble = $_GET["id"];
			$inmuebles = $crud->ObtenerInmueblePorId($idInmueble);
			$inmueble = mysqli_fetch_assoc($inmuebles);
		?>

		<div class="container margen-superior-actualizar-inmueble">
			<p class="lead text-center textoGrisClaro">ACTUALIZANDO INMUEBLE...</p>
			<hr>
			<div class="container mt-5 ">
				<div class="row">
					<div class="col-lg-4 offset-lg-1">
						<img src="imagenes/editar.png" alt="Icono Editar" class="imagenes-formularios">
					</div>

					<div class="col-lg-6">
						<form action="" method="POST" autocomplete='off'>
							<?php 
								echo "
									<p class='lead textoGrisClaro'>FOLIO: <mark class='folio'>".strtoupper($inmueble["folio"])."</mark></p>
								";
							?>
							<div class="form-group row mt-4">
								<div class="col-lg-12">
									<label for="nombreInmueble" class="textoGrisClaro">Ingresar Nuevo Nombre del Inmueble:</label>
									<?php 
										echo "
											<input type='text' name='nombreInmueble' id='nombreInmueble' value='".$inmueble["nombreInmueble"]."' autofocus placeholder='(75 caracteres como m&aacute;ximo)' class='form-control form-control-sm' maxlength=75 required>
										";
									?>
								</div>
							</div>
							<div class="form-group row mt-4">
								<div class="col-lg-12">
									<label for="ubicacion" class="textoGrisClaro">Ingresar Nueva Ubicaci&oacute;n:</label>
									<?php
										echo "
											<textarea name='ubicacion' id='ubicacion' cols='30' rows='3' placeholder='(125 caracteres como m&aacute;ximo)' class='form-control form-control-sm' maxlength=125 required>".$inmueble["ubicacion"]."</textarea>
										";
									?>
									
								</div>
							</div>
							
							<div class="modal-footer">
								<button type="submit" class="btn btn-info btn-sm">Guardar Cambios</button>
								<button type='button' class='btn btn-secondary btn-sm' onclick='CancelarActualizacion()'>Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</body>

	<script type="text/javascript">
		// ======== EN CASO DE CANCELAR EL EDITADO DEL INMUEBLE ========
		function CancelarActualizacion(){
			window.location.href = 'inmuebles_donaciones.php';
		}
	</script>

	<?php 
		if (isset($_POST["nombreInmueble"])) {
			$nombreInmueble = $_POST["nombreInmueble"];
			$ubicacion = $_POST["ubicacion"];
			$crud->ActualizarInmueble($nombreInmueble,$ubicacion,$idInmueble);
			$crud->ActualizarNombreOfertaDonacion($nombreInmueble,$idInmueble);
			$_SESSION["actualizacionInmueble"] = true;
			echo "
				<script type='text/javascript'>
					window.location.href = 'inmuebles_donaciones.php';
				</script>
			";
		}
	?>
</html>

<?php
	}
?>