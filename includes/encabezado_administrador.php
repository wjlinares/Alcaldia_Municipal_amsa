<header>
	<nav class="navbar navbar-expand-lg fixed-top fondoBarraNavegacion">
		<a class="navbar-brand" href="administrador.php" title="Inicio"><img src="imagenes/imgAlcaldia.png" alt="Logo Alcaldía" width="150" height="50"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuAdministrador" aria-controls="menuAdministrador" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="menuAdministrador">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link enlacesNavegacion" href="administrador.php" title="Inicio">Inicio <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle enlacesNavegacion" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Usuarios
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="roles.php">Gestión de Roles</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="usuarios.php">Gestión de Usuarios</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle enlacesNavegacion" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Registros
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="inmuebles_donaciones.php">Inmuebles</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="asignar_documentos.php">Documentaci&oacute;n</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="agregar_comodato.php">Comodatos</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle enlacesNavegacion" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Actualizaciones
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="actualizar_oferta.php">Oferta Donaci&oacute;n</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="actualizar_acuerdo.php">Acuerdo</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="actualizar_escritura.php">Escritura</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link enlacesNavegacion" href="registros_consultor.php" title="Vista Consultor">Vista Consultor</a>
				</li>
			</ul>
			<div class="rolActual">Se ha registrado como<br><span id="rolActual">Administrador</span></div>
			<a class="nav-link cerrar" href="index.php?CERRAR=true" title="Cerrar sesión">Salir</a>
		</div>
	</nav>
</header>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
