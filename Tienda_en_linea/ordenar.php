<?php
if(!isset($_SESSION["ID"]) && $_SESSION["STATUS"] != "ACTIVA") {
	echo "<script>
	alert('No estas autorizado para ver esta pagina');
	location.href='../index.php';
	</script>";
}
if(isset($_POST["enviar"])) {
	//crear orden
	$fecha = new DateTime();
	$fecha = date_format($fecha,"c");
	$sql = "INSERT INTO orden (numero_de_orden,
							numero_de_cliente,fecha) values (?,?,?)";
	$stmt = $conexion->prepare($sql);
	$data = array(NULL, $_SESSION['NUMERO_DE_CLIENTE'], $fecha);
	try{
			$stmt->execute($data);
			echo "<script>alert('Orden realizada.');</script>";
	}catch(PDOException $e) {
			echo  $e->getMessage();
			echo "<script>
							alert('no fue posible realizar la orden.');
							</script>";
			echo "<script>location.href='index.php?pagina=tienda';
							</script>";
	}
	// crear articulo
	$numeroDeOrden = $conexion->lastInsertID();
	for($x=0; $x < $_POST['interacion']; $x++){
	$cantidad = htmlspecialchars($_POST['cantidad'][$x]);
	if($cantidad == 0)continue;
	
			$numeroDeAlbum = $_POST['numero_de_album'][$x];
			$precioDeVenta = $_POST['precio'][$x];
			$sql = "INSERT INTO articulo
					(numero_de_articulo,numero_de_orden,
					numero_de_album, precio_de_venta, cantidad)
					values (?,?,?,?,?)";
			$stmt = $conexion->prepare($sql);
			$data = array(NULL, $numeroDeOrden, $numeroDeAlbum,
					$precioDeVenta, $cantidad);
			try{
					$stmt->execute($data);
					echo "<script>alert('Articulo agregado ');</script>";
					echo "<script>location.href='index.php?pagina=tienda';
					</script>";
			}catch(PDOException $e) {
				echo $e->getMessage();
				echo "<script>alert('Articulo no pudo ser agregado
				agregado ');</script>";
				echo "<script>location.href='index.php?pagina=tienda';
				</script>";
			}
	}
}
?>