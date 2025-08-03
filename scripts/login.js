document.addEventListener("DOMContentLoaded", function () {
  const videoContainer = document.getElementById("video-container");
  const video = document.getElementById("intro-video");
  const loginContent = document.getElementById("login-content");

  // Verificar si ya se mostró el video en esta sesión
  if (sessionStorage.getItem("videoShown") !== "true") {
    // Mostrar video solo si es la primera vez en esta sesión
    video.play();

    video.addEventListener("ended", function () {
      // Primero: animación de fade out del video
      videoContainer.classList.add("video-fade-out");

      // Esperar a que termine la animación de fade out
      setTimeout(() => {
        // Ocultar completamente el video
        videoContainer.classList.add("hidden");

        // Mostrar el login con fade in
        loginContent.classList.add("login-fade-in");

        // Guardar en sesión que ya se mostró el video
        sessionStorage.setItem("videoShown", "true");
      }, 800); // 800ms = duración de la animación de fade out
    });
  } else {
    // Si ya se mostró el video, ir directamente al login
    videoContainer.classList.add("hidden");
    loginContent.classList.add("login-fade-in");
  }

  // Precargar el video para caché
  const videoPreload = document.createElement("video");
  videoPreload.src = "./assets/intro-video.mp4";
  videoPreload.preload = "auto";

  // Validación de login
  const form = document.getElementById("form");
  if (form) {
    form.addEventListener("submit", function (e) {
      let valid = true;

      // Obtener los campos
      const cedula = form["cedula"];
      const contraseña = form["contraseña"];
      const errorCedula = document.getElementById("error-cedula");
      const errorPassword = document.getElementById("error-password");

      // Limpiar mensajes previos
      if (errorCedula) errorCedula.textContent = "";
      if (errorPassword) errorPassword.textContent = "";

      // Validar campos vacíos
      if (!cedula || !cedula.value.trim()) {
        if (errorCedula) errorCedula.textContent = "La cédula es obligatoria.";
        valid = false;
      }
      if (!contraseña || !contraseña.value.trim()) {
        if (errorPassword)
          errorPassword.textContent = "La contraseña es obligatoria.";
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
        return;
      }
      // Si los campos están llenos, el formulario se envía y el PHP valida en la base de datos
    });
  }
});
