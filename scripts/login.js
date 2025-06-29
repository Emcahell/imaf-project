document.getElementById('form').addEventListener('submit', async (e) => {
  e.preventDefault();

  const cedula = document.getElementById('input-cedula').value.trim();
  const password = document.getElementById('input-password').value.trim();

  const errorCedula = document.getElementById('error-cedula');
  const errorPassword = document.getElementById('error-password');

  errorCedula.textContent = '';
  errorPassword.textContent = '';

  let valido = true;

  // Validaciones vacías
  if (cedula === '') {
    errorCedula.textContent = 'Ingresa tu número de cédula.';
    valido = false;
  }

  if (password === '') {
    errorPassword.textContent = 'Ingresa tu contraseña.';
    valido = false;
  }

  if (!valido) return;

  try {
    const grupos = [
      {
        cedulas: await (await fetch('../../scripts/example-data/cedulaAdmin.json')).json(),
        passwords: await (await fetch('../../scripts/example-data/passwordAdmin.json')).json(),
        redirect: './pages/admin/usuarios.html'
      },
      {
        cedulas: await (await fetch('../../scripts/example-data/cedulaDocentes.json')).json(),
        passwords: await (await fetch('../../scripts/example-data/passwordDocentes.json')).json(),
        redirect: './pages/profesor/cursos.html'
      },
      {
        cedulas: await (await fetch('../../scripts/example-data/cedulaUsuario.json')).json(),
        passwords: await (await fetch('../../scripts/example-data/passwordUsuario.json')).json(),
        redirect: './pages/user/cursos.html'
      }
    ];

    let encontrado = false;

    for (const grupo of grupos) {
      if (grupo.cedulas.includes(cedula)) {
        if (grupo.passwords.includes(password)) {
          window.location.href = grupo.redirect;
          encontrado = true;
          break;
        } else {
          errorPassword.textContent = 'Contraseña incorrecta.';
          return;
        }
      }
    }

    if (!encontrado) {
      errorCedula.textContent = 'Cédula incorrecta.';
    }

  } catch (error) {
    console.error('Error al cargar archivos JSON:', error);
    alert('Error al verificar credenciales.');
  }


});

document.addEventListener('DOMContentLoaded', function() {
  const videoContainer = document.getElementById('video-container');
  const video = document.getElementById('intro-video');
  const loginContent = document.getElementById('login-content');
  
  // Verificar si ya se mostró el video en esta sesión
  if(sessionStorage.getItem('videoShown') !== 'true') {
    // Mostrar video solo si es la primera vez en esta sesión
    video.play();
    
    video.addEventListener('ended', function() {
      // Primero: animación de fade out del video
      videoContainer.classList.add('video-fade-out');
      
      // Esperar a que termine la animación de fade out
      setTimeout(() => {
        // Ocultar completamente el video
        videoContainer.classList.add('hidden');
        
        // Mostrar el login con fade in
        loginContent.classList.add('login-fade-in');
        
        // Guardar en sesión que ya se mostró el video
        sessionStorage.setItem('videoShown', 'true');
      }, 800); // 800ms = duración de la animación de fade out
    });
  } else {
    // Si ya se mostró el video, ir directamente al login
    videoContainer.classList.add('hidden');
    loginContent.classList.add('login-fade-in');
  }
  
  // Precargar el video para caché
  const videoPreload = document.createElement('video');
  videoPreload.src = './assets/intro-video.mp4';
  videoPreload.preload = 'auto';
});