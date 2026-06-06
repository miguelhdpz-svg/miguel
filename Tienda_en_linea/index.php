<?php
session_start();
include_once("conexion.php");
include_once("funciones.php");

$pagina = $_GET["pagina"] ?? "login";

/* dividir ruta */
$partes = explode("/", $pagina);

$archivo = "paginas/" . $partes[0] . ".php";

if(isset($partes[1])){
    $archivo = "paginas/" . $partes[0] . "/" . $partes[1] . ".php";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tienda en Línea</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<?php

if(file_exists($archivo)){
    include($archivo);
}else{
    echo "<div class='contenido'><h2>Página no encontrada</h2></div>";
}

?>

</body>
</html>