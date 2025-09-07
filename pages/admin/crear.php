<?php
include("../../backend/registrar-docente.php");
include("../../backend/registrar-curso.php");

include("../../backend/conexion.php");

// Obtener profesores (empleados tipo docente) con rol activo
$profesores = [];
$result = $conex->query("
  SELECT empleado.id, usuario.nombre, usuario.apellido
  FROM empleado
  JOIN usuario ON empleado.usuario_id = usuario.id
  WHERE empleado.tipo_empleado = 'docente'
    AND empleado.activo = 1
    AND usuario.activo = 1
");
while ($row = $result->fetch_assoc()) {
    $profesores[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>IMAF | Crear</title>
    <link
      rel="shortcut icon"
      href="../../assets/logo-imaf.ico"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="../../styles/header.css" />
    <link rel="stylesheet" href="../../styles/sidebar.css" />
    <link rel="stylesheet" href="../../styles/crear.css" />
    <link rel="stylesheet" href="../../styles/transitionPages.css" />
    <script src="../../scripts/transitionPages.js" defer></script>
    <script src="../../scripts/header.js" defer></script>
  </head>
  <body>
    <main>
      <?php
      session_start();
      include("../../backend/conexion.php");
      $usuario_id = $_SESSION['usuario_id'];
      $qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'administrador' AS rol FROM usuario WHERE id = $usuario_id");
      $usuario = mysqli_fetch_assoc($qUsuario);

      // Consulta el conteo de solicitudes pendientes
      $qSolicitudes = mysqli_query($conex, "SELECT COUNT(*) AS pendientes FROM inscripcion WHERE estado = 'pendiente'");
      $rowSolicitudes = mysqli_fetch_assoc($qSolicitudes);
      $solicitudes_pendientes = $rowSolicitudes['pendientes'];
      $GLOBALS['solicitudes_pendientes'] = $solicitudes_pendientes;

      include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
      ?>

      <section>
        <article class="sidebar">
          <nav>
            <ul>
              <li>
                <a href="./usuarios.php">
                  <svg class="icon-nav" viewBox="0 0 448 512">
                    <path
                      d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"
                    />
                  </svg>
                  Usuarios
                </a>
              </li>
              <li>
                <a href="./cursos.php">
                  <svg class="icon-nav icon-cursos" viewBox="0 0 512 512">
                    <path
                      d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"
                    />
                  </svg>
                  Cursos
                </a>
              </li>
              <li>
                <a href="./solicitudes.php">
                  <svg class="icon-nav" viewBox="0 0 512 512">
                    <path
                      d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z"
                    />
                  </svg>
                  Solicitudes
                </a>
              </li>
              <li class="li-location">
                <a class="location">
                  <svg class="icon-nav location" viewBox="0 0 448 512">
                    <path
                      d="M64 80c-8.8 0-16 7.2-16 16l0 320c0 8.8 7.2 16 16 16l320 0c8.8 0 16-7.2 16-16l0-320c0-8.8-7.2-16-16-16L64 80zM0 96C0 60.7 28.7 32 64 32l320 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM200 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"
                    />
                  </svg>
                  Crear
                </a>
              </li>
            </ul>
          </nav>
        </article>

        <article class="box-contenido">
          <div class="selection-box-card">
            <div class="card-box">
              <img
                src="/imaf-project/assets/images/imagen-cursos.png"
                alt="imagen sobre cursos"
              />
              <span>Cursos</span>
            </div>
            <div class="card-box">
              <img
                src="/imaf-project/assets/images/profesor-posando.png"
                alt="imagen de un profesor posando"
              />
              <span>Profesor</span>
            </div>
          </div>

          <div class="modal-cursos modal-none" id="modal-cursos">
            <div class="modal-icon">
              <svg class="closed-modal" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="form-crear-curso" id="form-crear-curso">
              <div class="modal-title">
                <h2>Crear Curso</h2>
              </div>
              <div class="form-group">
                <label for="imagen-curso">Imagen del Curso</label>
                <input type="file" name="imagen-curso" id="imagen-curso" accept="image/*" >
              </div>
              <div class="form-group">
                <label for="nombre-curso">Nombre</label>
                <input type="text" name="nombre-curso" id="nombre-curso" required>
              </div>
              <div class="form-group">
                <label for="profesor">Profesor</label>
                <select name="profesor" id="profesor-curso" required>
                  <option value="">Seleccione Un Profesor</option>
                  <?php foreach ($profesores as $prof): ?>
                    <option value="<?= $prof['id'] ?>">
                      <?= htmlspecialchars($prof['nombre'] . ' ' . $prof['apellido']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="fecha-inicio">Fecha de Inicio</label>
                <input type="date" name="fecha-inicio" id="fecha-inicio" required>
              </div>
              <div class="form-group">
                <label for="fecha-fin">Fecha de Finalización</label>
                <input type="date" name="fecha-fin" id="fecha-fin" required>
              </div>
              <div class="form-group">
                <label for="cupos">Cupos</label>
                <input type="number" name="cupos" id="cupos" required>
              </div>
              <div class="form-group">
                <label for="precio">Valor en BS</label>
                <input type="number" name="precio" id="precio-inscripcion" required>
              </div>
              <div class="form-group">
                  <label for="oferta">En oferta</label>
                  <input type="checkbox" name="oferta" id="oferta" value="1">
              </div>
              <button class="btn-modal" name="crear-curso" type="submit">Crear</button>
            </form>
          </div>

          <div class="modal-profesor modal-none" id="modal-profesor">
            <div class="modal-icon">
              <svg class="closed-modal" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2024 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
            </div>

            <form method="POST" action="" enctype="multipart/form-data" class="form-crear-profesor" id="form-crear-profesor">
              <div class="modal-title">
                <h2>Crear Profesor</h2>
              </div>
              <div class="form-group">
                <label for="nombre-profesor">Nombre</label>
                <input type="text" name="nombre-profesor" id="nombre-profesor" required>
              </div>
              <div class="form-group">
                <label for="apellido-profesor">Apellido</label>
                <input type="text" name="apellido-profesor" id="apellido-profesor" required>
              </div>
              <div class="form-group">
                <label for="cedula-profesor">Cedula</label>
                <input type="number" name="cedula-profesor" id="cedula-profesor" required>
              </div>
              <div class="form-group">
                <label for="fecha-nacimiento">Fecha Nacimiento</label>
                <input type="date" name="fecha-nacimiento" id="fecha-nacimiento" required>
              </div>
              
              <div class="form-group">
                <label for="contraseña-profesor">Contraseña</label>
                <input type="password" name="contraseña-profesor" id="contraseña-profesor" required>
              </div>
              <div class="form-group">
                <label for="correo-profesor">Correo</label>
                <input type="email" name="correo-profesor" id="correo-profesor" required>
              </div>
              <div class="form-group">
                <label for="telefono-profesor">Telefono</label>
                <input type="number" name="telefono-profesor" id="telefono-profesor" required>
              </div>
              <div class="form-group">
                <label for="foto-profesor">Foto del Profesor</label>
                <input type="file" name="foto-profesor" id="foto-profesor" accept="image/*">
              </div>
              <button type="submit" name="crear-profesor" class="btn-modal">Crear</button>
            </form>
          </div>
        </article>
      </section>
    </main>
    <script src="../../scripts/modal-crear.js"></script>
    </div>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($alerta)) echo $alerta; ?>
<?php if (!empty($alerta_docente)) echo $alerta_docente; ?>


  </body>
</html>
