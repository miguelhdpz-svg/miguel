<?php

if(isset($_POST["guardar"]))
{
    $sql = "INSERT INTO clientes(
                nombre,
                apellido,
                telefono,
                correo
            )
            VALUES(?,?,?,?)";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        $_POST["nombre"],
        $_POST["apellido"],
        $_POST["telefono"],
        $_POST["correo"]
    ]);

    echo "
    <script>
    alert('Cliente agregado');
    location.href='index.php?pagina=perfil';
    </script>
    ";
}

?>

<div class="contenido">

<form method="POST">

<h2>Agregar Cliente</h2>

<input
type="text"
name="nombre"
placeholder="Nombre"
required>

<input
type="text"
name="apellido"
placeholder="Apellido">

<input
type="text"
name="telefono"
placeholder="Teléfono">

<input
type="email"
name="correo"
placeholder="Correo">

<input
type="submit"
name="guardar"
value="Guardar">

</form>

</div>