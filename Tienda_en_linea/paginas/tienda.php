<?php

$sql = "SELECT * FROM chamarras";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$chamarras = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- MENÚ SUPERIOR -->

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
    href="index.php?pagina=pedidos/listar"
    style="
    color:white;
    text-decoration:none;
    background:#27ae60;
    padding:10px 20px;
    margin:5px;
    border-radius:5px;
    display:inline-block;
    ">
    📦 Órdenes
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

<div class="contenedor-tienda">

<h2>Chamarras disponibles</h2>

<?php foreach($chamarras as $c){ ?>

<div style="
display:flex;
align-items:center;
justify-content:center;
gap:20px;
background:white;
padding:20px;
margin:15px auto;
border-radius:10px;
box-shadow:0px 0px 10px rgba(0,0,0,0.2);
width:80%;
">

    <div>

        <?php if(!empty($c["imagen"])){ ?>

        <img
        src="imagenes/<?= $c["imagen"] ?>"
        alt="<?= $c["modelo"] ?>"
        width="220"
        style="border-radius:10px;">

        <?php } ?>

    </div>

    <div style="text-align:left;">

        <h3><?= $c["modelo"] ?></h3>

        <p>
        <strong>Material:</strong>
        <?= $c["material"] ?>
        </p>

        <p>
        <strong>Precio:</strong>
        $<?= number_format($c["precio"],2) ?>
        </p>

        <p>
        <strong>Stock:</strong>
        <?= $c["stock"] ?>
        </p>

        <a
        href="index.php?pagina=pedidos/agregar&id=<?= $c["id_chamarra"] ?>"
        style="
        background:#27ae60;
        color:white;
        text-decoration:none;
        padding:10px 20px;
        border-radius:5px;
        display:inline-block;
        ">
        🛒 Comprar
        </a>

    </div>

</div>

<?php } ?>

</div>

</div>