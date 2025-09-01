<?php
// filepath: c:\xampp\htdocs\imaf-project\includes\header.php

// Recibe: $usuario (array con nombre, apellido, foto, rol)
// Ejemplo de uso: include("../includes/header.php");
?>
<link rel="stylesheet" href="/imaf-project/assets/styles/header.css" />
<script src="/imaf-project/assets/scripts/header.js" defer></script>
<header>
  <div>
    <img class="logo" src="/imaf-project/assets/recursos/logo-imaf.png" alt="logo imaf" />
  </div>
  <div class="tools">
    <p><?= ucfirst($usuario['rol']) ?> <span id="conexion">•</span></p>
    <div id="btn-notification">
      <svg class="icon" id="icon-notification" viewBox="0 0 448 512">
        <path d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416l400 0c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4l0-25.4c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112l0 25.4c0 47.9 13.9 94.6 39.7 134.6L72.3 368C98.1 328 112 281.3 112 233.4l0-25.4c0-61.9 50.1-112 112-112zm64 352l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/>
      </svg>
    </div>
    <div class="box-useradmin">
      <img class="icon-user" src="<?= $usuario['foto'] ? '/imaf-project/uploads/profilepic/' . htmlspecialchars($usuario['foto']) : '/imaf-project/assets/recursos/user-default.png' ?>" alt="Foto de perfil" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
      <span>&nbsp; <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></span>
    </div>
    <div id="open-modal-edit">
      <svg class="icon icon-up-admin" viewBox="0 0 448 512">
        <path d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/>
      </svg>
    </div>
  </div>
  <div class="notification-modal none" id="notification-modal">
    <div class="title-notification">
      <div>
        <svg class="icon" id="icon-notification-back" viewBox="0 0 448 512">
          <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
        </svg>
        Notificaciones
      </div>
    </div>
    <!-- Aquí puedes cargar notificaciones dinámicas -->
    <a href="./solicitudes.php">Solicitud recibida</a>
    <a href="./usuarios.php">Nuevo usuario registrado</a>
  </div>
  <div class="edit-modal none" id="edit-modal">
    <svg class="icon icon-down-admin" id="close-modal-edit" viewBox="0 0 448 512">
      <path d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z"/>
    </svg>
    <a class="box-edit" href="../editar-perfil.php">
      <svg class="icon icon-edit-modal" viewBox="0 0 512 512">
        <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/>
      </svg>
      Editar perfil
    </a>
    <a class="box-salir" href="../../index.php">
      <svg class="icon-nav icon-salir-modal" viewBox="0 0 512 512">
        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32z"/>
      </svg>
      Salir
    </a>
  </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const closeBtn = document.getElementById('close-modal-edit');
  const editModal = document.getElementById('edit-modal');
  if (closeBtn && editModal) {
    closeBtn.addEventListener('click', function() {
      editModal.classList.add('none');
    });
  }
});
</script>