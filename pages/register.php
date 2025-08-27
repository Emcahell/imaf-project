<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/logo-imaf.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/register.css?v=<?=time()?>" />
  <script src="../scripts/register.js"></script>

  <title>IMAF | Registrarse</title>
</head>

<body>
  <div class="box-center">
    <img src="../assets/recursos/logo-imaf.png" alt="logo-imaf" class="logo-img" />

    <form method="POST" name="formRegister" class="form" action="">
      <h1 class="form-title">Registrarse</h1>

      <!-- Paso 1 -->
      <div id="step1">
        <input class="form-input" type="text" name="cedula" placeholder="Cédula" required />
        <input class="form-input" type="email" name="correo" placeholder="Correo" required />
        <input class="form-input" type="password" name="contraseña" placeholder="Contraseña" required />
        <button type="button" class="btn" onclick="nextStep()">Siguiente</button>
        <a href="/imaf-project/index.php">Iniciar sesion</a>
      </div>

      <!-- Paso 2 -->
      <div id="step2" style="display:none;">
        <input class="form-input" type="text" name="nombre" placeholder="Nombre" required />
        <input class="form-input" type="text" name="apellido" placeholder="Apellido" required />
        <input class="form-input" type="date" name="fecha_nacimiento" placeholder="Fecha de nacimiento" required />
        <select class="form-input" name="municipio" required>
          <option value="" disabled selected>Municipio</option>
          <option value="Aristides Bastidas">Aristides Bastidas</option>
          <option value="Bolívar">Bolívar</option>
          <option value="Bruzual">Bruzual</option>
          <option value="Cocorote">Cocorote</option>
          <option value="Independencia">Independencia</option>
          <option value="La Trinidad">La Trinidad</option>
          <option value="Monge">Monge</option>
          <option value="Nirgua">Nirgua</option>
          <option value="Páez">Páez</option>
          <option value="Peña">Peña</option>
          <option value="San Felipe">San Felipe</option>
          <option value="Sucre">Sucre</option>
          <option value="Urachiche">Urachiche</option>
          <option value="Veroes">Veroes</option>
        </select>
        <input class="form-input" type="text" name="telefono" placeholder="Teléfono" required />
        <button type="button" class="btn" onclick="prevStep()">Atrás</button>
        <button type="submit" class="btn" name="register">Registrar</button>
      </div>
    </form>

  </div>
  <img class="img-modelo" src="../assets/images/model-register.png" alt="mujer-posando-con-un-telefono-en-la-mano">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function nextStep() {
      document.getElementById('step1').style.display = 'none';
      document.getElementById('step2').style.display = 'block';
    }
    function prevStep() {
      document.getElementById('step2').style.display = 'none';
      document.getElementById('step1').style.display = 'block';
    }
  </script>

   <?php
include("../backend/registrar.php");
?>

</body>
</html>