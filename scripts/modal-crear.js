// Variables para abrir la modal
const openCurso = document.getElementById("open-modal-curso");
const openProfesor = document.getElementById("open-modal-profesor");

// Variables de cierre de la modal
const closeCurso = document.getElementById("close-curso");
const closeProfesor = document.getElementById("close-profesor");

// Variables de las modales
const modalCurso = document.getElementById("modal-curso");
const modalProfesor = document.getElementById("modal-profesor");

openCurso.addEventListener("click", () => {
  modalCurso.classList.toggle("none");
});
