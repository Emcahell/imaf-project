<?php
// filepath: c:\xampp\htdocs\imaf-project\pages\profesor\ajax_participantes.php
include("../../backend/conexion.php");

if (isset($_GET['curso_id'])) {
    $curso_id = intval($_GET['curso_id']);
    $filtro = mysqli_real_escape_string($conex, $_GET['filtro'] ?? '');
    $where = "";
    if ($filtro) {
        $where = "AND (u.cedula LIKE '%$filtro%' OR u.nombre LIKE '%$filtro%' OR u.apellido LIKE '%$filtro%')";
    }
    $q = mysqli_query($conex, "SELECT cp.id, u.cedula, u.nombre, u.apellido, u.telefono
        FROM curso_participante cp
        JOIN estudiante e ON cp.id_estudiante = e.id
        JOIN usuario u ON e.usuario_id = u.id
        WHERE cp.id_curso_promocion = $curso_id $where
        ORDER BY u.apellido, u.nombre");
    echo "<table style='width:100%;border-collapse:collapse;'>";
    echo "<tr style='background:#f7f7f7;'><th>Nombre</th><th>Apellido</th><th>Cédula</th><th>Teléfono</th><th></th></tr>";
    while ($row = mysqli_fetch_assoc($q)) {
        echo "<tr style='border-bottom:1px solid #eee;'>";
        echo "<td>".htmlspecialchars($row['nombre'])."</td>";
        echo "<td>".htmlspecialchars($row['apellido'])."</td>";
        echo "<td>".htmlspecialchars($row['cedula'])."</td>";
        echo "<td>".htmlspecialchars($row['telefono'])."</td>";
        echo "<td><button onclick='eliminarParticipante({$row['id']}, $curso_id)' style='background:#ffb3b3;color:#222;border:none;padding:4px 14px;border-radius:6px;cursor:pointer;'>Eliminar</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    exit;
}

if (isset($_POST['eliminar'], $_POST['id'], $_POST['curso_id'])) {
    $id = intval($_POST['id']);
    $curso_id = intval($_POST['curso_id']);
    mysqli_query($conex, "DELETE FROM curso_participante WHERE id=$id");
    $_GET['curso_id'] = $curso_id;
    include __FILE__;
    exit;
}

if (isset($_POST['agregar'], $_POST['curso_id'], $_POST['cedula_estudiante'])) {
    $curso_id = intval($_POST['curso_id']);
    $cedula = mysqli_real_escape_string($conex, $_POST['cedula_estudiante']);
    $q = mysqli_query($conex, "SELECT e.id FROM estudiante e JOIN usuario u ON e.usuario_id = u.id WHERE u.cedula = '$cedula'");
    if ($row = mysqli_fetch_assoc($q)) {
        $id_estudiante = $row['id'];
        $q2 = mysqli_query($conex, "SELECT * FROM curso_participante WHERE id_curso_promocion = $curso_id AND id_estudiante = $id_estudiante");
        if (mysqli_num_rows($q2) == 0) {
            mysqli_query($conex, "INSERT INTO curso_participante (id_curso_promocion, id_estudiante) VALUES ($curso_id, $id_estudiante)");
        }
    }
    $_GET['curso_id'] = $curso_id;
    include __FILE__;
    exit;
}
?>