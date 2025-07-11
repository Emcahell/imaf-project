

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../assets/logo-imaf.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/register.css" />
  <script src="../scripts/register.js" defer></script>

  <title>IMAF | Registrarse</title>
</head>

<body>
  <div class="box-center">
    <img src="../assets/recursos/logo-imaf.png" alt="logo-imaf" class="logo-img" />

    
     <form method="POST" action="#" name="formRegister" class="form" id="form">
      <div class="form-title">
        <h1>Registrarse</h1>
      </div>

      <div class="form-item">
        <input type="number" name="cedula" placeholder="Cédula" class="form-input" id="input-cedula"/>
        <svg class="icon icons-input-register" viewBox="0 0 448 512">
          <path
            d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
        </svg>
        <p class="error" id="error-cedula"></p>
      </div>

      <div class="form-item">
        <input type="password" name="contraseña" placeholder="Contraseña" class="form-input" id="input-password" />
        <svg class="icon icons-input-register tabler-icon" width="20" height="20" viewBox="0 0 20 20" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
          <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
          <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
        </svg>
        <p class="error" id="error-password"></p>
      </div>

      <div class="form-item">
        <input type="email" name="correo" placeholder="Correo" class="form-input" id="input-email"/>
        <svg class="icon icons-input-register" viewBox="0 0 512 512">
          <path
            d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z" />
        </svg>
        <p class="error" id="error-email"></p>
      </div>

      <div class="form-item">
        <button type="submit" name="button" class="btn">Registrar</button>
      </div>
      <div class="form-link">
        <a href="../index.html">Iniciar Sesion</a>
      </div>
    </form>

  </div>
  <img class="img-modelo" src="../assets/images/model-register.png" alt="mujer-posando-con-un-telefono-en-la-mano">

  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

   <?php
include("../backend/registrar.php");
?>

</body>
</html>