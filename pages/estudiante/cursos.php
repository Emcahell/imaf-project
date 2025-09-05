<?php

include("../../backend/conexion.php");
session_start();
$usuario_id = $_SESSION['usuario_id'];
$qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'estudiante' AS rol FROM usuario WHERE id = $usuario_id");
$usuario = mysqli_fetch_assoc($qUsuario);

// Cambiar estado automáticamente según la fecha
$conex->query("UPDATE curso_promocion SET estado = 'en_curso' WHERE estado = 'disponible' AND CURDATE() >= fecha_inicio AND CURDATE() <= fecha_fin");

// Obtener el id del estudiante correspondiente al usuario actual
$qEst = mysqli_query($conex, "SELECT id FROM estudiante WHERE usuario_id = $usuario_id");
$rowEst = mysqli_fetch_assoc($qEst);
$estudiante_id = $rowEst['id'];

// Obtener los IDs de cursos en los que el estudiante ya está inscrito
$idsInscritos = [];
$qInscritos = mysqli_query($conex, "SELECT id_curso_promocion FROM curso_participante WHERE id_estudiante = $estudiante_id");
while ($row = mysqli_fetch_assoc($qInscritos)) {
    $idsInscritos[] = $row['id_curso_promocion'];
}

// IDs de cursos con solicitud pendiente
$idsPendientes = [];
$qPendientes = mysqli_query($conex, "
    SELECT id_curso_promocion 
    FROM inscripcion 
    WHERE id_estudiante = $estudiante_id AND estado = 'pendiente'
");
while ($row = mysqli_fetch_assoc($qPendientes)) {
    $idsPendientes[] = $row['id_curso_promocion'];
}

// Cursos NO inscritos (solo para el select)
$queryNoInscritos = "
SELECT 
    cp.id,
    c.nombre AS nombre_curso
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
WHERE cp.estado = 'disponible'
AND cp.id NOT IN (
    SELECT cp2.id_curso_promocion FROM curso_participante cp2 WHERE cp2.id_estudiante = $estudiante_id
)
ORDER BY cp.fecha_inicio DESC
";


// Cursos disponibles (activos y no inscritos)
$queryDisponibles = "
SELECT 
    cp.id,
    c.nombre AS nombre_curso,
    cp.imagen,
    cp.fecha_inicio,
    cp.fecha_fin,
    cp.cupos,
    cp.precio,
    u.nombre AS nombre_profesor,
    u.apellido AS apellido_profesor
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
JOIN empleado e ON cp.id_profesor = e.id
JOIN usuario u ON e.usuario_id = u.id
WHERE cp.estado = 'disponible'
ORDER BY cp.fecha_inicio DESC
";
$resultDisponibles = $conex->query($queryDisponibles);

// Cursos cursando (inscritos y aprobados)
// Cursos cursando (inscritos y aprobados)
$queryCursando = "
SELECT
    cp.id,
    c.nombre AS nombre_curso,
    cp.imagen,
    cp.fecha_inicio,
    cp.fecha_fin,
    cp.cupos,
    cp.precio,
    cp.whatsapp_link,
    u.nombre AS nombre_profesor,
    u.apellido AS apellido_profesor
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
JOIN empleado e ON cp.id_profesor = e.id
JOIN usuario u ON e.usuario_id = u.id
JOIN curso_participante cp2 ON cp2.id_curso_promocion = cp.id
WHERE cp2.id_estudiante = $estudiante_id
  AND cp.estado IN ('disponible', 'en_curso')
ORDER BY cp.fecha_inicio DESC
";
$resultCursando = $conex->query($queryCursando);

// Cursos oferta (activos y con cupos disponibles)
$queryOferta = "
SELECT 
    cp.id,
    c.nombre AS nombre_curso,
    cp.imagen,
    cp.fecha_inicio,
    cp.fecha_fin,
    cp.cupos,
    cp.precio,
    u.nombre AS nombre_profesor,
    u.apellido AS apellido_profesor
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
JOIN empleado e ON cp.id_profesor = e.id
JOIN usuario u ON e.usuario_id = u.id
WHERE cp.estado = 'disponible'
  AND cp.oferta = 1
ORDER BY cp.fecha_inicio DESC
";
$resultOferta = $conex->query($queryOferta);

// Cursos terminados o inactivos
$queryTerminados = "
SELECT
    cp.id,
    c.nombre AS nombre_curso,
    cp.imagen,
    cp.fecha_inicio,
    cp.fecha_fin,
    cp.cupos,
    cp.precio,
    u.nombre AS nombre_profesor,
    u.apellido AS apellido_profesor
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
JOIN empleado e ON cp.id_profesor = e.id
JOIN usuario u ON e.usuario_id = u.id
JOIN curso_participante cp2 ON cp2.id_curso_promocion = cp.id
WHERE cp2.id_estudiante = $estudiante_id
  AND cp.estado = 'terminado'
ORDER BY cp.fecha_fin DESC
";
$resultTerminados = $conex->query($queryTerminados);

include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../assets/logo-imaf.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../../styles/globals.css">
    <link rel="stylesheet" href="../../styles/sidebar.css" />
    <link rel="stylesheet" href="../../styles/header.css" />
    <link rel="stylesheet" href="../../styles/cursos.css" />
    <link rel="stylesheet" href="../../styles/transitionPages.css">
    <script src="../../scripts/transitionPages.js" defer></script>
    <script src="../../scripts/header.js" defer></script>
    <script src="/imaf-project/scripts/estudiante/cursos.js" defer></script>
    <title>IMAF | Cursos</title>
   <style>
      /* Modal overlay */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(30, 30, 30, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  transition: opacity 0.2s;
}

/* Oculta el modal cuando tiene la clase none */
.modal.none {
  display: none !important;
}

/* Modal content box */
.modal-content {
  background: #fff;
  border-radius: 16px;
  padding: 32px 28px 24px 28px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  min-width: 340px;
  max-width: 95vw;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  animation: modalIn 0.2s;
}

@keyframes modalIn {
  from { transform: translateY(40px) scale(0.95); opacity: 0; }
  to   { transform: translateY(0) scale(1); opacity: 1; }
}

.modal-content h2 {
  margin-top: 0;
  margin-bottom: 18px;
  font-size: 1.4rem;
  font-weight: 700;
  color: #d81b60;
}

.modal-content .close {
  position: absolute;
  top: 18px;
  right: 22px;
  font-size: 1.6rem;
  color: #888;
  cursor: pointer;
  transition: color 0.2s;
}
.modal-content .close:hover {
  color: #d81b60;
}

.form-group {
  margin-bottom: 18px;
}

.form-group label {
  display: block;
  font-weight: 500;
  margin-bottom: 6px;
  color: #333;
}

.form-group select,
.form-group input[type="text"],
.form-group input[type="file"] {
  width: 100%;
  padding: 8px 10px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  font-size: 1rem;
  margin-bottom: 4px;
  background: #fafafa;
  transition: border 0.2s;
}

.form-group input[type="file"] {
  padding: 4px 0;
}

#curso_img_preview img {
  margin-top: 6px;
  border-radius: 6px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}


.btn-inscribirse {
  background: #d81b60;
  color: #fff;
  border: none;
  border-radius: 6px;
padding: 6px 12px;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
  margin-top: 10px;
}
.btn-inscribirse:hover {
  background: #ad1457;
}
.btn-enviar {
  background: #d81b60;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 10px 24px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
  margin-top: 10px;
}
.btn-enviar:hover {
  background: #ad1457;
}
    </style>
  </head>
  <body>
    <div class="container">
      <article class="sidebar">
        <nav>
          <ul>
            <li class="li-location">
              <a class="location" href="cursos.php">
                <svg class="icon-nav icon-cursos location" viewBox="0 0 512 512">
                  <path d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z"/>
                </svg>
                Cursos
              </a>
            </li>
            <li>
              <a href="./solicitudes.php">
                <svg class="icon-nav" viewBox="0 0 512 512">
                  <path d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z"/>
                </svg>
                Solicitudes
              </a>
            </li>
            <li>
              <a href="../../index.php">
                <svg class="icon-nav" viewBox="0 0 512 512">
                  <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32z"/>
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
            <button class="tab-btn active" id="tab-disponibles">Disponibles</button>
            <button class="tab-btn" id="tab-cursando">Cursando</button>
            <button class="tab-btn" id="tab-oferta">Oferta</button>
            <button class="tab-btn" id="tab-terminados">Terminados</button>
          </div>
          <div class="label-box">
            <span>Datos</span>
          </div>
        </div>

        <!-- cards area -->
        <div class="cards-area" id="cards-area">
          <div class="cards-area" id="tab-content-disponibles">
            <?php if ($resultDisponibles->num_rows): ?>
              <?php while($curso = $resultDisponibles->fetch_assoc()): ?>
                <!-- Card de curso disponible -->
                <div class="card-disponibles card-style">
                  <div class="card-img">
                    <img src="<?= !empty($curso['imagen']) ? '../../uploads/cursos/' . htmlspecialchars($curso['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' ?>" alt="">
                  </div>
                  <div class="card-info">
                    <div class="card-col left">
                      <div class="card-field">
                        <span class="card-label">Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Profesor:</span> <?= htmlspecialchars($curso['nombre_profesor'] . ' ' . $curso['apellido_profesor']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                      </div>
                    </div>
                    <div class="card-col right">
                      <div class="card-field">
                        <span class="card-label">Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Cupos restantes:</span>
                        <?php
                          // Calcular cupos restantes
                          $qCupos = mysqli_query($conex, "SELECT COUNT(*) AS inscritos FROM curso_participante WHERE id_curso_promocion = " . intval($curso['id']));
                          $rowCupos = mysqli_fetch_assoc($qCupos);
                          $cupos_restantes = $curso['cupos'] - intval($rowCupos['inscritos']);
                          echo $cupos_restantes;
                        ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                      </div>
                      
                    <div class="card-field">
                      <?php if (in_array($curso['id'], $idsInscritos)): ?>
                        <button class="btn-inscribirse" disabled style="background:white;color:#43a047;cursor:default;">Inscrito</button>
                      <?php elseif (in_array($curso['id'], $idsPendientes)): ?>
                        <span style="background:white; font-size:0.7rem; color: #d4a900;">
                          Solicitud pendiente
                        </span>
                      <?php else: ?>
                        <button class="btn-inscribirse" onclick="abrirFormularioInscripcion(<?= $curso['id'] ?>)">Inscribirse</button>
                      <?php endif; ?>
                    </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay cursos disponibles para mostrar.</p>
            <?php endif; ?>
          </div>
          <div class="cards-area" id="tab-content-cursando" style="display:none;">
            <?php if ($resultCursando->num_rows): ?>
              <?php while($curso = $resultCursando->fetch_assoc()): ?>
                <!-- Card de curso cursando -->
                <div class="card-cursando card-style">
                  <div class="card-img">
                    <img src="<?= !empty($curso['imagen']) ? '../../uploads/cursos/' . htmlspecialchars($curso['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' ?>" alt="">
                  </div>
                  <div class="card-info">
                    <div class="card-col left">
                      <div class="card-field">
                        <span class="card-label">Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Profesor:</span> <?= htmlspecialchars($curso['nombre_profesor'] . ' ' . $curso['apellido_profesor']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                      </div>
                    </div>
                    <div class="card-col right">
                      <div class="card-field">
                        <span class="card-label">Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                      </div>
                      <?php if (!empty($curso['whatsapp_link'])): ?>
                        <a href="<?= htmlspecialchars($curso['whatsapp_link']) ?>" target="_blank" title="Grupo WhatsApp" style=" margin-left:8px;display:inline-block;">
                          <svg style="width:40px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="50px" height="50px">
                            <path fill="#63E6BE" width="50px" d="M188.1 318.6C188.1 343.5 195.1 367.8 208.3 388.7L211.4 393.7L198.1 442.3L248 429.2L252.8 432.1C273 444.1 296.2 450.5 319.9 450.5L320 450.5C392.6 450.5 453.3 391.4 453.3 318.7C453.3 283.5 438.1 250.4 413.2 225.5C388.2 200.5 355.2 186.8 320 186.8C247.3 186.8 188.2 245.9 188.1 318.6zM370.8 394C358.2 395.9 348.4 394.9 323.3 384.1C286.5 368.2 261.5 332.6 256.4 325.4C256 324.8 255.7 324.5 255.6 324.3C253.6 321.7 239.4 302.8 239.4 283.3C239.4 264.9 248.4 255.4 252.6 251C252.9 250.7 253.1 250.5 253.3 250.2C256.9 246.2 261.2 245.2 263.9 245.2C266.5 245.2 269.2 245.2 271.5 245.3L272.3 245.3C274.6 245.3 277.5 245.3 280.4 252.1C281.6 255 283.4 259.4 285.3 263.9C288.6 271.9 292 280.2 292.6 281.5C293.6 283.5 294.3 285.8 292.9 288.4C289.5 295.2 286 298.8 283.6 301.4C280.5 304.6 279.1 306.1 281.3 310C296.6 336.3 311.9 345.4 335.2 357.1C339.2 359.1 341.5 358.8 343.8 356.1C346.1 353.5 353.7 344.5 356.3 340.6C358.9 336.6 361.6 337.3 365.2 338.6C368.8 339.9 388.3 349.5 392.3 351.5C393.1 351.9 393.8 352.2 394.4 352.5C397.2 353.9 399.1 354.8 399.9 356.1C400.8 358 400.8 366 397.5 375.2C394.2 384.5 378.4 392.9 370.8 394zM544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM244.1 457.9L160 480L182.5 397.8C168.6 373.8 161.3 346.5 161.3 318.5C161.4 231.1 232.5 160 319.9 160C362.3 160 402.1 176.5 432.1 206.5C462 236.5 480 276.3 480 318.7C480 406.1 407.3 477.2 319.9 477.2C293.3 477.2 267.2 470.5 244.1 457.9z"/>
                          </svg>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay cursos cursando para mostrar.</p>
            <?php endif; ?>
          </div>
          <div class="cards-area" id="tab-content-oferta" style="display:none;">
            <?php if ($resultOferta->num_rows): ?>
              <?php while($curso = $resultOferta->fetch_assoc()): ?>
                <!-- Card de curso oferta -->
                <div class="card-oferta card-style">
                  <div class="card-img">
                    <img src="<?= !empty($curso['imagen']) ? '../../uploads/cursos/' . htmlspecialchars($curso['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' ?>" alt="">
                  </div>
                  <div class="card-info">
                    <div class="card-col left">
                      <div class="card-field">
                        <span class="card-label">Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Profesor:</span> <?= htmlspecialchars($curso['nombre_profesor'] . ' ' . $curso['apellido_profesor']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                      </div>
                    </div>
                    <div class="card-col right">
                      <div class="card-field">
                        <span class="card-label">Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Cupos restantes:</span>
                        <?php
                          // Calcular cupos restantes
                          $qCupos = mysqli_query($conex, "SELECT COUNT(*) AS inscritos FROM curso_participante WHERE id_curso_promocion = " . intval($curso['id']));
                          $rowCupos = mysqli_fetch_assoc($qCupos);
                          $cupos_restantes = $curso['cupos'] - intval($rowCupos['inscritos']);
                          echo $cupos_restantes;
                        ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                      </div>
                      <div class="card-field">
                        <?php if (in_array($curso['id'], $idsInscritos)): ?>
                          <button class="btn-inscribirse" disabled style="background:white;color:#43a047;cursor:default;">Inscrito</button>
                        <?php elseif (in_array($curso['id'], $idsPendientes)): ?>
                          <span style="background:white; font-size:0.7rem; color: #d4a900;">
                            Solicitud pendiente
                          </span>
                        <?php else: ?>
                          <button class="btn-inscribirse" onclick="abrirFormularioInscripcion(<?= $curso['id'] ?>)">Inscribirse</button>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay cursos en oferta para mostrar.</p>
            <?php endif; ?>
          </div>
          <div class="cards-area" id="tab-content-terminados" style="display:none;">
            <?php if ($resultTerminados->num_rows): ?>
              <?php while($curso = $resultTerminados->fetch_assoc()): ?>
                <!-- Card de curso terminado -->
                <div class="card-terminados card-style">
                  <div class="card-img">
                    <img src="<?= !empty($curso['imagen']) ? '../../uploads/cursos/' . htmlspecialchars($curso['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' ?>" alt="">
                  </div>
                  <div class="card-info">
                    <div class="card-col left">
                      <div class="card-field">
                        <span class="card-label">Nombre:</span> <?= htmlspecialchars($curso['nombre_curso']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Profesor:</span> <?= htmlspecialchars($curso['nombre_profesor'] . ' ' . $curso['apellido_profesor']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de inicio:</span> <?= date("d/m/Y", strtotime($curso['fecha_inicio'])) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Fecha de fin:</span> <?= date("d/m/Y", strtotime($curso['fecha_fin'])) ?>
                      </div>
                    </div>
                    <div class="card-col right">
                      <div class="card-field">
                        <span class="card-label">Total de Cupos:</span> <?= htmlspecialchars($curso['cupos']) ?>
                      </div>
                      <div class="card-field">
                        <span class="card-label">Valor en Bs:</span> <?= number_format($curso['precio'], 2, ',', '.') ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <p>No hay cursos terminados o inactivos para mostrar.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Inscripción -->
    <div id="modal-inscripcion" class="modal none">
      <div class="modal-content">
        <span class="close" onclick="cerrarFormularioInscripcion()">&times;</span>
        <h2>Inscribirse al curso</h2>
        <form id="form-inscripcion" enctype="multipart/form-data" method="POST" action="/imaf-project/backend/procesar_inscripcion.php">
          <div class="form-group">
            <label for="curso_id_modal">Curso:</label>
            
            <select id="curso_id_modal" name="curso_id" required>
              <?php
              $resultNoInscritos = $conex->query($queryNoInscritos);
              while ($curso = $resultNoInscritos->fetch_assoc()):
              ?>
                <option value="<?= $curso['id'] ?>">
                  <?= htmlspecialchars($curso['nombre_curso']) ?>
                </option>
              <?php endwhile; ?>
            </select>
            <div id="curso_img_preview" style="margin-top:10px;">
              <!-- Aquí se muestra la imagen pequeña del curso seleccionado -->
            </div>
          </div>
          <div class="form-group">
            <label for="comprobante_pago">Comprobante de pago:</label>
            <input type="file" id="comprobante_pago" name="comprobante_pago" accept="image/*" required>
          </div>
          <div class="form-group">
            <label for="referencia_pago">Número de referencia:</label>
            <input type="text" id="referencia_pago" name="referencia_pago" required>
          </div>
          <button type="submit" class="btn-enviar">Enviar solicitud</button>
        </form>
      </div>
    </div>

    <script>
    window.cursosData = {};
    <?php
    $resultCursos = $conex->query($queryDisponibles);
    while ($curso = $resultCursos->fetch_assoc()) {
      echo "window.cursosData['{$curso['id']}'] = {imagen: '" . addslashes($curso['imagen']) . "', nombre: '" . addslashes($curso['nombre_curso']) . "'};\n";
    }
    ?>
    </script>

    <script>
    function abrirFormularioInscripcion(cursoId) {
      document.getElementById('modal-inscripcion').classList.remove('none');
      document.getElementById('curso_id_modal').value = cursoId;
      mostrarImagenCurso(cursoId);
    }
    function cerrarFormularioInscripcion() {
      document.getElementById('modal-inscripcion').classList.add('none');
    }
    function mostrarImagenCurso(cursoId) {
      const cursos = window.cursosData || {};
      const img = cursos[cursoId] ? cursos[cursoId].imagen : '';
      const nombre = cursos[cursoId] ? cursos[cursoId].nombre : '';
      document.getElementById('curso_img_preview').innerHTML = img
        ? `<img src="../../uploads/cursos/${img}" alt="${nombre}" style="width:60px;height:40px;">`
        : '';
    }
    document.getElementById('curso_id_modal').addEventListener('change', function() {
      mostrarImagenCurso(this.value);
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tabs = [
        {btn: 'tab-disponibles', content: 'tab-content-disponibles'},
        {btn: 'tab-cursando', content: 'tab-content-cursando'},
        {btn: 'tab-oferta', content: 'tab-content-oferta'},
        {btn: 'tab-terminados', content: 'tab-content-terminados'}
      ];

      tabs.forEach(tab => {
        document.getElementById(tab.btn).addEventListener('click', function() {
          tabs.forEach(t => document.getElementById(t.btn).classList.remove('active'));
          this.classList.add('active');
          tabs.forEach(t => document.getElementById(t.content).style.display = 'none');
          document.getElementById(tab.content).style.display = '';
        });
      });
    });
    </script>
  </body>
</html>