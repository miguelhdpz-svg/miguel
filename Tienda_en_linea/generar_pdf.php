<?php
ob_clean();
ob_start(); // iniciar buffer

include_once("../conexion.php");
include("../bibliotecas/MPDF60/mpdf.php");

$informe = $_GET["informe"];

include $informe . ".php";
$contenido = ob_get_clean(); // guardar y luego limpiar buffer

$mpdf = new mPDF();
$mpdf->SetDisplayMode("fullpage");
$mpdf->AddPage();
$mpdf->WriteHTML($contenido);
$mpdf->Output("../informes/" . $informe . ".pdf", "F");

echo "<script>window.open('../informes/" . $informe . ".pdf');</script>";
echo "<script>location.href='../index.php?pagina=mostrar_informes';</script>";
?>
