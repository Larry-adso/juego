<?php
include("../db/PDO.php");

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


try {
    // Preparar y ejecutar la consulta
    $consultaUsuario = $conexion->prepare("SELECT * FROM usuarios WHERE nickname = :nickname");
    $consultaUsuario->bindParam(':nickname', $_SESSION['nickname']);
    $consultaUsuario->execute();
    $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

    // Comprobar si se obtuvo el nombre de usuario correctamente
    if (!$usuario) {

        throw new Exception("El usuario no fue encontrado en la base de datos");
    }

    $nombreUsuario = $usuario['nickname'];
    $puntaje = $usuario['puntaje'];
    $nivel = $usuario['nivel'];
} catch (PDOException $e) {
    // Manejar errores de PDO
    echo "Error de PDO: " . $e->getMessage();
} catch (Exception $e) {
    // Manejar otros tipos de errores
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión a la base de datos
$conexion = null;
?>

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
            <h2 class="game-title">Bienvenido a Valorant</h2>
            <p> <?php echo $nombreUsuario; ?></p>
        
        </div>
        <div class="sidebar-menu">
            <ul>
                <?php
                // Agregar el enlace con el ID de usuario al botón "Jugar"
                echo "<li><a href='game/vida.php?id=" . $nombreUsuario . "'>Jugar</a></li>";
                ?>
                <li><a href="#">Mundos</a></li>
                <li><a href="historial/index.php">Historial</a></li>
                <li><a href="#">Armas</a></li>
                <li><a href="#">Perfil</a></li>
            </ul>
        </div>
    </div>
    <div class="main-content">
        <!-- Aquí puedes mantener el botón para jugar -->
        <button id="play-button" class="hidden" onclick="startGame()">
            <img src="../img/play.png" alt="Play">
        </button>
    </div>

</body>

</html>

<a name="" id="" class="btn btn-primary" href="#" role="button">Button</a>