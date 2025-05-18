const eyeIcons = document.querySelectorAll('.icon-tabler-eye');
const eyeOffIcons = document.querySelectorAll('.icon-tabler-eye-off');
const passwordInputs = document.querySelectorAll('input[type="password"]');

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
