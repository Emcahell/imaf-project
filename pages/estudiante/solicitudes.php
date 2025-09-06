<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../../assets/logo-imaf.ico" type="image/x-icon" />
  <link rel="stylesheet" href="../../styles/solicitudes.css" />
  <link rel="stylesheet" href="/imaf-project/styles/estudiante/solicitudes.css" />
  <link rel="stylesheet" href="../../styles/header.css" />
  <link rel="stylesheet" href="../../styles/sidebar.css" />
  <link rel="stylesheet" href="../../styles/transitionPages.css">
  <script src="../../scripts/transitionPages.js" defer></script>
  <script src="/imaf-project/scripts/header.js" defer></script>
  <script src="../../scripts/estudiante/solicitudes.js" defer></script>
  <title>IMAF | Solicitudes</title>

  <style>
    .cards-style{
      height:max-content !important;
    }
  </style>
</head>

<body>
  <main>
    <?php
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        // Redirige al login o muestra un mensaje de error
        header("Location: /imaf-project/index.php");
        exit;
    }
    include("../../backend/conexion.php");
    $usuario_id = $_SESSION['usuario_id'];
    $qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'estudiante' AS rol FROM usuario WHERE id = $usuario_id");    $usuario = mysqli_fetch_assoc($qUsuario);

    include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
    ?>

    <section>
          <article class="sidebar">
      <nav>
        <ul>
          <li>
            <a href="./cursos.php">
              <svg class="icon-nav icon-cursos" viewBox="0 0 512 512">
                <!-- Icono de cursos -->
                <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
              </svg>
              Cursos
            </a>
          </li>
          <li class="li-location">
            <a class="location">
              <svg class="icon-nav location" viewBox="0 0 512 512">
                <!-- Icono de solicitudes -->
                <path d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z"/>
              </svg>
              Solicitudes
            </a>
          </li>
          <li>
            <a href="/imaf-project/index.php">
              <svg class="icon-nav" viewBox="0 0 512 512">
                <!-- Icono de salir -->
                <path d="M497 273l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l41-41H176c-13.3 0-24-10.7-24-24s10.7-24 24-24h248l-41-41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80c9.4 9.4 9.4 24.6 0 33.9zM432 32H80C53.5 32 32 53.5 32 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48z"/>
              </svg>
              Salir
            </a>
          </li>
        </ul>
      </nav>
    </article>

      <article class="box-contenido">
        <div class="filter">
          <button class="button-active" id="btn-pendientes">Pendientes</button>
          <button id="btn-aprobados">Aprobados</button>
          <button id="btn-rechazados">Rechazados</button>
          <button id="btn-todos">Todos</button>
        </div>
        <div class="contenido">
          <?php
          $querySolicitudes = "
            SELECT 
                i.estado,
                i.referencia,
                i.comprobante,
                i.fecha,
                cp.imagen,
                c.nombre AS nombre_curso,
                u.nombre AS nombre_estudiante,
                u.apellido AS apellido_estudiante,
                u.cedula,
                u.correo,
                u.telefono,
                cp.precio AS valor_curso
            FROM inscripcion i
            JOIN curso_promocion cp ON i.id_curso_promocion = cp.id
            JOIN curso c ON cp.id_curso = c.id
            JOIN estudiante e ON i.id_estudiante = e.id
            JOIN usuario u ON e.usuario_id = u.id
            WHERE i.id_estudiante = (
                SELECT id FROM estudiante WHERE usuario_id = $usuario_id
            )
            ORDER BY i.id DESC
            ";
          $resultSolicitudes = $conex->query($querySolicitudes);
          ?>

          <div class="box-cards box-card-pendientes" id="pendientes">
            <?php
            $hayPendientes = false;
            $resultSolicitudes->data_seek(0);
            while($sol = $resultSolicitudes->fetch_assoc()):
              if($sol['estado'] == 'pendiente'):
                $hayPendientes = true;
            ?>
                <div style="height:max-content;" class="card-pendientes card-style">
                  <div class="card-info">
                  
                    <div class="card-img" style="cursor:pointer"
                        onclick="abrirModalComprobante('../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>')">
                      <span class="title-c">Comprobante</span>
                      <?php if (!empty($sol['comprobante'])): ?>
                        <img src="../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>" alt="Comprobante">
                      <?php else: ?>
                        <span>No subido</span>
                      <?php endif; ?>
                    </div>
                    <div class="card-col left">
                      <div class="card-field">
                        <span class="card-label">Nombre:</span> <?= htmlspecialchars($sol['nombre_estudiante'] . ' ' . $sol['apellido_estudiante']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Cédula:</span> <?= htmlspecialchars($sol['cedula']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Correo:</span> <?= htmlspecialchars($sol['correo']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Teléfono:</span> <?= htmlspecialchars($sol['telefono']) ?>
                      </div>
                    </div>
                    <div class="card-col right">
                      <div class="card-field">
                        <span class="card-label">Curso:</span> <?= htmlspecialchars($sol['nombre_curso']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Referencia:</span> <?= htmlspecialchars($sol['referencia']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de pago:</span> <?= date("d/m/Y", strtotime($sol['fecha'])) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Valor del curso:</span> <?= number_format($sol['valor_curso'], 2, ',', '.') ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Estado:</span>
                        <span style="color:
                          <?php
                            if($sol['estado']=='pendiente') echo '#d81b60';
                            elseif($sol['estado']=='aprobada') echo '#43a047';
                            else echo '#e53935';
                          ?>">
                          <?= ucfirst($sol['estado']) ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
              endif;
            endwhile;
            if(!$hayPendientes):
            ?>
              <p>No hay solicitudes pendientes para mostrar.</p>
            <?php endif; ?>
          </div>
          
          
          <div class="box-cards box-card-aprobados" id="aprobados">
            <?php
            $resultSolicitudes->data_seek(0);
            $hayAprobados = false;
            while($sol = $resultSolicitudes->fetch_assoc()):
              if($sol['estado'] == 'aprobada'):
                $hayAprobados = true;
            ?>
              <div class="card-aprobados card-style">
                <div class="card-info">
                  <div class="card-img" style="cursor:pointer"
                    onclick="abrirModalComprobante('../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>')">
                    <span class="title-c">Comprobante</span>
                    <?php if (!empty($sol['comprobante'])): ?>
                      <img src="../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>" alt="Comprobante">
                    <?php else: ?>
                      <span>No subido</span>
                    <?php endif; ?>
                  </div>
                   <div class="card-col left">
                      <div class="card-field">
                        <span class="card-label">Nombre:</span> <?= htmlspecialchars($sol['nombre_estudiante'] . ' ' . $sol['apellido_estudiante']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Cédula:</span> <?= htmlspecialchars($sol['cedula']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Correo:</span> <?= htmlspecialchars($sol['correo']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Teléfono:</span> <?= htmlspecialchars($sol['telefono']) ?>
                      </div>
                    </div>
                    <div class="card-col right">
                      <div class="card-field">
                        <span class="card-label">Curso:</span> <?= htmlspecialchars($sol['nombre_curso']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Referencia:</span> <?= htmlspecialchars($sol['referencia']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de pago:</span> <?= date("d/m/Y", strtotime($sol['fecha'])) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Valor del curso:</span> <?= number_format($sol['valor_curso'], 2, ',', '.') ?>
                      </div>
                    <div class="card-field">
                      <span class="card-label">Estado:</span>
                      <span style="color:
                        <?php
                          if($sol['estado']=='pendiente') echo '#d81b60';
                          elseif($sol['estado']=='aprobada') echo '#43a047';
                          else echo '#e53935';
                        ?>">
                        <?= ucfirst($sol['estado']) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            <?php
              endif;
            endwhile;
            if(!$hayAprobados):
            ?>
              <p>No hay solicitudes aprobadas para mostrar.</p>
            <?php endif; ?>
          </div>

  
          <div class="box-cards box-card-rechazados" id="rechazados">
            <?php
            $resultSolicitudes->data_seek(0);
            $hayRechazados = false;
            while($sol = $resultSolicitudes->fetch_assoc()):
              if($sol['estado'] == 'rechazada'):
                $hayRechazados = true;
            ?>
              <div class="card-rechazados card-style">
                <div class="card-info">
                  <div class="card-img" style="cursor:pointer"
                    onclick="abrirModalComprobante('../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>')">
                    <span class="title-c">Comprobante</span>
                    <?php if (!empty($sol['comprobante'])): ?>
                      <img src="../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>" alt="Comprobante">
                    <?php else: ?>
                      <span>No subido</span>
                    <?php endif; ?>
                  </div>
                   <div class="card-col left">
                    <div class="card-field">
                      <span class="card-label">Nombre:</span> <?= htmlspecialchars($sol['nombre_estudiante'] . ' ' . $sol['apellido_estudiante']) ?>
                    </div>
                    <div class="card-field">
                      <span class="card-label">Cédula:</span> <?= htmlspecialchars($sol['cedula']) ?>
                    </div>
                    <div class="card-field">
                      <span class="card-label">Correo:</span> <?= htmlspecialchars($sol['correo']) ?>
                    </div>
                    <div class="card-field">
                      <span class="card-label">Teléfono:</span> <?= htmlspecialchars($sol['telefono']) ?>
                    </div>
                  </div>
                  <div class="card-col right">
                    <div class="card-field">
                      <span class="card-label">Curso:</span> <?= htmlspecialchars($sol['nombre_curso']) ?>
                    </div>
                    <div class="card-field">
                      <span class="card-label">Referencia:</span> <?= htmlspecialchars($sol['referencia']) ?>
                    </div>
                    <div class="card-field">
                      <span class="card-label">Fecha de pago:</span> <?= date("d/m/Y", strtotime($sol['fecha'])) ?>
                    </div>
                    <div class="card-field">
                      <span class="card-label">Valor del curso:</span> <?= number_format($sol['valor_curso'], 2, ',', '.') ?>
                    </div>
                    <div class="card-field">
                      <span class="card-label">Estado:</span>
                      <span style="color:
                        <?php
                          if($sol['estado']=='pendiente') echo '#d81b60';
                          elseif($sol['estado']=='aprobada') echo '#43a047';
                          else echo '#e53935';
                        ?>">
                        <?= ucfirst($sol['estado']) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            <?php
              endif;
            endwhile;
            if(!$hayRechazados):
            ?>
              <p>No hay solicitudes rechazadas para mostrar.</p>
            <?php endif; ?>
          </div>

          <div class="box-cards box-card-todos" id="todos">
            <?php
            $resultSolicitudes->data_seek(0);
            $hayTodas = false;
            while($sol = $resultSolicitudes->fetch_assoc()):
              $hayTodas = true;
            ?>
              <div class="card-todos card-style">
                <div class="card-info">
                  <div class="card-img" style="cursor:pointer"
                    onclick="abrirModalComprobante('../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>')">
                    <span class="title-c">Comprobante</span>
                    <?php if (!empty($sol['comprobante'])): ?>
                      <img src="../../uploads/comprobantes/<?= htmlspecialchars($sol['comprobante']) ?>" alt="Comprobante">
                    <?php else: ?>
                      <span>No subido</span>
                    <?php endif; ?>
                  </div>
                   <div class="card-col left">
                      <div class="card-field">
                        <span class="card-label">Nombre:</span> <?= htmlspecialchars($sol['nombre_estudiante'] . ' ' . $sol['apellido_estudiante']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Cédula:</span> <?= htmlspecialchars($sol['cedula']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Correo:</span> <?= htmlspecialchars($sol['correo']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Teléfono:</span> <?= htmlspecialchars($sol['telefono']) ?>
                      </div>
                    </div>
                    <div class="card-col right">
                      <div class="card-field">
                        <span class="card-label">Curso:</span> <?= htmlspecialchars($sol['nombre_curso']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Referencia:</span> <?= htmlspecialchars($sol['referencia']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de pago:</span> <?= date("d/m/Y", strtotime($sol['fecha'])) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Valor del curso:</span> <?= number_format($sol['valor_curso'], 2, ',', '.') ?>
                      </div>
                    <div class="card-field">
                      <span class="card-label">Estado:</span>
                      <span style="color:
                        <?php
                          if($sol['estado']=='pendiente') echo '#d81b60';
                          elseif($sol['estado']=='aprobada') echo '#43a047';
                          else echo '#e53935';
                        ?>">
                        <?= ucfirst($sol['estado']) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile;
            if(!$hayTodas):
            ?>
              <p>No hay solicitudes para mostrar.</p>
            <?php endif; ?>
          </div>
                  ?>
                </div>
  </main>


   <!-- Modal para comprobante -->
      <div id="modal-comprobante" class="modal-comprobante none">
        <span class="close-modal" onclick="cerrarModalComprobante()">&times;</span>
        <img id="img-modal-comprobante" src="" alt="Comprobante grande">
      </div>

      <script>
function abrirModalComprobante(src) {
  document.getElementById('img-modal-comprobante').src = src;
  document.getElementById('modal-comprobante').classList.remove('none');
}
function cerrarModalComprobante() {
  document.getElementById('modal-comprobante').classList.add('none');
}
</script>
</body>

</html>