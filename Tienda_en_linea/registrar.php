<?php
include("registrar.html");
include ("funciones.php");
include ("conexion.php");
if(isset($_POST["enviar"])) {
	$aviso = "";
	$nombre = htmlspecialchars($_POST['nombre'] ??"");
	$apellido = htmlspecialchars($_POST['apellido'] ??"");
	$nombreCompleto = $nombre . " " .$apellido;
	$direccion = htmlspecialchars($_POST['direccion'] ??"");
	$codigoPostal = htmlspecialchars($_POST['codigo_postal'] ?? "");
	$ciudad = htmlspecialchars($_POST['ciudad'] ??"");
	$correoElectronico =
	htmlspecialchars($_POST['correo_electronico'] ??"");
	$contrasena = htmlspecialchars($_POST['contrasena'] ??"");
	$contrasenaCifrada = password_hash($contrasena,
	PASSWORD_DEFAULT);
	// confirmar si correo electrónico ya existe
	$sql = "SELECT * FROM cliente WHERE correo_electronico = ?";
	$stmt = $conexion->prepare($sql);
	$stmt->execute(array($correoElectronico));
	$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
	if($resultado) {
			$aviso = "Este correo electronico ya esta registrado";
	}else{
			$sql = "INSERT INTO cliente (numero_de_cliente, nombre,
					apellido, direccion, codigo_postal, ciudad,
					correo_electronico,
					contrasena) values (null,?,?,?,?,?,?,?)";
			$stmt = $conexion->prepare($sql);
			try{
					$stmt->execute(array(
							$nombre,
							$apellido,
							$direccion,
							$codigoPostal,
							$ciudad,
							$correoElectronico,
							$contrasenaCifrada
						));
					$aviso = "Has abierto una cuenta.";
			}catch(PDOException $e) {
				echo $e->getMessage();
				}
							$asunto = "Registro";
						$mensaje = "Estimado $nombreCompleto, por este medio
									confirmamos la creación de tu cuenta en la tienda
									en línea.";
	enviarCorreo($correoElectronico, $nombreCompleto,
									$asunto,$mensaje);
	}
	echo "<div id='aviso'>".$aviso."</div>"; 
}
?>