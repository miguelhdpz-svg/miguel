<?php
session_start();
include("conexion.php");
include("funciones.php"); // aquí debe estar enviarCorreo()

if(!isset($_SESSION["ID"]) || $_SESSION["STATUS"] != "ACTIVA"){
    echo "<script>
    alert('No autorizado');
    location.href='index.php';
    </script>";
    exit;
}

if(isset($_POST["enviar"])){

    // Crear orden
    $fecha = new DateTime();
    $fecha = $fecha->format("Y-m-d H:i:s");

    $sql = "INSERT INTO orden (numero_de_orden, numero_de_cliente, fecha)
            VALUES (NULL, ?, ?)";
    $stmt = $conexion->prepare($sql);

    try{
        $stmt->execute([
            $_SESSION["NUMERO_DE_CLIENTE"],
            $fecha
        ]);

        // Obtener número de orden
        $numeroDeOrden = $conexion->lastInsertId();

        // Obtener correo del cliente
        $correo = $_SESSION["CORREO"];
        $nombre = $_SESSION["USUARIO"];

        // Crear enlace a factura
        $enlace = "http://localhost/Tienda_en_linea/factura.php?numeroDeOrden=".$numeroDeOrden;

        // Contenido del correo
        $asunto = "Nueva orden";
        $mensaje = "
        <p>Estimado $nombre,</p>
        <p>Gracias por su pedido. Esta orden será enviada dentro de dos días.</p>
        <p>Haga clic aquí para ver su factura:</p>
        <a href='$enlace'>Ver factura</a>
        <br><br>
        <p>Atentamente,<br>La tienda</p>
        ";

        // Enviar correo
        enviarCorreo($correo, $nombre, $asunto, $mensaje);

        echo "<script>
        alert('Orden creada y correo enviado');
        location.href='index.php?pagina=tienda';
        </script>";

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
?>