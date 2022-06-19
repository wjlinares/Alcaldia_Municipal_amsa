<?php
	session_start();

	if (isset($_REQUEST["CERRAR"])){
		unset($_SESSION["administrador"]);
		unset($_SESSION["consultor"]);
		session_destroy();
		echo "
			<script type='text/javascript'>
				location.href='index.php';
			</script>
		";
	}

	if (isset($_SESSION["administrador"])){
		echo "
			<script type='text/javascript'>
				location.href='administrador.php';
			</script>
		";
	}elseif (isset($_SESSION["consultor"])){
		echo "
			<script type='text/javascript'>
				location.href='consultor.php';
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
			require_once("includes/seguridad.php");
			require_once("includes/crud.php");
			$crud = new Crud();
		?>

		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-8 pl-0">
					<img src="imagenes/fondo_login.jpg" alt="Imagen fondo" class="imgLogin">
				</div>
				<div class="col-lg-4 formLogin">
					<div class="formOrientacion">
						<img src="imagenes/imgAlcaldia.png" alt="Logo AMSA" width="250" height="80">
						<hr>
						<form action="" method="POST" autocomplete="off">
							<div class="form-group row">
								<label for="usuario">Usuario:</label>
								<input type="text" name="usuario" id="usuario" autofocus placeholder="Ingrese su usuario." required class="form-control">
							</div>
							<div class="form-group row mt-3">
								<label for="contrasena">Contraseña:</label>
								<input type="password" name="clave" id="contrasena" placeholder="Ingrese su contraseña." required class="form-control">
							</div>
							<div class="form-group row mt-4">
								<button type="submit" name="btnSesion" class="btn btn-outline-primary btn-block">Iniciar sesión</button>
							</div>
							<hr>
						</form>
						<?php 
							if (isset($_GET["error"]) && $_GET["error"]) {
								echo "<p class='text-center text-danger'>Usuario o Contrase&ntilde;a incorrectos</p>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<?php
	if (isset($_POST["btnSesion"])){
		$usuario = $_POST["usuario"];
		$clave = $_POST["clave"];

		$registros = $crud->ObtenerTodos("usuarios");
		if (mysqli_num_rows($registros) > 0){
			foreach ($registros as $registro) {
				if (($usuario == $registro['usuario']) && ($clave == Desencriptar($registro['clave']))){
					switch ($registro["idRol"]){
						case 1:
							$_SESSION["administrador"] = 1;
							echo "
								<script>
									location.href='administrador.php';
								</script>
							";
						break;
						case 2:
							$_SESSION["consultor"] = 2;
							echo "
								<script>
									location.href='consultor.php';
								</script>
							";							
						break;
					}
				}else{
					echo "
						<script type='text/javascript'>
							window.location.href='index.php?error=true';
						</script>
					";
				}
			}
		}
	}
?>

<?php
	}
?>