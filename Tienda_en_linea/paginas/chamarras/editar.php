<?php

$id = $_GET["id"];

/* OBTENER DATOS DE LA CHAMARRA */
$stmt = $conexion->prepare("SELECT * FROM chamarras WHERE id_chamarra = ?");
$stmt->execute([$id]);
$chamarra = $stmt->fetch(PDO::FETCH_ASSOC);

/* ACTUALIZAR */
if(isset($_POST["actualizar"]))
{
    try{

        $sql = "UPDATE chamarras SET
                    modelo = ?,
                    material = ?,
                    precio = ?,
                    stock = ?,
                    id_talla = ?,
                    id_color = ?
                WHERE id_chamarra = ?";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $_POST["modelo"],
            $_POST["material"],
            $_POST["precio"],
            $_POST["stock"],
            $_POST["id_talla"],
            $_POST["id_color"],
            $id
        ]);

        echo "<script>
            alert('Chamarra actualizada');
            location.href='index.php?pagina=chamarras/listar';
        </script>";

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

/* DATOS PARA SELECTS */
$tallas = $conexion->query("SELECT * FROM tallas")->fetchAll(PDO::FETCH_ASSOC);
$colores = $conexion->query("SELECT * FROM colores")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="contenido">

<form method="POST">

<h2>Editar Chamarra</h2>

<input type="text" name="modelo" value="<?= $chamarra["modelo"] ?>" required>

<input type="text" name="material" value="<?= $chamarra["material"] ?>" required>

<input type="number" step="0.01" name="precio" value="<?= $chamarra["precio"] ?>" required>

<input type="number" name="stock" value="<?= $chamarra["stock"] ?>" required>

<!-- TALLAS -->
<select name="id_talla">
    <?php foreach($tallas as $t){ ?>
        <option value="<?= $t["id_talla"] ?>"
        <?= $t["id_talla"] == $chamarra["id_talla"] ? "selected" : "" ?>>
            <?= $t["talla"] ?>
        </option>
    <?php } ?>
</select>

<!-- COLORES -->
<select name="id_color">
    <?php foreach($colores as $c){ ?>
        <option value="<?= $c["id_color"] ?>"
        <?= $c["id_color"] == $chamarra["id_color"] ? "selected" : "" ?>>
            <?= $c["color"] ?>
        </option>
    <?php } ?>
</select>

<input type="submit" name="actualizar" value="Actualizar">

</form>

</div>