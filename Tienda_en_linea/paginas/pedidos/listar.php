<?php

$sql = "

SELECT

o.id_ordenes,

c.nombre AS cliente,

e.nombre AS empleado,

o.fecha_pedido,

o.estado,

ch.modelo,

dp.precio,

t.talla,

co.color,

tu.descripcion_tuneo,

tu.imagen

FROM ordenes o

INNER JOIN clientes c
ON o.id_clientes = c.id_cliente

INNER JOIN empleados e
ON o.id_empleados = e.id_emplado

INNER JOIN detalle_pedido dp
ON o.id_ordenes = dp.id_ordenes

INNER JOIN chamarras ch
ON dp.id_chamarra = ch.id_chamarra

LEFT JOIN tallas t
ON ch.id_talla = t.id_talla

LEFT JOIN colores co
ON ch.id_color = co.id_color

LEFT JOIN tuneos tu
ON dp.id_detalle = tu.id_detalle

ORDER BY o.id_ordenes DESC

";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div style="
background:#1E1E1E;
padding:15px;
margin-bottom:20px;
text-align:center;
border-radius:10px;
">

    <a
    href="index.php?pagina=clientes/listar"
    style="
    color:white;
    text-decoration:none;
    background:#3498db;
    padding:10px 20px;
    margin:5px;
    border-radius:5px;
    display:inline-block;
    ">
    👥 Clientes
    </a>

    <a
    href="index.php?pagina=tienda"
    style="
    color:white;
    text-decoration:none;
    background:#27ae60;
    padding:10px 20px;
    margin:5px;
    border-radius:5px;
    display:inline-block;
    ">
    🧥 Tienda
    </a>

    <a
    href="logout.php"
    onclick="return confirm('¿Desea cerrar sesión?')"
    style="
    color:white;
    text-decoration:none;
    background:#e74c3c;
    padding:10px 20px;
    margin:5px;
    border-radius:5px;
    display:inline-block;
    ">
    🚪 Salir
    </a>

</div>

<div class="contenido">

<div style="width:95%">

<h2>Pedidos</h2>



<br><br>

<table>

<tr>

<th>Cliente</th>
<th>Empleado</th>
<th>Fecha</th>
<th>Estado</th>
<th>Chamarra</th>
<th>Precio</th>
<th>Talla</th>
<th>Color</th>
<th>Tuneo</th>
<th>Imagen</th>
<th>Acciones</th>

</tr>

<?php foreach($pedidos as $p){ ?>

<tr>

<td>
<?= $p["cliente"] ?>
</td>

<td>
<?= $p["empleado"] ?>
</td>

<td>
<?= $p["fecha_pedido"] ?>
</td>

<td>
<?= $p["estado"] ?>
</td>

<td>
<?= $p["modelo"] ?>
</td>

<td>
$<?= $p["precio"] ?>
</td>

<td>
<?= $p["talla"] ?>
</td>

<td>
<?= $p["color"] ?>
</td>

<td>
<?= $p["descripcion_tuneo"] ?>
</td>

<td>

<?php if(!empty($p["imagen"])){ ?>

<img
src="imagenes/<?= $p["imagen"] ?>"
width="80">

<?php } ?>

</td>

<td>

<a
href="index.php?pagina=pedidos/editar&id=<?= $p["id_ordenes"] ?>">
✏️
</a>

&nbsp;&nbsp;

<a
href="index.php?pagina=pedidos/eliminar&id=<?= $p["id_ordenes"] ?>"
onclick="return confirm('¿Eliminar pedido?')">
🗑️
</a>

&nbsp;&nbsp;

<a
href="index.php?pagina=pedidos/factura&id=<?= $p["id_ordenes"] ?>"
target="_blank">
📄
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>