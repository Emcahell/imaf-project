<?php
// filepath: c:\xampp\htdocs\imaf-project\pages\profesor\cursos.php
include("../../backend/conexion.php");
session_start();

// Procesar finalización de curso
if (isset($_POST['finalizar_curso'])) {
    $id = intval($_POST['finalizar_curso']);
    mysqli_query($conex, "UPDATE curso_promocion SET finalizado = 1 WHERE id = $id");
    header("Location: cursos.php");
    exit;
}

// Validar sesión
$cedula = $_SESSION['cedula'] ?? null;
if (!$cedula) {
    header("Location: ../../index.php");
    exit;
}

// Obtener empleado_id del docente
$query = "SELECT u.id AS usuario_id, e.id AS empleado_id, u.nombre, u.apellido
          FROM usuario u
          JOIN empleado e ON e.usuario_id = u.id
          WHERE u.cedula = '$cedula' AND e.tipo_empleado = 'docente'";
$result = mysqli_query($conex, $query);
$docente = mysqli_fetch_assoc($result);

if (!$docente) {
    echo "<p>No tienes cursos asignados.</p>";
    exit;
}

$empleado_id = $docente['empleado_id'];

// Cursos activos
$queryCursosActivos = "
SELECT cp.*, c.nombre AS nombre_curso
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
WHERE cp.id_profesor = $empleado_id AND cp.finalizado = 0
ORDER BY cp.fecha_inicio DESC
";
$resultCursosActivos = mysqli_query($conex, $queryCursosActivos);

// Cursos terminados
$queryCursosTerminados = "
SELECT cp.*, c.nombre AS nombre_curso
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
WHERE cp.id_profesor = $empleado_id AND cp.finalizado = 1
ORDER BY cp.fecha_inicio DESC
";
$resultCursosTerminados = mysqli_query($conex, $queryCursosTerminados);
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
    <link rel="stylesheet" href="../../styles/globals.css" />
    <link rel="stylesheet" href="../../styles/profesores/sidebar.css" />
    <link rel="stylesheet" href="../../styles/header.css" />
    <link rel="stylesheet" href="../../styles/cursos.css" />
    <link rel="stylesheet" href="../../styles/profesores/cards-cursos.css" />
    <script src="../../scripts/headerDocente.js" defer></script>
    <script src="../../scripts/profesor/cursos.js" defer></script>
    <title>IMAF | Cursos</title>
  </head>
  <body>
    <?php

    $usuario_id = $_SESSION['usuario_id'];
    $qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'docente' AS rol FROM usuario WHERE id = $usuario_id");
    $usuario = mysqli_fetch_assoc($qUsuario);

    include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
    ?>
    <!-- El resto de tu página -->

    <div class="container">
      <article class="sidebar">
        <nav>
          <ul>
            <li class="li-location">
              <a class="location">
                <svg
                  class="icon-nav icon-cursos location"
                  viewBox="0 0 512 512"
                >
                  <path
                    d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"
                  />
                </svg>
                Cursos
              </a>
            </li>

            <li>
              <a href="../../index.php">
                <svg class="icon-nav" viewBox="0 0 512 512">
                  <path
                    d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"
                  />
                </svg>
                Salir
              </a>
            </li>
          </ul>
        </nav>
      </article>

     <div class="right-column">
    <div class="right-bottom">
        <div class="dashboard-options">
            <button id="btn-realizados" class="tab-btn active">Realizando</button>
            <button id="btn-terminados" class="tab-btn">Terminados</button>
        </div>
        <div class="label-box">
            <span>Datos</span>
        </div>
    </div>

    <!-- Cursos activos -->
    <div class="cards-area" id="cards-area">
        <?php if (mysqli_num_rows($resultCursosActivos) > 0): ?>
            <?php while($curso = mysqli_fetch_assoc($resultCursosActivos)): ?>
                <?php
                // Obtener participantes
                $id_curso_promocion = $curso['id'];
                $q = mysqli_query($conex, "SELECT COUNT(*) AS total FROM curso_participante WHERE id_curso_promocion = $id_curso_promocion");
                $total_participantes = mysqli_fetch_assoc($q)['total'];
                $cupos_restantes = $curso['cupos'] - $total_participantes;
                ?>
                <div class="card-activos card-style">
                    <div class="card-img">
                        <img src="<?= !empty($curso['imagen']) ? '../../uploads/cursos/' . htmlspecialchars($curso['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' ?>" alt="imagen del curso" />
                    </div>
                    <div class="card-info" style="display:flex;justify-content:space-between;align-items:flex-start;">
                        <div class="card-col left">
                            <div class="card-field">
                                <span class="card-label"><img src="../../assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="../../assets/icons/eye.svg" style="width:16px;vertical-align:middle;"> Profesor:</span> <?= htmlspecialchars($docente['nombre'] . ' ' . $docente['apellido']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="../../assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="../../assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                            </div>
                        </div>
                        <div class="card-col right">
                            <div class="card-field">
                                <span class="card-label">
                                    <img src="/imaf-project/assets/icons/eye.svg"
                                         style="width:16px;vertical-align:middle;cursor:pointer;"
                                         onclick="openParticipantesModal(<?= $curso['id'] ?>)"
                                         
                                    >
                                    Participantes:
                                </span>
                                <?= $total_participantes ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="../../assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="../../assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Cupos Restantes:</span> <?= $cupos_restantes ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="../../assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;">
                        <form method="POST">
                            <input type="hidden" name="finalizar_curso" value="<?= $curso['id'] ?>">
                            <button type="submit" class="btn-finalizar" style="background:#7fffa7;color:#222;font-weight:bold;border:none;padding:10px 30px;border-radius:8px;cursor:pointer;">Finalizar</button>
                        </form>
                        <?php if (!empty($curso['whatsapp_link'])): ?>
                            <a href="<?= htmlspecialchars($curso['whatsapp_link']) ?>" target="_blank" class="btn-wsp" style="background:#7fffa7;color:#222;font-weight:bold;border:none;padding:10px 30px;border-radius:8px;text-decoration:none;">WhatsApp</a>
                        <?php else: ?>
                            <button class="btn-wsp" type="button" style="background:#7fffa7;color:#222;font-weight:bold;border:none;padding:10px 30px;border-radius:8px;cursor:pointer;" onclick="openWhatsappModal(<?= $curso['id'] ?>)">WhatsApp</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes cursos asignados.</p>
        <?php endif; ?>
    </div>
    <!-- fin area activos -->

    <!-- Cursos terminados -->
    <div class="cards-area" id="cards-terminados" style="display:none;">
        <?php if (mysqli_num_rows($resultCursosTerminados) > 0): ?>
            <?php while($curso = mysqli_fetch_assoc($resultCursosTerminados)): ?>
                <?php
                $id_curso_promocion = $curso['id'];
                $q = mysqli_query($conex, "SELECT COUNT(*) AS total FROM curso_participante WHERE id_curso_promocion = $id_curso_promocion");
                $total_participantes = mysqli_fetch_assoc($q)['total'];
                $cupos_restantes = $curso['cupos'] - $total_participantes;
                ?>
                <div class="card-terminados card-style">
                    <div class="card-img">
                        <img src="<?= !empty($curso['imagen']) ? '../../uploads/cursos/' . htmlspecialchars($curso['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' ?>" alt="imagen del curso" />
                    </div>
                    <div class="card-info" style="display:flex;justify-content:space-between;align-items:flex-start;">
                        <div class="card-col left">
                            <div class="card-field">
                                <span class="card-label"><img src="/imaf-project/assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"> Profesor:</span> <?= htmlspecialchars($docente['nombre'] . ' ' . $docente['apellido']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="/imaf-project/assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="/imaf-project/assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                            </div>
                        </div>
                        <div class="card-col right">
                            <div class="card-field">
                                <span class="card-label"><img src="/imaf-project/assets/icons/eye.svg" style="width:16px;vertical-align:middle;"> Participantes:</span> <?= $total_participantes ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="/imaf-project/assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="/imaf-project/assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Cupos Restantes:</span> <?= $cupos_restantes ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"><img src="/imaf-project/assets/icons/pen-to-square.svg" style="width:16px;vertical-align:middle;"> Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:10px;">
                        <span style="color:red;font-weight:bold;font-size:1.2em;">Terminado</span>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No tienes cursos terminados.</p>
        <?php endif; ?>
    </div>
    <!-- fin area terminados -->
</div>

<!-- Mini modal para agregar link WhatsApp -->
<div id="whatsapp-modal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:#0005;justify-content:center;align-items:center;z-index:999;">
    <div style="background:#fff;padding:30px 20px;border-radius:12px;min-width:300px;max-width:90vw;box-shadow:0 2px 8px #0002;position:relative;">
        <span style="position:absolute;top:10px;right:15px;cursor:pointer;font-size:1.5em;" onclick="closeWhatsappModal()">&times;</span>
        <form method="POST" id="form-whatsapp-link">
            <input type="hidden" name="curso_id" id="modal_curso_id" value="">
            <label for="whatsapp_link">Enlace de grupo WhatsApp:</label>
            <input type="url" name="whatsapp_link" id="whatsapp_link" required style="width:100%;margin:10px 0;padding:8px;border-radius:6px;border:1px solid #bbb;">
            <button type="submit" style="background:#7fffa7;color:#222;font-weight:bold;border:none;padding:8px 24px;border-radius:8px;cursor:pointer;">Guardar</button>
        </form>
    </div>
</div>

<?php
// Guardar el link de WhatsApp
if (isset($_POST['whatsapp_link'], $_POST['curso_id'])) {
    $link = mysqli_real_escape_string($conex, $_POST['whatsapp_link']);
    $curso_id = intval($_POST['curso_id']);
    mysqli_query($conex, "UPDATE curso_promocion SET whatsapp_link='$link' WHERE id=$curso_id");
    echo "<script>window.location.href='cursos.php';</script>";
    exit;
}
?>

<script>
function openWhatsappModal(cursoId) {
    document.getElementById('whatsapp-modal').style.display = 'flex';
    document.getElementById('modal_curso_id').value = cursoId;
}
function closeWhatsappModal() {
    document.getElementById('whatsapp-modal').style.display = 'none';
}
</script>

<script>
    // Simple JS para tabs
    const btnRealizados = document.getElementById('btn-realizados');
    const btnTerminados = document.getElementById('btn-terminados');
    const cardsArea = document.getElementById('cards-area');
    const cardsTerminados = document.getElementById('cards-terminados');

    btnRealizados.addEventListener('click', () => {
        btnRealizados.classList.add('active');
        btnTerminados.classList.remove('active');
        cardsArea.style.display = 'block';
        cardsTerminados.style.display = 'none';
    });

    btnTerminados.addEventListener('click', () => {
        btnTerminados.classList.add('active');
        btnRealizados.classList.remove('active');
        cardsArea.style.display = 'none';
        cardsTerminados.style.display = 'block';
    });
</script>

<!-- Modal de participantes mejorada -->
<div id="participantes-modal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:#0005;justify-content:center;align-items:center;z-index:999;">
    <div style="background:#fff;padding:40px 30px;border-radius:16px;min-width:500px;max-width:98vw;box-shadow:0 4px 24px #0003;position:relative;">
        <span style="position:absolute;top:18px;right:22px;cursor:pointer;font-size:2em;" onclick="closeParticipantesModal()">&times;</span>
        <h2 style="margin-bottom:18px;">Participantes del curso</h2>
        <div style="margin-bottom:18px;">
            <input type="text" id="busqueda-participante" placeholder="Buscar por nombre, apellido o cédula..." style="width:100%;padding:10px;border-radius:8px;border:1px solid #bbb;">
        </div>
        <div id="participantes-list" style="margin-bottom:18px;max-height:350px;overflow-y:auto;">
            <!-- Aquí se cargan los participantes vía AJAX -->
        </div>
        <form id="form-agregar-participante" style="display:flex;gap:10px;">
            <input type="hidden" name="curso_id" id="modal_participantes_curso_id" value="">
            <input type="text" name="cedula_estudiante" id="cedula_estudiante" placeholder="Cédula del estudiante" required style="padding:8px;border-radius:8px;border:1px solid #bbb;">
            <button type="submit" style="background:#7fffa7;color:#222;font-weight:bold;border:none;padding:8px 24px;border-radius:8px;cursor:pointer;">Agregar</button>
        </form>
    </div>
</div>

<script>
function openParticipantesModal(cursoId) {
    document.getElementById('participantes-modal').style.display = 'flex';
    document.getElementById('modal_participantes_curso_id').value = cursoId;
    cargarParticipantes(cursoId, '');
    document.getElementById('busqueda-participante').value = '';
}

function closeParticipantesModal() {
    document.getElementById('participantes-modal').style.display = 'none';
}

// Cargar participantes vía AJAX con filtro
function cargarParticipantes(cursoId, filtro) {
    fetch('ajax_participantes.php?curso_id=' + cursoId + '&filtro=' + encodeURIComponent(filtro))
        .then(res => res.text())
        .then(html => {
            document.getElementById('participantes-list').innerHTML = html;
        });
}

// Eliminar participante
function eliminarParticipante(id, cursoId) {
    fetch('ajax_participantes.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'eliminar=1&id=' + id + '&curso_id=' + cursoId
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('participantes-list').innerHTML = html;
    });
}

// Agregar participante
document.getElementById('form-agregar-participante').onsubmit = function(e) {
    e.preventDefault();
    const cursoId = document.getElementById('modal_participantes_curso_id').value;
    const cedula = document.getElementById('cedula_estudiante').value;
    fetch('ajax_participantes.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'agregar=1&curso_id=' + cursoId + '&cedula_estudiante=' + encodeURIComponent(cedula)
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('participantes-list').innerHTML = html;
        document.getElementById('cedula_estudiante').value = '';
    });
};

// Buscar participantes en tiempo real
document.getElementById('busqueda-participante').addEventListener('input', function() {
    const cursoId = document.getElementById('modal_participantes_curso_id').value;
    const filtro = this.value;
    cargarParticipantes(cursoId, filtro);
});
</script>
  </body>
</html>