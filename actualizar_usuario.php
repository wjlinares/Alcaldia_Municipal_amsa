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
			require_once("includes/seguridad.php");
			require_once("includes/crud.php");
			$crud = new Crud();
		?>
		<!-- ========== PETICIÓN PARA TOMAR LOS DATOS DE LA DB EN BASE AL ID PROPORCIONADO POR GET ========== -->
		<?php 
			$id = $_GET["id"];
			$usuarios = $crud->ObtenerUsuarioPorId("usuarios",$id);
			$usuario = mysqli_fetch_assoc($usuarios);
		?>

		<div class="container margen-superior-actualizar-usuario">
			<p class="lead text-center textoGrisClaro">ACTUALIZANDO USUARIO...</p>
			<hr>
			<div class="container mt-4">
				<div class="row">
					<div class="col-lg-4 offset-lg-1 mt-5">
						<img src="imagenes/editar.png" alt="Icono Editar" class="imagenes-formularios">
					</div>

					<div class="col-lg-5">
						<form action="" method="POST" autocomplete='off'>
							<div class="form-group row">
								<div class="col-lg-12">
									<label for="nombre" class="textoGrisClaro">Nombre:</label>
									<?php 
										echo "
											<input type='text' name='nombre' id='nombre' value='".$usuario["nombre"]."' required autofocus placeholder='(50 caracteres como m&aacute;ximo)' class='form-control form-control-sm' autofocus>
										";
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<label for="usuario" class="textoGrisClaro">Usuario:</label>
									<?php 
										echo "
											<input type='text' name='usuario' id='usuario' value='".$usuario["usuario"]."' required autofocus placeholder='Ingresar usuario.' class='form-control form-control-sm' readonly>
										";
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<label for="clave" class="textoGrisClaro">Contraseña:</label>
									<input type="password" name="clave" id="clave" placeholder="Ingresar contraseña (sólo si se desea actualizar)" class="form-control form-control-sm">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<label for="rol" class="textoGrisClaro">Establecer un rol:</label>
									<select name="rol" id="rol" class="form-control form-control-sm">
										<!-- === La siguiente lógica es necesaria para poder saber a que rol pertenece el usuario seleccionado por ID === -->
										<?php 
											$listaRoles = $crud->ObtenerTodos("roles");
											$roles = mysqli_fetch_assoc($listaRoles);
											if (mysqli_num_rows($listaRoles) > 0) {
												$listaUsuarios = $crud->ObtenerUsuarioPorId("usuarios",$id);
												$usuarios = mysqli_fetch_assoc($listaUsuarios);
												
												if ($id == 1) {
													$rolObtenido = $crud->ObtenerRolPorId("roles",$id);
													$rolPrincipal = mysqli_fetch_assoc($rolObtenido);
													echo "
														<option value='".$rolPrincipal["idRol"]."' selected>".$rolPrincipal["rol"]."</option>
													";
												}else{
													foreach ($listaRoles as $rol) {
														if ($usuarios["idRol"] == $rol["idRol"]) {
															echo "
																<option value='".$rol["idRol"]."' selected>".$rol["rol"]."</option>
															";
														}else{
															echo "
																<option value='".$rol["idRol"]."'>".$rol["rol"]."</option>
															";
														}
													}
												}

											}
										?>
									</select>
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
		// ======== EN CASO DE CANCELAR EL EDITADO DEL USUARIO ========
		function CancelarActualizacion(){
			window.location.href = 'usuarios.php';
		}
	</script>

	<?php 
		if (isset($_POST["usuario"])) {
			$nombre = $_POST["nombre"];
			$clave = $_POST["clave"];
			$rol = $_POST["rol"];

			if ($clave != "") {
				$claveEncriptada = Encriptar($clave);
				$crud->ActualizarUsuarioConClave($id,$nombre,$claveEncriptada,$rol);
				$_SESSION["usuarioActualizado"] = true;
				echo "
					<script type='text/javascript'>
						window.location.href = 'usuarios.php';
					</script>
				";
			}else{
				$crud->ActualizarUsuarioSinClave($id,$nombre,$rol);
				$_SESSION["usuarioActualizado"] = true;
				echo "
					<script type='text/javascript'>
						window.location.href = 'usuarios.php';
					</script>
				";
			}
		}
	?>
</html>

<?php
	}
?>