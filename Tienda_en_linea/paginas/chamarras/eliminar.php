<?php

$id = $_GET["id"];

try{

    $sql = "DELETE FROM chamarras WHERE id_chamarra = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id]);

    echo "<script>
        alert('Chamarra eliminada');
        location.href='index.php?pagina=chamarras/listar';
    </script>";

}catch(PDOException $e){
    echo $e->getMessage();
}

?>