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
</head>

<body>
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
    <div class="main-content">
        <!-- Aquí puedes mantener el botón para jugar -->
        <button id="play-button" class="hidden" onclick="startGame()">
            <img src="../img/play.png" alt="Play">
        </button>
    </div>
</body>

</html>