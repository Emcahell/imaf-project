const openModal1 = document.getElementById('open-modal1');
const openModal2 = document.getElementById('open-modal2');
const openModal3 = document.getElementById('open-modal3');

const closedModal1 = document.getElementById('closed-modal1');
const closedModal2 = document.getElementById('closed-modal2'); 
const closedModal3 = document.getElementById('closed-modal3');

const modal1 = document.getElementById('modal1');
const modal2 = document.getElementById('modal2');
const modal3 = document.getElementById('modal3');

openModal1.addEventListener('click', () => {
    modal1.classList.toggle('modal-hidden');
});

closedModal1.addEventListener('click', () => {
  modal1.classList.toggle('modal-hidden');
})

openModal2.addEventListener('click', () => {
  modal2.classList.toggle('modal-hidden');
});

closedModal2.addEventListener('click', () => {
modal2.classList.toggle('modal-hidden');
})

openModal3.addEventListener('click', () => {
  modal1.classList.toggle('modal-hidden');
});

closedModal3.addEventListener('click', () => {
modal1.classList.toggle('modal-hidden');
})