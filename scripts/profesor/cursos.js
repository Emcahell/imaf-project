document.addEventListener("DOMContentLoaded", function () {
  const btnRealizados = document.getElementById("btn-realizados");
  const btnTerminados = document.getElementById("btn-terminados");

  function setActive(btn) {
    [btnRealizados, btnTerminados].forEach((b) =>
      b.classList.remove("active")
    );
    btn.classList.add("active");
  }

  function showActivos() {
    setActive(btnRealizados);
    document
      .querySelectorAll(".card-activos")
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
      .querySelectorAll(".card-terminados")
      .forEach((card) => (card.style.display = ""));
  }

  btnRealizados.addEventListener("click", showActivos);
  btnTerminados.addEventListener("click", showTerminados);

  showActivos();
});
