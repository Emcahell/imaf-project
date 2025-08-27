<?php
include("conexion.php");

$alerta_docente = ''; // Inicializa la variable

if (isset($_POST['crear-profesor'])) {
    // Recoger datos del formulario
    $cedula = trim($_POST['cedula-profesor']);
    $password = trim($_POST['contraseña-profesor']);
    $correo = trim($_POST['correo-profesor']);
    $nombre = trim($_POST['nombre-profesor']);
    $apellido = trim($_POST['apellido-profesor']);
    $telefono = trim($_POST['telefono-profesor']);
    $fecha_nacimiento = trim($_POST['fecha-nacimiento']);
    $municipio = trim($_POST['municipio-profesor'] ?? '');
    $direccion = trim($_POST['direccion-profesor'] ?? '');
    $fecha_registro = date("Y-m-d");

    // Manejo de la foto
    $foto_nombre = '';
if (isset($_FILES["foto-profesor"]) && $_FILES["foto-profesor"]["error"] == 0) {
    $fotoTmp = $_FILES["foto-profesor"]["tmp_name"];
    $foto_nombre = uniqid() . "_" . basename($_FILES["foto-profesor"]["name"]);
    $directorio = realpath(__DIR__ . '/../uploads/profilepic');
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $rutaDestino = $directorio . DIRECTORY_SEPARATOR . $foto_nombre;
    move_uploaded_file($fotoTmp, $rutaDestino);
}

    // Verificar si la cédula o el correo ya existen
    $verificar = "SELECT * FROM usuario WHERE cedula='$cedula' OR correo='$correo'";
    $existe = mysqli_query($conex, $verificar);

    if (mysqli_num_rows($existe) > 0) {
         $alerta_docente = "<script>
        Swal.fire({
            title: 'Error',
            text: 'La cédula o el correo ya están registrados.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        </script>";
    } else {
        // Insertar en la tabla usuario (agregando el campo foto)
        $consulta_usuario = "INSERT INTO usuario (cedula, contraseña, correo, nombre, apellido, telefono, fecha_nacimiento, municipio, direccion, fecha_registro, foto) 
                            VALUES ('$cedula', '$password', '$correo', '$nombre', '$apellido', '$telefono', '$fecha_nacimiento', '$municipio', '$direccion', CURDATE(), '$foto_nombre')";
        
        $resultado_usuario = mysqli_query($conex, $consulta_usuario);

        if ($resultado_usuario) {
            // Obtener el ID del usuario recién insertado
            $usuario_id = mysqli_insert_id($conex);
            
            // Insertar en la tabla empleado como docente
            $consulta_empleado = "INSERT INTO empleado (usuario_id, tipo_empleado) VALUES ('$usuario_id', 'docente')";
            $resultado_empleado = mysqli_query($conex, $consulta_empleado);

            if ($resultado_empleado) {

                $alerta_docente = "<script>
            Swal.fire({
                title: 'Registro de docente exitoso',
                text: '¡Docente creado correctamente!',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            </script>";
            } else {
                $alerta_docente = "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Error al registrar como empleado docente.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                </script>";
            }
        } else {
          $alerta_docente = "<script>
            Swal.fire({
                title: 'Error',
                text: 'Error al registrar el usuario.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            </script>";
        }
    }
}
?>