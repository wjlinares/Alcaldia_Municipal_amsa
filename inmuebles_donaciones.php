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

		<div class="container-fluid margen-superior-inmuebles-donaciones">
			<p class="lead text-center textoGrisClaro">ADMINISTRACI&Oacute;N DE INMUEBLES</p>
			<hr>
			<div class="row">
				<div class="col-lg-12">
					<button type="button" class="btn btn-primary btn-sm" data-toggle='modal' data-target='#modal-agregarInmueble'>Agregar Nuevo<br> Inmueble</button>
					<a href="buscar_inmueble.php" class="btn btn-secondary btn-sm">Realizar b&uacute;squeda<br>de Inmuebles</a>
					<div class="modal fade" id="modal-agregarInmueble" tabindex="-1" role='dialog' aria-labelledby='modal-agregarInmueble' aria-hidden='true'>
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Agregando nuevo inmueble...</h5>
									<button class="close" data-dismiss='modal' aria-label='Cerrar'>
										<span aria-hidden='true'>&times;</span>
									</button>
								</div>
								<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
									<div class="modal-body">
										<!-- Cuerpo o contenido del modal -->
										<?php 
											require_once("agregar_inmueble_donacion.php");
										?>
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

			<?php
				// ================= VERIFICACIÓN DE LA EXISTENCIA DE LA VARIABLE $_GET["paginaInmuebles"] EN LA URL =================
				if (isset($_GET["paginaInmuebles"])) {
					// ===== Calculando el 'desde' y el 'hasta' para la paginación =====:
					$inmueblesPorPagina = 5; // Cantidad de usuarios a mostrar por página.
					$inicio = ($_GET["paginaInmuebles"]-1) * $inmueblesPorPagina;
					$registros = $crud->ObtenerInmueblesPaginacion("inmuebles",$inicio,$inmueblesPorPagina);
					$registro = mysqli_fetch_assoc($registros);
					// Autocalculando el total de páginas en base a la petición:
					$listadoInmuebles = $crud->ObtenerTodos("inmuebles");
					$totalPaginas = ceil(mysqli_num_rows($listadoInmuebles) / $inmueblesPorPagina);
				}else{
					// Se establece la variable GET y se inicializa en '1' ya que al pricipio NO EXISTE.
		    		$_GET["paginaInmuebles"] = 1;
					$inmueblesPorPagina = 5;
					$inicio = ($_GET["paginaInmuebles"]-1) * $inmueblesPorPagina;
					$registros = $crud->ObtenerInmueblesPaginacion("inmuebles",$inicio,$inmueblesPorPagina);
					$listadoInmuebles = $crud->ObtenerTodos("inmuebles");
					$totalPaginas = ceil(mysqli_num_rows($listadoInmuebles) / $inmueblesPorPagina);
				}

				// ALERTAS JAVASCRIPT:
				if (isset($_SESSION["actualizacionInmueble"]) && $_SESSION["actualizacionInmueble"]) {
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡El registro fue actualizado con &eacute;xito!', 'success');
						</script>
					";
					$_SESSION["actualizacionInmueble"] = false;
					unset($_SESSION["actualizacionInmueble"]);
				}

				if (isset($_SESSION["documentacionAsignada"]) && $_SESSION["documentacionAsignada"]) {
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Documentaci&oacute;n asignada con &eacute;xito!', 'success');
						</script>
					";
					$_SESSION["documentacionAsignada"] = false;
					unset($_SESSION["documentacionAsignada"]);
				}

				if (isset($_SESSION["comodatoAsignado"]) && $_SESSION["comodatoAsignado"]) {
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Comodato asignado con &eacute;xito!', 'success');
						</script>
					";
					$_SESSION["comodatoAsignado"] = false;
					unset($_SESSION["comodatoAsignado"]);
				}

				if (isset($_SESSION["eliminacionInmueble"]) && $_SESSION["eliminacionInmueble"]) {
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡El registro fue eliminado con &eacute;xito!', 'success');
						</script>
					";
					$_SESSION["eliminacionInmueble"] = false;
					unset($_SESSION["eliminacionInmueble"]);
				}

				if (isset($_SESSION["folioEncontrado"]) && $_SESSION["folioEncontrado"]) {
					$_SESSION["folioEncontrado"] = false;
					unset($_SESSION["folioEncontrado"]);
					echo "
						<script type='text/javascript'>
							swal('¡ERROR!', '¡Folio ya existe! - El registro no pudo ser agregado.', 'error');
						</script>
					";
				}

				if (isset($_SESSION["ofertaActualizada"]) && $_SESSION["ofertaActualizada"]) {
					$_SESSION["ofertaActualizada"] = false;
					unset($_SESSION["ofertaActualizada"]);
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Oferta de Donaci&oacute;n actualizada con &eacute;xito!', 'success');
						</script>
					";
				}

				if (isset($_SESSION["acuerdoActualizado"]) && $_SESSION["acuerdoActualizado"]) {
					$_SESSION["acuerdoActualizado"] = false;
					unset($_SESSION["acuerdoActualizado"]);
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Acuerdo Municipal actualizado con &eacute;xito!', 'success');
						</script>
					";
				}

				if (isset($_SESSION["escrituraActualizada"]) && $_SESSION["escrituraActualizada"]) {
					$_SESSION["escrituraActualizada"] = false;
					unset($_SESSION["escrituraActualizada"]);
					echo "
						<script type='text/javascript'>
							swal('INFORMACIÓN', '¡Escritura actualizada con &eacute;xito!', 'success');
						</script>
					";
				}

				// ================= LISTANDO LOS INMUEBLES: =================
				if (mysqli_num_rows($registros) > 0) {
					echo "
						<table class='table table-bordered table-striped table-hover table-sm mt-4 text-center'>
							<thead class='bg-secondary tablasEncabezado'>
								<tr>
									<th colspan='4'>REGISTROS ACTUALES</th>
								</tr>
								<tr>
									<th>FOLIO</th>
									<th>INMUEBLE</th>
									<th>UBICACI&Oacute;N</th>
									<th>ACCIONES</th>
								</tr>
							</thead>
							<tbody>
					";

					foreach ($registros as $registro) {
						echo "
							<tr>
								<td>".strtoupper($registro['folio'])."</td>
								<td>".$registro['nombreInmueble']."</td>
								<td>".$registro['ubicacion']."</td>
								<td>
									<a href='actualizar_inmueble.php?id=".$registro['idInmueble']."' class='btn btn-outline-info btn-sm'>Editar Inmueble</a>
									<a href='eliminar_inmueble.php?id=".$registro['idInmueble']."' class='btn btn-outline-danger btn-sm'>Eliminar Inmueble</a>
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
			    	if (isset($_GET["paginaInmuebles"])) {
			    		// BOTÓN ANTERIOR:
				    	// Para "desactivar el botón ANTERIOR", si el número de página 'Activa' es menor o igual a 1.
				    	if ($_GET['paginaInmuebles'] <= 1) {
				    		echo "<li class='page-item disabled'><a href='inmuebles_donaciones.php?paginaInmuebles=".($_GET['paginaInmuebles']-1)."' class='page-link'>&laquo; Anterior</a></li>";
				    	}else{
				    		echo "<li class='page-item'><a href='inmuebles_donaciones.php?paginaInmuebles=".($_GET['paginaInmuebles']-1)."' class='page-link'>&laquo; Anterior</a></li>";
				    	}

				    	// Botones 1,2,3,4,5... generados automáticamente.
				    	for ($i=0; $i < $totalPaginas; $i++) { 
				    		if (($i+1) == $_GET['paginaInmuebles']) { // Verificación para aplicar la clase "Active de bootstrap".
				    			echo "<li class='page-item active'><a href='inmuebles_donaciones.php?paginaInmuebles=".($i+1)."' class='page-link'>".($i+1)."</a></li>";
				    		}else{
				    			echo "<li class='page-item'><a href='inmuebles_donaciones.php?paginaInmuebles=".($i+1)."' class='page-link'>".($i+1)."</a></li>";
				    		}
				    	}

				    	// BOTÓN SIGUIENTE:
				    	// Para "desactivar el botón SIGUIENTE", si el número de página 'Activa' es mayor o igual al calculado en ($totalPaginas) O si es igual a "1".
				    	if (($_GET['paginaInmuebles'] >= $totalPaginas) || (mysqli_num_rows($registros) == 1)) {
				    		echo "<li class='page-item disabled'><a href='inmuebles_donaciones.php?paginaInmuebles=".($_GET['paginaInmuebles']+1)."' class='page-link'>Siguiente &raquo;</a></li>";
				    	}else{
				    		echo "<li class='page-item'><a href='inmuebles_donaciones.php?paginaInmuebles=".($_GET['paginaInmuebles']+1)."' class='page-link'>Siguiente &raquo;</a></li>";
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