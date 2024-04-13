<?php
include("../db/conexion.php");
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

$consulta = $conexion->prepare("SELECT * FROM avatar ");
$consulta->execute();
$info = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/avatar.css">
  <title>Selección de Avatar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <header>
    <div class="top-container">
      <h1>Seleccione su Avatar</h1>

    </div>

    <button class="btn">
      Atras
    </button>

  </header>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($info as $avatar) { ?>
      <div class="col">
        <div class="card">
          <div class="row no-gutters">
            <div class="col-md-6">
              <img src="<?php echo substr($avatar['ruta'], 3); ?>" class="card-img-top" style="height: 350px; width:280px;">
            </div>
            <div class="col-md-6">
              <div class="card-body">

                <h5 class="card-title"><?php echo $avatar['id'] . ' : ' . $avatar['nombre']; ?></h5>
                <h8 class="card-title"><?php echo $avatar['Descripcion']; ?></h8>
                <br>
                <br>
                <form action="agente.php" method="get">
                  <input type="hidden" name="id_avatar" value="<?php echo $avatar['id']; ?>">
                  <input type="hidden" name="nickname" value="<?php echo $_SESSION['nickname']; ?>">
                  <button type="submit" class="btn btn-primary">Seleccionar</button>
                </form>



              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <script>
    let selectedAvatar = null;

    function selectAvatar(avatar) {
      if (selectedAvatar) {
        selectedAvatar.classList.remove('selected');
      }
      avatar.classList.add('selected');
      selectedAvatar = avatar;
    }

    function confirmSelection() {
      if (selectedAvatar) {
        // Aquí puedes agregar la lógica para procesar la selección del avatar
        console.log("Avatar seleccionado:", selectedAvatar.querySelector('h2').textContent);
      } else {
        alert("Por favor seleccione un avatar.");
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>