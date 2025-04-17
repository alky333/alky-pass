document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("passwordForm");
  const list = document.getElementById("passwordList");
  const searchInput = document.getElementById("searchInput");

  function copyToClipboard(text, button) {
    try {
      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
          addCopyEffect(button);
        });
      } else {
        const tempInput = document.createElement("input");
        tempInput.style.position = 'absolute';
        tempInput.style.left = '-9999px';
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        try {
          document.execCommand('copy');
          addCopyEffect(button);
        } finally {
          document.body.removeChild(tempInput);
        }
      }
    } catch (err) {
      console.log('Error al copiar:', err);
    }
  }

  function addCopyEffect(button) {
    if (button) {
      button.classList.add('copied');
      setTimeout(() => {
        button.classList.remove('copied');
      }, 1000);
    }
  }

  function loadPasswords(searchTerm = "") {
    fetch("api/get_all.php")
      .then(res => res.json())
      .then(data => {
        const filtered = data.filter(p => {
          return p.plataforma.toLowerCase().includes(searchTerm.toLowerCase()) ||
                 p.usuario.toLowerCase().includes(searchTerm.toLowerCase());
        });

        list.innerHTML = "";

        filtered.forEach((p, index) => {
          const card = document.createElement("div");
          card.className = "card p-3 password-card card-animated";

          const passwordId = `pwd-${p.id}`;
          card.innerHTML = `
            <h5>${p.plataforma}</h5>
            <div class="user-field mb-2">
              <div class="d-flex align-items-center">
                <strong>Usuario:</strong>
                <span class="mx-2">${p.usuario}</span>
                <button class="btn btn-outline-light btn-sm btn-copy-user" data-user="${p.usuario}">📋</button>
              </div>
            </div>
            <div class="password-field mb-2">
              <input type="password" id="${passwordId}" class="form-control form-control-sm password-input" value="${p.contrasena}" readonly>
              <button class="btn btn-outline-light btn-sm btn-toggle">👁️</button>
              <button class="btn btn-outline-light btn-sm btn-copy">📋</button>
            </div>
            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-custom btn-sm btn-edit mr-1 flex-fill">✏️ Editar</button>
              <button class="btn btn-outline-danger btn-sm btn-delete flex-fill">🗑️ Eliminar</button>
            </div>
          `;

          card.style.animationDelay = `${index * 100}ms`;

          card.querySelector('.btn-copy-user')?.addEventListener('click', function () {
            copyToClipboard(this.getAttribute('data-user'), this);
          });

          card.querySelector('.btn-copy')?.addEventListener('click', function () {
            copyToClipboard(p.contrasena, this);
          });

          card.querySelector(".btn-toggle")?.addEventListener("click", function () {
            toggleVisibility(passwordId, this);
          });

          card.querySelector(".btn-edit")?.addEventListener("click", function () {
            editPassword(p.id, p.plataforma, p.usuario, p.contrasena);
          });

          card.querySelector(".btn-delete")?.addEventListener("click", function () {
            deletePassword(p.id);
          });

          list.appendChild(card);
        });
      })
      .catch(error => {
        console.log('Error al cargar contraseñas:', error);
      });
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const data = {
      plataforma: document.getElementById("plataforma").value,
      usuario: document.getElementById("usuario").value,
      contrasena: document.getElementById("contrasena").value
    };
    fetch("api/insert.php", {
      method: "POST",
      body: JSON.stringify(data)
    })
      .then(res => res.json())
      .then(() => {
        form.reset();
        $('#addModal').modal('hide');
        loadPasswords();
      });
  });

  function toggleVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
      input.type = "text";
      button.textContent = "🙈";
    } else {
      input.type = "password";
      button.textContent = "👁️";
    }
  }

  function deletePassword(id) {
    const confirmarModal = $('#confirmarModal');
    confirmarModal.modal('show');

    const botonConfirmar = document.getElementById("btnConfirmarEliminar");
    botonConfirmar.onclick = () => {
      fetch("api/delete.php", {
        method: "POST",
        body: JSON.stringify({ id })
      })
        .then(res => res.json())
        .then(response => {
          $('#confirmarModal').modal('hide');
          if (response.success || response.status === "ok") {
            loadPasswords();
          } else {
            mostrarMensaje("Error", "No se pudo eliminar. Intenta nuevamente.");
          }
        });
    };
  }

  function editPassword(id, plataforma, usuario, contrasena) {
    document.getElementById("edit-id").value = id;
    document.getElementById("edit-plataforma").value = plataforma;
    document.getElementById("edit-usuario").value = usuario;
    document.getElementById("edit-contrasena").value = contrasena;
    $('#editModal').modal('show');
  }

  document.getElementById("editForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const id = document.getElementById("edit-id").value;
    const plataforma = document.getElementById("edit-plataforma").value;
    const usuario = document.getElementById("edit-usuario").value;
    const contrasena = document.getElementById("edit-contrasena").value;

    fetch("api/update.php", {
      method: "POST",
      body: JSON.stringify({ id, plataforma, usuario, contrasena })
    })
      .then(res => res.json())
      .then(() => {
        $('#editModal').modal('hide');
        loadPasswords();
      });
  });

  function mostrarMensaje(titulo, mensaje = "") {
    document.getElementById('mensajeModalLabel').innerText = titulo;
    document.getElementById('mensajeModalBody').innerHTML = mensaje;
    $('#mensajeModal').modal('show');
  }

  if (searchInput) {
    searchInput.addEventListener("input", function () {
      loadPasswords(searchInput.value);
    });
  }

  loadPasswords();
});
