<?php
if(isset($_POST["guardar"])){

$sql = "INSERT INTO chamarras(modelo,material,precio,stock,id_talla,id_color)
VALUES (?,?,?,?,?,?)";

$stmt = $conexion->prepare($sql);
$stmt->execute([
$_POST["modelo"],
$_POST["material"],
$_POST["precio"],
$_POST["stock"],
$_POST["id_talla"],
$_POST["id_color"]
]);

echo "<script>location.href='index.php?pagina=chamarras/listar';</script>";
}
?>

<div class="contenido">
<form method="POST">

<h2>Agregar Chamarra</h2>

<input name="modelo">
<input name="material">
<input name="precio">
<input name="stock">

<input name="id_talla">
<input name="id_color">

<input type="submit" name="guardar" value="Guardar">

</form>
</div>