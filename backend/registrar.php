<?php

include("../backend/conexion.php");

if (isset($_POST['register'])) {
    $cedula = trim($_POST['cedula']);
    $password = trim($_POST['contraseña']);
    $email = trim($_POST['correo']);
    $fecha_registro = date("d-m-y");

    // Verificar si la cédula o el correo ya existen en usuario
    $verificar = "SELECT * FROM usuario WHERE cedula='$cedula' OR correo='$email'";
    $existe = mysqli_query($conex, $verificar);

    if (mysqli_num_rows($existe) > 0) {
        echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'La cédula o el correo ya están registrados.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        </script>";
    } else {
        // 1. Insertar en usuario
        $consulta = "INSERT INTO usuario (cedula, contraseña, correo, fecha_registro) VALUES ('$cedula','$password','$email','$fecha_registro')";
        $resultado = mysqli_query($conex, $consulta);

        // 2. Insertar en estudiante
        if ($resultado) {
            $usuario_id = mysqli_insert_id($conex);
            $consulta_estudiante = "INSERT INTO estudiante (usuario_id) VALUES ('$usuario_id')";
            mysqli_query($conex, $consulta_estudiante);

            echo "<script>
            Swal.fire({
                title: 'Registro exitoso',
                text: '¡Bienvenido!',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                }
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'No se pudo registrar. Por favor, inténtelo de nuevo.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            </script>";
        }
    }
}

?>