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
		<link rel="stylesheet" href="estilos/sweetalert2.min.css">
		<script type='text/javascript' src='js/sweetalert2.min.js'></script>
		<meta name='viewport' content="width='device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1'">
	</head>
	<body>
		<?php
			require_once("includes/encabezado_administrador.php");
			require_once("includes/crud.php");
			$crud = new Crud();			
		?>

		<div class="container margen-superior">
		<p class="lead text-center textoGrisClaro">ADMINISTRACIÓN DE ROLES</p>
		<hr>

			<?php 
				$registros = $crud->ObtenerTodos('roles');
				if (mysqli_num_rows($registros) > 0){
					echo "
						<table class='table table-bordered table-striped table-hover table-sm mt-4 text-center'>
							<thead class='bg-secondary tablasEncabezado'>
								<tr>
									<th colspan='3'>REGISTROS ACTUALES</th>
								</tr>
								<tr>
									<th>ID</th>
									<th>ROL</th>
									<th>ACCIONES</th>
								</tr>
							</thead>
							<tbody>
					";

					foreach ($registros as $registro)
					{
						echo "
							<tr>
								<td>".$registro['idRol']."</td>
								<td>".$registro['rol']."</td>
								<td><a href='actualizar_rol.php?id=".$registro['idRol']."' class='btn btn-outline-info btn-sm'>Editar Rol</a></td>
							</tr>
						";
					}
					echo "
							</tbody>
						</table>
					";
				}

				if (isset($_SESSION["rolActualizado"]) && $_SESSION["rolActualizado"]) {
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Rol actualizado con &eacute;xito!', 'success');
						</script>
					";
					$_SESSION["rolActualizado"] = false;
					unset($_SESSION["rolActualizado"]);
				}
			?>

		</div>

		<script type="text/javascript" src='js/main.js'></script>
	</body>
</html>

<?php
	}
?>