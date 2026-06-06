<?php
$id = $_GET["id"];

$stmt = $conexion->prepare("DELETE FROM chamarras WHERE id_chamarra=?");
$stmt->execute([$id]);

echo "<script>location.href='index.php?pagina=chamarras/listar';</script>";
?>