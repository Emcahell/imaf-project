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
