<?php
include("../backend/conexion.php");
session_start();
$usuario_id = $_SESSION['usuario_id'];

$curso_id = $_POST['curso_id'];
$referencia = $_POST['referencia_pago'];
$estado = 'pendiente';

$comprobante = '';
$carpeta = $_SERVER['DOCUMENT_ROOT'] . "/imaf-project/uploads/comprobantes/";
if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}
if (isset($_FILES['comprobante_pago']) && $_FILES['comprobante_pago']['error'] == 0) {
    $nombreArchivo = uniqid() . '_' . $_FILES['comprobante_pago']['name'];
    move_uploaded_file($_FILES['comprobante_pago']['tmp_name'], $carpeta . $nombreArchivo);
    $comprobante = $nombreArchivo;
}

// Verifica si el estudiante existe en la tabla estudiante
$check = mysqli_query($conex, "SELECT id FROM estudiante WHERE usuario_id = $usuario_id");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($conex, "INSERT INTO estudiante (usuario_id) VALUES ($usuario_id)");
    // Obtener el id recién insertado
    $estudiante_id = mysqli_insert_id($conex);
} else {
    $row = mysqli_fetch_assoc($check);
    $estudiante_id = $row['id'];
}

// Inserta la solicitud en la tabla inscripcion
$query = "INSERT INTO inscripcion (id_estudiante, id_curso_promocion, comprobante, referencia, estado) VALUES ($estudiante_id, $curso_id, '$comprobante', '$referencia', '$estado')";
mysqli_query($conex, $query);

header("Location: ../pages/estudiante/solicitudes.php");
exit;