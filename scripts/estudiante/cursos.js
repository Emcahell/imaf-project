document.addEventListener("DOMContentLoaded", function () {
  const btnDisponibles = document.getElementById("btn-disponibles");
  const btnCursando = document.getElementById("btn-cursando");
  const btnOferta = document.getElementById("btn-oferta");
  const btnTerminados = document.getElementById("btn-terminados");

  function setActive(btn) {
    [btnDisponibles, btnCursando, btnOferta, btnTerminados].forEach((b) =>
      b.classList.remove("active")
    );
    btn.classList.add("active");
  }

  function showDisponibles() {
    setActive(btnDisponibles);
    document
      .querySelectorAll(".card-disponibles")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".card-cursando")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-oferta")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = "none"));
  }

  function showCursando() {
    setActive(btnCursando);
    document
      .querySelectorAll(".card-disponibles")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-cursando")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".card-oferta")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = "none"));
  }

  function showOferta() {
    setActive(btnOferta);
    document
      .querySelectorAll(".card-disponibles")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-cursando")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-oferta")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = "none"));
  }

  function showTerminados() {
    setActive(btnTerminados);
    document
      .querySelectorAll(".card-disponibles")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-cursando")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-oferta")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = ""));
  }

  btnDisponibles.addEventListener("click", showDisponibles);
  btnCursando.addEventListener("click", showCursando);
  btnOferta.addEventListener("click", showOferta);
  btnTerminados.addEventListener("click", showTerminados);

  showDisponibles();
});

document.addEventListener("DOMContentLoaded", function () {
  // Selecciona la tab activa al cargar
  const urlParams = new URLSearchParams(window.location.search);
  const tab = urlParams.get("tab") || "disponibles";

  document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.classList.remove("active");
    if (btn.textContent.trim().toLowerCase() === tab) {
      btn.classList.add("active");
    }
  });

  // Si necesitas cargar contenido dinámico por AJAX, aquí puedes hacerlo
  // Por ahora, el contenido se carga por PHP, así que no es necesario más JS
});

// Modal inscripción (ya está en el HTML, pero puedes dejar aquí también)
function abrirFormularioInscripcion(cursoId) {
  document.getElementById("modal-inscripcion").classList.remove("none");
  document.getElementById("curso_id_modal").value = cursoId;
  mostrarImagenCurso(cursoId);
}

function cerrarFormularioInscripcion() {
  document.getElementById("modal-inscripcion").classList.add("none");
}

// Mostrar imagen del curso seleccionado
function mostrarImagenCurso(cursoId) {
  const cursos = window.cursosData || {};
  const img = cursos[cursoId] ? cursos[cursoId].imagen : "";
  const nombre = cursos[cursoId] ? cursos[cursoId].nombre : "";
  document.getElementById("curso_img_preview").innerHTML = img
    ? `<img src="../../uploads/cursos/${img}" alt="${nombre}" style="width:60px;height:40px;">`
    : "";
}

document
  .getElementById("curso_id_modal")
  .addEventListener("change", function () {
    mostrarImagenCurso(this.value);
  });

// cambiar entre tabs
