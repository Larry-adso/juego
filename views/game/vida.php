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

include('../../db/PDO.php');

// Actualizar el campo 'vida' en la tabla 'usuarios'
$vida = 100; // Valor de vida a actualizar
$sql = "UPDATE usuarios SET vida = :vida WHERE nickname = :nickname";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':vida', $vida, PDO::PARAM_INT);
$stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
$stmt->execute();

// Redireccionar con una alerta en JavaScript
echo '<script>
        alert("¡Su vida ha sido restaurada correctamente!");
        window.location = "../selecccion_de_avatar.php";
      </script>';
exit();
?>
