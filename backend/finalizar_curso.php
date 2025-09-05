<?php
include("conexion.php");
session_start();

date_default_timezone_set('America/New_York');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_curso'])) {
    $curso_id = intval($_POST['finalizar_curso']);
    $fecha_actual = date('Y-m-d');
    // Cambia el estado a terminado y actualiza la fecha de fin
    $sql = "UPDATE curso_promocion SET estado = 'terminado', fecha_fin = '$fecha_actual' WHERE id = $curso_id";
    mysqli_query($conex, $sql);
    header("Location: ../pages/profesor/cursos.php?finalizado=success");
    exit;
}
?>