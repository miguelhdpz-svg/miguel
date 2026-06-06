<?php

$id_chamarra = $_GET["id"] ?? 0;

/* CHAMARRA SELECCIONADA */

$stmt = $conexion->prepare(
"SELECT * FROM chamarras
WHERE id_chamarra = ?"
);

$stmt->execute([$id_chamarra]);

$chamarra = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$chamarra)
{
    echo "<h2>Chamarra no encontrada</h2>";
    exit();
}

/* GUARDAR PEDIDO */

if(isset($_POST["guardar"]))
{
    try{

        $sql = "INSERT INTO ordenes(
                    id_clientes,
                    id_empleados,
                    estado
                )
                VALUES(
                    ?, ?, ?
                )";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $_POST["id_clientes"],
            $_POST["id_empleados"],
            $_POST["estado"]
        ]);

        $id_orden = $conexion->lastInsertId();

        $sql = "INSERT INTO detalle_pedido(
                    id_chamarra,
                    cantidad,
                    precio,
                    id_ordenes
                )
                VALUES(
                    ?, ?, ?, ?
                )";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $chamarra["id_chamarra"],
            1,
            $chamarra["precio"],
            $id_orden
        ]);

        $id_detalle = $conexion->lastInsertId();

        $sql = "UPDATE chamarras
                SET id_talla = ?,
                    id_color = ?
                WHERE id_chamarra = ?";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $_POST["id_talla"],
            $_POST["id_color"],
            $chamarra["id_chamarra"]
        ]);

        $sql = "INSERT INTO tuneos(
                    id_detalle,
                    nombre_tuneo,
                    descripcion_tuneo,
                    imagen
                )
                VALUES(
                    ?, ?, ?, ?
                )";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $id_detalle,
            "Personalizado",
            $_POST["descripcion_tuneo"],
            $_POST["imagen"]
        ]);

        echo "
        <script>
        alert('Pedido agregado correctamente');
        location.href='index.php?pagina=pedidos/listar';
        </script>
        ";

    }catch(PDOException $e){

        echo $e->getMessage();
    }
}

/* CLIENTES */

$stmt = $conexion->prepare(
"SELECT * FROM clientes"
);

$stmt->execute();

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* EMPLEADOS */

$stmt = $conexion->prepare(
"SELECT * FROM empleados"
);

$stmt->execute();

$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

?>

<div class="contenido">

<form method="POST">

<h2 id="titulo_de_pagina">
Agregar Pedido
</h2>

<a
href="index.php?pagina=tienda"
style="
background:#3498db;
color:white;
padding:10px 15px;
text-decoration:none;
border-radius:5px;
display:inline-block;
margin-bottom:20px;
">
⬅ Regresar a Tienda
</a>
<hr>
<br><br>

<select name="id_clientes" required>

<option value="">
Seleccione Cliente
</option>

<?php foreach($clientes as $cliente){ ?>

<option value="<?= $cliente["id_cliente"] ?>">

<?= $cliente["nombre"] ?>
<?= $cliente["apellido"] ?>

</option>

<?php } ?>

</select>

<br><br>

<select name="id_empleados" required>

<option value="">
Seleccione Empleado
</option>

<?php foreach($empleados as $empleado){ ?>

<option value="<?= $empleado["id_emplado"] ?>">

<?= $empleado["nombre"] ?>
<?= $empleado["apellido"] ?>

</option>

<?php } ?>

</select>




<h3>Chamarra Seleccionada</h3>

<p>
<strong>Modelo:</strong>
<?= $chamarra["modelo"] ?>
</p>

<p>
<strong>Material:</strong>
<?= $chamarra["material"] ?>
</p>

<p>
<strong>Precio:</strong>
$<?= $chamarra["precio"] ?>
</p>

<input
type="hidden"
name="id_chamarra"
value="<?= $chamarra["id_chamarra"] ?>">

<select name="id_talla" required>

<option value="">
Seleccione Talla
</option>

<?php foreach($tallas as $t){ ?>

<option value="<?= $t["id_talla"] ?>">
<?= $t["talla"] ?>
</option>

<?php } ?>

</select>

<select name="id_color" required>

<option value="">
Seleccione Color
</option>

<?php foreach($colores as $c){ ?>

<option value="<?= $c["id_color"] ?>">
<?= $c["color"] ?>
</option>

<?php } ?>

</select>

<textarea
name="descripcion_tuneo"
placeholder="Descripción del tuneo"></textarea>

<input
type="text"
name="imagen"
placeholder="nombre_imagen.jpg">

<select name="estado">

<option value="Pendiente">
Pendiente
</option>

<option value="En producción">
En producción
</option>

<option value="Terminado">
Terminado
</option>

<option value="Entregado">
Entregado
</option>

</select>

<input
type="submit"
name="guardar"
value="Guardar Pedido">

</form>

</div>