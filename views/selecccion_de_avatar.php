<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/avatar.css">
  <title>Selección de Avatar</title>
</head>
<body>
  <header>
    <div class="top-container">
      <h1>Seleccione su Avatar</h1>
      <div class="icons">
        <a href="#inicio"><img src="inicio-icon.png" alt="Inicio"></a>
        <a href="#armas"><img src="armas-icon.png" alt="Armas"></a>
        <a href="#perfil"><img src="perfil-icon.png" alt="Perfil"></a>
        <a href="#mundos"><img src="mundos-icon.png" alt="Mundos"></a>
      </div>
      <button class="back-button">Atrás</button>
    </div>
  </header>

  <main>
    <div class="avatar-container">
      <!-- Contenedor de avatares -->
      <div class="avatar" onclick="selectAvatar(this)">
        <img src="avatar1.png" alt="Avatar 1">
        <div class="info">
          <h2>Avatar 1</h2>
          <p>Características: Característica 1, Característica 2, Característica 3</p>
        </div>
      </div>
      <div class="avatar" onclick="selectAvatar(this)">
        <img src="avatar2.png" alt="Avatar 2">
        <div class="info">
          <h2>Avatar 2</h2>
          <p>Características: Característica 1, Característica 2, Característica 3</p>
        </div>
      </div>
      <!-- Agregar más avatares según sea necesario -->
    </div>
    <button class="select-button" onclick="confirmSelection()">Seleccionar Avatar</button>
  </main>

  <script>
    let selectedAvatar = null;

    function selectAvatar(avatar) {
      if (selectedAvatar) {
        selectedAvatar.classList.remove('selected');
      }
      avatar.classList.add('selected');
      selectedAvatar = avatar;
    }

    function confirmSelection() {
      if (selectedAvatar) {
        // Aquí puedes agregar la lógica para procesar la selección del avatar
        console.log("Avatar seleccionado:", selectedAvatar.querySelector('h2').textContent);
      } else {
        alert("Por favor seleccione un avatar.");
      }
    }
  </script>
</body>
</html>
