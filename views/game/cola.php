<?php
include("../../db/conexion.php");
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nickname'])) {
    echo '<script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "../index.php";
          </script>';
    session_destroy();
    die();
}
include("../../db/conexion.php");

$consulta = "SELECT s.id, s.nickname, m.nombre AS nombre_mapa, a.nombre AS nombre_avatar
                 FROM sala s
                 INNER JOIN mapas m ON s.id_mapa = m.id
                 INNER JOIN avatar a ON s.id_avatar = a.id";

$resultado = $conexion->query($consulta);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparacion de enfrentamientos </title>
    <!-- Agregar los enlaces a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/cola.css">
   
</head>

<body>
<div class="container">
    <header>
        <h1>¿Desea iniciar la batalla?</h1>
    </header>

    <!-- Resto del contenido -->
</div>

    <!-- Agregar el audio -->
    <audio id="audio" src="https://www.soundjay.com/button/beep-07.wav" preload="auto"></audio>

    <a href="#" id="iniciarBatallaBtn" class="btn btn-primary mi-btn" onclick="startCountdown()">Iniciar Batalla</a>
    <div id="contador"></div>

    <!-- Agregar el script de Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function startCountdown() {
            var botonBatalla = document.getElementById("iniciarBatallaBtn");
            botonBatalla.style.display = "none"; // Ocultar el botón al iniciar el contador

            var contadorElemento = document.getElementById("contador");
            var contador = 10;

            var intervalo = setInterval(function () {
                contadorElemento.innerHTML = contador;
                contador--;

                if (contador < 0) {
                    clearInterval(intervalo);
                    // Redireccionar después de que el contador llegue a cero
                    window.location.href = "../enfrentamientos/inir.php";
                } else {
                    // Cambiar el color de cada número
                    var color = getRandomColor();
                    contadorElemento.style.color = color;
                    // Reproducir el sonido
                    document.getElementById("audio").play();
                }
            }, 1000);

            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        }
    </script>

</body>

</html>
