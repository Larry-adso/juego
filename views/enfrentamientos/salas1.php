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

// Verificar si los jugadores están definidos
if (!isset($_GET['jugadores'])) {
    // Redireccionar si los jugadores no están definidos
    header("Location: pagina_anterior.php");
    exit();
}

include("../../db/conexion.php");

// Obtener la vida máxima de la tabla usuarios
$sql_vida_maxima = "SELECT MAX(vida) AS vida_maxima FROM usuarios";
$result_vida_maxima = $conexion->query($sql_vida_maxima);

// Verificar si se encontró la vida máxima
if ($result_vida_maxima->num_rows > 0) {
    $row_vida_maxima = $result_vida_maxima->fetch_assoc();
    $vida_maxima = $row_vida_maxima["vida_maxima"];
} else {
    // Si no se encontró la vida máxima, asigna un valor predeterminado
    $vida_maxima = 150; // Valor predeterminado
}

// Obtener el nickname del usuario autenticado
$usuario_autenticado = $_SESSION['nickname'];

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
      background-color: #4CAF50; /* Color de fondo de la barra de progreso */
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
    <p>Usuario autenticado: <?php echo $usuario_autenticado; ?></p>
  </header>
  <main class="container">
    <h1>Enfrentamiento</h1>
    <p>Los jugadores en enfrentamiento son:</p>
    <div class="row">
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
      } else {
          // Si no se encontraron jugadores, mostrar un mensaje de error
          echo "<div class='col-md-12'><p>No se encontraron jugadores.</p></div>";
      }
      ?>
    </div>
    <!-- Aquí puedes incluir más contenido si es necesario -->
  </main>
  <footer>
    <!-- Aquí va tu pie de página si es necesario -->
  </footer>
  <!-- Enlaces a JavaScript y otros scripts si es necesario -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión con la base de datos
$conexion->close();
?>
