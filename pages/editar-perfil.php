<?php

session_start();
include("../backend/conexion.php");

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol'])) {
    header("Location: ../index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$rol = $_SESSION['rol'];

// Cargar datos generales
$qUsuario = mysqli_query($conex, "SELECT * FROM usuario WHERE id = $usuario_id");
$usuario = mysqli_fetch_assoc($qUsuario);

// Cargar datos adicionales según rol
$datos_rol = [];
if ($rol == 'docente' || $rol == 'administrador') {
    $qEmp = mysqli_query($conex, "SELECT * FROM empleado WHERE usuario_id = $usuario_id");
    $datos_rol = mysqli_fetch_assoc($qEmp);
} elseif ($rol == 'estudiante') {
    $qEst = mysqli_query($conex, "SELECT * FROM estudiante WHERE usuario_id = $usuario_id");
    $datos_rol = mysqli_fetch_assoc($qEst);
}

// Para mostrar el nombre del rol en el header
$nombres_roles = [
    'administrador' => 'Administrador',
    'docente' => 'Docente',
    'estudiante' => 'Estudiante'
];

// Eliminar foto si se envía el POST de eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_foto'])) {
    if (!empty($usuario['foto'])) {
        $ruta_foto = __DIR__ . '/../uploads/profilepic/' . $usuario['foto'];
        if (file_exists($ruta_foto)) {
            unlink($ruta_foto);
        }
        mysqli_query($conex, "UPDATE usuario SET foto = NULL WHERE id = $usuario_id");
    }
    header("Location: editar-perfil.php?success=1");
    exit;
}

// Subir foto de perfil a uploads/profilepic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nombre = 'perfil_' . $usuario_id . '_' . time() . '.' . $ext;
        $destino = __DIR__ . '/../uploads/profilepic/' . $foto_nombre;
        move_uploaded_file($tmp_name, $destino);
        mysqli_query($conex, "UPDATE usuario SET foto = '$foto_nombre' WHERE id = $usuario_id");
    }
    header("Location: editar-perfil.php?success=1");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombres']);
    $apellido = trim($_POST['apellidos']);
    $cedula = trim($_POST['cedula']);
    $correo = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);
    $telefono = trim($_POST['telefono']);
    $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
    $municipio = trim($_POST['municipio']);
    $direccion = trim($_POST['direccion']);

    // Actualiza la tabla usuario
    $sql = "UPDATE usuario SET 
        nombre = '$nombre',
        apellido = '$apellido',
        cedula = '$cedula',
        correo = '$correo',
        contraseña = '$contraseña',
        telefono = '$telefono',
        fecha_nacimiento = '$fecha_nacimiento',
        municipio = '$municipio',
        direccion = '$direccion'
        WHERE id = $usuario_id";
    mysqli_query($conex, $sql);

    header("Location: editar-perfil.php?success=1");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="stylesheet" href="/imaf-project/styles/globals.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/imaf-project/assets/logo-imaf.ico" type="image/x-icon">
  <link rel="stylesheet" href="/imaf-project/styles/header.css">
  <link rel="stylesheet" href="/imaf-project/styles/perfil.css">
  <link rel="stylesheet" href="/imaf-project/styles/transitionPages.css">
  <script src="/imaf-project/scripts/transitionPages.js" defer></script>
  <script src="/imaf-project/scripts/header.js" defer></script>
  <title>Perfil | <?= $nombres_roles[$rol] ?></title>
  <style>
    .credenciales-input:disabled,
    .data input:disabled,
    .data select:disabled {
      background: #f3f3f3;
      color: #888;
      border: 1px solid #ddd;
    }
    .edit-btn, .save-btn, .cancel-btn {
      margin-top: 16px;
      margin-right: 8px;
    }
    .img-box {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      overflow: hidden;
      margin: 0 auto 16px auto;
      position: relative;
      background: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    .img-upload-label {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0; left: 0;
      border-radius: 50%;
      cursor: pointer;
      background: rgba(0,0,0,0.3);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.2s;
      font-size: 1.2em;
      text-align: center;
    }
    .img-box:hover .img-upload-label {
      opacity: 1;
    }
    .img-upload-input {
      display: none;
    }
  </style>
</head>
<body>
  <main>
    <header>
      <div>
        <img src="/imaf-project/assets/recursos/logo-imaf.png" alt="logo-imaf" class="logo">
      </div>
      <div class="tools">
        <p><?= $nombres_roles[$rol] ?> <span id="conexion">•</span></p>
        <div class="box-useradmin">
          <svg class="icon" id="icon-user" viewBox="0 0 512 512">
            <path d="M406.5 399.6C387.4 352.9 341.5 320 288 320l-64 0c-53.5 0-99.4 32.9-118.5 79.6C69.9 362.2 48 311.7 48 256C48 141.1 141.1 48 256 48s208 93.1 208 208c0 55.7-21.9 106.2-57.5 143.6zm-40.1 32.7C334.4 452.4 296.6 464 256 464s-78.4-11.6-110.5-31.7c7.3-36.7 39.7-64.3 78.5-64.3l64 0c38.8 0 71.2 27.6 78.5 64.3zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-272a40 40 0 1 1 0-80 40 40 0 1 1 0 80zm-88-40a88 88 0 1 0 176 0 88 88 0 1 0 -176 0z"/>
          </svg>
          <span>&nbsp; <?= htmlspecialchars($usuario['nombre'] ?? '') ?></span>
        </div>
        <a class="back" href="/imaf-project/index.php">Salir</a>
      </div>
    </header>
    <section>
      <article class="sidebar">
        <div class="perfil-box">
          <form id="form-foto" method="POST" enctype="multipart/form-data" style="margin-bottom: 0;">
            <div class="img-box">
              <img src="<?php
                if (isset($usuario['foto']) && $usuario['foto']) {
                  echo '/imaf-project/uploads/profilepic/' . htmlspecialchars($usuario['foto']);
                } else {
                  echo '/imaf-project/assets/recursos/user-default.png';
                }
              ?>" alt="imagen-perfil" id="preview-img">
              <?php if (isset($usuario['foto']) && $usuario['foto']): ?>
                <label class="img-upload-label" id="label-foto" for="img-upload" style="cursor:pointer;">
                  <span id="foto-action">Eliminar foto</span>
                  <input type="file" id="img-upload" name="foto" class="img-upload-input" accept="image/*" onchange="enviarFoto(event)">
                </label>
                <form id="form-eliminar-foto" method="POST" style="display:none;">
                  <input type="hidden" name="eliminar_foto" value="1">
                </form>
              <?php else: ?>
                <label class="img-upload-label" id="label-foto" for="img-upload" style="cursor:pointer;">
                  <span id="foto-action">Subir foto</span>
                  <input type="file" id="img-upload" name="foto" class="img-upload-input" accept="image/*" onchange="enviarFoto(event)">
                </label>
              <?php endif; ?>
            </div>
          </form>
          <form id="form-eliminar-foto" method="POST" style="display:none;">
            <input type="hidden" name="eliminar_foto" value="1">
          </form>
          <div class="credenciales">
            <div class="div-label">Cedula</div>
            <input type="text" name="cedula" value="<?= htmlspecialchars($usuario['cedula'] ?? '') ?>" class="credenciales-input" disabled>
            <div class="div-label">Contraseña</div>
            <input type="password" name="password" value="********" class="credenciales-input" disabled>
          </div>
          <a 
            href="<?php
              if ($rol == 'administrador') {
                  echo '/imaf-project/pages/admin/usuarios.php';
              } elseif ($rol == 'docente') {
                  echo '/imaf-project/pages/profesor/cursos.php';
              } elseif ($rol == 'estudiante') {
                  echo '/imaf-project/pages/estudiante/cursos.php';
              } else {
                  echo '/imaf-project/index.php';
              }
            ?>" 
            class="back"
          >Volver</a>
        </div>
      </article>
      <article class="content-box">
        <form class="data-box" method="POST" action="" id="form-perfil" enctype="multipart/form-data">
          <input type="hidden" name="cedula" value="<?= htmlspecialchars($usuario['cedula'] ?? '') ?>">
          <div class="left-content">
            <div class="data">
              <p>Cédula</p>
              <input type="text" name="cedula" value="<?= htmlspecialchars($usuario['cedula'] ?? '') ?>" disabled>
            </div>
            <div class="data">
              <p>Nombres</p>
              <input type="text" name="nombres" value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" disabled>
            </div>
            <div class="data">
              <p>Apellidos</p>
              <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellido'] ?? '') ?>" disabled>
            </div>
            <div class="data">
              <p>Correo</p>
              <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo'] ?? '') ?>" disabled>
            </div>
            <div class="data">
              <p>Contraseña</p>
              <input type="text" name="contraseña" value="<?= htmlspecialchars($usuario['contraseña'] ?? '') ?>" disabled>
            </div>
            <div class="data">
              <p>Teléfono</p>
              <input type="number" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>" disabled>
            </div>
          </div>
          <div class="right-content">
            <div class="data">
              <p>Fecha De Nacimiento</p>
              <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($usuario['fecha_nacimiento'] ?? '') ?>" disabled>
            </div>
            <div class="data">
              <p>Municipio</p>
              <select name="municipio" disabled>
                <option value="" disabled>Municipio</option>
                <?php
                $municipios = [
                  "Aristides Bastidas", "Bolívar", "Bruzual", "Cocorote", "Independencia", "La Trinidad",
                  "Monge", "Nirgua", "Páez", "Peña", "San Felipe", "Sucre", "Urachiche", "Veroes"
                ];
                foreach ($municipios as $m) {
                  $selected = ($usuario['municipio'] ?? '') == $m ? 'selected' : '';
                  echo "<option value=\"$m\" $selected>$m</option>";
                }
                ?>
              </select>
            </div>
            <div class="data">
              <p>Dirección</p>
              <input type="text" name="direccion" value="<?= htmlspecialchars($usuario['direccion'] ?? '') ?>" disabled>
            </div>
            <div class="data">
              <p>Cargo</p>
              <input type="text" name="cargo" value="<?php
                // Determinar el rol para mostrar
                $qEst = mysqli_query($conex, "SELECT id FROM estudiante WHERE usuario_id = $usuario_id AND activo = 1");
                $qDoc = mysqli_query($conex, "SELECT id FROM empleado WHERE usuario_id = $usuario_id AND tipo_empleado = 'docente' AND activo = 1");
                if ($rol == 'administrador') echo 'Administrador';
                elseif (mysqli_num_rows($qEst) > 0 && mysqli_num_rows($qDoc) > 0) echo 'Ambos';
                elseif (mysqli_num_rows($qEst) > 0) echo 'Estudiante';
                elseif (mysqli_num_rows($qDoc) > 0) echo 'Docente';
                else echo 'Sin rol';
              ?>" disabled>
            </div>
          </div>
          <button type="button" class="edit-btn" id="btn-editar">Editar</button>
          <button type="submit" class="save-btn edit-btn" id="btn-guardar" style="display:none;">Guardar</button>
          <button type="button" class="cancel-btn edit-btn" id="btn-cancelar" style="display:none;">Cancelar</button>
        </form>
      </article>
    </section>
  </main>
  <script>
    // Desbloquear campos al dar click en Editar
    document.getElementById('btn-editar').onclick = function() {
      document.querySelectorAll('.data-box input, .data-box select').forEach(el => el.disabled = false);
      document.getElementById('btn-editar').style.display = 'none';
      document.getElementById('btn-guardar').style.display = '';
      document.getElementById('btn-cancelar').style.display = '';
    };
    // Cancelar edición
    document.getElementById('btn-cancelar').onclick = function() {
      window.location.reload();
    };
    function previewFoto(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview-img').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    function enviarFoto(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        // Previsualización instantánea
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview-img').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
        // Enviar el formulario de la foto automáticamente
        document.getElementById('form-foto').submit();
      }
    }
  </script>
  <script>
const labelFoto = document.getElementById('label-foto');
const fotoAction = document.getElementById('foto-action');
<?php if (isset($usuario['foto']) && $usuario['foto']): ?>
labelFoto.addEventListener('click', function(e) {
  if (e.target === fotoAction) {
    e.preventDefault();
    document.getElementById('form-eliminar-foto').submit();
  }
});
labelFoto.addEventListener('mouseover', function() {
  fotoAction.textContent = 'Eliminar foto';
});
labelFoto.addEventListener('mouseout', function() {
  fotoAction.textContent = 'Eliminar foto';
});
<?php else: ?>
labelFoto.addEventListener('mouseover', function() {
  fotoAction.textContent = 'Subir foto';
});
labelFoto.addEventListener('mouseout', function() {
  fotoAction.textContent = 'Subir foto';
});
<?php endif; ?>
function enviarFoto(event) {
  const input = event.target;
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('preview-img').src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
    document.getElementById('form-foto').submit();
  }
}
</script>
</body>
</html>