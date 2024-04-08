<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Principal - Juego</title>
    <link rel="stylesheet" href="../css/lobby.css">
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>Bienvenido a Valorant</h1>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="#" onclick="showPlayButton()">Jugar</a></li>
                <li><a href="#">Mundos</a></li>
                <li><a href="#">Armas</a></li>
                <li><a href="#">Perfil</a></li>
            </ul>
        </div>
    </div>
    <div class="main-content">
        <button id="play-button" class="hidden" onclick="startGame()">
            <img src="../img/play.png" alt="Play">
        </button>
    </div>

    <script src="../js/lobby.js"></script>
</body>

</html>
