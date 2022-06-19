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
			<p class="lead textoGrisClaro text-center">B&Uacute;SQUEDA DE INMUEBLES...</p>
			<hr>
			<div class="row justify-content-center">
				<div class="col-lg-3">
					<a href="registros_consultor.php" title="Volver" class="text-info">Volver al listado de inmuebles</a>
				</div>
			</div>
			<div class="row justify-content-center mt-4">
				<div class="col-lg-6">
					<form action="" method="POST" autocomplete="off">
						<div class="form-group row">
							<div class="col-lg-10">
								<input type="text" name="folio" id="folio" autofocus placeholder="Ingresar criterio de b&uacute;squeda (folio o inmueble)" class="form-control text-center" required>
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
			if (isset($_POST["folio"])) {
				$folio = $_POST["folio"];
				$listadoInmuebles = $crud->ObtenerInmueblePorFolio("inmuebles",$folio);
				$registro = mysqli_fetch_assoc($listadoInmuebles);
				if (mysqli_num_rows($listadoInmuebles) > 0) {
					echo "<div class='container-fluid'>";
						echo "
							<table class='table table-bordered table-striped table-hover table-sm mt-4 text-center'>
								<thead class='bg-secondary tablasEncabezado'>
									<tr>
									<th colspan='4'>RESULTADOS DE BÚSQUEDA PARA: <span class='text-warning'>".strtoupper($folio)."</span></th>
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

						foreach ($listadoInmuebles as $registro) {
							echo "
								<tr>
									<td>".strtoupper($registro['folio'])."</td>
									<td>".$registro['nombreInmueble']."</td>
									<td>".$registro['ubicacion']."</td>
									<td>
									<a href='consulta_documentos.php?id=".$registro['idInmueble']."' class='btn btn-outline-info btn-sm'>Ver Documentos</a>
									</td>
								</tr>
							";
						}
						echo "
								</tbody>
							</table>
						";
					echo "</div>";
				}else{
					echo "<p class='text-center lead text-primary mt-5'>No se obtuvieron resultados para el inmueble: <span class='text-danger'>".strtoupper($folio)."</span></p>";
				}
			}
		?>

	</body>
</html>

<?php
	}
?>