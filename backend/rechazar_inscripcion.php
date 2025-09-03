<?php
include("../backend/conexion.php");
session_start();

if (isset($_POST['inscripcion_id'])) {
    $inscripcion_id = intval($_POST['inscripcion_id']);
    // Actualizar estado a rechazada
    mysqli_query($conex, "UPDATE inscripcion SET estado = 'rechazada' WHERE id = $inscripcion_id");
}

header("Location: ../pages/admin/solicitudes.php");
exit;