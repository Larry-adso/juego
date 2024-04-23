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

// Obtener el nickname del jugador que inició sesión
$nickname_disparador = $_SESSION['nickname'];

// Verificar si se recibió una solicitud GET con el nombre del jugador objetivo
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['disparar']) && isset($_GET['jugador_objetivo'])) {
    $jugador_objetivo = $_GET['jugador_objetivo'];

    // Conexión a la base de datos
    include("../../db/conexion.php");

    // Obtener el ID del arma del jugador que inició sesión desde la tabla sala
    $sql_arma_disparador = "SELECT id_arma FROM sala WHERE nickname = '$nickname_disparador'";
    $result_arma_disparador = $conexion->query($sql_arma_disparador);

    if ($result_arma_disparador->num_rows > 0) {
        $row_arma_disparador = $result_arma_disparador->fetch_assoc();
        $id_arma_disparador = $row_arma_disparador['id_arma'];

        // Obtener los datos del arma (nombre, daños) desde la tabla armas
        $sql_datos_arma = "SELECT nombre, da_body, da_head FROM armas WHERE id = $id_arma_disparador";
        $result_datos_arma = $conexion->query($sql_datos_arma);

        if ($result_datos_arma->num_rows > 0) {
            $row_datos_arma = $result_datos_arma->fetch_assoc();
            $nombre_arma = $row_datos_arma['nombre'];

            // Seleccionar aleatoriamente si el disparo es a la cabeza (1) o al cuerpo (0)
            $parte_cuerpo = rand(0, 1);

            // Determinar el daño según la parte del cuerpo atacada
            $danio = ($parte_cuerpo === 1) ? $row_datos_arma['da_head'] : $row_datos_arma['da_body'];

            // Actualizar la vida del jugador objetivo en la base de datos
            $sql_actualizar_vida = "UPDATE usuarios SET vida = vida - $danio WHERE nickname = '$jugador_objetivo'";
            $conexion->query($sql_actualizar_vida);

            // Obtener el puntaje actual del jugador que realizó el disparo
            $sql_puntaje_actual = "SELECT puntaje FROM usuarios WHERE nickname = '$nickname_disparador'";
            $result_puntaje_actual = $conexion->query($sql_puntaje_actual);

            if ($result_puntaje_actual->num_rows > 0) {
                $row_puntaje_actual = $result_puntaje_actual->fetch_assoc();
                $puntaje_actual = $row_puntaje_actual['puntaje'];

                // Sumar el daño al puntaje actual del jugador
                $puntaje_nuevo = $puntaje_actual + $danio;

                // Actualizar el puntaje del jugador en la base de datos
                $sql_actualizar_puntaje = "UPDATE usuarios SET puntaje = $puntaje_nuevo WHERE nickname = '$nickname_disparador'";
                $conexion->query($sql_actualizar_puntaje);
            }

            // Después de actualizar la vida del jugador objetivo en la base de datos
            if ($conexion->affected_rows > 0 && $conexion->affected_rows != -1) {
                // Obtener la vida actual del jugador objetivo
                $sql_vida_actual = "SELECT vida FROM usuarios WHERE nickname = '$jugador_objetivo'";
                $result_vida_actual = $conexion->query($sql_vida_actual);
                if ($result_vida_actual->num_rows > 0) {
                    $row_vida_actual = $result_vida_actual->fetch_assoc();
                    $vida_actual = $row_vida_actual['vida'];

                    // Verificar si la vida del jugador objetivo es menor o igual a 0
                    if ($vida_actual <= 0) {
                        $new_resumen_w = 'perdedor';
                        $estados = "UPDATE sala SET resumen = '$new_resumen_w' WHERE nickname = '$jugador_objetivo'";
                        $conexion->query($estados);

                        $sql_eliminar_jugador = "DELETE FROM sala WHERE nickname = '$jugador_objetivo'";
                        $conexion->query($sql_eliminar_jugador);

                        // Mostrar mensaje de eliminación y quién lo eliminó
                        echo "<script>alert('¡$jugador_objetivo ha sido eliminado por $nickname_disparador!');</script>";
                    }
                }
            }

            // Mensaje de disparo exitoso
            $mensaje_disparo = ($parte_cuerpo === 1) ? "cabeza" : "cuerpo";

            // Obtener los nicknames de los jugadores en la sala
            $sql_nicknames = "SELECT nickname FROM sala";
            $result_nicknames = $conexion->query($sql_nicknames);
            $nicknames = array();

            if ($result_nicknames->num_rows > 0) {
                while ($row = $result_nicknames->fetch_assoc()) {
                    $nicknames[] = $row['nickname'];
                }
            }

            // Redirigir a salas1.php con los nicknames como parámetros GET
            $jugadores = isset($_GET['jugadores']) ? $_GET['jugadores'] : '';

            // Redirigir a sala1.php
            echo "<script>
            alert('¡Disparo exitoso con un daño de $danio puntos usando $nombre_arma en $mensaje_disparo!');

                    window.location = '../enfrentamientos/salas1.php?jugadores=" . implode(',', $jugadores) . "';
                  </script>";
            exit();
        } else {
            echo "<script>
            alert('Error: No se encontraron jugadores en la sala');
            window.location = 'salas1.php';
          </script>";
        }
    } else {
        echo "<script>alert('Error: No se encontró el ID del arma del disparador');
        window.location = 'salas1.php';
        </script>";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();

    // Redirigir de vuelta a la página anterior
    // header("Location: pagina_anterior.php");
    exit();
} else {
    // Si no se recibió una solicitud GET válida, redirigir a una página de error o mostrar un mensaje
    echo "<script>alert('Error: Acceso no autorizado');</script>";
    header("Location: pagina_error.php");
    exit();
}
