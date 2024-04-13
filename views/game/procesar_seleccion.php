<?php
// procesar_seleccion.php

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
if(isset($_GET['id_avatar']) && isset($_GET['nickname'])) {
    $id_avatar = $_GET['id_avatar'];
    $nickname = $_GET['nickname'];

    // Actualizar la tabla de usuarios con el id del avatar seleccionado
    $consulta = $conexion->prepare("INSERT INTO sala (id_avatar, nickname) VALUES (?, ?)");
    $consulta->bind_param("ss", $id_avatar, $nickname);
    $consulta->execute();
    
    // Redireccionar al usuario a mapa.php
    header("Location: ../mundos.php");
    exit();
} else {
    // Si no se reciben los parámetros necesarios, redireccionar a una página de error o manejar el error de otra manera.
    echo "Error: Parámetros faltantes";
}
?>
