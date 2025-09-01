<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="../../assets/logo-imaf.ico" type="image/x-icon" />
  <link rel="stylesheet" href="../../styles/solicitudes.css" />
  <link rel="stylesheet" href="../../styles/header.css" />
  <link rel="stylesheet" href="../../styles/sidebar.css" />
  <link rel="stylesheet" href="../../styles/transitionPages.css">
  <script src="../../scripts/transitionPages.js" defer></script>
  <script src="../../scripts/header.js" defer></script>
  <script src="../../scripts/solicitudes.js" defer></script>
  <title>IMAF | Solicitudes</title>
</head>

<body>
  <main>
    <?php
    session_start();
    include("../../backend/conexion.php");
    $usuario_id = $_SESSION['usuario_id'];
    $qUsuario = mysqli_query($conex, "SELECT nombre, apellido, foto, 'administrador' AS rol FROM usuario WHERE id = $usuario_id");
    $usuario = mysqli_fetch_assoc($qUsuario);

    include($_SERVER['DOCUMENT_ROOT'] . '/imaf-project/pages/header.php');
    ?>

    <section>
      <article class="sidebar">
        <nav>
          <ul>
            <li>
              <a href="./usuarios.php">
                <svg class="icon-nav" viewBox="0 0 448 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                </svg>
                Usuarios
              </a>
            </li>
            <li>
              <a href="./cursos.php">
                <svg class="icon-nav icon-cursos" viewBox="0 0 512 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M160 64c0-35.3 28.7-64 64-64L576 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-239.2 0c-11.8-25.5-29.9-47.5-52.4-64l99.6 0 0-32c0-17.7 14.3-32 32-32l64 0c17.7 0 32 14.3 32 32l0 32 64 0 0-288L224 64l0 49.1C205.2 102.2 183.3 96 160 96l0-32zm0 64a96 96 0 1 1 0 192 96 96 0 1 1 0-192zM133.3 352l53.3 0C260.3 352 320 411.7 320 485.3c0 14.7-11.9 26.7-26.7 26.7L26.7 512C11.9 512 0 500.1 0 485.3C0 411.7 59.7 352 133.3 352z" />
                </svg>
                Cursos
              </a>
            </li>
            <li class="li-location">
              <a class="location">
                <svg class="icon-nav location" viewBox="0 0 512 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path
                    d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z" />
                </svg>
                Solicitudes
              </a>
            </li>
            <li>
              <a href="./crear.php">
                <svg class="icon-nav" viewBox="0 0 448 512">
                  <path
                    d="M64 80c-8.8 0-16 7.2-16 16l0 320c0 8.8 7.2 16 16 16l320 0c8.8 0 16-7.2 16-16l0-320c0-8.8-7.2-16-16-16L64 80zM0 96C0 60.7 28.7 32 64 32l320 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM200 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                </svg>
                Crear
              </a>
            </li>
          </ul>
        </nav>
      </article>

      <article class="box-contenido">
        <div class="filter">
          <button class="button-active" id="btn-pendientes">Pendientes</button>
          <button id="btn-aprobados">Aprobados</button>
          <button id="btn-rechazados">Rechazados</button>
          <button id="btn-todos">Todos</button>
        </div>
        <div class="contenido">

          <div class="box-cards box-card-pendientes" id="pendientes">
            <div class="card-pendientes card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <button class="aprobar">Aprobar</button>
                <button class="rechazar">Rechazar</button>
              </div>
            </div>
            <div class="card-pendientes card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <button class="aprobar">Aprobar</button>
                <button class="rechazar">Rechazar</button>
              </div>
            </div>
            <div class="card-pendientes card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <button class="aprobar">Aprobar</button>
                <button class="rechazar">Rechazar</button>
              </div>
            </div>
            <div class="card-pendientes card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <button class="aprobar">Aprobar</button>
                <button class="rechazar">Rechazar</button>
              </div>
            </div>
          </div>

          <div class=" box-cards box-card-aprobados" id="aprobados">
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
          </div>

          <div class=" box-cards box-card-rechazados" id="rechazados">
            <div class="card-rechazados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-rechazado">Rechazado</p>
              </div>
            </div>
            <div class="card-rechazados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-rechazado">Rechazado</p>
              </div>
            </div>
            <div class="card-rechazados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-rechazado">Rechazado</p>
              </div>
            </div>
          </div>

          <div class="box-cards box-card-todos" id="todos">
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-aprobados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-aprobado">Aprobado</p>
              </div>
            </div>
            <div class="card-rechazados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-rechazado">Rechazado</p>
              </div>
            </div>
            <div class="card-rechazados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-rechazado">Rechazado</p>
              </div>
            </div>
            <div class="card-rechazados card-style">
              <div class="card-info">
                <div class="card-img">
                  <p class="title-c">Comprobante</p>
                </div>
                <div class="card-col left">
                  <div class="card-field">
                    <span class="icon-field">
                      <span class="icon-field">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                          <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                          <path
                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                      </span>
                    </span>
                    <span class="card-label">Nombre:</span> Coronel Aureliano
                  </div>
                  <div class="card-field">
                    <span class="icon-field"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                          d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                      </svg>
                    </span>
                    <span class="card-label">Curso:</span> Pescaditos de oro
                  </div>
                  <div class="card-field">
                    <span class="card-label">Fecha de pago:</span> 10/11/1878
                  </div>
                </div>
                <div class="card-col right">
                  <div class="card-field">
                    <span class="card-label">Correo:</span> buendia@colmail.com
                  </div>
                  <div class="card-field">
                    <span class="card-label">Teléfono:</span> 0412 11 77 333
                  </div>
                  <div class="card-field">
                    <span class="card-label">Valor en Bs:</span> 360.00
                  </div>
                </div>
              </div>
              <div class="box-buttons">
                <p class="e-rechazado">Rechazado</p>
              </div>
            </div>
        </div>
      </article>
    </section>
  </main>
</body>

</html>