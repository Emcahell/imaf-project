<?php

include("../backend/conexion.php");



if (isset($_POST['register'])) {
    $cedula = trim($_POST['cedula']);
    $password = trim($_POST['contraseña']);
    $email = trim($_POST['correo']);
    $fecha_registro = date("d/m/y");

    // Verificar si la cédula o el correo ya existen
    $verificar = "SELECT * FROM estudiante WHERE cedula='$cedula' OR correo='$email'";
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
        $consulta = "INSERT INTO estudiante(cedula, contraseña, correo, fecha_reg) VALUES ('$cedula','$password','$email','$fecha_registro')";
        $resultado = mysqli_query($conex, $consulta);

        if ($resultado) {
            echo "<script>
            Swal.fire({
                title: 'Registro exitoso',
                text: '¡Bienvenido!',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.html';
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