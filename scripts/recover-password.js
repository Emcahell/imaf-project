const eyeIcons = document.querySelectorAll('.icon-tabler-eye');
const eyeOffIcons = document.querySelectorAll('.icon-tabler-eye-off');
const passwordInputs = document.querySelectorAll('input[type="password"]');
const form = document.getElementById('form');
const pass1 = document.getElementById('password1');
const pass2 = document.getElementById('password2');
const errorP1 = document.getElementById('error1');
const errorP2 = document.getElementById('error2');

// Cambiar el tipo de input a password y viceversa
function togglePasswordVisibility(index) {
  if (eyeIcons[index].classList.contains('block')) {
    passwordInputs[index].type = 'text';
    eyeIcons[index].classList.remove('block');
    eyeIcons[index].classList.add('none');
    eyeOffIcons[index].classList.remove('none');
    eyeOffIcons[index].classList.add('block');
  } else {
    passwordInputs[index].type = 'password';
    eyeIcons[index].classList.remove('none');
    eyeIcons[index].classList.add('block');
    eyeOffIcons[index].classList.remove('block');
    eyeOffIcons[index].classList.add('none');
  }
}

eyeIcons.forEach((eyeIcon, index) => {
  eyeIcon.addEventListener('click', () => {
    togglePasswordVisibility(index);
  });
});

eyeOffIcons.forEach((eyeOffIcon, index) => {
  eyeOffIcon.addEventListener('click', () => {
    togglePasswordVisibility(index);
  });
});


// Validaciones
const passwordPattern = /^[0-9*]{6,}$/; //números (0-9) y asterisco (*)

form.addEventListener('submit', (e) => {
  e.preventDefault();

  // Limpiar errores
  errorP1.textContent = '';
  errorP2.textContent = '';

  const p1 = pass1.value.trim();
  const p2 = pass2.value.trim();
  let valid = true;

  if (p1 === '') {
    errorP1.textContent = 'La contraseña no puede ir vacía.';
    valid = false;
  } else if (!passwordPattern.test(p1)) {
    errorP1.textContent = 'La contraseña debe tener al menos 6 caracteres y solo puede incluir *';
    valid = false;
  }

  if (p2 === '') {
    errorP2.textContent = 'Debe repetir la contraseña.';
    valid = false;
  } else if (p1 !== p2) {
    errorP2.textContent = 'Las contraseñas no coinciden.';
    valid = false;
  }

  if (valid) {
    Swal.fire({
      icon: 'success',
      title: '¡Contraseña enviada!',
      text: 'Tu contraseña fue validada y enviada correctamente.',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = './index.html';
      form.reset();
    });
  }
});