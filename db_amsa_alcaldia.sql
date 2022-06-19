CREATE DATABASE db_amsa_alcaldia;
USE db_amsa_alcaldia;

CREATE TABLE roles(
	idRol INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	rol VARCHAR(25) DEFAULT NULL
);

-- Estos registros deben INSERTARSE al momento de crear la base de datos porque serán estáticos.
-- En otras palabras solo Crear la Base de datos, Usarla, y ejecutar el Script de las tablas junto con estos INSERT.
INSERT INTO roles(rol) VALUES('Administrador');
INSERT INTO roles(rol) VALUES('Consultor');

CREATE TABLE usuarios(
	idUsuario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(50) NULL,
	usuario VARCHAR(25) NULL,
	clave BLOB,
	idRol INT NOT NULL, FOREIGN KEY (idRol) REFERENCES roles(idRol) ON DELETE CASCADE
);
-- Este registro debe insertarse automáticamente cuando se ejecuta todo el script de la Base de Datos.
-- ¡IMPORTANTE PARA PODER ACCEDER AL SISTEMA AL PRINCIPIO!
-- La contraseña cifrada que se está insertando a la hora de crear el registro para el usuario "admin" también es "admin".
-- Es decir: Usuario: "admin" Contraseña: "admin".
INSERT INTO usuarios(nombre,usuario,clave,idRol) VALUES('principal','admin','WWdhSXlYWGhhK0gzcWRzOFZqNHVwdz09',1);

CREATE TABLE inmuebles(
	idInmueble INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	folio VARCHAR(25) NULL,
	nombreInmueble VARCHAR(75) NULL,
	ubicacion VARCHAR(125) NULL,
	idUsuario INT NOT NULL, FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario) ON DELETE CASCADE
);

CREATE TABLE documentos(
	idDocumento INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreOfertaDonacion VARCHAR(75),
	imgOferta VARCHAR(200) NULL,
	imgAcuerdo VARCHAR(200) NULL,
	imgEscritura VARCHAR(200) NULL,
	idInmueble INT NOT NULL, FOREIGN KEY(idInmueble) REFERENCES inmuebles(idInmueble) ON DELETE CASCADE
);

CREATE TABLE comodatos(
	idComodato INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	imgComodato VARCHAR(200) NULL,
	idDocumento INT NOT NULL, FOREIGN KEY(idDocumento) REFERENCES documentos(idDocumento) ON DELETE CASCADE
);







