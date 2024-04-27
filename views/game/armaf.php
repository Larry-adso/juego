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

// Verificar si se reciben los parámetros necesarios
if (isset($_GET['id_arma'])) {
    $id_arma = $_GET['id_arma'];
    $nickname = $_SESSION['nickname'];

    // Actualizar la tabla de usuarios con el id del arma seleccionado solo para el usuario actual
    $consulta = $conexion->prepare("UPDATE sala SET id_arma = ? WHERE nickname = ?");
    if ($consulta === false) {
        die("Error de preparación de consulta: " . $conexion->error);
    }

    $consulta->bind_param('is', $id_arma, $nickname);
    if (!$consulta->execute()) {
        die("Error al ejecutar la consulta: " . $consulta->error);
    }

    // Obtener los jugadores de vuelta desde los parámetros GET
    $jugadores = isset($_GET['jugadores']) ? $_GET['jugadores'] : '';

    // Redirigir a sala1.php
    echo "<script>
            window.location = '../enfrentamientos/inir.php?jugadores=" . implode(',', $jugadores) . "';
          </script>";
    exit();
} else {
    // Si no se reciben los parámetros necesarios, redireccionar a una página de error o manejar el error de otra manera.
    echo "Error: Parámetros faltantes";
}
?>
