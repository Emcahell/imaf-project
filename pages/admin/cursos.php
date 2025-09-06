<?php
include("../../backend/conexion.php");

// Cursos activos
$queryActivos = "
SELECT 
    cp.id,
    c.nombre AS nombre_curso,
    cp.imagen,
    cp.fecha_inicio,
    cp.fecha_fin,
    cp.cupos,
    cp.precio,
    u.nombre AS nombre_profesor,
    u.apellido AS apellido_profesor,
    cp.oferta,
    cp.estado
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
JOIN empleado e ON cp.id_profesor = e.id
JOIN usuario u ON e.usuario_id = u.id
WHERE cp.estado IN ('disponible', 'en_curso')
ORDER BY cp.id DESC";
$resultActivos = $conex->query($queryActivos);

// Consulta profesores activos (ajusta el campo 'activo' según tu estructura)
$queryProfesores = "
SELECT u.*, e.id AS empleado_id
FROM usuario u
INNER JOIN empleado e ON u.id = e.usuario_id
WHERE e.tipo_empleado = 'docente' AND e.activo = 1
";
$resultProfesores = $conex->query($queryProfesores);


// Cursos terminados
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
    u.apellido AS apellido_profesor,
    cp.oferta,
    cp.estado
FROM curso_promocion cp
JOIN curso c ON cp.id_curso = c.id
JOIN empleado e ON cp.id_profesor = e.id
JOIN usuario u ON e.usuario_id = u.id
WHERE cp.estado = 'terminado'
ORDER BY cp.fecha_fin DESC
";
$resultTerminados = $conex->query($queryTerminados);

// Determinar tab activo
$tab = $_GET['tab'] ?? 'activos';

// Obtener lista de profesores activos para el select
$docentes = [];
$qDocentes = mysqli_query($conex, "SELECT e.id, u.nombre, u.apellido FROM empleado e JOIN usuario u ON e.usuario_id = u.id WHERE e.tipo_empleado = 'docente' AND e.activo = 1");
while ($row = mysqli_fetch_assoc($qDocentes)) {
    $docentes[] = $row;
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
    <link rel="stylesheet" href="../../styles/globals.css">
    <link rel="stylesheet" href="../../styles/sidebar.css" />
    <link rel="stylesheet" href="../../styles/header.css" />
    <link rel="stylesheet" href="/imaf-project/styles/cursos.css" />
    <link rel="stylesheet" href="../../styles/transitionPages.css">
    <script src="../../scripts/transitionPages.js" defer></script>
    <script src="../../scripts/header.js" defer></script>
    <script src="/imaf-project/scripts/cursos.js" defer></script>
    <title>IMAF | Cursos</title>
    <style>
      .card-style{
        height: max-content;
      }



    </style>
  </head>
  <body>
      <?php
        session_start();
        include("../../backend/conexion.php");
        $usuario_id = $_SESSION['usuario_id'];
        $qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'administrador' AS rol FROM usuario WHERE id = $usuario_id");
        $usuario = mysqli_fetch_assoc($qUsuario);

        include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
        ?>

    <div class="container">
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

      <div class="right-column">
        <div class="right-bottom">
       <div class="dashboard-options">
        <a href="?tab=activos"><button class="tab-btn <?= $tab == 'activos' ? 'active' : '' ?>">Activos</button></a>
        <a href="?tab=profesores"><button class="tab-btn <?= $tab == 'profesores' ? 'active' : '' ?>">Profesores</button></a>
        <a href="?tab=terminados"><button class="tab-btn <?= $tab == 'terminados' ? 'active' : '' ?>">Terminados</button></a>
      </div>

          <div class="label-box" style="display:flex; align-items:center;justify-content:space-between;">
            <span>Datos</span>

             <div class="search-box" style="display:inline-block;width: 40vw;">
                <input type="text" id="busqueda-cards" placeholder="Buscar por cualquier dato..." style="width:100%;padding:8px 14px;border-radius:8px;border:1px solid #ccc;">
            </div>
          </div>

        </div>

        <!-- cards area -->
    <div class="cards-area" id="cards-area">
  <?php if ($tab == 'activos'): ?>
    <?php if ($resultActivos->num_rows): ?>
      <?php while($curso = $resultActivos->fetch_assoc()): ?>
        <?php
          // Obtener número de participantes
          $curso_id = $curso['id'];
          $qPart = mysqli_query($conex, "SELECT COUNT(*) AS total FROM curso_participante WHERE id_curso_promocion = $curso_id");
          $row = mysqli_fetch_assoc($qPart);
          $num_participantes = $row ? intval($row['total']) : 0;
        ?>
        <div class="card-activos card-style" data-curso-id="<?= $curso['id'] ?>">
          <div class="card-img">
            <img src="<?= !empty($curso['imagen']) ? '../../uploads/cursos/' . htmlspecialchars($curso['imagen']) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' ?>" alt="">
            <?php if ($curso['estado'] === 'en_curso'): ?>
              <span style="position:relative;left:20px;background:#43a047;color:#fff;padding:4px 12px;border-radius:6px;font-weight:bold;font-size:0.95em;box-shadow:0 2px 6px #0002;">En curso</span>
            <?php endif; ?>
          </div>
          <div class="card-info">
            <form class="form-editar-curso" method="POST" action="/imaf-project/backend/editar_curso.php">
              <input type="hidden" name="curso_id" value="<?= $curso['id'] ?>">
              <div class="card-col left">
                <div class="card-field">
                  <span class="card-label">Nombre:</span>
                  <input type="text" name="nombre_curso" value="<?= htmlspecialchars($curso['nombre_curso']) ?>" disabled>
                </div>
                <div class="card-field">
                  <span class="card-label">Profesor:</span>
                  <select name="id_profesor" disabled>
                    <?php foreach ($docentes as $doc): ?>
                      <option value="<?= $doc['id'] ?>" <?= ($curso['nombre_profesor'].' '.$curso['apellido_profesor'] == $doc['nombre'].' '.$doc['apellido']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($doc['nombre'].' '.$doc['apellido']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="card-field">
                  <span class="card-label">Fecha de inicio:</span>
                  <input type="date" name="fecha_inicio" value="<?= htmlspecialchars($curso['fecha_inicio']) ?>" disabled>
                </div>
                <div class="card-field">
                  <span class="card-label">Fecha de fin:</span>
                  <input type="date" name="fecha_fin" value="<?= htmlspecialchars($curso['fecha_fin']) ?>" disabled>
                </div>
                <div class="card-field">
                  <span class="card-label">Participantes:</span>
                  <span><?= $num_participantes ?></span>
                  <button type="button" class="btn-ver-participantes" data-curso="<?= $curso['id'] ?>" style="background:none;border:none;padding:0;vertical-align:middle;">
                    <svg width="18" height="18" viewBox="0 0 576 512" style="vertical-align:middle;cursor:pointer;">
                      <path fill="currentColor" d="M572.52 241.4C518.7 135.5 410.7 64 288 64S57.3 135.5 3.48 241.4a48.07 48.07 0 0 0 0 45.2C57.3 376.5 165.3 448 288 448s230.7-71.5 284.52-161.4a48.07 48.07 0 0 0 0-45.2zM288 400c-97.2 0-189.6-57.6-238.8-144C98.4 169.6 190.8 112 288 112s189.6 57.6 238.8 144C477.6 342.4 385.2 400 288 400zm0-272a128 128 0 1 0 128 128A128 128 0 0 0 288 128zm0 208a80 80 0 1 1 80-80 80 80 0 0 1-80 80z"/>
                    </svg>
                  </button>
                </div>
                 <div class="card-field">
                  <span class="card-label">Total de Cupos:</span>
                  <input type="number" name="cupos" value="<?= htmlspecialchars($curso['cupos']) ?>" min="1" disabled>
                </div>
                <div class="card-field">
                  <span class="card-label">Valor en Bs:</span>
                  <input type="number" name="precio" value="<?= htmlspecialchars($curso['precio']) ?>" step="0.01" min="0" disabled>
                </div>
                <div class="card-field">
                  <label>
                    <input type="checkbox" name="oferta" value="0" <?= isset($curso) && $curso['oferta'] ? 'checked' : '' ?> disabled>
                    En oferta
                  </label>
                </div>

              </div>

              <div class="card-actions">
                <button type="button" class="btn-editar-curso">Editar</button>
                <button type="submit" class="btn-guardar-curso" style="display:none;">Guardar</button>
                <button type="button" class="btn-cancelar-curso" style="display:none;">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
       
      <?php endwhile; ?>
    <?php else: ?>
      <p>No hay cursos activos para mostrar.</p>
    <?php endif; ?>
        <!-- fin area activos -->

        <!-- inicio area de profesores -->
         <?php elseif ($tab == 'profesores'): ?>
    <?php if ($resultProfesores->num_rows): ?>
      <?php while($prof = $resultProfesores->fetch_assoc()): ?>
        <!-- Card de profesor -->
          <div class="card-profesores card-style">
            <div class="card-img">
              <img src="<?= (!empty($prof['foto']) ? '../../uploads/profilepic/' . htmlspecialchars($prof['foto']) : 'https://via.placeholder.com/120x120?text=Foto') ?>" alt="">
            </div>
            <div class="card-info">
              <div class="card-col left">
                <div class="card-field">
                  <span class="card-label">Nombre:</span> <?= htmlspecialchars($prof['nombre']) ?>
                </div>
                <div class="card-field">
                  <span class="card-label">Apellido:</span> <?= htmlspecialchars($prof['apellido']) ?>
                </div>
                <div class="card-field">
                  <span class="card-label">Cedula:</span> <?= htmlspecialchars($prof['cedula']) ?>
                </div>
                <div class="card-field">
                  <span class="card-label">Fecha Nacimiento:</span> <?= htmlspecialchars($prof['fecha_nacimiento']) ?>
                </div>
              </div>
              <div class="card-col right">
              
                <div class="card-field">
                  <span class="card-label">Contraseña:</span> <?= htmlspecialchars($prof['contraseña']) ?>
                </div>
                <div class="card-field">
                  <span class="card-label">Correo:</span> <?= htmlspecialchars($prof['correo']) ?>
                </div>
                <div class="card-field">
                  <span class="card-label">Telefono:</span> <?= htmlspecialchars($prof['telefono']) ?>
                </div>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No hay profesores activos para mostrar.</p>
        <?php endif; ?>
          <!-- fin area profesores -->
          <!-- ...dentro del área de cards terminados... -->
            <?php elseif ($tab == 'terminados'): ?>
    <?php if ($resultTerminados->num_rows): ?>
      <?php while($curso = $resultTerminados->fetch_assoc()): ?>
        <!-- Card de curso terminado/inactivo -->
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
            <?php endif; ?>
          </div>


        </div> <!-- fin cards-area -->
        </div>
      </div>
    </div>


    <!-- Modal de participantes (solo una vez en la página) -->
    <div id="modal-participantes" class="modal-participantes modal none">
      <div class="modal-content">
        <span class="close" onclick="cerrarModalParticipantes()">&times;</span>
        <h3>Participantes del curso</h3>
        <input type="text" id="busqueda-participante" placeholder="Buscar por nombre, apellido o cédula..." onkeyup="filtrarParticipantes()">
        <div id="tabla-participantes"></div>
        <form id="form-agregar-participante" style="display:flex;gap:1em;margin-top:1em;">
          <input type="hidden" name="curso_id" id="modal_participantes_curso_id">
          <input type="text" name="cedula_estudiante" placeholder="Cédula del estudiante" required style="flex:1;">
          <button type="submit">Agregar</button>
        </form>
      </div>
    </div>
    <script>
  // Editar datos del curso ya creado

document.querySelectorAll(".btn-editar-curso").forEach((btn) => {
  btn.addEventListener("click", function () {
    const form = btn.closest(".form-editar-curso");
    form
      .querySelectorAll("input, select")
      .forEach((el) => (el.disabled = false));
    form.querySelector(".btn-guardar-curso").style.display = "";
    form.querySelector(".btn-cancelar-curso").style.display = "";
    btn.style.display = "none";
  });
});
document.querySelectorAll(".btn-cancelar-curso").forEach((btn) => {
  btn.addEventListener("click", function () {
    const form = btn.closest(".form-editar-curso");
    form.reset();
    form
      .querySelectorAll("input, select")
      .forEach((el) => (el.disabled = true));
    form.querySelector(".btn-guardar-curso").style.display = "none";
    form.querySelector(".btn-editar-curso").style.display = "";
    btn.style.display = "none";
  });
});

//// modal de ver participantes en curso ya creado ////

// Mostrar modal y cargar participantes
document.querySelectorAll(".btn-ver-participantes").forEach((btn) => {
  btn.addEventListener("click", function () {
    var cursoId = btn.getAttribute("data-curso");
    document.getElementById("modal-participantes").classList.remove("none");
    document.getElementById("modal_participantes_curso_id").value = cursoId;
    cargarParticipantes(cursoId, "");
    document.getElementById("busqueda-participante").value = "";
  });
});

function cerrarModalParticipantes() {
  document.getElementById("modal-participantes").classList.add("none");
}

// Cargar participantes vía AJAX
function cargarParticipantes(cursoId, filtro) {
  fetch(
    "/imaf-project/pages/admin/ajax_participantes.php?curso_id=" +
      cursoId +
      "&filtro=" +
      encodeURIComponent(filtro)
  )
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("tabla-participantes").innerHTML = html;
    });
}

// Filtrar participantes
function filtrarParticipantes() {
  var cursoId = document.getElementById("modal_participantes_curso_id").value;
  var filtro = document.getElementById("busqueda-participante").value;
  cargarParticipantes(cursoId, filtro);
}

// Agregar participante
document
  .getElementById("form-agregar-participante")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    var cursoId = document.getElementById("modal_participantes_curso_id").value;
    var cedula = this.cedula_estudiante.value;
    var formData = new FormData();
    formData.append("agregar", 1);
    formData.append("curso_id", cursoId);
    formData.append("cedula_estudiante", cedula);
    fetch("/imaf-project/pages/admin/ajax_participantes.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((html) => {
        document.getElementById("tabla-participantes").innerHTML = html;
        this.cedula_estudiante.value = "";
      });
  });

// Eliminar participante (llamado desde el HTML generado)
function eliminarParticipante(id, cursoId) {
  var formData = new FormData();
  formData.append("eliminar", 1);
  formData.append("id", id);
  formData.append("curso_id", cursoId);
  fetch("/imaf-project/pages/admin/ajax_participantes.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("tabla-participantes").innerHTML = html;
    });
}

//filtro de busqueda

document.getElementById('busqueda-cards').addEventListener('input', function() {
  const filtro = this.value.toLowerCase();
  // Selecciona todas las cards visibles (activos, profesores, terminados)
  document.querySelectorAll('.cards-area > .card-style').forEach(card => {
    // Busca en todo el texto visible de la card
    const texto = card.innerText.toLowerCase();
    card.style.display = texto.includes(filtro) ? '' : 'none';
  });
});

      </script>
  </body>
</html>