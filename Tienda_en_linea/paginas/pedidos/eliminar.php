<?php

if(!isset($_GET["id"]))
{
    exit();
}

$id = $_GET["id"];

$stmt = $conexion->prepare(
"DELETE FROM ordenes
 WHERE id_ordenes = ?"
);

$stmt->execute([$id]);

echo "
<script>
    alert('Pedido eliminado');
    location.href='index.php?pagina=pedidos/listar';
</script>
";
?>