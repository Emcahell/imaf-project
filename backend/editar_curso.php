<?php

include(__DIR__ . "/../backend/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso_id = intval($_POST['curso_id']);
    $nombre_curso = mysqli_real_escape_string($conex, $_POST['nombre_curso']);
    $id_profesor = intval($_POST['id_profesor']);
    $fecha_inicio = mysqli_real_escape_string($conex, $_POST['fecha_inicio']);
    $fecha_fin = mysqli_real_escape_string($conex, $_POST['fecha_fin']);
    $cupos = intval($_POST['cupos']);
    $precio = floatval($_POST['precio']);
    $oferta = isset($_POST['oferta']) ? 1 : 0; // <-- NUEVO


    // Actualiza curso_promocion (sin nombre)
    $sql = "UPDATE curso_promocion SET 
            id_profesor = $id_profesor,
            fecha_inicio = '$fecha_inicio',
            fecha_fin = '$fecha_fin',
            cupos = $cupos,
            precio = $precio,
            oferta = $oferta
        WHERE id = $curso_id";
    $result = mysqli_query($conex, $sql);

    // Actualiza el nombre en la tabla curso si es necesario
    if ($result) {
        // Busca el id_curso relacionado
        $q = mysqli_query($conex, "SELECT id_curso FROM curso_promocion WHERE id = $curso_id");
        $row = mysqli_fetch_assoc($q);
        if ($row) {
            $id_curso = intval($row['id_curso']);
            mysqli_query($conex, "UPDATE curso SET nombre = '$nombre_curso' WHERE id = $id_curso");
        }
        header("Location: ../pages/admin/cursos.php?tab=activos&edit=success");
        exit;
    } else {
        header("Location: ../pages/admin/cursos.php?tab=activos&edit=error");
        exit;
    }
} else {
    header("Location: ../pages/admin/cursos.php");
    exit;
}