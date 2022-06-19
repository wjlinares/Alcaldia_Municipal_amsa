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
<?php 
	// Desactivar Adevertencias(Warnings) del PHP:
	error_reporting(0);
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
			$idInmueble = $_GET["id"];
			$registroEncontrado = $crud->ObtenerInmueblePorId($idInmueble);
			$inmueble = mysqli_fetch_assoc($registroEncontrado);
		?>

		<div class="container margen-superior-eliminar-inmueble">
			<p class="lead textoGrisClaro text-center">ELIMINANDO INMUEBLE...</p>
			<hr>
			<div class="container mt-5 ">
				<div class="row">
					<div class="col-lg-3">
						<img src="imagenes/eliminar.png" alt="Icono Eliminar" class="imagenes-formularios">
					</div>

					<div class="col-lg-9">
						<div class="form-group row">
							<div class="col-lg-12">
								<p class="lead text-danger text-center">¿Está seguro que desea eliminar el registro y toda la documentación asociada?<br>¡Esta acción es irreversible!</p>
								<!-- <hr>	 -->
								<?php 
									echo "
										<table class='table table-sm table-bordered'>
											<tr>
												<td class='text-center'><span class='lead textoGrisClaro'>FOLIO</span></td>
												<td class='text-center'><span class='lead textoGrisClaro'>INMUEBLE</span></td>
												<td class='text-center'><span class='lead textoGrisClaro'>UBICACI&Oacute;N</span></td>
											</tr>
											<tr>
												<td class='text-center'><span class='text-info'>".strtoupper($inmueble["folio"])."</span></td>
												<td class='text-center'><span class='text-info'>".$inmueble["nombreInmueble"]."</span></td>
												<td class='text-center'><span class='text-info'>".$inmueble["ubicacion"]."</span></td>
											</tr>
										</table>
									";
								?>
							</div>
						</div>
						<br>
						<form action="" method="POST">
							<div class="modal-footer">
								<button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar Inmueble</button>
								<button type='button' class='btn btn-secondary btn-sm' onclick='CancelarEliminacion()'>Cancelar</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- ========== ELIMINANDO UN INMUEBLE Y TODA SU DOCUMENTACIÓN ASOCIADA ========== -->
			<?php 
				if (isset($_POST["eliminar"])) {
					$idInmuebleParaEliminarComodato = $crud->ObtenerIdDocumento($idInmueble);
					$idInmuebleEncontrado = mysqli_fetch_assoc($idInmuebleParaEliminarComodato);
					// Para eliminar los Comodatos del Servidor antes de eliminar el registro dentro de la Base de Datos:
					$comodatosAEliminar = $crud->ObtenerComodatosPorId($idInmuebleEncontrado["idDocumento"]);

					if (mysqli_num_rows($comodatosAEliminar) > 0) {
						
						foreach ($comodatosAEliminar as $comodato) {
							unlink($comodato["imgComodato"]);
						}
					}

					// Eliminando los demás Documentos del Servidor:
					$documentosObtenidos = $crud->ObtenerDocumentos($idInmueble);
					$documentos = mysqli_fetch_assoc($documentosObtenidos);
					unlink($documentos["imgOferta"]);
					unlink($documentos["imgAcuerdo"]);
					unlink($documentos["imgEscritura"]);

					// Eliminando TODO el registro almacenado en la Base de Datos de las rutas de los documentos incluyendo las rutas de los comodatos:
					$crud->EliminarInmueblePorId($idInmueble);
					$_SESSION["eliminacionInmueble"] = true;
					echo "
						<script type='text/javascript'>
							window.location.href = 'inmuebles_donaciones.php';
						</script>
					";
				}
			?>
		</div>

	</body>

	<script type="text/javascript">
		// ======== EN CASO DE CANCELAR EL EDITADO DEL ROL ========
		function CancelarEliminacion(){
			window.location.href = 'inmuebles_donaciones.php';
		}
	</script>
</html>

<?php
	}
?>