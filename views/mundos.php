<?php
include("../db/conexion.php");
session_start();
if (!isset($_SESSION['nickname'])) {
  echo '<script>
          alert("Por favor inicie sesión e intente nuevamente");
          window.location = "../index.php";
        </script>';
  session_destroy();
  die();
}

$consulta = $conexion->prepare("SELECT * FROM mapas ");
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
</head>

<body>
  <header>

 
    <a class="btn" href="../"> Atras</a>

  </header>


  <p class="#"><?php echo $_SESSION['nickname']; ?></p>

  <main>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php
        $count = 0;
        foreach ($info as $mapas) {
          $class = ($count == 0) ? 'active' : '';
        ?>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $count; ?>" class="<?php echo $class; ?>" aria-current="<?php echo $class; ?>" aria-label="Slide <?php echo $count; ?>"></button>
        <?php
          $count++;
        }
        ?>
      </div>
      <div class="carousel-inner">
        <?php
        $count = 0;
        foreach ($info as $mapas) {
          $class = ($count == 0) ? 'active' : '';
        ?>

        <h3 class="titulo_mapas" >Nivel de mundo : <?php echo $mapas['nivel_m']; ?></h3>

          <div class="carousel-item <?php echo $class; ?>">
            <img src="<?php echo substr($mapas['ruta'], 3); ?>" class="d-block w-100"  alt="">
            <div class="carousel-caption d-none d-md-block">
              <br>
             

              <form action="game/procesar_mapa.php" method="get">
                <input type="hidden" name="id_mapa" value="<?php echo $mapas['id']; ?>">
                <input type="submit" name="" class="btn btn-success" value="entrar al mundo">
              </form>
            </div>
          </div>
        <?php
          $count++;
        }
        ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  </main>




  <script>
    function activateRoom(button) {
      var buttons = document.querySelectorAll('.room-button');
      buttons.forEach(function(btn) {
        btn.classList.remove('active');
      });
      button.classList.add('active');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>