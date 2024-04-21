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
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="game-title">Bienvenido a Valorant</h2>
            <p><?php echo $nombreUsuario; ?></p>
            <p><?php echo $nombreRango; ?></p>
            <img src="<?php echo $imagenRango; ?>" alt="Rango">
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
