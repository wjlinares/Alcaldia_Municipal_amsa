<?php
	session_start();

	if (!isset($_SESSION["administrador"])){
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
			require_once("includes/encabezado_administrador.php");
			require_once("includes/seguridad.php");
			require_once("includes/crud.php");
			$crud = new Crud();
		?>

		<div class="container margen-superior">
			<p class="lead text-center buscarUsuario textoGrisClaro">BÚSCANDO USUARIO...</p>
			<hr>
			<div class="row justify-content-center">
				<div class="col-lg-3">
					<a href="usuarios.php" title="Volver" class="text-info">Volver al listado de usuarios</a>
				</div>
			</div>
			<div class="row justify-content-center mt-4">
				<div class="col-lg-6">
					<form action="" method="POST" autocomplete="off">
						<div class="form-group row">
							<div class="col-lg-10">
								<input type="text" name="usuario" autofocus placeholder="Ingresar criterio de b&uacute;squeda (nombre o usuario)" class="form-control text-center" required>
							</div>
							<div class="col-lg-2">
								<button type="submit" class="btn btn-secondary btn-buscar">BUSCAR</button>
							</div>

						</div>
					</form>

				</div>
			</div>
		</div>

		<?php
			if (isset($_POST["usuario"])) {
				$usuario = $_POST["usuario"];
				$listadoUsuarios = $crud->ObtenerRolUsuarioPorUsuario($usuario);
				$registro = mysqli_fetch_assoc($listadoUsuarios);
				if (mysqli_num_rows($listadoUsuarios) > 0) {
					echo "
						<div class='container'>
							<table class='table table-bordered table-striped table-hover table-sm mt-4 text-center'>
								<thead class='bg-secondary tablasEncabezado'>
									<tr>
										<th colspan='4'>RESULTADOS DE BÚSQUEDA PARA: <span class='text-warning'>".strtoupper($usuario)."</span></th>
									</tr>
									<tr>
										<th>NOMBRE</th>
										<th>USUARIO</th>
										<th>ROL</th>
										<th>ACCIONES</th>
									</tr>
								</thead>
								<tbody>
					";

					foreach ($listadoUsuarios as $registro) {
						echo "
							<tr>
								<td>".$registro['nombre']."</td>
								<td>".$registro['usuario']."</td>
								<td>".$registro['rol']."</td>
								<td>
									<a href='actualizar_usuario.php?id=".$registro['idUsuario']."' class='btn btn-outline-info btn-sm'>Editar Usuario</a>
									<a href='eliminar_usuario.php?id=".$registro['idUsuario']."' class='btn btn-outline-danger btn-sm'>Eliminar Usuario</a>
								</td>
							</tr>
						";
					}
					echo "
								</tbody>
							</table>
						</div>
					";
				}else{
					echo "<p class='text-center lead text-primary mt-5'>No se obtuvieron resultados para el usuario: <span class='text-danger'>".$usuario."</span></p>";
				}
			}
		?>

	</body>
</html>

<?php
	}
?>