<?php

$sql = "SELECT * FROM clientes";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div style="
background:#1E1E1E;
padding:15px;
margin-bottom:20px;
text-align:center;
border-radius:10px;
">

    <a
    href="index.php?pagina=pedidos/listar"
    style="
    color:white;
    text-decoration:none;
    background:#3498db;
    padding:10px 20px;
    margin:5px;
    border-radius:5px;
    display:inline-block;
    ">
    📦 Órdenes
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

<hr>

<h2>Clientes Registrados</h2>

<a class="agregar"
href="index.php?pagina=clientes/agregar">
+
</a>

<br><br>

<?php if(isset($clientes) && count($clientes) > 0){ ?>

<table>

<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Teléfono</th>
    <th>Correo</th>
    <th>Acciones</th>
</tr>

<?php foreach($clientes as $cliente){ ?>

<tr>

<td><?= $cliente["id_cliente"] ?></td>
<td><?= $cliente["nombre"] ?></td>
<td><?= $cliente["apellido"] ?></td>
<td><?= $cliente["telefono"] ?></td>
<td><?= $cliente["correo"] ?></td>

<td>

<a href="index.php?pagina=clientes/editar&id=<?= $cliente['id_cliente'] ?>">
✏️
</a>

&nbsp;&nbsp;

<a href="index.php?pagina=clientes/eliminar&id=<?= $cliente['id_cliente'] ?>"
onclick="return confirm('¿Desea eliminar este cliente y todos sus pedidos?')">
🗑️
</a>

</td>

</tr>

<?php } ?>

</table>

<?php } else { ?>

<p>No hay clientes registrados.</p>

<?php } ?>