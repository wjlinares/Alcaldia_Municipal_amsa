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

		<div class="container margen-superior-usuarios">
			<p class="lead text-center textoGrisClaro">ADMINISTRACIÓN DE USUARIOS</p>
			<hr>
			<div class="row">
				<div class="col-lg-12">
					<button type="button" class="btn btn-primary btn-sm" data-toggle='modal' data-target='#modal-agregarUsuario'>Agregar Usuario</button>
					<a href="buscar_usuario.php" class="btn btn-secondary btn-sm">Buscar usuario</a>
					<div class="modal fade" id="modal-agregarUsuario" tabindex="-1" role='dialog' aria-labelledby='modal-agregarUsuario' aria-hidden='true'>
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Agregando nuevo usuario...</h5>
									<button class="close" data-dismiss='modal' aria-label='Cerrar'>
										<span aria-hidden='true'>&times;</span>
									</button>
								</div>
								<form action="" method="POST" autocomplete="off">
									<div class="modal-body">
										<!-- Cuerpo o contenido del modal -->
										<div class="form-group row">
											<div class="col-lg-12">
												<label for="nombre">Nombre:</label>
												<input type="text" name="nombre" id="nombre" required placeholder="(50 caracteres como m&aacute;ximo)" class="form-control form-control-sm" maxlength=50>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-12">
												<label for="usuario">Usuario:</label>
												<input type="text" name="usuario" id="usuario" required placeholder="(25 caracteres como m&aacute;ximo)" class="form-control form-control-sm" maxlength=25>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-12">
												<label for="clave">Contrase&ntilde;a:</label>
												<input type="password" name="clave" id="clave" required placeholder="Ingresar contraseña." class="form-control form-control-sm">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-12">
												<label for="rol">Establecer un rol:</label>
												<select name="rol" id="rol" class="form-control form-control-sm">
													<!-- Agregando los roles al select desde la base de datos -->
													<?php 
														$listaRoles = $crud->ObtenerTodos("roles");
														$roles = mysqli_fetch_assoc($listaRoles);
														if (mysqli_num_rows($listaRoles) > 0) {
															foreach ($listaRoles as $rol) {
																echo "
																	<option value='".$rol["idRol"]."'>".$rol["rol"]."</option>
																";
															}
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary btn-sm">Agregar</button>
										<button type="button" class="btn btn-secondary btn-sm" data-dismiss='modal'>Cancelar</button>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>


			<!-- ======================================= INSERTANDO NUEVOS USUARIOS ======================================= -->
			<?php
				if (isset($_POST["nombre"])) {
					$nombre = $_POST["nombre"];
					$usuario = $_POST["usuario"];
					$clave = $_POST["clave"];
					$idRol = $_POST["rol"];

					// Verificando la existencia de un usuario antes de insertarlo:
					$usuarios = $crud->ObtenerUsuarioPorCampoUsuario($usuario);
					if (mysqli_num_rows($usuarios) > 0) {
						$usuario = true;
					}else{
						// Encriptando la clave:
						$claveEncriptada = Encriptar($clave);
						$crud->InsertarUsuario($nombre,$usuario,$claveEncriptada,$idRol);
						$usuario = false;
						// El script de JavaScript tal y como está, es para recargar la página de los usuarios.
						echo "
							<script type='text/javascript'>
								location.href='#';
							</script>
						";
					}

					if ($usuario) {
						echo "
							<script type='text/javascript'>
								swal('¡ERROR!', '¡El usuario que intentaba registrar ya existe, intente con uno diferente.', 'error');
							</script>
						";
						$usuario = false;
					}
				}

				// ALERTAS JAVASCRIPT DE CONFIRMACIÓN:
				if (isset($_SESSION["usuarioActualizado"]) && $_SESSION["usuarioActualizado"]) {
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Usuario actualizado con &eacute;xito!', 'success');
						</script>
					";
					$_SESSION["usuarioActualizado"] = false;
					unset($_SESSION["usuarioActualizado"]);
				}

				if (isset($_SESSION["usuarioEliminado"]) && $_SESSION["usuarioEliminado"]) {
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Usuario eliminado con &eacute;xito!', 'success');
						</script>
					";
					$_SESSION["usuarioEliminado"] = false;
					unset($_SESSION["usuarioEliminado"]);
				}


			?>


			<?php
				// ================= VERIFICACIÓN DE LA EXISTENCIA DE LA VARIABLE $_GET["pagina"] EN LA URL =================
				if (isset($_GET["pagina"])) {
					// ===== Calculando el 'desde' y el 'hasta' para la paginación =====:
					$usuariosPorPagina = 4; // Cantidad de usuarios a mostrar por página.
					$inicio = ($_GET["pagina"]-1) * $usuariosPorPagina;
					$registros = $crud->ObtenerUsuariosPaginacion($inicio,$usuariosPorPagina);
					$registro = mysqli_fetch_assoc($registros);
					// Autocalculando el total de páginas en base a la petición:
					$listadoUsuarios = $crud->ObtenerTodos("usuarios");
					$totalPaginas = ceil(mysqli_num_rows($listadoUsuarios) / $usuariosPorPagina);
				}else{
					// Se establece la variable GET y se inicializa en '1' ya que al pricipio NO EXISTE.
		    		$_GET["pagina"] = 1;
					$usuariosPorPagina = 4;
					$inicio = ($_GET["pagina"]-1) * $usuariosPorPagina;
					$registros = $crud->ObtenerUsuariosPaginacion($inicio,$usuariosPorPagina);
					$listadoUsuarios = $crud->ObtenerTodos("usuarios");
					$totalPaginas = ceil(mysqli_num_rows($listadoUsuarios) / $usuariosPorPagina);
				}


				// ================= LISTANDO LOS ROLES Y USUARIOS: =================
				if (mysqli_num_rows($registros) > 0) {
					echo "
						<table class='table table-bordered table-striped table-hover table-sm mt-4 text-center'>
							<thead class='bg-secondary tablasEncabezado'>
								<tr>
									<th colspan='4'>REGISTROS ACTUALES</th>
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

					foreach ($registros as $registro) {
						echo "
							<tr>
								<td>".$registro['nombre']."</td>
								<td>".$registro['usuario']."</td>
								<td>".$registro['rol']."</td>
								<td>"
						;
									if (($registro['usuario'] == 'admin') && ($registro['idRol'] == 1)) {
										echo "
											<a href='actualizar_usuario.php?id=".$registro['idUsuario']."' class='btn btn-outline-info btn-sm'>Editar Usuario</a>
										";
									}else{
										echo "
											<a href='actualizar_usuario.php?id=".$registro['idUsuario']."' class='btn btn-outline-info btn-sm'>Editar Usuario</a>
											<a href='eliminar_usuario.php?id=".$registro['idUsuario']."' class='btn btn-outline-danger btn-sm'>Eliminar Usuario</a>
										";
									}
						echo "
								</td>
							</tr>
						";
					}
					echo "
							</tbody>
						</table>
					";
				}
			?>
			
			<!-- ================================================= PAGINACIÓN PARA USUARIOS ================================================= -->
			<nav aria-label='Page'>
			  <ul class='pagination pagination-sm justify-content-end'>
			    <?php
			    	if (isset($_GET["pagina"])) {
			    		// BOTÓN ANTERIOR:
				    	// Para "desactivar el botón ANTERIOR", si el número de página 'Activa' es menor o igual a 1.
				    	if ($_GET['pagina'] <= 1) {
				    		echo "<li class='page-item disabled'><a href='usuarios.php?pagina=".($_GET['pagina']-1)."' class='page-link'>&laquo; Anterior</a></li>";
				    	}else{
				    		echo "<li class='page-item'><a href='usuarios.php?pagina=".($_GET['pagina']-1)."' class='page-link'>&laquo; Anterior</a></li>";
				    	}

				    	// Botones 1,2,3,4,5... generados automáticamente.
				    	for ($i=0; $i < $totalPaginas; $i++) { 
				    		if (($i+1) == $_GET['pagina']) { // Verificación para aplicar la clase "Active de bootstrap".
				    			echo "<li class='page-item active'><a href='usuarios.php?pagina=".($i+1)."' class='page-link'>".($i+1)."</a></li>";
				    		}else{
				    			echo "<li class='page-item'><a href='usuarios.php?pagina=".($i+1)."' class='page-link'>".($i+1)."</a></li>";
				    		}
				    	}

				    	// BOTÓN SIGUIENTE:
				    	// Para "desactivar el botón SIGUIENTE", si el número de página 'Activa' es mayor o igual al calculado en ($totalPaginas) O si es igual a "1".
				    	if (($_GET['pagina'] >= $totalPaginas) || (mysqli_num_rows($registros) == 1)) {
				    		echo "<li class='page-item disabled'><a href='usuarios.php?pagina=".($_GET['pagina']+1)."' class='page-link'>Siguiente &raquo;</a></li>";
				    	}else{
				    		echo "<li class='page-item'><a href='usuarios.php?pagina=".($_GET['pagina']+1)."' class='page-link'>Siguiente &raquo;</a></li>";
				    	}
			    	}
			    ?>
			    
			  </ul>
			</nav>
			<!-- ================================================= FIN DE LA PAGINACIÓN ================================================= -->
			
		</div>
		
		<script type="text/javascript" src='js/main.js'></script>
	</body>
</html>

<?php
	}
?>