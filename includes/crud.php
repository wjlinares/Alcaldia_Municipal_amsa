<?php
	// INCLUSIÓN DEL SCRIPT DE CONEXIÓN:
	require_once("conexion.php");
?>

<?php 
	
	class Crud{

		// ================================== MÉTODO GENÉRICO =======================================
		// Método para Obtener Todos los registros:
		public function ObtenerTodos($tabla){
			global $conexion;
			$sql = "SELECT * FROM ".$tabla;
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// ======================= MÉTODOS CRUD EXCLUSIVOS PARA LA TABLA ROLES =======================
		// Método para Obtener Un registro específico:
		public function ObtenerRolPorId($tabla,$id){
			global $conexion;
			$sql = "SELECT * FROM $tabla WHERE idRol=$id";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Actualizar Roles:
		public function ActualizarRol($tabla,$id,$rol){
			global $conexion;
			$sql = "UPDATE $tabla SET rol = '$rol' WHERE(idRol = $id)";
			mysqli_query($conexion,$sql);
		}

		// Método para enlistar los Usuarios y Roles:
		public function ObtenerRolesUsuarios(){
			global $conexion;
			$sql = "SELECT * FROM roles INNER JOIN usuarios ON roles.idRol = usuarios.idRol ORDER BY rol ASC";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Mostrar El Rol y el Usuario al mismo tiempo a través del ID del usuario:
		public function ObtenerRolUsuarioPorId($id){
			global $conexion;
			$sql = "SELECT usuarios.nombre,usuarios.usuario, roles.rol FROM roles INNER JOIN usuarios ON (roles.idRol = usuarios.idRol) AND (usuarios.idUsuario = $id)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Mostrar El Rol y el Usuario al mismo tiempo a través del USUARIO del usuario para la páginade búsqueda:
		public function ObtenerRolUsuarioPorUsuario($usuario){
			global $conexion;
			$sql = "SELECT * FROM usuarios INNER JOIN roles ON (usuarios.idRol = roles.idRol) AND ((usuario LIKE '%$usuario%') OR (nombre LIKE '%$usuario%'))";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para obtener un usuario por su nombre de usuario:
		public function ObtenerUsuarioPorCampoUsuario($usuario){
			global $conexion;
			$sql = "SELECT usuario FROM usuarios WHERE(usuarios.usuario = '$usuario')";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// ======================= MÉTODOS CRUD EXCLUSIVOS PARA LA TABLA USUARIOS =======================
		// Método para Obtener Un Usuario específico:
		public function ObtenerUsuarioPorId($tabla,$id){
			global $conexion;
			$sql = "SELECT * FROM $tabla WHERE idUsuario=$id";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para insertar Usuarios:
		public function InsertarUsuario($nombre,$usuario,$clave,$rol){
			global $conexion;
			$sql = "INSERT INTO usuarios (nombre,usuario,clave,idRol) VALUES('$nombre', '$usuario', '$clave', $rol)";
			mysqli_query($conexion,$sql);
		}

		// Método para Eliminar Un Usuario:
		public function EliminarUsuario($tabla,$id){
			if ($id > 0) {
				global $conexion;
				$sql = "DELETE FROM $tabla WHERE(idUsuario = $id)";
				mysqli_query($conexion,$sql);
			}

		}

		// Método para Actualizar un Usuario y cuando Actualizan la CLAVE a través del compo Contraseña:
		public function ActualizarUsuarioConClave($id,$nombre,$clave,$rol){
			global $conexion;
			$sql = "UPDATE usuarios SET nombre = '$nombre', clave = '$clave', idRol = $rol WHERE(idUsuario = $id)";
			mysqli_query($conexion,$sql);
		}

		// Método para Actualizar un Usuario cuando "NO" Actualizan la CLAVE a través del compo Contraseña:
		public function ActualizarUsuarioSinClave($id,$nombre,$rol){
			global $conexion;
			$sql = "UPDATE usuarios SET nombre = '$nombre', idRol = $rol WHERE(idUsuario = $id)";
			mysqli_query($conexion,$sql);
		}

		// Método para Obtener los Usuarios para la paginación:
		public function ObtenerUsuariosPaginacion($inicio,$cantidadUsuarios){
			global $conexion;
			$sql = "SELECT * FROM roles INNER JOIN usuarios ON roles.idRol = usuarios.idRol  ORDER BY rol ASC LIMIT $inicio, $cantidadUsuarios";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Mostrar los datos del inmueble a Actualizar:
		public function ObtenerInmueblePorId($idInmueble){
			global $conexion;
			$sql = "SELECT folio, nombreInmueble, ubicacion FROM inmuebles WHERE(idInmueble = '$idInmueble')";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Actualizar un Inmueble:
		public function ActualizarInmueble($nombreInmueble,$ubicacion,$idInmueble){
			global $conexion;
			$sql = "UPDATE inmuebles SET nombreInmueble = '$nombreInmueble', ubicacion = '$ubicacion'  WHERE(idInmueble = $idInmueble)";
			mysqli_query($conexion,$sql);
		}

		// Método para Actualizar el Nombre Oferta Donación en base al Nombre del inmueble actualizado:
		public function ActualizarNombreOfertaDonacion($nombreOfertaDonacion,$idInmueble){
			global $conexion;
			$sql = "UPDATE documentos SET nombreOfertaDonacion = '$nombreOfertaDonacion' WHERE(idInmueble = $idInmueble)";
			mysqli_query($conexion,$sql);
		}

		// Método para Obtener sólo el nombre de un Inmueble a través de su ID de inmueble:
		public function ObtenerNombreInmueblePorId($idInmueble){
			global $conexion;
			$sql = "SELECT nombreInmueble FROM inmuebles WHERE(idInmueble = $idInmueble)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Obtener los INMUEBLES para la paginación:
		public function ObtenerInmueblesPaginacion($tabla,$inicio,$cantidadInmuebles){
			global $conexion;
			$sql = "SELECT * FROM $tabla ORDER BY idInmueble ASC LIMIT $inicio, $cantidadInmuebles";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Obtener sólo los inmuebles:
		public function ObtenerSoloInmuebles($tabla){
			global $conexion;
			$sql = "SELECT idInmueble, nombreInmueble FROM ".$tabla;
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para insertar inmuebles:
		public function InsertarInmueble($tabla,$folio,$nombreInmueble,$ubicacion,$idUsuario){
			global $conexion;
			$sql = "INSERT INTO $tabla (folio,nombreInmueble,ubicacion,idUsuario) VALUES('$folio', '$nombreInmueble', '$ubicacion', $idUsuario)";
			mysqli_query($conexion,$sql);
		}

		

		// Método para Obtener los INMUEBLES por su folio:
		public function ObtenerInmueblePorFolio($tabla,$folio){
			global $conexion;
			// $sql = "SELECT * FROM $tabla WHERE(folio = '$folio') ORDER BY idInmueble ASC";
			$sql = "SELECT * FROM $tabla WHERE((folio LIKE '%$folio%') OR (nombreInmueble LIKE '%$folio%')) ORDER BY idInmueble ASC";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Obtener un sólo código de Folio para evitar el ingreso de inmuebles duplicados:
		public function ObtenerFolio($folio){
			global $conexion;
			$sql = "SELECT folio FROM inmuebles WHERE(folio = '$folio')";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para insertar inmuebles:
		public function InsertarDocumentos($tabla,$nombreOfertaDonacion,$imgOferta,$imgAcuerdo,$imgEscritura,$idInmueble){
			global $conexion;
			$sql = "INSERT INTO $tabla (nombreOfertaDonacion,imgOferta,imgAcuerdo,imgEscritura,idInmueble) VALUES('$nombreOfertaDonacion', '$imgOferta', '$imgAcuerdo', '$imgEscritura',$idInmueble)";
			mysqli_query($conexion,$sql);
		}

		// Método para Obtener un sólo Nombre de alguna oferta si ésta existe. (se utiliza para verificar existencia de documentos ántes de ser asignados a un inmueble):
		public function ObtenerNombreOfertaDonacion($nombreOfertaDonacion){
			global $conexion;
			$sql = "SELECT nombreOfertaDonacion FROM documentos WHERE(nombreOfertaDonacion = '$nombreOfertaDonacion')";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Obtener el LISTADO de nombres e Id's de las ofertas de donación de la tabla documentos:
		public function ObtenerListadoNombresOfertaDonacion(){
			global $conexion;
			$sql = "SELECT idDocumento, nombreOfertaDonacion FROM documentos";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para insertar Comodatos:
		public function InsertarComodato($imgComodato,$idDocumento){
			global $conexion;
			$sql = "INSERT INTO comodatos (imgComodato,idDocumento) VALUES('$imgComodato', $idDocumento)";
			mysqli_query($conexion,$sql);
		}

		// Método para Obtener el LISTADO de Documentos:
		public function ObtenerDocumentos($idInmueble){
			global $conexion;
			$sql = "SELECT * FROM documentos WHERE(idInmueble = $idInmueble)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Obtener un sólo nombre de las Ofertas de Donación a través del ID de la tabla Documentos:
		public function ObtenerNombreOfertaDonacionPorId($idInmueble){
			global $conexion;
			$sql = "SELECT nombreOfertaDonacion FROM documentos WHERE(idInmueble = $idInmueble)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Obtener los Comodatos a través del ID de la tabla Documentos:
		public function ObtenerComodatosPorId($idDocumento){
			global $conexion;
			$sql = "SELECT imgComodato FROM comodatos WHERE(idDocumento = $idDocumento)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Métodos para elminar un registro Completo con toda su documentación asociada (Oferta de donación, Acuerdo, Escritura y comodatos...)
		// Método para Obtener el idDocumento a través del idInmueble para poder eliminar los Comodatos:
		public function ObtenerIdDocumento($idInmueble){
			global $conexion;
			$sql = "SELECT idDocumento FROM documentos WHERE(idInmueble = $idInmueble)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Eliminar el registro completo y las rutas de los archivos:
		public function EliminarInmueblePorId($idInmueble){
			global $conexion;
			$sql = "DELETE FROM inmuebles WHERE(idInmueble = $idInmueble)";
			$resultado = mysqli_query($conexion,$sql);
		}

		// ===== Métodos para las actualizaciones de los documentos:
		// Método para obtener la ruta de la imagen de la oferta de donación a través del IdDocumento para poder eliminar el archivo del servidor.
		public function ObtenerImgOfertaPorIdDocumento($idDocumento){
			global $conexion;
			$sql = "SELECT imgOferta FROM documentos WHERE(idDocumento = $idDocumento)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		// Método para Actualizar la Ruta y Nombre de la nueva oferta de donación:
		public function ActualizarOfertaDonacion($imgOferta, $idDocumento){
			global $conexion;
			$sql = "UPDATE documentos SET imgOferta = '$imgOferta' WHERE(idDocumento = $idDocumento)";
			mysqli_query($conexion,$sql);
		}

		public function ObtenerimgAcuerdoPorIdDocumento($idDocumento){
			global $conexion;
			$sql = "SELECT imgAcuerdo FROM documentos WHERE(idDocumento = $idDocumento)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		public function ActualizarAcuerdo($imgAcuerdo, $idDocumento){
			global $conexion;
			$sql = "UPDATE documentos SET imgAcuerdo = '$imgAcuerdo' WHERE(idDocumento = $idDocumento)";
			mysqli_query($conexion,$sql);
		}

		public function ObtenerimgEscrituraPorIdDocumento($idDocumento){
			global $conexion;
			$sql = "SELECT imgEscritura FROM documentos WHERE(idDocumento = $idDocumento)";
			$resultado = mysqli_query($conexion,$sql);
			return $resultado;
		}

		public function ActualizarEscritura($imgEscritura, $idDocumento){
			global $conexion;
			$sql = "UPDATE documentos SET imgEscritura = '$imgEscritura' WHERE(idDocumento = $idDocumento)";
			mysqli_query($conexion,$sql);
		}
		

	}


?>
