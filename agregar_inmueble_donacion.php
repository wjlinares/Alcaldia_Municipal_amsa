<?php
	require_once("includes/crud.php");
	$crud = new Crud();
?>

<div class="container">
	<div class="form-group row">
		<div class="col-lg-12">
			<label for="folio">Ingresar N&deg; de folio:</label>
			<input type="text" name="folio" id="folio" required placeholder="(25 caracteres como m&aacute;ximo)" class="form-control form-control-sm" maxlength=25>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-lg-12">
			<label for="nombreInmueble">Ingresar nombre del inmueble:</label>
			<input type="text" name="nombreInmueble" id="nombreInmueble" onkeyup="AsignadoAutomaticoDeNombre()" required placeholder="(75 caracteres como m&aacute;ximo)" class="form-control form-control-sm" maxlength=75>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-lg-12">
			<label for="ubicacion">Ingresar lugar o ubicaci&oacute;n del inmueble:</label>
			<textarea name="ubicacion" id="ubicacion" cols="30" rows="3" required placeholder="(125 caracteres como m&aacute;ximo)" class="form-control form-control-sm" maxlength=125></textarea>
		</div>
	</div>
</div>

<!-- INSERTANDO NUEVOS INMUEBLES Y OFERTAS DE DONACIÓN -->
<?php 
	if (isset($_POST["folio"])) {
		$folio = $_POST["folio"];
		$nombreInmueble = $_POST["nombreInmueble"];
		$ubicacion = $_POST["ubicacion"];

		$folioExistente = $crud->ObtenerFolio($folio);
		if (mysqli_num_rows($folioExistente) >= 1) {
			$_SESSION["folioEncontrado"] = true;
		}else{
			$_SESSION["administrador"] = 1;
			$crud->InsertarInmueble("inmuebles",$folio,$nombreInmueble,$ubicacion,$_SESSION["administrador"]);
			echo "
				<script type='text/javascript'>
					location.href='#';
				</script>
			";
		}


	}
?>
