<?php
include("../backend/conexion.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso_id = intval($_POST['curso_id']);
    $fecha_inicio = mysqli_real_escape_string($conex, $_POST['fecha_inicio']);
    mysqli_query($conex, "UPDATE curso_promocion SET fecha_inicio='$fecha_inicio' WHERE id=$curso_id");
    echo "ok";
}
?>