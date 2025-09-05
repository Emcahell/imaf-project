<?php
// filepath: c:\xampp\htdocs\imaf-project\pages\profesor\cursos.php
include("../../backend/conexion.php");
session_start();


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

// Cursos activos (disponibles o en curso)
$queryCursosActivos = "
SELECT cp.*, c.nombre AS nombre_curso
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
WHERE cp.id_profesor = $empleado_id AND cp.estado IN ('disponible', 'en_curso')
ORDER BY cp.fecha_inicio DESC
";
$resultCursosActivos = mysqli_query($conex, $queryCursosActivos);

// Cursos terminados
$queryCursosTerminados = "
SELECT cp.*, c.nombre AS nombre_curso
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
WHERE cp.id_profesor = $empleado_id AND cp.estado = 'terminado'
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

    <style>
        /* Puedes agregar esto en tu archivo CSS o dentro de <style> en cursos.php */
// filepath: c:\xampp\htdocs\imaf-project\styles\profesores\cards-cursos.css

#graduar-modal .modal-content {
    padding: 40px 30px;
    border-radius: 16px;
    min-width: 500px;
    max-width: 98vw;
    width: 80vw;
    box-shadow: 0 4px 24px #0003;
    position: relative;
    background: #fff;
}

#graduar-modal h2 {
    margin-bottom: 28px;
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
}

#graduar-list table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
}

#graduar-list th, #graduar-list td {
    text-align: center;
    padding: 14px 10px;
    font-size: 1.1rem;
    background: #f9f9f9;
    border-radius: 8px;
}

#graduar-list th {
    background: #f0f0f0;
    font-weight: bold;
    font-size: 1.15rem;
}

#graduar-list tr {
    margin-bottom: 12px;
}

#graduar-list .btn-certificado {
    margin-left: 8px;
}

#graduar-list .graduado-label {
    color: #43a047;
    font-weight: bold;
    margin-right: 8px;
}
    </style>
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
                                <span class="card-label">Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Profesor:</span> <?= htmlspecialchars($docente['nombre'] . ' ' . $docente['apellido']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                            </div>
                            <a
                                href="<?= !empty($curso['whatsapp_link']) ? htmlspecialchars($curso['whatsapp_link']) : 'javascript:void(0);' ?>"
                                target="_blank"
                                title="Grupo WhatsApp"
                                style="margin-left:8px;display:inline-block;cursor:pointer;"
                                <?php if (empty($curso['whatsapp_link'])): ?>
                                    onclick="openWhatsappModal(<?= $curso['id'] ?>); return false;"
                                <?php endif; ?>
                                >
                                    <svg style="width:40px; margin-top:6px; " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="32" height="32">
                                        <path fill="#63E6BE" d="M188.1 318.6C188.1 343.5 195.1 367.8 208.3 388.7L211.4 393.7L198.1 442.3L248 429.2L252.8 432.1C273 444.1 296.2 450.5 319.9 450.5L320 450.5C392.6 450.5 453.3 391.4 453.3 318.7C453.3 283.5 438.1 250.4 413.2 225.5C388.2 200.5 355.2 186.8 320 186.8C247.3 186.8 188.2 245.9 188.1 318.6zM370.8 394C358.2 395.9 348.4 394.9 323.3 384.1C286.5 368.2 261.5 332.6 256.4 325.4C256 324.8 255.7 324.5 255.6 324.3C253.6 321.7 239.4 302.8 239.4 283.3C239.4 264.9 248.4 255.4 252.6 251C252.9 250.7 253.1 250.5 253.3 250.2C256.9 246.2 261.2 245.2 263.9 245.2C266.5 245.2 269.2 245.2 271.5 245.3L272.3 245.3C274.6 245.3 277.5 245.3 280.4 252.1C281.6 255 283.4 259.4 285.3 263.9C288.6 271.9 292 280.2 292.6 281.5C293.6 283.5 294.3 285.8 292.9 288.4C289.5 295.2 286 298.8 283.6 301.4C280.5 304.6 279.1 306.1 281.3 310C296.6 336.3 311.9 345.4 335.2 357.1C339.2 359.1 341.5 358.8 343.8 356.1C346.1 353.5 353.7 344.5 356.3 340.6C358.9 336.6 361.6 337.3 365.2 338.6C368.8 339.9 388.3 349.5 392.3 351.5C393.1 351.9 393.8 352.2 394.4 352.5C397.2 353.9 399.1 354.8 399.9 356.1C400.8 358 400.8 366 397.5 375.2C394.2 384.5 378.4 392.9 370.8 394zM544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM244.1 457.9L160 480L182.5 397.8C168.6 373.8 161.3 346.5 161.3 318.5C161.4 231.1 232.5 160 319.9 160C362.3 160 402.1 176.5 432.1 206.5C462 236.5 480 276.3 480 318.7C480 406.1 407.3 477.2 319.9 477.2C293.3 477.2 267.2 470.5 244.1 457.9z"/>
                                    </svg>
                                </a>
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
                                <span class="card-label"> Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"> Cupos Restantes:</span> <?= $cupos_restantes ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label"> Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                            </div>
        
                            <form method="POST" action="/imaf-project/backend/finalizar_curso.php">
                                <input type="hidden" name="finalizar_curso" value="<?= $curso['id'] ?>">
                                <button style="margin-top:10px;" type="submit" class="btn-finalizar">Finalizar</button>
                            </form>
                
                        </div>
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
                                <span class="card-label">Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Profesor:</span> <?= htmlspecialchars($docente['nombre'] . ' ' . $docente['apellido']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                            </div>
                        </div>
                        <div class="card-col right">
                            <span style="font-size:0.6rem;" class="card-label">
                                <img src="/imaf-project/assets/icons/eye.svg"
                                    style="width:16px;vertical-align:middle;cursor:pointer;"
                                    onclick="openGraduarModal(<?= $curso['id'] ?>)">
                                Participantes: <?= $total_participantes ?>
                            </span>
                            <div class="card-field">
                                <span class="card-label">Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Cupos Restantes:</span> <?= $cupos_restantes ?>
                            </div>
                            <div class="card-field">
                                <span class="card-label">Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                            </div>
                            <div style="margin-top:10px;">
                                <span style="color:red;font-weight:bold;font-size:0.6rem;">Terminado</span>
                            </div>
                            <?php
                                $q = mysqli_query($conex, "SELECT graduado FROM curso_participante WHERE id_curso_promocion = {$curso['id']} AND id_estudiante = {$_SESSION['usuario_id']}");
                                $row = mysqli_fetch_assoc($q);
                                if ($row && $row['graduado']) {
                                    echo '<a href="/imaf-project/backend/descargar_certificado.php?curso_id='.$curso['id'].'" class="btn-certificado" style="background:#43a047;color:#fff;font-weight:bold;border:none;padding:8px 24px;border-radius:8px;cursor:pointer;">Descargar certificado</a>';
                                }
                            ?>
                        </div>
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
        cardsArea.style.display = 'grid';
        cardsTerminados.style.display = 'none';
    });

    btnTerminados.addEventListener('click', () => {
        btnTerminados.classList.add('active');
        btnRealizados.classList.remove('active');
        cardsArea.style.display = 'none';
        cardsTerminados.style.display = 'grid';
    });
</script>

<!-- Modal de participantes  -->
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



<script>

    //modal de graduar participantes

function openGraduarModal(cursoId) {
    document.getElementById('graduar-modal').style.display = 'flex';
    fetch('ajax_graduar.php?curso_id=' + cursoId)
        .then(res => res.text())
        .then(html => {
            document.getElementById('graduar-list').innerHTML = html;
        });
}
function closeGraduarModal() {
    document.getElementById('graduar-modal').style.display = 'none';
}

//funcion de graduar participantes
function graduarParticipante(id, cursoId, btn) {
    fetch('ajax_graduar.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'graduar=1&id=' + id + '&curso_id=' + cursoId
    })
    .then(() => {
        // Actualiza la fila: muestra "Graduado" y el botón de certificado
        const td = btn.parentNode;
        td.innerHTML = "<span style='color:green;font-weight:bold;'>Graduado</span> <a href='/imaf-project/backend/descargar_certificado.php?participante_id=" + id + "' class='btn-certificado' style='background:#43a047;color:#fff;font-weight:bold;border:none;padding:6px 16px;border-radius:8px;cursor:pointer;'>Descargar certificado</a>";
    });
}

</script>

<!-- Modal para graduar participantes -->

<div id="graduar-modal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:#0005;justify-content:center;align-items:center;z-index:999;">
    <div class="modal-content">
        <span style="position:absolute;top:18px;right:22px;cursor:pointer;font-size:2em;" onclick="closeGraduarModal()">&times;</span>
        <h2>Graduar participantes</h2>
        <div id="graduar-list" style="margin-bottom:18px;max-height:350px;overflow-y:auto;">
            <!-- Se carga la lista vía AJAX -->
        </div>
    </div>
</div>
  </body>
</html>