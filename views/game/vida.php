<?php
// Iniciar la sesión
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

// Obtener el nickname del usuario autenticado
$nickname = $_SESSION['nickname'];

// Incluir el archivo de conexión a la base de datos
include('../../db/PDO.php'); // Asegúrate de que el nombre del archivo de conexión sea el correcto

// Actualizar el campo 'vida' en la tabla 'usuarios'
$vida = 150; // Valor de vida a actualizar
$sql = "UPDATE usuarios SET vida = :vida WHERE nickname = :nickname";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':vida', $vida, PDO::PARAM_INT);
$stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
$stmt->execute();

// Redirigir a alguna página después de la actualización
header('Location: ../selecccion_de_avatar.php');
exit();
?>
