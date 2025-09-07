<?php

session_start();
include("conexion.php");
$usuario_id = $_SESSION['usuario_id'];
$qEst = mysqli_query($conex, "SELECT id FROM estudiante WHERE usuario_id = $usuario_id");
$rowEst = mysqli_fetch_assoc($qEst);
$estudiante_id = $rowEst['id'];
mysqli_query($conex, "UPDATE notificacion SET leida = 1 WHERE id_estudiante = $estudiante_id AND leida = 0");
?>