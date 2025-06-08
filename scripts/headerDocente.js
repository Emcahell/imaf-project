const iconUser = document.getElementById('icon-user');
const openEdit = document.getElementById('open-modal-edit');
const closedEdit = document.getElementById('close-modal-edit');
const modalEdit = document.getElementById('edit-modal');

const openPanelEdit = openEdit.addEventListener("click", () =>{
  if (modalEdit.classList.contains('none')){
      modalEdit.classList.remove('none');
      modalEdit.classList.add("block");
      iconUser.classList.add('icon-modal-open');
  }
})

const closedPanelEdit = closedEdit.addEventListener("click", () =>{
  if (modalEdit.classList.contains('block')){
      modalEdit.classList.remove('block');
      iconUser.classList.remove('icon-modal-open');
      modalEdit.classList.add("none");
  }
})