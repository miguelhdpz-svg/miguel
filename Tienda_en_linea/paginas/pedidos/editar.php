<?php

$id = $_GET["id"] ?? 0;

/* OBTENER PEDIDO */

$sql = "

SELECT

o.id_ordenes,
o.fecha_pedido,
o.estado,

dp.id_detalle,
dp.id_chamarra,
dp.precio,

ch.modelo,
ch.id_talla,
ch.id_color,

tu.descripcion_tuneo,
tu.imagen

FROM ordenes o

LEFT JOIN detalle_pedido dp
ON o.id_ordenes = dp.id_ordenes

LEFT JOIN chamarras ch
ON dp.id_chamarra = ch.id_chamarra

LEFT JOIN tuneos tu
ON dp.id_detalle = tu.id_detalle

WHERE o.id_ordenes = ?

";

$stmt = $conexion->prepare($sql);
$stmt->execute([$id]);

$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$pedido)
{
    die("Pedido no encontrado");
}

/* TALLAS */

$stmt = $conexion->prepare(
"SELECT * FROM tallas"
);

$stmt->execute();

$tallas = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* COLORES */

$stmt = $conexion->prepare(
"SELECT * FROM colores"
);

$stmt->execute();

$colores = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ACTUALIZAR */

if(isset($_POST["actualizar"]))
{
    $stmt = $conexion->prepare(
    "UPDATE ordenes
     SET fecha_pedido=?,
         estado=?
     WHERE id_ordenes=?"
    );

    $stmt->execute([
        $_POST["fecha_pedido"],
        $_POST["estado"],
        $id
    ]);

    $stmt = $conexion->prepare(
    "UPDATE chamarras
     SET id_talla=?,
         id_color=?
     WHERE id_chamarra=?"
    );

    $stmt->execute([
        $_POST["id_talla"],
        $_POST["id_color"],
        $pedido["id_chamarra"]
    ]);

    $stmt = $conexion->prepare(
    "UPDATE tuneos
     SET descripcion_tuneo=?,
         imagen=?
     WHERE id_detalle=?"
    );

    $stmt->execute([
        $_POST["descripcion_tuneo"],
        $_POST["imagen"],
        $pedido["id_detalle"]
    ]);

    echo "
    <script>
    alert('Pedido actualizado correctamente');
    location.href='index.php?pagina=pedidos/listar';
    </script>
    ";
}

?>

<h2 id="titulo_de_pagina">
Editar Pedido
</h2>

<a
href="index.php?pagina=pedidos/listar"
style="
background:#3498db;
color:white;
padding:10px 15px;
text-decoration:none;
border-radius:5px;
display:inline-block;
margin-bottom:20px;
">
⬅ Regresar a Pedidos
</a>

<div class="contenido">

<form method="POST">

<label>Fecha</label>

<input
type="datetime-local"
name="fecha_pedido"
value="<?= date('Y-m-d\TH:i', strtotime($pedido['fecha_pedido'])) ?>"
required>

<label>Estado</label>

<select name="estado">

<option
value="Pendiente"
<?= ($pedido["estado"]=="Pendiente") ? "selected" : "" ?>>
Pendiente
</option>

<option
value="En producción"
<?= ($pedido["estado"]=="En producción") ? "selected" : "" ?>>
En producción
</option>

<option
value="Terminado"
<?= ($pedido["estado"]=="Terminado") ? "selected" : "" ?>>
Terminado
</option>

<option
value="Entregado"
<?= ($pedido["estado"]=="Entregado") ? "selected" : "" ?>>
Entregado
</option>

</select>

<label>Chamarra</label>

<input
type="text"
value="<?= $pedido["modelo"] ?>"
readonly>

<label>Precio</label>

<input
type="text"
value="$<?= $pedido["precio"] ?>"
readonly>

<label>Talla</label>

<select name="id_talla">

<?php foreach($tallas as $t){ ?>

<option
value="<?= $t["id_talla"] ?>"
<?= ($pedido["id_talla"]==$t["id_talla"]) ? "selected" : "" ?>>

<?= $t["talla"] ?>

</option>

<?php } ?>

</select>

<label>Color</label>

<select name="id_color">

<?php foreach($colores as $c){ ?>

<option
value="<?= $c["id_color"] ?>"
<?= ($pedido["id_color"]==$c["id_color"]) ? "selected" : "" ?>>

<?= $c["color"] ?>

</option>

<?php } ?>

</select>

<label>Tuneo</label>

<textarea
name="descripcion_tuneo"><?= $pedido["descripcion_tuneo"] ?? "" ?></textarea>

<label>Imagen</label>

<input
type="text"
name="imagen"
value="<?= $pedido["imagen"] ?? "" ?>"
placeholder="imagen.jpg">

<br><br>

<input
type="submit"
name="actualizar"
value="Actualizar Pedido">

</form>

</div>