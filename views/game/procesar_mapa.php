<?php
include("../../db/conexion.php");
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nickname']) || !isset($_SESSION['id'])) {
    echo '<script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "../index.php";
          </script>';
    session_destroy();
    die();
}

// Verificar si se reciben los parámetros necesarios
if(isset($_GET['id_mapa'])) {
    $id_mapa = $_GET['id_mapa'];
    $id_jugador = $_SESSION['id'];

    echo "ID Mapa recibido: " . $id_mapa; // Agrega esta línea para depurar

    // Actualizar la tabla de usuarios con el id del avatar seleccionado
    $consulta = $conexion->prepare("UPDATE sala_detalle SET id_mapa = ? WHERE id_jugador = ?");
    if ($consulta === false) {
        die("Error de preparación de consulta: " . $conexion->error);
    }
    
    $consulta->bind_param('is', $id_mapa, $id_jugador);
    if (!$consulta->execute()) {
        die("Error al ejecutar la consulta: " . $consulta->error);
    }
    
    echo '<script>
    alert("se guardo correctamente");
    window.location = "../game/cola.php";
  </script>';
    exit();
} else {
    // Si no se reciben los parámetros necesarios, redireccionar a una página de error o manejar el error de otra manera.
    echo "Error: Parámetros faltantes";
}
?>
