<?php

include("conexion.php");
$alerta = ''; // Inicializa la variable

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["crear-curso"])) {
    $nombreCurso = $_POST["nombre-curso"];
    $profesorId = $_POST["profesor"];
    $fechaInicio = $_POST["fecha-inicio"];
    $fechaFin = $_POST["fecha-fin"];
    $cupos = $_POST["cupos"];
    $precio = $_POST["precio"];
    $oferta = isset($_POST['oferta']) ? 1 : 0;

    // Manejo de la imagen
    $imagenNombre = null;
    $rutaCarpeta = realpath(__DIR__ . '/../uploads/cursos');
    if ($rutaCarpeta === false) {
        $rutaCarpeta = __DIR__ . '/../uploads/cursos';
        if (!is_dir($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0777, true);
        }
    }
    if (isset($_FILES["imagen-curso"]) && $_FILES["imagen-curso"]["error"] == 0) {
        $imagenTmp = $_FILES["imagen-curso"]["tmp_name"];
        $imagenNombre = uniqid() . "_" . basename($_FILES["imagen-curso"]["name"]);
        $rutaDestino = $rutaCarpeta . DIRECTORY_SEPARATOR . $imagenNombre;
        move_uploaded_file($imagenTmp, $rutaDestino);
    }
    // 1. Insertar el curso base si no existe
    $stmt = $conex->prepare("SELECT id FROM curso WHERE nombre = ?");
    $stmt->bind_param("s", $nombreCurso);
    $stmt->execute();
    $stmt->bind_result($cursoId);
    if (!$stmt->fetch()) {
        $stmt->close();
        $stmtInsert = $conex->prepare("INSERT INTO curso (nombre) VALUES (?)");
        $stmtInsert->bind_param("s", $nombreCurso);
        $stmtInsert->execute();
        $cursoId = $stmtInsert->insert_id;
        $stmtInsert->close();
    } else {
        $stmt->close();
    }

    // 2. Insertar la promoción del curso
    $stmtPromo = $conex->prepare("INSERT INTO curso_promocion (id_curso, imagen, id_profesor, fecha_inicio, fecha_fin, cupos, precio, oferta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtPromo->bind_param("isissidi", $cursoId, $imagenNombre, $profesorId, $fechaInicio, $fechaFin, $cupos, $precio, $oferta);
    $stmtPromo->execute();
    $stmtPromo->close();

    // Mostrar mensaje de éxito con SweetAlert2
$alerta = "<script>
Swal.fire({
    title: '¡Curso creado!',
    text: 'El curso se registró correctamente.',
    icon: 'success',
    confirmButtonText: 'Aceptar'
});
</script>";
}
?>