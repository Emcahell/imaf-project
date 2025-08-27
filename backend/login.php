<?php

include("conexion.php");
session_start();

$alerta = '';

if (isset($_POST['login'])) {
    $cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
    $contraseña = isset($_POST['contraseña']) ? trim($_POST['contraseña']) : '';

    // Busca el usuario por cédula y contraseña
    $consulta = "SELECT * FROM usuario WHERE cedula='$cedula' AND contraseña='$contraseña'";
    $resultado = mysqli_query($conex, $consulta);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        if ($usuario['activo'] != 1) {
            $alerta = "<script>
            Swal.fire({
                title: 'Usuario inactivo',
                text: 'Tu usuario está inactivo, contacta al administrador.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
            </script>";
        } else {
            $usuario_id = $usuario['id'];

            // Verificar roles activos
            $qEst = mysqli_query($conex, "SELECT id FROM estudiante WHERE usuario_id = $usuario_id AND activo = 1");
            $qDoc = mysqli_query($conex, "SELECT id FROM empleado WHERE usuario_id = $usuario_id AND tipo_empleado = 'docente' AND activo = 1");
            $qAdmin = mysqli_query($conex, "SELECT id FROM empleado WHERE usuario_id = $usuario_id AND tipo_empleado = 'administrador' AND activo = 1");

            $esEstudiante = mysqli_num_rows($qEst) > 0;
            $esDocente = mysqli_num_rows($qDoc) > 0;
            $esAdmin = mysqli_num_rows($qAdmin) > 0;

            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['cedula'] = $cedula;

            if ($esAdmin) {
                $_SESSION['rol'] = 'administrador';
                header("Location: /imaf-project/pages/admin/usuarios.php");
                exit;
            } elseif ($esEstudiante && $esDocente) {
                // No guardes $_SESSION['rol'] aquí
                header("Location: /imaf-project/pages/elegir-rol.php");
                exit;
            } elseif ($esEstudiante) {
                $_SESSION['rol'] = 'estudiante';
                header("Location: /imaf-project/pages/estudiante/panel.php");
                exit;
            } elseif ($esDocente) {
                $_SESSION['rol'] = 'docente';
                header("Location: /imaf-project/pages/profesor/cursos.php");
                exit;
            } else {
                $alerta = "<script>
                Swal.fire({
                    title: 'Sin rol activo',
                    text: 'No tienes un rol activo en el sistema.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                </script>";
            }
        }
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