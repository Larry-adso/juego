<?php

include("../../db/conexion.php");

// Iniciar sesión
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
if(isset($_GET['id_avatar']) && isset($_SESSION['id'])) {
    $id_avatar = $_GET['id_avatar'];
    $id_jugador = $_SESSION['id'];

    // Verificar si el id_jugador ya está en la tabla sala_detalle
    $consulta_existencia = $conexion->prepare("SELECT id_avatar FROM sala_detalle WHERE id_jugador = ?");
    $consulta_existencia->bind_param("s", $id_jugador);
    $consulta_existencia->execute();
    $resultado_existencia = $consulta_existencia->get_result();

    // Si el id_jugador ya está en la tabla, eliminar el registro existente
    if($resultado_existencia->num_rows > 0) {
        $eliminar_anterior = $conexion->prepare("DELETE FROM sala_detalle WHERE id_jugador = ?");
        $eliminar_anterior->bind_param("s", $id_jugador);
        $eliminar_anterior->execute();
    }

    // Insertar el nuevo registro
    $insertar_nuevo = $conexion->prepare("INSERT INTO sala_detalle (id_avatar, id_jugador) VALUES (?, ?)");
    $insertar_nuevo->bind_param("ss", $id_avatar, $id_jugador);
    $insertar_nuevo->execute();

    // Verificar si la operación se realizó correctamente
    if($insertar_nuevo->affected_rows > 0) {
        // Redireccionar al usuario a mapa.php
        header("Location: ../mundos.php");
        exit();
    } else {
        echo "Error: No se pudo realizar la operación";
    }
} else {
    // Si no se reciben los parámetros necesarios, redireccionar a una página de error o manejar el error de otra manera.
    echo "Error: Parámetros faltantes";
}
?>
