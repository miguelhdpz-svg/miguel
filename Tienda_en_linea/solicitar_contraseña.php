<!DOCTYPE html>
<html lang="es">
	<head>
			<title>Tienda</title>
			<link rel="stylesheet" href="estilos/tiendas.css"/>
			<script src="https://www.google.com/recaptcha/api.js"
			async defer></script>
	</head>
<body>
<div class="contenido">
	<form name="entrar" method="POST" enctype="multipart/form-data"
	action="">
			<p id="título_de_pagina">Reestablecer contraseña</p>
			<input type="email" required name="correo_electronico"
			placeholder="Correo electronico" />
			<div class="g-recaptcha" data-sitekey=
					"6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
			<br/>
			<div class="contenedorIcon">
					<input type="submit" class="icon" id="enviar"
					name="enviar" value="&rarr;" />
			</div>
			<a href="index.php">Regresar</a>
	</form>
</div>
<?php
if(isset($_POST["enviar"])) {
	$aviso = "";
	$correoElectronico =
			htmlspecialchars($_POST['correo_electronico']);
	$fichaToken = bin2hex(random_bytes(32));
	$marcaTemporal = new DateTime("now");
	$marcaTemporal = $marcaTemporal->getTimestamp();
	include("conexion.php");
	try{
			$sql = "UPDATE cliente SET ficha_token = ? WHERE
									correo_electronico = ?";
			$stmt = $conexion->prepare($sql);
			$stmt->execute(array($fichaToken, $correoElectronico));
	}catch(PDOException $e) {
			echo $e->getMessage();
	}
	$enlace = sprintf("%s://%s",isset($_SERVER['HTTPS']) &&
			$_SERVER['HTTPS'] != 'off' ?
			'https' :'http',$_SERVER['HTTP_HOST'].
			dirname($_SERVER['PHP_SELF']).
			"/paginas/cambiar_contraseña.php" );
	$enlace = $enlace."?fichaToken=".$fichaToken.
			"&marcaTemporal=".$marcaTemporal;
	include("funciones.php");
	$asunto = "Reestablecer contrasena";
	$mensaje = "<p>Si deseas reestablecer tu contrasena haz
			clic <a href=".$enlace.">aquí</a></p>";
	try{
			enviarCorreo($correoElectronico, "Cliente", $asunto,
					$mensaje);
			$aviso = 'Te enviamos un correo electronico.';
	} catch(Exception $e){
			$aviso = 'No se pudo enviar correo electronico';
	}
	echo "<div id='aviso'>".$aviso."</div>";
}

?>
</body>
</html>