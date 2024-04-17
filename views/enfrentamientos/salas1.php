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
    $vida_maxima = 100; // Valor predeterminado
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
      background-color: #4CAF50; /* Color de fondo de la barra de progreso */
    }
  </style>
</head>
<body>
  <header>
    <!-- Aquí va tu encabezado si es necesario -->
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

          // Iterar sobre los jugadores y obtener sus nombres y vidas
          foreach ($jugadores as $jugador) {
              // Escapar el nombre del jugador para evitar inyección SQL
              $jugador_escapado = $conexion->real_escape_string($jugador);

              // Consulta SQL para obtener el nombre y la vida del jugador
              $sql = "SELECT nickname, vida FROM usuarios WHERE nickname = '$jugador_escapado'";
              $result = $conexion->query($sql);

              // Verificar si se encontró el jugador y mostrar su nombre y vida con una barra de progreso
              if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $nombre_jugador = $row["nickname"];
                  $vida_jugador = $row["vida"];

                  // Calcular el porcentaje de vida del jugador
                  $vida_porcentaje = ($vida_jugador / $vida_maxima) * 100;

                  // Mostrar el nombre del jugador y su vida con una tarjeta y barra de progreso
                  echo "<div class='col-md-4'>
                          <div class='card'>
                            <div class='card-body'>
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

                  // Verificar si la vida del jugador es menor o igual a 0 y eliminarlo de la tabla sala
                  if ($vida_jugador <= 0) {
                      // Eliminar al jugador de la tabla sala
                      $sql_eliminar_jugador = "DELETE FROM sala WHERE nickname = '$nombre_jugador'";
                      $conexion->query($sql_eliminar_jugador);

                      // Mostrar mensaje de eliminación
                      echo "<script>alert('¡$nombre_jugador ha sido eliminado!');</script>";
                  }
              } else {
                  echo "<div class='col-md-4'>
                          <div class='card'>
                            <div class='card-body'>
                              <h5 class='card-title'>$jugador</h5>
                              <p class='card-text'>¡Jugador no encontrado!</p>
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
