const btn = document.getElementById('btn-notification');
const modalNotification = document.getElementById('notification-modal');
const iconNotification = document.getElementById('icon-notification');
const openEdit = document.getElementById('open-modal-edit');
const closedEdit = document.getElementById('close-modal-edit');
const closedNotification = document.getElementById('icon-notification-back');
const modalEdit = document.getElementById('edit-modal');

// Modal notificación
const togglePanelNotification = btn.addEventListener("click", () =>{
  if (modalNotification.classList.contains('none')){
      modalNotification.classList.remove('none');
      iconNotification.classList.add('fill-notification');
      modalNotification.classList.add("block");
  } else {
      iconNotification.classList.remove('fill-notification');
      modalNotification.classList.remove("block");
      modalNotification.classList.add("none");
  }
})

const closedNotificationPanel = closedNotification.addEventListener("click", () => {
  if (modalNotification.classList.contains('block')){
      modalNotification.classList.remove("block");
      iconNotification.classList.remove('fill-notification');
      modalNotification.classList.add("none");
  }
})

// Modal editar admin
const openPanelEdit = openEdit.addEventListener("click", () =>{
  if (modalEdit.classList.contains('none')){
      modalEdit.classList.remove('none');
      modalEdit.classList.add("block");
  }
})

const closedPanelEdit = closedEdit.addEventListener("click", () =>{
  if (modalEdit.classList.contains('block')){
      modalEdit.classList.remove('block');
      modalEdit.classList.add("none");
  }
})