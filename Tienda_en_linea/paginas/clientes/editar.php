<?php

$id = $_GET["id"];

$stmt = $conexion->prepare(
"SELECT * FROM clientes
 WHERE id_cliente=?"
);

$stmt->execute([$id]);

$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$cliente)
{
    die("Cliente no encontrado");
}

if(isset($_POST["actualizar"]))
{
    $sql = "UPDATE clientes SET
            nombre=?,
            apellido=?,
            telefono=?,
            correo=?
            WHERE id_cliente=?";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        $_POST["nombre"],
        $_POST["apellido"],
        $_POST["telefono"],
        $_POST["correo"],
        $id
    ]);

    echo "
    <script>
    alert('Cliente actualizado');
    location.href='index.php?pagina=clientes/listar';
    </script>
    ";
}

?>

<h2 id="titulo_de_pagina">
Editar Cliente
</h2>

<a
href="index.php?pagina=clientes/listar"
style="
background:#3498db;
color:white;
padding:10px 15px;
text-decoration:none;
border-radius:5px;
display:inline-block;
margin-bottom:20px;
">
⬅ Regresar a Clientes
</a>

<div class="contenido">

<form method="POST">

<input
type="text"
name="nombre"
value="<?= $cliente['nombre'] ?>"
placeholder="Nombre"
required>

<input
type="text"
name="apellido"
value="<?= $cliente['apellido'] ?>"
placeholder="Apellido">

<input
type="text"
name="telefono"
value="<?= $cliente['telefono'] ?>"
placeholder="Teléfono">

<input
type="email"
name="correo"
value="<?= $cliente['correo'] ?>"
placeholder="Correo electrónico">

<input
type="submit"
name="actualizar"
value="Actualizar Cliente">

</form>

</div>