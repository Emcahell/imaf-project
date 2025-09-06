<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../../assets/logo-imaf.ico" type="image/x-icon" />
  <link rel="stylesheet" href="/imaf-project/styles/solicitudes.css" />
  <link rel="stylesheet" href="../../styles/header.css" />
  <link rel="stylesheet" href="../../styles/sidebar.css" />
  <link rel="stylesheet" href="../../styles/transitionPages.css">
  <script src="../../scripts/transitionPages.js" defer></script>
  <script src="../../scripts/header.js" defer></script>
  <script src="../../scripts/solicitudes.js" defer></script>
  <title>IMAF | Solicitudes</title>
 <style>
  .card-style{
    height:max-content;
  }
 </style>
</head>

<body>
  <main>
    <?php
    session_start();
    include("../../backend/conexion.php");
    $usuario_id = $_SESSION['usuario_id'];
    $qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'administrador' AS rol FROM usuario WHERE id = $usuario_id");
    $usuario = mysqli_fetch_assoc($qUsuario);

    include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
    ?>

    <section>
      <article class="sidebar">
        <nav>
          <ul>
            <li>
              <a href="./usuarios.php">
                <svg class="icon-nav" viewBox="0 0 448 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                </svg>
                Usuarios
              </a>
            </li>
            <li>
              <a href="./cursos.php">
                <svg class="icon-nav icon-cursos" viewBox="0 0 512 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z" />
                </svg>
                Cursos
              </a>
            </li>
            <li class="li-location">
              <a class="location">
                <svg class="icon-nav location" viewBox="0 0 512 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z" />
                </svg>
                Solicitudes
              </a>
            </li>
            <li>
              <a href="./crear.php">
                <svg class="icon-nav" viewBox="0 0 448 512">
                  <path
                    d="M64 80c-8.8 0-16 7.2-16 16l0 320c0 8.8 7.2 16 16 16l320 0c8.8 0 16-7.2 16-16l0-320c0-8.8-7.2-16-16-16L64 80zM0 96C0 60.7 28.7 32 64 32l320 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM200 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg>
                Crear
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

        <div class="search-box" style="margin: 10px 0;">
          <input type="text" id="busqueda-cards" placeholder="Buscar por cualquier dato..." style="width:100%;padding:8px 14px;border-radius:8px;border:1px solid #ccc;">
        </div>
        <div class="contenido">

          <?php
          $queryPendientes = "
          SELECT 
              i.id,
              i.comprobante,
              i.referencia,
              i.estado,
              i.fecha,
              i.id_estudiante,
              i.id_curso_promocion,
              cp.precio AS valor_curso,
              cp.fecha_inicio,
              cp.fecha_fin,
              c.nombre AS nombre_curso,
              u.nombre AS nombre_estudiante,
              u.apellido AS apellido_estudiante,
              u.cedula,
              u.correo,
              u.telefono
          FROM inscripcion i
          JOIN curso_promocion cp ON i.id_curso_promocion = cp.id
          JOIN curso c ON cp.id_curso = c.id
          JOIN estudiante e ON i.id_estudiante = e.id
          JOIN usuario u ON e.usuario_id = u.id
          WHERE i.estado = 'pendiente'
          ORDER BY i.fecha DESC
          ";
          $resultPendientes = mysqli_query($conex, $queryPendientes);
          ?>

          <div class="box-cards box-card-pendientes" id="pendientes">
            <?php if (mysqli_num_rows($resultPendientes)): ?>
              <?php while($sol = mysqli_fetch_assoc($resultPendientes)): ?>
                <div class="card-pendientes card-style">
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
                    </div>
                  </div>
                  <div class="box-buttons">
                    <form method="POST" action="/imaf-project/backend/aprobar_inscripcion.php" style="display:inline;">
                      <input type="hidden" name="inscripcion_id" value="<?= $sol['id'] ?>">
                      <button class="aprobar" type="submit">Aprobar</button>
                    </form>
                    <form method="POST" action="/imaf-project/backend/rechazar_inscripcion.php" style="display:inline;">
                      <input type="hidden" name="inscripcion_id" value="<?= $sol['id'] ?>">
                      <button class="rechazar" type="submit">Rechazar</button>
                    </form>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay solicitudes pendientes para mostrar.</p>
            <?php endif; ?>
          </div>
          
          <?php
          // Solicitudes aprobadas
          $queryAprobados = "
          SELECT 
              i.id,
              i.comprobante,
              i.referencia,
              i.estado,
              i.fecha,
              i.id_estudiante,
              i.id_curso_promocion,
              cp.precio AS valor_curso,
              cp.fecha_inicio,
              cp.fecha_fin,
              c.nombre AS nombre_curso,
              u.nombre AS nombre_estudiante,
              u.apellido AS apellido_estudiante,
              u.cedula,
              u.correo,
              u.telefono
          FROM inscripcion i
          JOIN curso_promocion cp ON i.id_curso_promocion = cp.id
          JOIN curso c ON cp.id_curso = c.id
          JOIN estudiante e ON i.id_estudiante = e.id
          JOIN usuario u ON e.usuario_id = u.id
          WHERE i.estado = 'aprobada'
          ORDER BY i.fecha DESC
          ";
          $resultAprobados = mysqli_query($conex, $queryAprobados);
          ?>

          <!-- Aprobadas -->
          <div class="box-cards box-card-aprobados" id="aprobados" style="display:none;">
            <?php if (mysqli_num_rows($resultAprobados)): ?>
              <?php while($sol = mysqli_fetch_assoc($resultAprobados)): ?>
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
                        <span style="color:#43a047;">
                          <?= ucfirst($sol['estado']) ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay solicitudes aprobadas para mostrar.</p>
            <?php endif; ?>
          </div>


          <?php
          $queryTodos = "
          SELECT 
              i.id,
              i.comprobante,
              i.referencia,
              i.estado,
              i.fecha,
              i.id_estudiante,
              i.id_curso_promocion,
              cp.precio AS valor_curso,
              cp.fecha_inicio,
              cp.fecha_fin,
              c.nombre AS nombre_curso,
              u.nombre AS nombre_estudiante,
              u.apellido AS apellido_estudiante,
              u.cedula,
              u.correo,
              u.telefono
          FROM inscripcion i
          JOIN curso_promocion cp ON i.id_curso_promocion = cp.id
          JOIN curso c ON cp.id_curso = c.id
          JOIN estudiante e ON i.id_estudiante = e.id
          JOIN usuario u ON e.usuario_id = u.id
          ORDER BY i.fecha DESC
          ";
          $resultTodos = mysqli_query($conex, $queryTodos);
          ?>

          <?php

          // Solicitudes rechazadas
          $queryRechazados = "
          SELECT 
              i.id,
              i.comprobante,
              i.referencia,
              i.estado,
              i.fecha,
              i.id_estudiante,
              i.id_curso_promocion,
              cp.precio AS valor_curso,
              cp.fecha_inicio,
              cp.fecha_fin,
              c.nombre AS nombre_curso,
              u.nombre AS nombre_estudiante,
              u.apellido AS apellido_estudiante,
              u.cedula,
              u.correo,
              u.telefono
          FROM inscripcion i
          JOIN curso_promocion cp ON i.id_curso_promocion = cp.id
          JOIN curso c ON cp.id_curso = c.id
          JOIN estudiante e ON i.id_estudiante = e.id
          JOIN usuario u ON e.usuario_id = u.id
          WHERE i.estado = 'rechazada'
          ORDER BY i.fecha DESC
          ";
          $resultRechazados = mysqli_query($conex, $queryRechazados);
          ?>

          <!-- Rechazadas -->
          <div class="box-cards box-card-rechazados" id="rechazados" style="display:none;">
            <?php if (mysqli_num_rows($resultRechazados)): ?>
              <?php while($sol = mysqli_fetch_assoc($resultRechazados)): ?>
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
                        <span style="color:#e53935;">
                          <?= ucfirst($sol['estado']) ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay solicitudes rechazadas para mostrar.</p>
            <?php endif; ?>
          </div>

          <div class="box-cards box-card-todos" id="todos" style="display:none;">
            <?php if (mysqli_num_rows($resultTodos)): ?>
              <?php while($sol = mysqli_fetch_assoc($resultTodos)): ?>
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
                        <span style="color:<?= $sol['estado']=='pendiente' ? '#d81b60' : ($sol['estado']=='aprobada' ? '#43a047' : '#e53935') ?>;">
                          <?= ucfirst($sol['estado']) ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay solicitudes para mostrar.</p>
            <?php endif; ?>
          </div>

        </div>
      </article>
    </section>
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

// Filtro de búsqueda para solicitudes
document.getElementById('busqueda-cards').addEventListener('input', function() {
  const filtro = this.value.toLowerCase();

  // Filtra en cada sección de solicitudes
  ['pendientes', 'aprobados', 'rechazados', 'todos'].forEach(id => {
    const box = document.getElementById(id);
    if (box) {
      box.querySelectorAll('.card-style').forEach(card => {
        const texto = card.innerText.toLowerCase();
        card.style.display = texto.includes(filtro) ? '' : 'none';
      });
    }
  });
});
</script>
</body>

</html>