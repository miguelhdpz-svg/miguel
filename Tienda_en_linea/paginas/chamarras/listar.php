<?php

$sql = "SELECT * FROM chamarras";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$chamarras = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="contenido">
<div style="width:90%">

<h2>Chamarras</h2>

<a class="agregar" href="index.php?pagina=chamarras/agregar">+</a>

<table>

<tr>
    <th>ID</th>
    <th>Modelo</th>
    <th>Precio</th>
    <th>Stock</th>
    <th>Acciones</th>
</tr>

<?php if(count($chamarras) > 0){ ?>

    <?php foreach($chamarras as $c){ ?>

    <tr>
        <td><?= $c["id_chamarra"] ?></td>
        <td><?= $c["modelo"] ?></td>
        <td>$<?= $c["precio"] ?></td>
        <td><?= $c["stock"] ?></td>

        <td>

           <a href="index.php?pagina=chamarras/editar&id=<?= $c['id_chamarra'] ?>">✏️</a>

			<a href="index.php?pagina=chamarras/eliminar&id=<?= $c['id_chamarra'] ?>"
				onclick="return confirm('¿Eliminar esta chamarra?')">🗑️</a>

        </td>
    </tr>

    <?php } ?>

<?php } else { ?>

<tr>
    <td colspan="5">No hay chamarras registradas</td>
</tr>

<?php } ?>

</table>

</div>
</div>