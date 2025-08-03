document.addEventListener("DOMContentLoaded", function () {
  const form = document.forms["formRegister"];
  const cedula = form["cedula"];
  const contraseña = form["contraseña"];
  const correo = form["correo"];
  const errorCedula = document.getElementById("error-cedula");
  const errorPassword = document.getElementById("error-password");
  const errorEmail = document.getElementById("error-email");

  form.addEventListener("submit", function (e) {
    let valid = true;

    // Limpiar mensajes previos
    errorCedula.textContent = "";
    errorPassword.textContent = "";
    errorEmail.textContent = "";

    // Validar campos vacíos
    if (!cedula.value.trim()) {
      errorCedula.textContent = "La cédula es obligatoria.";
      valid = false;
    }
    if (!contraseña.value.trim()) {
      errorPassword.textContent = "La contraseña es obligatoria.";
      valid = false;
    }
    if (!correo.value.trim()) {
      errorEmail.textContent = "El correo es obligatorio.";
      valid = false;
    }

    if (!valid) e.preventDefault();
  });
});
