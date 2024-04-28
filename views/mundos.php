<?php
include("../db/conexion.php");
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

// Obtener el nivel del jugador desde la base de datos
$nickname = $_SESSION['nickname'];
$consulta_nivel = $conexion->prepare("SELECT nivel FROM usuarios WHERE nickname = ?");
$consulta_nivel->bind_param("s", $nickname);
$consulta_nivel->execute();
$resultado_nivel = $consulta_nivel->get_result();
$nivel_jugador = $resultado_nivel->fetch_assoc()['nivel'];

// Consulta modificada para seleccionar solo los mapas del mismo nivel que el del jugador
// Consulta modificada para seleccionar solo los mapas del mismo nivel que el del jugador
if ($nivel_jugador == 1) {
  $consulta = $conexion->prepare("SELECT * FROM mapas WHERE nivel_m = 1");
} else {
  $consulta = $conexion->prepare("SELECT * FROM mapas WHERE nivel_m >= 2");
}
$consulta->execute();
$info = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="../css/mundos.css">
  <title>Mundos</title>

  <style>
    .card-img-top {
      width: 100%;
      height: 15rem;
      object-fit: cover;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
    }
  </style>
</head>

<body>
  <header>
    <a class="btn" href="../"> Atras</a>
  </header>

  <p class="#"><?php echo $_SESSION['nickname']; ?></p>

  <main class="container">
    <?php foreach ($info as $mapa): ?>
    <div class="col-md-4 mb-4">
      <div class="card">
        <img src="<?php echo substr($mapa['ruta'], 6); ?>" class="card-img-top" alt="">
        <div class="card-body text-center mi-card">
          <h5 class="card-title">Nivel de mundo: <?php echo $mapa['nivel_m']; ?></h5>
          <form action="game/procesar_mapa.php" method=" get">
            <input type="hidden" name="id_mapa" value="<?php echo $mapa['id']; ?>">
            <input type="submit" class="btn btn-success mt-2" value="Elegir mundo">
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </main>

  <script>
    // Recargar la página cada 3 segundos
    setInterval(function() {
      location.reload();
    }, 3000);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
