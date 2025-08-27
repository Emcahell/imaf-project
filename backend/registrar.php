<?php

include("../backend/conexion.php");

if (isset($_POST['register'])) {
    $cedula = trim($_POST['cedula']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
    $municipio = trim($_POST['municipio']);
    $telefono = trim($_POST['telefono']);
    $password = trim($_POST['contraseña']);
    $email = trim($_POST['correo']);
    $fecha_registro = date("Y-m-d H:i:s"); // Formato estándar de fecha y hora

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
        // 1. Insertar en usuario con todos los datos y fecha_registro
        $consulta = "INSERT INTO usuario (cedula, nombre, apellido, correo, telefono, fecha_nacimiento, municipio, contraseña, fecha_registro) 
            VALUES ('$cedula','$nombre','$apellido','$email','$telefono','$fecha_nacimiento','$municipio','$password','$fecha_registro')";
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