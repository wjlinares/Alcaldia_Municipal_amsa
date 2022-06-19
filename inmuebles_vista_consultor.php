<?php
	session_start();

	if (!isset($_SESSION["consultor"])) {
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
			require_once("includes/encabezado_consultor.php");
			require_once("includes/seguridad.php");
			require_once("includes/crud.php");
			$crud = new Crud();
		?>

		<div class="container-fluid margen-superior-registros-consultor">
			<p class="lead text-center titulos">INMUEBLES - ALCALD&Iacute;A MUNICIPAL DE SANTA ANA</p>
			<hr>
			<div class="row">
				<div class="col-lg-12">
					<a href="buscar_inmueble_vista_consultor.php" class="btn btn-primary btn-sm btnBuscarConsultor">B&uacute;squeda de inmuebles</a>
				</div>
			</div>

			<?php
				// ================= VERIFICACIÓN DE LA EXISTENCIA DE LA VARIABLE $_GET["paginaInmueblesVistaConsultor"] EN LA URL =================
				if (isset($_GET["paginaInmueblesVistaConsultor"])) {
					// ===== Calculando el 'desde' y el 'hasta' para la paginación =====:
					$inmueblesPorPagina = 5; // Cantidad de usuarios a mostrar por página.
					$inicio = ($_GET["paginaInmueblesVistaConsultor"]-1) * $inmueblesPorPagina;
					$registros = $crud->ObtenerInmueblesPaginacion("inmuebles",$inicio,$inmueblesPorPagina);
					$registro = mysqli_fetch_assoc($registros);
					// Autocalculando el total de páginas en base a la petición:
					$listadoInmuebles = $crud->ObtenerTodos("inmuebles");
					$totalPaginas = ceil(mysqli_num_rows($listadoInmuebles) / $inmueblesPorPagina);
				}else{
					// Se establece la variable GET y se inicializa en '1' ya que al pricipio NO EXISTE.
		    		$_GET["paginaInmueblesVistaConsultor"] = 1;
					$inmueblesPorPagina = 5;
					$inicio = ($_GET["paginaInmueblesVistaConsultor"]-1) * $inmueblesPorPagina;
					$registros = $crud->ObtenerInmueblesPaginacion("inmuebles",$inicio,$inmueblesPorPagina);
					$listadoInmuebles = $crud->ObtenerTodos("inmuebles");
					$totalPaginas = ceil(mysqli_num_rows($listadoInmuebles) / $inmueblesPorPagina);
				}

				// ALERTA JAVASCRIPT:
				global $confirmacion;
				if ($confirmacion || isset($_GET["confirm"])) {
					echo "
						<div class='alert alert-success mt-2'>
							<strong>INFORMACIÓN:</strong> El registro fué agregado con éxito!
							<button class='close'  data-dismiss='alert'>
								<span class='aria-hidden'>&times;</span>
							</button>
						</div>
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
									<a href='consulta_documentos_vista_consultor.php?id=".$registro['idInmueble']."' class='btn btn-outline-info btn-sm'>Ver Documentos</a>
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
			
			<!-- ================================================= PAGINACIÓN PARA INMUEBLES ================================================= -->
			<nav aria-label='Page'>
			  <ul class='pagination pagination-sm justify-content-end'>
			    <?php
			    	if (isset($_GET["paginaInmueblesVistaConsultor"])) {
			    		// BOTÓN ANTERIOR:
				    	// Para "desactivar el botón ANTERIOR", si el número de página 'Activa' es menor o igual a 1.
				    	if ($_GET['paginaInmueblesVistaConsultor'] <= 1) {
				    		echo "<li class='page-item disabled'><a href='inmuebles_vista_consultor.php?paginaInmueblesVistaConsultor=".($_GET['paginaInmueblesVistaConsultor']-1)."' class='page-link'>&laquo; Anterior</a></li>";
				    	}else{
				    		echo "<li class='page-item'><a href='inmuebles_vista_consultor.php?paginaInmueblesVistaConsultor=".($_GET['paginaInmueblesVistaConsultor']-1)."' class='page-link'>&laquo; Anterior</a></li>";
				    	}

				    	// Botones 1,2,3,4,5... generados automáticamente.
				    	for ($i=0; $i < $totalPaginas; $i++) { 
				    		if (($i+1) == $_GET['paginaInmueblesVistaConsultor']) { // Verificación para aplicar la clase "Active de bootstrap".
				    			echo "<li class='page-item active'><a href='inmuebles_vista_consultor.php?paginaInmueblesVistaConsultor=".($i+1)."' class='page-link'>".($i+1)."</a></li>";
				    		}else{
				    			echo "<li class='page-item'><a href='inmuebles_vista_consultor.php?paginaInmueblesVistaConsultor=".($i+1)."' class='page-link'>".($i+1)."</a></li>";
				    		}
				    	}

				    	// BOTÓN SIGUIENTE:
				    	// Para "desactivar el botón SIGUIENTE", si el número de página 'Activa' es mayor o igual al calculado en ($totalPaginas) O si es igual a "1".
				    	if (($_GET['paginaInmueblesVistaConsultor'] >= $totalPaginas) || (mysqli_num_rows($registros) == 1)) {
				    		echo "<li class='page-item disabled'><a href='inmuebles_vista_consultor.php?paginaInmueblesVistaConsultor=".($_GET['paginaInmueblesVistaConsultor']+1)."' class='page-link'>Siguiente &raquo;</a></li>";
				    	}else{
				    		echo "<li class='page-item'><a href='inmuebles_vista_consultor.php?paginaInmueblesVistaConsultor=".($_GET['paginaInmueblesVistaConsultor']+1)."' class='page-link'>Siguiente &raquo;</a></li>";
				    	}
			    	}
			    ?>
			    
			  </ul>
			</nav>
			<!-- ================================================= FIN DE LA PAGINACIÓN ================================================= -->
			
		</div>

	</body>
</html>

<?php
	}
?>