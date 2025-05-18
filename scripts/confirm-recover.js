const form = document.getElementById('cedula-form');
const input = document.getElementById("input-confirmar");
const btn = document.getElementById("btn-confirmar");
const errorP = document.getElementById('error');

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const cedula = input.value.trim();
  errorP.textContent = ''; // limpiar mensajes previos

  // Validaciones
  if (cedula === '') {
    errorP.textContent = 'Ingresa tu número de cédula.';
    return;
  }

  if (cedula.length < 7) {
    errorP.textContent = 'La cédula debe tener al menos 7 números.';
    return;
  }

  try {
    const response = await fetch('../../scripts/example-data/cedula.json');
    const data = await response.json();
    const listaCedula = data.validos;

    if (!listaCedula.includes(cedula)) {
      errorP.textContent = 'La cédula es incorrecta.';
      return;
    }

    // Cédula correcta: redirigir
    window.location.href = './recover-password.html';

  } catch (error) {
    errorP.textContent = 'Error al verificar la cédula.';
    console.error(error);
  }
});