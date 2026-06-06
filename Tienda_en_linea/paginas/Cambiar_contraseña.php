<!DOCTYPE html>
<html lang="nl">
	<head>
			<title>Tienda</title>
			<link rel="stylesheet" href="../estilos/tiendas.css" />
	</head>
<body>
<div class="contenido">
	<form name="formulario" method="POST"
	enctype="multipart/form-data" action=""
	onsubmit="
	if(document.formulario.contrasena1 !== 
			document.formulario.contrasena2){
			alert('contrasenas deben ser idénticas'); 
			return false;">
	<p id="título_de_página">Cambio de contraseña</p>
	<input required type="email" name="correo_electronico"
	placeholder="por@ejemplo.com" /><br>
	<input required type="password" name="contrasena1"
	placeholder="nueva contrasena"/><br>
	<input required type="password" name="contrasena2"
	placeholder="repetir contrasena"  /><br>
	<div class="contenedorIcon">
			<input type="submit" class="icon" id="enviar" 
			name="enviar" value="&rarr;" />
	</div>
</form>
</div>
</body>
</html>
<?php
if(isset($_POST["enviar"])) {
if(isset($_GET["fichaToken"]) &&
isset($_GET["marcaTemporal"])){
	$fichaToken = $_GET["fichaToken"];
	$marcaTemporal = $_GET["marcaTemporal"];
	
	$mensaje = "";
	$correoElectrónico =
			htmlspecialchars($_POST["correo_electronico"]);
	$contrasena = htmlspecialchars($_POST["contrasena1"]);
	$contrasenaCifrada=password_hash(
			$contrasena,PASSWORD_DEFAULT);
	include("../conexion.php");
	$sql = "SELECT * FROM cliente WHERE correo_electronico = ?
									AND ficha_token = ?";
	$stmt = $conexión->prepare($sql);
	try {
			$stmt->execute(array($correoElectronico,$fichaToken));
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			if($resultado) {
				$marcaTemporal_2 = new DateTime("now");
				$marcaTemporal_2 = $marcaTemporal_2->getTimestamp();
			if(($marcaTemporal_2 - $marcaTemporal) < 43200){
				$query = "UPDATE cliente SET 'contrasena' = ?
				WHERE 'correo_electronico' = ?";
				$stmt = $conexión->prepare($query);
				$stmt = $stmt->execute(array($contrasenaCifrada,
							$correoElectrónico));
				if($stmt) {
					echo "<script>alert('Tu contrasena ha sido
					reestablecida.');
					location.href='../index.php';
					</script>";
									}
			}else{
				echo "<script>alert('Enlace ya no es válido.');
						location.href='../index.php';
						</script>";
			}
		}
	}catch(PDOException $e) {
		echo $e->getMessage();
	}
}
}
?>