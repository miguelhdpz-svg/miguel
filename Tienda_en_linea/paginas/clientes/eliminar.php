<?php

$id = $_GET["id"];

try{

    $sql = "DELETE FROM clientes
            WHERE id_cliente = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id]);

    echo "
    <script>
        alert('Cliente eliminado correctamente');
        location.href='index.php?pagina=clientes/listar';
    </script>
    ";

}catch(PDOException $e){

    echo "
    <script>
        alert('No se puede eliminar el cliente porque tiene pedidos registrados.');
        location.href='index.php?pagina=clientes/listar';
    </script>
    " . $e;
}

?>