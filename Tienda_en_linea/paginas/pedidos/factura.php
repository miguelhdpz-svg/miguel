<?php

$id = $_GET["id"];

/* DATOS DEL PEDIDO */

$sql = "
SELECT

o.id_ordenes,
o.fecha_pedido,
o.estado,

c.nombre AS cliente_nombre,
c.apellido AS cliente_apellido,
c.correo,
c.telefono,

e.nombre AS empleado_nombre,
e.apellido AS empleado_apellido,

ch.modelo,
ch.material,

dp.cantidad,
dp.precio,

t.descripcion_tuneo,
t.imagen

FROM ordenes o

INNER JOIN clientes c
ON o.id_clientes = c.id_cliente

INNER JOIN empleados e
ON o.id_empleados = e.id_emplado

INNER JOIN detalle_pedido dp
ON o.id_ordenes = dp.id_ordenes

INNER JOIN chamarras ch
ON dp.id_chamarra = ch.id_chamarra

LEFT JOIN tuneos t
ON dp.id_detalle = t.id_detalle

WHERE o.id_ordenes = ?
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$id]);

$factura = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$factura)
{
    echo "<h2>Factura no encontrada</h2>";
    exit();
}

$total = $factura["cantidad"] * $factura["precio"];

?>

<div class="contenido">

<div style="
width:80%;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0px 0px 10px #ccc;
">

<h1>FACTURA</h1>

<hr>

<h3>Datos del Cliente</h3>

<p>
<b>Nombre:</b>
<?= $factura["cliente_nombre"] ?>
<?= $factura["cliente_apellido"] ?>
</p>

<p>
<b>Correo:</b>
<?= $factura["correo"] ?>
</p>

<p>
<b>Teléfono:</b>
<?= $factura["telefono"] ?>
</p>

<hr>

<h3>Datos del Pedido</h3>

<p>
<b>Folio:</b>
<?= $factura["id_ordenes"] ?>
</p>

<p>
<b>Fecha:</b>
<?= $factura["fecha_pedido"] ?>
</p>

<p>
<b>Estado:</b>
<?= $factura["estado"] ?>
</p>

<p>
<b>Empleado:</b>
<?= $factura["empleado_nombre"] ?>
<?= $factura["empleado_apellido"] ?>
</p>

<hr>

<h3>Producto</h3>

<table border="1" width="100%">

<tr>
<th>Modelo</th>
<th>Material</th>
<th>Cantidad</th>
<th>Precio</th>
<th>Total</th>
</tr>

<tr>
<td><?= $factura["modelo"] ?></td>
<td><?= $factura["material"] ?></td>
<td><?= $factura["cantidad"] ?></td>
<td>$<?= $factura["precio"] ?></td>
<td>$<?= $total ?></td>
</tr>

</table>

<hr>

<h3>Tuneo</h3>

<p>
<?= $factura["descripcion_tuneo"] ?>
</p>

<?php
if(!empty($factura["imagen"]))
{
?>
<img
src="imagenes/<?= $factura["imagen"] ?>"
width="250">
<?php
}
?>

<hr>

<h2>
TOTAL A PAGAR:
$<?= number_format($total,2) ?>
</h2>

<br>

<button onclick="window.print()">
🖨️ Imprimir Factura
</button>

</div>

</div>