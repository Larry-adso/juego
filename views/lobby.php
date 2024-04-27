<?php
include("../php/rangos.php");

try {
    // Consulta para obtener la información del usuario
    $consultaUsuario = $conexion->prepare("SELECT * FROM usuarios WHERE nickname = :nickname");
    $consultaUsuario->bindParam(':nickname', $_SESSION['nickname']);
    $consultaUsuario->execute();
    $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

    // Comprobar si se obtuvo el usuario correctamente
    if (!$usuario) {
        throw new Exception("El usuario no fue encontrado en la base de datos");
    }

    $nombreUsuario = $usuario['nickname'];
    $puntaje = $usuario['puntaje'];
    $nivel = $usuario['nivel'];


    // Consulta para obtener la información del rango del usuario
    $consultaRango = $conexion->prepare("SELECT * FROM rangos WHERE id = :nivel");
    $consultaRango->bindParam(':nivel', $usuario['nivel']);
    $consultaRango->execute();
    $rango = $consultaRango->fetch(PDO::FETCH_ASSOC);

    // Comprobar si se obtuvo el rango correctamente
    if (!$rango) {
        throw new Exception("El rango del usuario no fue encontrado en la base de datos");
    }

    $nombreRango = $rango['nombre'];

    // Ajustar la ruta de la imagen del rango
    $imagenRango = "../img/rangos/" . $rango['ruta_rango'];
} catch (PDOException $e) {
    // Manejar errores de PDO
    echo "Error de PDO: " . $e->getMessage();
} catch (Exception $e) {
    // Manejar otros tipos de errores
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz Principal - Juego</title>
    <link rel="stylesheet" href="../css/lobby.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-thin-straight/css/uicons-thin-straight.css'>
    
    <style>
        @import url('https://cdn-uicons.flaticon.com/2.3.0/uicons-thin-straight/css/uicons-thin-straight.css');
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #video-background {
            position: absolute;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .mute-button {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 999;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="video-container">
        <video autoplay loop id="video-background">
            <source src="../img/videos/fondo.mp4" type="video/mp4">
            <!-- Agrega más formatos de video si lo deseas -->
            Tu navegador no soporta videos HTML5.
        </video>
        <div class="mute-button" onclick="toggleMute()">
            <i class="fi fi-ts-volume-down"></i>
        </div>
        <div class="sidebar-info">
            <h2 class="game-title">Bienvenido</h2>
            <p><?php echo $nombreUsuario; ?></p>
            <h2 class="points">puntos: <?php echo $puntaje; ?></h2>
            <h2 class="points">Nivel: <?php echo $nivel; ?> </h2>
            <img id="rangoImg" src="<?php echo $imagenRango; ?>" alt="Rango" width="40px">
            <p><?php echo $nombreRango; ?></p>
        </div>
        <div class="sidebar">
            <div class="sidebar-menu">
                <ul>
                    <?php
                    // Agregar el enlace con el ID de usuario al botón "Jugar"
                    echo "<li><a href='game/vida.php?id=" . $nombreUsuario . "'>Jugar</a></li>";
                    ?>
                    <li><a href="#">Mundos</a></li>
                    <li><a href="historial/index.php">Historial</a></li>
                    <li><a href="#">Armas</a></li>
                    <li><a href="../php/login_register/cerrar.php">Cerrar</a></li>
                </ul>
            </div>
        </div>
      
    </div>
    <script>
        var video = document.getElementById('video-background');
        var muteButton = document.querySelector('.mute-button');
        var isMuted = false;

        function toggleMute() {
            if (isMuted) {
                video.muted = false;
                isMuted = false;
                // Alternar la clase del icono a "fi-ts-volume-down"
                muteButton.querySelector('i').classList.toggle('fi-ts-volume-down');
                // Quitar la clase del icono "fi-ts-volume-mute"
                muteButton.querySelector('i').classList.remove('fi-ts-volume-mute');
            } else {
                video.muted = true;
                isMuted = true;
                // Alternar la clase del icono a "fi-ts-volume-mute"
                muteButton.querySelector('i').classList.toggle('fi-ts-volume-mute');
                // Quitar la clase del icono "fi-ts-volume-down"
                muteButton.querySelector('i').classList.remove('fi-ts-volume-down');
            }
        }

        // Reproducir el video cuando se haga clic en algún lugar de la página
        document.addEventListener('click', function() {
            if (video.paused) {
                video.play();
            }
        });
    </script>
</body>

</html>
