<?php
include("conexion.php");

if(isset($_GET["numeroDeOrden"])){

    $numeroDeOrden = $_GET["numeroDeOrden"];

    $sql = "SELECT * FROM orden WHERE numero_de_orden = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$numeroDeOrden]);
    $orden = $stmt->fetch(PDO::FETCH_ASSOC);

    if($orden){
        echo "<h2>Factura</h2>";
        echo "<p>Orden #: ".$orden["numero_de_orden"]."</p>";
        echo "<p>Cliente #: ".$orden["numero_de_cliente"]."</p>";
        echo "<p>Fecha: ".$orden["fecha"]."</p>";
    }else{
        echo "Orden no encontrada";
    }

}else{
    echo "No se recibió número de orden";
}
?>