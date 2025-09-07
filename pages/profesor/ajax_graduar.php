<?php
// ajax_graduar.php

include("../../backend/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['graduar'], $_POST['id'], $_POST['curso_id'])) {
    $id = intval($_POST['id']);
    $curso_id = intval($_POST['curso_id']);
    mysqli_query($conex, "UPDATE curso_participante SET graduado=1 WHERE id=$id AND id_curso_promocion=$curso_id");

    // Obtener id_estudiante
    $res = mysqli_query($conex, "SELECT id_estudiante FROM curso_participante WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    $id_estudiante = intval($row['id_estudiante']);

    // Obtener nombre del curso
    $resCurso = mysqli_query($conex, "SELECT c.nombre FROM curso_promocion cp JOIN curso c ON cp.id_curso = c.id WHERE cp.id = $curso_id");
    $rowCurso = mysqli_fetch_assoc($resCurso);
    $nombreCurso = $rowCurso['nombre'];

    // Insertar notificación
    $mensaje = "¡Felicidades! Ahora puedes descargar el certificado del curso: $nombreCurso";
    mysqli_query($conex, "INSERT INTO notificacion (id_estudiante, mensaje) VALUES ($id_estudiante, '" . mysqli_real_escape_string($conex, $mensaje) . "')");

    exit;
}

if (isset($_GET['curso_id'])) {
    $curso_id = intval($_GET['curso_id']);
    
$q = mysqli_query($conex, "
    SELECT cp.id, u.nombre, u.apellido, u.cedula, u.telefono, cp.graduado
    FROM curso_participante cp
    JOIN estudiante e ON cp.id_estudiante = e.id
    JOIN usuario u ON e.usuario_id = u.id
    WHERE cp.id_curso_promocion = $curso_id
");
echo "<table>";
echo "<tr>
        <th>Nombre</th>
        <th>Cédula</th>
        <th>Teléfono</th>
        <th>Acción</th>
    </tr>";
while ($row = mysqli_fetch_assoc($q)) {
    echo "<tr>
        <td>".htmlspecialchars($row['nombre'].' '.$row['apellido'])."</td>
        <td>".htmlspecialchars($row['cedula'])."</td>
        <td>".htmlspecialchars($row['telefono'])."</td>
        <td>";
    if ($row['graduado']) {
        echo "<span class='graduado-label'>Graduado</span> <a href='/imaf-project/backend/descargar_certificado.php?participante_id={$row['id']}' class='btn-certificado' style='background:#43a047;color:#fff;font-weight:bold;border:none;padding:6px 16px;border-radius:8px;cursor:pointer;'>Descargar certificado</a>";
    } else {
        echo "<button onclick='graduarParticipante({$row['id']}, $curso_id, this)' style='background:#43a047;color:#fff;font-weight:bold;border:none;padding:6px 16px;border-radius:8px;cursor:pointer;'>Graduar</button>";
    }
    echo "</td></tr>";
}
echo "</table>";
    exit;
}


?>