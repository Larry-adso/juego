<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nickname'])) {
    echo '<script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "../index.php";
          </script>';
    session_destroy();
    exit(); // Terminar la ejecución del script después de redireccionar
}

include("../../db/conexion.php");

// Obtener el nickname del usuario autenticado
$usuario_autenticado = $_SESSION['nickname'];

// Obtener los datos del usuario autenticado
$sql_usuario_autenticado = "SELECT u.nickname, a.ruta as avatar
                            FROM usuarios u
                            INNER JOIN sala s ON u.nickname = s.nickname
                            INNER JOIN avatar a ON s.id_avatar = a.id
                            WHERE u.nickname = ?";

$consulta_usuario_autenticado = $conexion->prepare($sql_usuario_autenticado);
$consulta_usuario_autenticado->bind_param("s", $usuario_autenticado);
$consulta_usuario_autenticado->execute();
$result_usuario_autenticado = $consulta_usuario_autenticado->get_result();

// Verificar si se encontró el usuario autenticado
if ($result_usuario_autenticado->num_rows > 0) {
    $row_usuario_autenticado = $result_usuario_autenticado->fetch_assoc();
    $nombre_usuario_autenticado = $row_usuario_autenticado["nickname"];
    $avatar_usuario_autenticado = $row_usuario_autenticado["avatar"];
} else {
   
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Ganador</title>
    <!-- Enlaces a Bootstrap y estilos CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/victory.css">
</head>

<body>
    <div class="container">
        <h1>¡Felicidades! Eres el ganador</h1>
        <img src="<?php echo $avatar_usuario_autenticado; ?>" alt="Avatar" width="300px">
        <p>Nombre de usuario: <?php echo $nombre_usuario_autenticado; ?></p>
        <a href="../lobby.php" class="btn">Volver al lobby</a>

    </div>
</body>

</html>
<?php
// Cerrar la conexión con la base de datos
$conexion->close();
?>
