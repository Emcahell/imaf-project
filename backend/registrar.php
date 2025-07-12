<?php

include("../backend/conexion.php");


if (isset($_POST['register'])) {
    $cedula = trim($_POST['cedula']);
    $password = trim($_POST['contraseña']);
    $email = trim($_POST['correo']);
    $fecha_registro = date("d/m/y");
    $consulta = "INSERT INTO estudiante(cedula, contraseña, correo, fecha_reg) VALUES ('$cedula','$password','$email','$fecha_registro')";

    $resultado= mysqli_query($conex,$consulta);

    if ($resultado){
    ?>
    <h2>¡Registro exitoso!</h2>
    <?php
    } else {
    ?>
    <h2>Error en el registro</h2>
    <?php
    }

}

?>