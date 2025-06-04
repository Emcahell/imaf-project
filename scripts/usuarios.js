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

  document.querySelectorAll('.icon-see-more-open').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const boton = e.currentTarget;
      const table = boton.closest('.table-row2');

      if (table) {
        const boxSeeMore = table.querySelector('.box-see-more');
        table.classList.toggle('active');
        boton.classList.toggle('rotate-icon');
        boxSeeMore.classList.toggle('none');
      }
    });
  });


//Hice esto recién terminado mi reposo por la cirujia 3/06/25.