<?php

	define('METHOD','AES-256-CBC');
	define('SECRET_KEY','WhkY_M42/SIf@nDxZ6?$A/1*2l_02y0');
	define('SECRET_IV','101712');

	function Encriptar($cadena){
		$output=FALSE;
		$key=hash('sha256', SECRET_KEY);
		$iv=substr(hash('sha256', SECRET_IV), 0, 16);
		$output=openssl_encrypt($cadena, METHOD, $key, 0, $iv);
		$output=base64_encode($output);
		return $output;
	}

	function Desencriptar($cadena){
		$key=hash('sha256', SECRET_KEY);
		$iv=substr(hash('sha256', SECRET_IV), 0, 16);
		$output=openssl_decrypt(base64_decode($cadena), METHOD, $key, 0, $iv);
		return $output;
	}

?>