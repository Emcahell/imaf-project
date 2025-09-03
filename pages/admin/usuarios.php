<?php
include("../../backend/conexion.php");

// Cambia las consultas para traer el rol:
$queryEstudiantes = "
SELECT 
  u.*,
  CASE 
    WHEN e.id IS NOT NULL AND e.activo = 1 AND emp.id IS NOT NULL AND emp.activo = 1 THEN 'Ambos'
    WHEN e.id IS NOT NULL AND e.activo = 1 THEN 'Estudiante'
    WHEN emp.id IS NOT NULL AND emp.activo = 1 THEN 'Docente'
    ELSE 'Sin rol'
  END AS rol
FROM usuario u
LEFT JOIN estudiante e ON e.usuario_id = u.id
LEFT JOIN empleado emp ON emp.usuario_id = u.id AND emp.tipo_empleado = 'docente'
WHERE u.activo = 1
";
$resultEstudiantes = mysqli_query($conex, $queryEstudiantes);

$queryInactivos = "
SELECT 
  u.*,
  CASE 
    WHEN e.id IS NOT NULL AND e.activo = 1 AND emp.id IS NOT NULL AND emp.activo = 1 THEN 'Ambos'
    WHEN e.id IS NOT NULL AND e.activo = 1 THEN 'Estudiante'
    WHEN emp.id IS NOT NULL AND emp.activo = 1 THEN 'Docente'
    ELSE 'Sin rol'
  END AS rol
FROM usuario u
LEFT JOIN estudiante e ON e.usuario_id = u.id
LEFT JOIN empleado emp ON emp.usuario_id = u.id AND emp.tipo_empleado = 'docente'
WHERE u.activo = 0
";
$resultInactivos = mysqli_query($conex, $queryInactivos);

// Inactivar estudiante (eliminar lógico)
if (isset($_POST['inactivar_usuario'])) {
    $id = intval($_POST['inactivar_usuario']);
    mysqli_query($conex, "UPDATE usuario SET activo = 0 WHERE id = $id");
    header("Location: usuarios.php");
    exit;
}

// Reactivar estudiante
if (isset($_POST['activar_usuario'])) {
    $id = intval($_POST['activar_usuario']);
    mysqli_query($conex, "UPDATE usuario SET activo = 1 WHERE id = $id");
    header("Location: usuarios.php");
    exit;
}

// Cambiar rol desde el formulario (desactivar en vez de borrar)
if (isset($_POST['cambiar_rol'], $_POST['usuario_id'], $_POST['nuevo_rol'])) {
    $usuario_id = intval($_POST['usuario_id']);
    $nuevo_rol = $_POST['nuevo_rol'];

    // --- ESTUDIANTE ---
    $qEst = mysqli_query($conex, "SELECT id, activo FROM estudiante WHERE usuario_id = $usuario_id");
    $rowEst = mysqli_fetch_assoc($qEst);
    if ($nuevo_rol == 'Estudiante' || $nuevo_rol == 'Ambos') {
        if ($rowEst) {
            mysqli_query($conex, "UPDATE estudiante SET activo = 1 WHERE usuario_id = $usuario_id");
        } else {
            mysqli_query($conex, "INSERT INTO estudiante (usuario_id, activo) VALUES ($usuario_id, 1)");
        }
    } else {
        if ($rowEst) {
            mysqli_query($conex, "UPDATE estudiante SET activo = 0 WHERE usuario_id = $usuario_id");
        }
    }

    // --- DOCENTE ---
    $qDoc = mysqli_query($conex, "SELECT id, activo FROM empleado WHERE usuario_id = $usuario_id AND tipo_empleado = 'docente'");
    $rowDoc = mysqli_fetch_assoc($qDoc);
    if ($nuevo_rol == 'Docente' || $nuevo_rol == 'Ambos') {
        if ($rowDoc) {
            mysqli_query($conex, "UPDATE empleado SET activo = 1 WHERE usuario_id = $usuario_id AND tipo_empleado = 'docente'");
        } else {
            mysqli_query($conex, "INSERT INTO empleado (usuario_id, tipo_empleado, activo) VALUES ($usuario_id, 'docente', 1)");
        }
    } else {
        if ($rowDoc) {
            mysqli_query($conex, "UPDATE empleado SET activo = 0 WHERE usuario_id = $usuario_id AND tipo_empleado = 'docente'");
        }
    }

    header("Location: usuarios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="../../assets/logo-imaf.ico"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="../../styles/usuarios.css" />
    <link rel="stylesheet" href="../../styles/header.css" />
    <link rel="stylesheet" href="../../styles/sidebar.css" />
    <link rel="stylesheet" href="../../styles/transitionPages.css" />
    <script src="../../scripts/transitionPages.js" defer></script>
    <script src="../../scripts/header.js" defer></script>
    <script src="../../scripts/usuarios.js" defer></script>
    <title>IMAF | Usuarios</title>
  </head>
  <body>
    <main>
      <?php
      session_start();
      $usuario_id = $_SESSION['usuario_id'];
      $qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'administrador' AS rol FROM usuario WHERE id = $usuario_id");
      $usuario = mysqli_fetch_assoc($qUsuario);

      include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
      ?>

      <section>
        <article class="sidebar">
          <nav>
            <ul>
              <li class="li-location">
                <a class="location">
                  <svg class="icon-nav location" viewBox="0 0 448 512">
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
              <li>
                <a href="./crear.php">
                  <svg class="icon-nav" viewBox="0 0 448 512">
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
          <div class="filter">
            <button class="tab-btn btn-active" id="btn-todos">Todos</button>
            <button class="tab-btn" id="btn-inactivos">Inactivos</button>
          </div>

          <article class="box-todos" id="box-todos">
            <div class="contenido">
              <div class="separador">
                <div class="table-header table-row">
                  <p class="table-header-item">Cédula</p>
                  <p class="table-header-item b">Nombre</p>
                  <p class="table-header-item r">Teléfono</p>
                  <p class="table-header-item r">Correo</p>
                  <p class="table-header-item r">Municipio</p>
                  <p class="table-header-item r">Rol</p>
                  <p class="table-header-item r">Fecha de Nacimiento</p>
                  <p class="table-header-item lastchild r">Eliminar</p>
                </div>
              </div>

              <div class="scroll-area">
                <?php while($usuario = mysqli_fetch_assoc($resultEstudiantes)): ?>
                  <?php if($usuario['cedula'] === 'admin') continue; ?>
                  <div class="table-row2">
                    <div class="box-icon-see-more">
                      <!-- ...icono ver más... -->
                    </div>
                    <p class="table-header-item box-info-y-edit">
                      <a href="/imaf-project/pages/edit-perfil.php?id=<?= $usuario['id'] ?>">
                        <img class="editsvg r" src="/imaf-project/assets/icons/pen-to-square.svg" alt="Editar" />
                      </a>
                      <?= htmlspecialchars($usuario['cedula']) ?>
                    </p>
                    <p class="table-header-item b"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></p>
                    <p class="table-header-item r"><?= htmlspecialchars($usuario['telefono']) ?></p>
                    <p class="table-header-item r" title="<?= htmlspecialchars($usuario['correo']) ?>">
                      <?= htmlspecialchars($usuario['correo']) ?>
                    </p>
                    <p class="table-header-item r"><?= htmlspecialchars($usuario['municipio']) ?></p>
                    <p class="table-header-item r">
                      <form method="POST" style="display:inline;">
                        <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
                        <select name="nuevo_rol" onchange="this.form.submit()" style="min-width:90px;">
                          <option value="Estudiante" <?= $usuario['rol']=='Estudiante' ? 'selected' : '' ?>>Estudiante</option>
                          <option value="Docente" <?= $usuario['rol']=='Docente' ? 'selected' : '' ?>>Docente</option>
                          <option value="Ambos" <?= $usuario['rol']=='Ambos' ? 'selected' : '' ?>>Ambos</option>
                        </select>
                        <input type="hidden" name="cambiar_rol" value="1">
                      </form>
                    </p>
                    <p class="table-header-item r"><?= htmlspecialchars($usuario['fecha_nacimiento']) ?></p>
                    <span class="table-header-item r">
                      <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="inactivar_usuario" value="<?= $usuario['id'] ?>">
                        <button type="submit" style="background:none;border:none;padding:0;">
                          <img class="trash-cansvg" src="/imaf-project/assets/icons/trash-can.svg" alt="Eliminar" />
                        </button>
                      </form>
                    </span>
                  </div>
                  <?php endwhile; ?>


            </div>
          </article>

          <!-- ################# -->

          <!-- USUARIOS INACTIVOS -->

          <article class="box-inactivos" id="box-inactivos">
            <div class="contenido">
              <div class="separador">
                <div class="table-header table-row">
                  <p class="table-header-item">Cédula</p>
                  <p class="table-header-item b">Nombre</p>
                  <p class="table-header-item r">Teléfono</p>
                  <p class="table-header-item r">Correo</p>
                  <p class="table-header-item r">Municipio</p>
                  <p class="table-header-item r">Rol</p>
                  <p class="table-header-item r">Fecha de Nacimiento</p>
                  <p class="table-header-item lastchild r">Devolver</p>
                </div>
              </div>

              <div class="scroll-area">
                <?php while($usuario = mysqli_fetch_assoc($resultInactivos)): ?>
                  <div class="table-row2">
                    <!-- ...icono ver más... -->
                    <p class="table-header-item box-info-y-edit">
                      <a href="/imaf-project/pages/edit-perfil.php?id=<?= $usuario['id'] ?>">
                        <img class="editsvg r" src="/imaf-project/assets/icons/pen-to-square.svg" alt="Editar" />
                      </a>
                      <?= htmlspecialchars($usuario['cedula']) ?>
                    </p>
                    <p class="table-header-item b"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></p>
                    <p class="table-header-item r"><?= htmlspecialchars($usuario['telefono']) ?></p>
                    <p class="table-header-item r" title="<?= htmlspecialchars($usuario['correo']) ?>">
                      <?= htmlspecialchars($usuario['correo']) ?>
                    </p>
                    <p class="table-header-item r"><?= htmlspecialchars($usuario['municipio']) ?></p>
                    <p class="table-header-item r"><?= htmlspecialchars($usuario['rol']) ?></p> <!-- NUEVA COLUMNA -->

                    <p class="table-header-item r"><?= htmlspecialchars($usuario['fecha_nacimiento']) ?></p>
                    <span class="table-header-item r">
                      <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="activar_usuario" value="<?= $usuario['id'] ?>">
                        <button type="submit" style="background:none;border:none;padding:0;">
                          <img src="/imaf-project/assets/icons/arrow-left.svg" class="icon icon-accion icon-devolver" style="width: 16px; height: auto; margin: auto; cursor: pointer;" viewBox="0 0 512 512">
                            <path d="M..." /> <!-- tu path aquí -->
                         </img>
                        </button>
                      </form>
                    </span>
                  </div>
                  <?php endwhile; ?>
              </div>
            </div>
          </article>

          <!-- ################# -->
        </article>
      </section>
    </main>
  </body>
</html>
