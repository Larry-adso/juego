<?php
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

include("../db/PDO.php");

try {
    // Preparar y ejecutar la consulta
    $consultaUsuario = $conexion->prepare("SELECT nickname FROM usuarios WHERE nickname = :nickname");
    $consultaUsuario->bindParam(':nickname', $_SESSION['nickname']);
    $consultaUsuario->execute();
    $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

    // Comprobar si se obtuvo el nombre de usuario correctamente
    if (!$usuario) {

        throw new Exception("El usuario no fue encontrado en la base de datos");
    }

    $nombreUsuario = $usuario['nickname'];
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú lateral responsive - MagtimusPro</title>

    <link rel="stylesheet" href="../css/nav.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open">
            </i>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <i class="fab fa-youtube"></i>
            <p>: <?php echo $nombreUsuario; ?></p>
        </div>

        <div class="options__menu">

            <a href="../php/login_register/cerrar.php" class="selected">
                <div class="option">
                    <i class="fas fa-home" title="Inicio"></i>
                    <h4>cerrar</h4>
                </div>
            </a>

            <a href="lobby.php">
                <div class="option">
                    <i class="far fa-file" title="Portafolio"></i>
                    <h4>jugar</h4>
                </div>
            </a>

            <a href="admin/avatar.php">
                <div class="option">
                    <i class="far fa-file" title="Portafolio"></i>
                    <h4>avatar</h4>
                </div>
            </a>

            <a href="mundos.php">
                <div class="option">
                    <i class="fas fa-video" title="Cursos"></i>
                    <h4>mundos</h4>
                </div>
            </a>

            <a href="armas.php">
                <div class="option">
                    <i class="far fa-sticky-note" title="Blog"></i>
                    <h4>armas</h4>
                </div>
            </a>

            <a href="selecccion_de_avatar.php">
                <div class="option">
                    <i class="far fa-id-badge" title="Contacto"></i>
                    <h4>avatar confirmSelection</h4>
                </div>
            </a>

            <a href="admin/mapas.php">
                <div class="option">
                    <i class="far fa-address-card" title="Nosotros"></i>
                    <h4>mapas</h4>
                </div>
            </a>

            <a href="admin/armas.php">
                <div class="option">
                    <i class="far fa-address-card" title="Nosotros"></i>
                    <h4>armas</h4>
                </div>
            </a>

            <a href="game/armas_select.php">
                <div class="option">
                    <i class="far fa-address-card" title="Nosotros"></i>
                    <h4>ver armas</h4>
                </div>
            </a>

        </div>
    </div>

    <main>


    </main>

    <script src="../js/nav.js"></script>
</body>

</html>