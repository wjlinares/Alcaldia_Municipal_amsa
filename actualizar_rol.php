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
			$id = $_GET["id"];
			$registros = $crud->ObtenerRolPorId('roles',$id);
			$registro = mysqli_fetch_assoc($registros);
		?>

		<div class="container margen-superior-actualizar-rol">
			<p class="lead text-center textoGrisClaro">ACTUALIZANDO ROL...</p>
			<hr>
			<div class="container mt-5 ">
				<div class="row">
					<div class="col-lg-4 offset-lg-1">
						<img src="imagenes/editar.png" alt="Icono Editar" class="imagenes-formularios">
					</div>

					<div class="col-lg-6 mt-4">
						<form action="" method="POST" autocomplete='off'>
							<div class="form-group row">
								<div class="col-lg-12">
									<label for="rol" class="textoGrisClaro">Ingresar nuevo nombre:</label>
									<?php 
										echo "
											<input type='text' name='rol' id='rol' value='".$registro['rol']."' class='form-control' placeholder='(25 caracteres como m&aacute;ximo)' required autofocus maxlength=25>
										";
									?>
								</div>
							</div>
							<br>
							<div class="modal-footer justify-content-start">
								<button type="submit" class="btn btn-info btn-sm">Guardar Cambios</button>
								<button type='button' class='btn btn-secondary btn-sm' onClick='CancelarEdicionDeRoles();'>Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- ========== ACTUALIZANDO EL ROL ========== -->
			<?php 
				if (isset($_POST["rol"])) {
					$rol = $_POST["rol"];
					if (mysqli_num_rows($registros) > 0) {
						$crud->ActualizarRol('roles',$id,$rol);
						$_SESSION["rolActualizado"] = true;
						echo "
							<script type='text/javascript'>
								location.href='roles.php';
							</script>
						";
					}else{
						echo "
							<p class='lead text-muted text-center'>No se encontraron registros con ID:<b>$id</b></p>
							<hr>
						";
					}
				}
			?>
		</div>

	</body>

	<script type="text/javascript">
		// ======== EN CASO DE CANCELAR EL EDITADO DEL ROL ========
		function CancelarEdicionDeRoles(){
			window.location.href = 'roles.php';
		}
	</script>
</html>

<?php
	}
?>