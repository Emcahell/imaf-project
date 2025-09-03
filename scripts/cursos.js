document.addEventListener("DOMContentLoaded", function () {
  const btnActivos = document.getElementById("btn-activos");
  const btnProfesores = document.getElementById("btn-profesores");
  const btnTerminados = document.getElementById("btn-terminados");

  function setActive(btn) {
    [btnActivos, btnProfesores, btnTerminados].forEach((b) =>
      b.classList.remove("active")
    );
    btn.classList.add("active");
  }

  function showActivos() {
    setActive(btnActivos);
    document
      .querySelectorAll(".card-activos")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".card-profesores")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = "none"));
  }

  function showProfesores() {
    setActive(btnProfesores);
    document
      .querySelectorAll(".card-activos")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-profesores")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = "none"));
  }

  function showTerminados() {
    setActive(btnTerminados);
    document
      .querySelectorAll(".card-activos")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-profesores")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = ""));
  }

  btnActivos.addEventListener("click", showActivos);
  btnTerminados.addEventListener("click", showTerminados);
  btnProfesores.addEventListener("click", showProfesores);

  showActivos();
});

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
