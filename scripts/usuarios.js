const btn = document.getElementById('btn-notification');
const modal = document.getElementById('modal');

const togglePanel = btn.addEventListener("click", () =>{
  if (modal.classList.contains('none')){
      modal.classList.remove('none');
      modal.classList.add("block");
  } else {
      modal.classList.remove("block");
      modal.classList.add("none");
  }
})

