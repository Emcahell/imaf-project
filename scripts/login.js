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

  //   const cedulasValidas = await cedulasRes.json();
  //   const passwordsValidas = await passwordsRes.json();

  //   const listaCedula = cedulasValidas.validos;
  //   const listaPassword = passwordsValidas.validos;

  //   const cedulaCorrecta = listaCedula.includes(cedula);
  //   const passwordCorrecta = listaPassword.includes(password);

  //   if (!cedulaCorrecta) {
  //     errorCedula.textContent = 'Cédula incorrecta.';
  //   }

  //   if (!passwordCorrecta) {
  //     errorPassword.textContent = 'Contraseña incorrecta.';
  //   }

  //   if (cedulaCorrecta && passwordCorrecta) {
  //     window.location.href = './pages/admin/usuarios.html';
  //   }

  // } catch (err) {
  //   console.error('Error cargando archivos JSON', err);
  //   alert('Ocurrió un error al verificar las credenciales.');
  // }
});
