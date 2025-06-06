document.getElementById('form').addEventListener('submit', async function(e) {
  e.preventDefault();

  const cedula = document.getElementById('input-cedula').value.trim();
  const password = document.getElementById('input-password').value.trim();

  // Carga los archivos JSON desde la carpeta example-data
  const cedulasResp = await fetch('./scripts/example-data/cedula.json');
  const passwordsResp = await fetch('./scripts/example-data/password.json');
  const cedulas = (await cedulasResp.json()).validos;
  const passwords = (await passwordsResp.json()).validos;

  // Busca la cédula y compara la contraseña en el mismo índice
  const index = cedulas.indexOf(cedula);
  if (index !== -1 && passwords[index] === password) {
    alert('Inicio de sesión exitoso');
    window.location.href = './pages/admin/usuarios.html';
  } else {
    alert('Cédula o contraseña incorrecta');
  }
});