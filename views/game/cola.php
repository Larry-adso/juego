<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Campos de la Tabla Sala</title>
    <!-- Agregar los enlaces a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/cola.css">
    <style>
        #contador {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3em;
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h1>Jugadores en cola</h1>
    </header>

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

    

    // Cerrar la conexión a la base de datos
    ?>

    <a href="../enfrentamientos/inir.php" id="iniciarBatallaBtn" class="btn btn-primary mi-btn" onclick="startCountdown()">Iniciar Batalla</a>
    <div id="contador"></div>
    <!-- Agregar el script de Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
