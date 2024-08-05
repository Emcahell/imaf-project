// CAMBIAR DE VISTA ENTRE TODOS E INACTIVOS

const btnTodos = document.getElementById('btn-todos');
const btnInactivos = document.getElementById('btn-inactivos');

const boxTodos = document.getElementById('box-todos');
const boxInactivos = document.getElementById('box-inactivos');

btnInactivos.addEventListener('click', () => {
  boxTodos.classList.add('none');
  boxTodos.classList.remove('block');
  btnTodos.classList.remove('btn-active');
  btnInactivos.classList.add('btn-active');
  boxInactivos.classList.add('block');
})

btnTodos.addEventListener('click', () => {
  boxInactivos.classList.add('none');
  boxInactivos.classList.remove('block');
  btnInactivos.classList.remove('btn-active');
  btnTodos.classList.add('btn-active');
  boxTodos.classList.add('block');
})

  // MOSTRAR Y OCULTAR SECCION DE VER MAS INFO EN DISPOSITIVOS MOVILES

  const btnSeeMore = document.querySelectorAll('.icon-see-more-open');
  
  btnSeeMore.forEach(btn => {
    btn.addEventListener('click', () => {

    })
  });


//   const iconSeeMore = document.getElementById('icon-see-more');
//   const table = document.getElementById('table');
//   const boxSeeMore = document.getElementById('see-more');

// iconSeeMore.addEventListener('click', () => {
//   table.classList.toggle('active');
//   boxSeeMore.classList.toggle('none');
//   iconSeeMore.classList.toggle('rotate-icon');
// })

//Hice esto recién terminado mi reposo por la cirujia 3/06/25.