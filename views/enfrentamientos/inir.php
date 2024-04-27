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

include("../../db/PDO.php");

try {
  // Preparar y ejecutar la consulta para obtener la información del usuario
  $consultaUsuario = $conexion->prepare("SELECT nickname, nivel FROM usuarios WHERE nickname = :nickname ");
  $consultaUsuario->bindParam(':nickname', $_SESSION['nickname']);
  $consultaUsuario->execute();
  $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

  // Comprobar si se obtuvo el nombre de usuario correctamente
  if (!$usuario) {
    throw new Exception("El usuario no fue encontrado en la base de datos");
  }

  $nombreUsuario = $usuario['nickname'];
  $nivelUsuario = $usuario['nivel'];
} catch (PDOException $e) {
  // Manejar errores de PDO
  echo "Error de PDO: " . $e->getMessage();
  exit();
} catch (Exception $e) {
  // Manejar otros tipos de errores
  echo "Error: " . $e->getMessage();
  exit();
}

// Realizar la consulta para obtener una muestra aleatoria de 4 jugadores con el mismo nivel y mismo mapa
try {
  $conexion = new PDO("mysql:host=localhost;dbname=juego", "root", "");
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sala = $conexion->prepare("SELECT sala.*, usuarios.nivel, mapas.nombre AS nombre_mapa, armas.nombre AS nombre_arma 
                              FROM sala 
                              INNER JOIN usuarios ON sala.nickname = usuarios.nickname
                              INNER JOIN mapas ON sala.id_mapa = mapas.id
                              INNER JOIN armas ON sala.id_arma = armas.id
                              WHERE usuarios.nivel = :nivelUsuario
                              AND sala.id_mapa = (SELECT id_mapa FROM sala WHERE nickname = :nombreUsuario LIMIT 1)
                              AND sala.nickname != :nombreUsuario
                              ORDER BY RAND()
                              LIMIT 4");
  $sala->bindParam(':nivelUsuario', $nivelUsuario);
  $sala->bindParam(':nombreUsuario', $nombreUsuario);
  $sala->execute();
  $info = $sala->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  // Manejar errores de PDO
  echo "Error de PDO: " . $e->getMessage();
  exit();
}

// Obtener los nicknames de los jugadores seleccionados
$jugadores = array_column($info, 'nickname');

// Agregar el nickname del usuario que inició sesión
array_push($jugadores, $nombreUsuario);

// Generar un número aleatorio para identificar la sala

// Redireccionar a salas1.php y pasar los nicknames de los 5 jugadores y el número de sala
header("Location: salas1.php?jugadores=" . implode(',', $jugadores));

try {
  $updateSala = $conexion->prepare("UPDATE sala SET ocupado = 1, numero_sala = :numeroSala WHERE nickname IN ('" . implode("','", $jugadores) . "')");
  $updateSala->bindParam(':numeroSala', $numeroSala);
  $updateSala->execute();
  header("Location: salas1.php?jugadores=" . implode(',', $jugadores) . "&numero_sala=" . $numeroSala);
} catch (PDOException $e) {
  // Manejar errores de PDO
  echo "Error de PDO al actualizar el campo 'ocupado': " . $e->getMessage();
}


exit();
?>
