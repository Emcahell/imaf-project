document.getElementById('form').addEventListener('submit', async function (e) {
  e.preventDefault();

  const cedula = document.getElementById("input-cedula").value.trim();
  const password = document.getElementById("input-password").value.trim();
  const correo = document.getElementById("input-email").value.trim();

  const errorCedula = document.getElementById("error-cedula");
  const errorPassword = document.getElementById("error-password");
  const errorCorreo = document.getElementById("error-email");

  errorCedula.textContent = "";
  errorPassword.textContent = "";
  errorCorreo.textContent = "";

  let valido = true;

  if (cedula === "") {
    errorCedula.textContent = "La cédula no puede estar vacía.";
    valido = false;
  } else if (!/^\d{7,}$/.test(cedula)) {
    errorCedula.textContent = "La cédula debe tener al menos 7 números.";
    valido = false;
  }

  if (password === "") {
    errorPassword.textContent = "La contraseña no puede estar vacía.";
    valido = false;
  } else if (!/^[a-zA-Z0-9\*]+$/.test(password)) {
    errorPassword.textContent =
      "La contraseña solo puede contener letras, números y el asterisco (*).";
    valido = false;
  }

  if (correo === "") {
    errorCorreo.textContent = "El correo no puede estar vacío.";
    valido = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
    errorCorreo.textContent = "El correo no es válido.";
    valido = false;
  }

  // Si todo está bien
if (valido) {
  try{
    const response = await fetch('aqui metes el enlace al php bro', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        cedula: cedula,
        contraseña: password,
        correo: correo
      })
    });

    const data = await response.json();

    if (response.ok) {
      Swal.fire({
        icon: 'success',
        title: "Registro exitoso",
        text: "Puedes iniciar sesión",
        confirmButtonText: 'Aceptar'
    }).then(() => {
          window.location.href = "../index.html";
    });
    } else {
      throw new Error(data.message || 'Error al registrar');
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: error.message || 'Ocurrió un error al registrar',
      confirmButtonText: 'Aceptar'
    });
  }
}
});

// Fade in del body
document.addEventListener("DOMContentLoaded", function () {
  document.body.style.opacity = "1";
});

// Fade out antes de cambiar de página
document.querySelectorAll("a").forEach((link) => {
  if (link.href && !link.hash) {
    link.addEventListener("click", function (e) {
      if (this.href.includes(window.location.hostname)) {
        e.preventDefault();
        document.body.style.opacity = "0";
        setTimeout(() => {
          window.location.href = this.href;
        }, 300);
      }
    });
  }
});
