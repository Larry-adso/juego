<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/mundos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-XXX" crossorigin="anonymous" />


  <title>Mundos</title>
</head>
<body>
  <header>
    <div class="top-container">
      <div class="room-buttons">
        <!-- Botones de las diferentes salas -->
        <button class="room-button active" onclick="activateRoom(this)">Sala 1</button>
        <button class="room-button" onclick="activateRoom(this)">Sala 2</button>
        <!-- Otros botones -->
        <div class="icons">
          <a href="#inicio"><img src="../img/home_263115.png" ></a>
          <a href="#armas"><img src="../img/missile_838464.png" ></a>
          <a href="#perfil"><img src="../img/mundo.png" ></a>
          <a href="#mundos"><img src="../img/user_1144760.png" ></a>
        </div>
      </div>
      <h1>Salas</h1>
      <button class="back-button">Atrás</button>
    </div>
  </header>

  <main>
    <div class="rooms-container">
      <!-- Contenedor de las salas -->
      <div class="room">
        <img src="../img/mundo1.jpg" alt="Sala 1" width="300" height="200">
        <div class="info">
          <h2>Sala 1</h2>
          <p>Jugadores: 4/8</p>
          <button class="join-button">Unirme</button>
        </div>
      </div>
      <div class="room">
        <img src="../img/mundo2.jpg" alt="Sala 2" width="300" height="200">
        <div class="info">
          <h2>Sala 2</h2>
          <p>Jugadores: 3/8</p>
          <button class="join-button">Unirme</button>
        </div>
      </div>
      <!-- Agregar más salas según sea necesario -->
    </div>
  </main>

  <script>
    function activateRoom(button) {
      var buttons = document.querySelectorAll('.room-button');
      buttons.forEach(function(btn) {
        btn.classList.remove('active');
      });
      button.classList.add('active');
    }
  </script>
</body>
</html>
