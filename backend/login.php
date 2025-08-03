<?php
include("conexion.php");

$alerta = ''; // Inicializa la variable

if (isset($_POST['login'])) {
    $cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
    $contraseña = isset($_POST['contraseña']) ? trim($_POST['contraseña']) : '';

    // Buscar en estudiante
    $consulta_est = "SELECT u.*, 'estudiante' AS rol FROM usuario u INNER JOIN estudiante e ON u.id = e.usuario_id WHERE u.cedula='$cedula' AND u.contraseña='$contraseña'";
    $resultado_est = mysqli_query($conex, $consulta_est);

    // Buscar en empleado (docente o administrador)
    $consulta_emp = "SELECT u.*, e.tipo_empleado AS rol FROM usuario u INNER JOIN empleado e ON u.id = e.usuario_id WHERE u.cedula='$cedula' AND u.contraseña='$contraseña'";
    $resultado_emp = mysqli_query($conex, $consulta_emp);

    if (mysqli_num_rows($resultado_est) > 0) {
        $usuario = mysqli_fetch_assoc($resultado_est);
        session_start();
        $_SESSION['cedula'] = $cedula;
        $_SESSION['rol'] = $usuario['rol'];
        header("Location: ../pages/panel-estudiante.php");
        exit();
    } elseif (mysqli_num_rows($resultado_emp) > 0) {
        $usuario = mysqli_fetch_assoc($resultado_emp);
        session_start();
        $_SESSION['cedula'] = $cedula;
        $_SESSION['rol'] = $usuario['rol'];
        if ($usuario['rol'] == 'docente') {
            header("Location: /imaf-project/pages/profesor/cursos.html");
        } elseif ($usuario['rol'] == 'administrador') {
            header("Location: /imaf-project/pages/admin/usuarios.html");
        }
        exit();
    } else {
        $alerta = "<script>
        Swal.fire({
            title: 'Error',
            text: 'Credenciales incorrectas.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        </script>";
    }
}
?>
