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
			require_once("includes/crud.php");
			$crud = new Crud();
		?>
		<!-- ========== PETICIÓN PARA TOMAR LOS DATOS DE LA DB EN BASE AL ID PROPORCIONADO POR GET ========== -->
		<?php 
			$id = $_GET["id"];
			$usuarios = $crud->ObtenerRolUsuarioPorId($id);
			$usuario = mysqli_fetch_assoc($usuarios);
		?>

		<div class="container margen-superior">
			<p class="lead textoGrisClaro text-center">ELIMINANDO USUARIO...</p>
			<hr>
			<div class="container mt-5 ">
				<div class="row">
					<div class="col-lg-4">
						<img src="imagenes/eliminar.png" alt="Icono Eliminar" class="imagenes-formularios">
					</div>

					<div class="col-lg-8">
						<div class="form-group row">
							<div class="col-lg-12">
								<p class="lead text-danger text-center">¿Está seguro que desea eliminar el registro?<br>¡Esta acción es irreversible!</p>
								<!-- <hr>	 -->
								<?php 
									echo "
										<table class='table table-sm table-bordered'>
											<tr>
												<td class='text-center'><span class='lead textoGrisClaro'>Nombre</span></td>
												<td class='text-center'><span class='lead textoGrisClaro'>Usuario</span></td>
												<td class='text-center'><span class='lead textoGrisClaro'>Rol</span></td>
											</tr>
											<tr>
												<td class='text-center'><span class='text-info'>".$usuario["nombre"]."</span></td>
												<td class='text-center'><span class='text-info'>".$usuario["usuario"]."</span></td>
												<td class='text-center'><span class='text-info'>".$usuario["rol"]."</span></td>
											</tr>
										</table>
									";
								?>
							</div>
						</div>
						<br>
						<form action="" method="POST">
							<div class="modal-footer">
								<button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar Usuario</button>
								<button type='button' class='btn btn-secondary btn-sm' onclick='CancelarEliminacion()'>Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- ========== ELIMINANDO USUARIO ========== -->
			<?php 
				if (isset($_POST["eliminar"])) {
					if (mysqli_num_rows($usuarios) > 0) {
						$crud->EliminarUsuario("usuarios",$id);
						$_SESSION["usuarioEliminado"] = true;
						echo "
							<script type='text/javascript'>
								window.location.href = 'usuarios.php';
							</script>
						";
					}
				}
			?>
		</div>

	</body>

	<script type="text/javascript">
		// ======== EN CASO DE CANCELAR EL EDITADO DEL ROL ========
		function CancelarEliminacion(){
			window.location.href = 'usuarios.php';
		}
	</script>
</html>

<?php
	}
?>