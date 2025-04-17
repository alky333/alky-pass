<?php include("api/session.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <link rel="icon" type="image/png" href="media/logo.png">

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pass Keep</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    
    .invert-logo {
      filter: invert(1);
    }

    .dropdown-menu-dark {
      background-color: #343a40;
      color: white;
    }

    .dropdown-menu-dark label {
      color: white;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
    }

    .content-wrapper {
      flex: 1;
    }

    footer {
      margin-top: auto;
    }

    .decorative-bar {
      height: 6px;
      background-color: #17a2b8;
    }

    body {
      background-color: #121212;
      color: white;
    }


    .password-field {
      display: flex;
      align-items: center;
    }

    .password-input {
      flex: 1;
      margin-right: 8px;
    }

    .btn-copy,
    .btn-toggle {
      white-space: nowrap;
    }

    .form-control-sm {
      font-size: 0.875rem;
      padding: 0.25rem 0.5rem;
    }

    @keyframes fadeInContent {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in-content {
  animation: fadeInContent 1s ease-out;
}


.login-box {
  animation: fadeSlideIn 0.8s ease-out;
}

  </style>
</head>

<body class="text-warning">
<div class="dynamic-mouse-bg" id="mouseReactiveBg"></div>

<div class="matrix-effect" id="matrixEffect"></div>

  <!-- Navbar -->
  <nav class="navbar pulse-navbar">
    <div class="container-fluid d-flex align-items-center ">
      <a class="navbar-brand" href="#">
        <img src="media/database-lock.svg" alt="Logo" width="30" height="24"
          class="d-inline-block align-text-top invert-logo" />
          <span class="glitch" data-text="Pass Keep"><strong>Keepper</strong></>

      </a>

      <!-- Search form -->
      <div class="search-container">
        <input class="form-control" id="searchInput" type="search" placeholder="Buscar plataforma o usuario..." 
               aria-label="Search">
      </div>

      <!-- Dropdown with form -->
      <!-- Botón para abrir el modal de añadir -->
      <button class="btn btn-outline-light btn-sm" data-toggle="modal" data-target="#addModal">
        Añadir Contraseña
      </button>


      <!-- Logout -->
      <a href="#" class="btn btn-danger btn-sm ml-2" id="logoutBtn">Salir</a>
    </div>
  </nav>

  <!-- Contenido principal envuelto -->
  <div class="content-wrapper">
  <div id="passwordList" class="container-fluid fade-in-content"></div>
</div>

</div>

    </div>
  </div>

  <!-- Modal para editar contraseña -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content modal-glass text-white">

        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Contraseña</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <input type="hidden" id="edit-id">
            <div class="form-group">
              <label for="edit-plataforma">Plataforma</label>
              <input type="text" class="form-control" id="edit-plataforma" required>
            </div>
            <div class="form-group">
              <label for="edit-usuario">Usuario</label>
              <input type="text" class="form-control" id="edit-usuario" required>
            </div>
            <div class="form-group">
              <label for="edit-contrasena">Contraseña</label>
              <input type="text" class="form-control" id="edit-contrasena" required>
            </div>
            <button type="submit" class="btn btn-outline-custom btn-block">Guardar cambios</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Mensaje -->
  <div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-glass text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="mensajeModalLabel">Mensaje</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="mensajeModalBody">Texto del mensaje...</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Confirmación -->
  <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-glass text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmarModalLabel">¿Estás seguro?</h5>
        </div>
        <div class="modal-body" id="confirmarModalBody">
          Esta acción no se puede deshacer.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Sí, eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal para agregar contraseña -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content modal-glass text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Añadir Contraseña</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="passwordForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="plataforma">Plataforma</label>
              <input type="text" id="plataforma" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="usuario">Usuario</label>
              <input type="text" id="usuario" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="contrasena">Contraseña</label>
              <input type="text" id="contrasena" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-outline-custom mr-2" data-dismiss="modal">Cancelar</button>
<button type="submit" class="btn btn-outline-custom">Guardar</button>


          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="decorative-bar"></div>
    <div class="bg-dark text-white text-center py-3">
      Creado por Alky (⌐■_■)
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script>
    // Ctrl + K para enfocar el buscador
    document.addEventListener('keydown', function (e) {
      if (e.ctrlKey && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
          searchInput.focus();
          searchInput.select();
        }
      }
    });
  </script>
  <script src="js/main.js"></script>

  <!-- matrix effect -->
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("matrixEffect");
    const lines = 50; // Puedes subir o bajar el número

    for (let i = 0; i < lines; i++) {
      const line = document.createElement("div");
      line.classList.add("matrix-line");
      line.style.left = `${Math.random() * 100}%`;
      line.style.animationDelay = `${Math.random() * 3}s`;
      line.style.animationDuration = `${2 + Math.random() * 3}s`;
      container.appendChild(line);
    }
  });
</script>

<script>
document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Crear contenedor principal
    const container = document.createElement('div');
    container.className = 'tv-shutdown-container';
    document.body.appendChild(container);
    
    // Crear el elemento de apagado TV
    const tvShutdown = document.createElement('div');
    tvShutdown.className = 'tv-shutdown';
    container.appendChild(tvShutdown);
    
    // Crear efecto de línea de escaneo
    const scanline = document.createElement('div');
    scanline.className = 'tv-scanline';
    container.appendChild(scanline);
    
    // Aplicar animaciones
    container.style.animation = 'fadeToBlack 1s forwards';
    tvShutdown.style.animation = 'tvShutdown 1s cubic-bezier(.23,1,.32,1) forwards';
    
    // Forzar que todo el contenido se oculte
    setTimeout(() => {
        document.body.style.visibility = 'hidden';
        container.style.visibility = 'visible';
        tvShutdown.style.visibility = 'visible';
    }, 100);
    
    // Redirigir después de que termine la animación
    setTimeout(() => {
        window.location.href = 'api/logout.php';
    }, 1000);
});
</script>

</body>

</html>