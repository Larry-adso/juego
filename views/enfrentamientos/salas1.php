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

include("../../db/conexion.php");

// Obtener el nickname del usuario autenticado
$usuario_autenticado = $_SESSION['nickname'];

// Obtener los datos del usuario autenticado
$sql_usuario_autenticado = "SELECT u.nickname, u.vida, a.ruta as avatar FROM usuarios u
                            INNER JOIN sala s ON u.nickname = s.nickname
                            INNER JOIN avatar a ON s.id_avatar = a.id
                            WHERE u.nickname = '$usuario_autenticado'";
$result_usuario_autenticado = $conexion->query($sql_usuario_autenticado);

// Inicializar vida_maxima con un valor predeterminado
$vida_maxima = 150; // Valor predeterminado

// Verificar si se encontró el usuario autenticado
if ($result_usuario_autenticado->num_rows > 0) {
  $row_usuario_autenticado = $result_usuario_autenticado->fetch_assoc();
  $nombre_usuario_autenticado = $row_usuario_autenticado["nickname"];
  $vida_usuario_autenticado = $row_usuario_autenticado["vida"];
  $avatar_usuario_autenticado = $row_usuario_autenticado["avatar"];

  // Calcular el porcentaje de vida del usuario autenticado
  $vida_porcentaje_usuario_autenticado = ($vida_usuario_autenticado / $vida_maxima) * 100;
} else {
  // Si el usuario autenticado no se encuentra en la tabla sala, mostrar mensaje y redireccionar
  echo '<script>
            alert("Lo siento ha sido eliminado ");
            window.location = "../lobby.php";
          </script>';
  die();
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Enfrentamiento</title>
  <!-- Enlaces a Bootstrap y estilos CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilos personalizados */
    .card {
      margin-bottom: 20px;
    }

    .progress {
      height: 20px;
      margin-bottom: 10px;
    }

    .progress-bar {
      background-color: #4CAF50;
      /* Color de fondo de la barra de progreso */
    }

    .avatar-img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <header>
    <!-- Mostrar el usuario autenticado -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <img src="<?php echo $avatar_usuario_autenticado; ?>" class="avatar-img" alt="Avatar">
          <h3><?php echo $nombre_usuario_autenticado; ?></h3>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: <?php echo $vida_porcentaje_usuario_autenticado; ?>%;" aria-valuenow="<?php echo $vida_porcentaje_usuario_autenticado; ?>" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p>Vida: <?php echo $vida_usuario_autenticado; ?></p>
        </div>
      </div>
    </div>
  </header>
  <?php
  // Verificar si solo hay un jugador en la sala
  $sql_numero_jugadores = "SELECT COUNT(*) as total_jugadores FROM sala";
  $result_numero_jugadores = $conexion->query($sql_numero_jugadores);

  if ($result_numero_jugadores->num_rows > 0) {
    $row_numero_jugadores = $result_numero_jugadores->fetch_assoc();
    $total_jugadores = $row_numero_jugadores['total_jugadores'];

    if ($total_jugadores == 1) {
      // Eliminar al único jugador de la sala
      $sql_eliminar_jugador = "DELETE FROM sala";
      $conexion->query($sql_eliminar_jugador);

      // Mostrar mensaje de ganador y redirigir al usuario al lobby
      echo '<div class="alert alert-success" role="alert">
                ¡Felicidades! ¡Eres el ganador!
              </div>';
      echo '<script>
                setTimeout(function(){
                  window.location.href = "../lobby.php";
                }, 3000);
              </script>';
      exit; // Terminar la ejecución del script
    }
  }
  ?>


  <main class="container">
    <h1>Enfrentamiento</h1>
    <p>Los jugadores en enfrentamiento son:</p>
    <?php
    // Verificar si $jugadores está definido y no es nulo
    if (isset($_GET['jugadores']) && $_GET['jugadores'] !== '') {
      // Obtener los jugadores del URL
      $jugadores = explode(',', $_GET['jugadores']);

      // Iterar sobre los jugadores y obtener sus nombres, vidas y avatares
      foreach ($jugadores as $jugador) {
        // Escapar el nombre del jugador para evitar inyección SQL
        $jugador_escapado = $conexion->real_escape_string($jugador);

        // Consulta SQL para obtener los datos del jugador
        $sql = "SELECT u.nickname, u.vida, a.ruta as avatar FROM usuarios u
                  INNER JOIN sala s ON u.nickname = s.nickname
                  INNER JOIN avatar a ON s.id_avatar = a.id
                  WHERE u.nickname = '$jugador_escapado' AND u.vida > 0";
        $result = $conexion->query($sql);

        // Verificar si se encontró el jugador y mostrar su información
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $nombre_jugador = $row["nickname"];
          $vida_jugador = $row["vida"];
          $avatar_jugador = $row["avatar"];

          // Calcular el porcentaje de vida del jugador
          $vida_porcentaje = ($vida_jugador / $vida_maxima) * 100;

          // Mostrar el avatar, nombre del jugador y su vida con una tarjeta y barra de progreso
          if ($nombre_jugador != $usuario_autenticado) {
            // Solo mostrar el botón de ataque si el jugador objetivo no es el mismo que el usuario autenticado
            echo "<div class='col-md-4'>
                            <div class='card'>
                              <div class='card-body'>
                                <img src='$avatar_jugador' class='avatar-img' alt='Avatar'>
                                <h5 class='card-title'>$nombre_jugador</h5>
                                <div class='progress'>
                                  <div class='progress-bar' role='progressbar' style='width: $vida_porcentaje%;' aria-valuenow='$vida_porcentaje' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                                <p class='card-text'>Vida: $vida_jugador</p>
                                <form action='disparar.php' method='post'>
                                  <input type='hidden' name='jugador_objetivo' value='$nombre_jugador'>
                                  <button type='submit' name='disparar' class='btn btn-primary'>Disparar</button>
                                </form>
                              </div>
                            </div>
                          </div>";
          }
        }
      }
    } else {
      // Si no se encontraron jugadores, mostrar un mensaje de error
      echo "<div class='col-md-12'><p>No se encontraron jugadores.</p></div>";
    }
    ?>
    <!-- Aquí puedes incluir más contenido si es necesario -->
  </main>
  <footer>
    <!-- Aquí va tu pie de página si es necesario -->
  </footer>
  <!-- Enlaces a JavaScript y otros scripts si es necesario -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Script para recargar la página cada 3 segundos -->
  <script>
    setTimeout(function() {
      location.reload();
    }, 3000);
  </script>
</body>

</html>

<?php
// Cerrar la conexión con la base de datos
$conexion->close();
?>