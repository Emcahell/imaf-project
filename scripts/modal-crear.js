const cardCursos = document.querySelectorAll(".card-box")[0];
const cardProfesor = document.querySelectorAll(".card-box")[1];
const modalCursos = document.getElementById("modal-cursos");
const modalProfesor = document.getElementById("modal-profesor");
const closeModalCursos = modalCursos.querySelector(".closed-modal");
const closeModalProfesor = modalProfesor.querySelector(".closed-modal");
const cardsBox = document.querySelector(".selection-box-card");

// Mostrar modal de cursos y ocultar cards
cardCursos.addEventListener("click", () => {
  modalCursos.classList.remove("modal-none");
  cardsBox.classList.add("modal-none");
});

// Mostrar modal de profesor y ocultar cards
cardProfesor.addEventListener("click", () => {
  modalProfesor.classList.remove("modal-none");
  cardsBox.classList.add("modal-none");
});

// Cerrar modal de cursos y mostrar cards
closeModalCursos.addEventListener("click", () => {
  modalCursos.classList.add("modal-none");
  cardsBox.classList.remove("modal-none");
});

// Cerrar modal de profesor y mostrar cards
closeModalProfesor.addEventListener("click", () => {
  modalProfesor.classList.add("modal-none");
  cardsBox.classList.remove("modal-none");
});
