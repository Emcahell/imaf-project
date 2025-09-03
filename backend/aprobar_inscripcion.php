<?php
include("../backend/conexion.php");
session_start();

if (isset($_POST['inscripcion_id'])) {
    $inscripcion_id = intval($_POST['inscripcion_id']);

    // Obtener datos de la inscripción
    $query = "SELECT id_estudiante, id_curso_promocion FROM inscripcion WHERE id = $inscripcion_id";
    $result = mysqli_query($conex, $query);
    $inscripcion = mysqli_fetch_assoc($result);

    if ($inscripcion) {
        // Actualizar estado a aprobada
        mysqli_query($conex, "UPDATE inscripcion SET estado = 'aprobada' WHERE id = $inscripcion_id");

        // Insertar en curso_participante si no existe
        $id_estudiante = $inscripcion['id_estudiante'];
        $id_curso_promocion = $inscripcion['id_curso_promocion'];
        $check = mysqli_query($conex, "SELECT id FROM curso_participante WHERE id_estudiante = $id_estudiante AND id_curso_promocion = $id_curso_promocion");
        if (mysqli_num_rows($check) == 0) {
            mysqli_query($conex, "INSERT INTO curso_participante (id_estudiante, id_curso_promocion) VALUES ($id_estudiante, $id_curso_promocion)");
        }
    }
}

header("Location: ../pages/admin/solicitudes.php");
exit;