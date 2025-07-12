document.addEventListener("DOMContentLoaded", function () {
  const btnPendientes = document.getElementById("btn-pendientes");
  const btnAprobados = document.getElementById("btn-aprobados");
  const btnRechazados = document.getElementById("btn-rechazados");
  const btnTodos = document.getElementById("btn-todos");

  function setActive(btn) {
    [btnPendientes, btnAprobados, btnRechazados, btnTodos].forEach((b) =>
      b.classList.remove("button-active")
    );
    btn.classList.add("button-active");
  }

  function showPendientes() {
    setActive(btnPendientes);
    document
      .querySelectorAll(".box-card-pendientes")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".box-card-aprobados")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-rechazados")
      .forEach((card) => (card.style.display = "none"));
    document
    .querySelectorAll(".box-card-todos")
      .forEach((card) => (card.style.display = "none"));
  }

  function showAprobados() {
    setActive(btnAprobados);
    document
      .querySelectorAll(".box-card-pendientes")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-aprobados")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".box-card-rechazados")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-todos")
      .forEach((card) => (card.style.display = "none"));
  }

  function showRechazados() {
    setActive(btnRechazados);
    document
      .querySelectorAll(".box-card-pendientes")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-aprobados")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-rechazados")
      .forEach((card) => (card.style.display = ""));
    document
      .querySelectorAll(".box-card-todos")
      .forEach((card) => (card.style.display = "none"));
  }

  function showTodos() {
    setActive(btnTodos);
    document
      .querySelectorAll(".box-card-pendientes")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-aprobados")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-rechazados")
      .forEach((card) => (card.style.display = "none"));
    document
      .querySelectorAll(".box-card-todos")
      .forEach((card) => (card.style.display = ""));
  }

  btnPendientes.addEventListener("click", showPendientes);
  btnAprobados.addEventListener("click", showAprobados);
  btnRechazados.addEventListener("click", showRechazados);
  btnTodos.addEventListener("click", showTodos);

  showActivos();
});
