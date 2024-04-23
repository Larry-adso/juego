<?php
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

// Obtener el nivel del usuario
$consulta = $conexion->prepare("SELECT armas.*, usuarios.nivel as usuario_nivel
FROM armas 
JOIN usuarios ON armas.nivel <= usuarios.nivel
WHERE usuarios.nickname = ?");
$consulta->bind_param("s", $_SESSION['nickname']);
$consulta->execute();
$info = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de arma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../css/armas.css">
</head>

<body>
    <header>
        <div class="top-container">
            <h1>Seleccione su arma</h1>
        </div>
        <button class="btns">Atras</button>
    </header>

    <div class="row row-cols-1 row-cols-md-3 g-4 mi-row">
        <?php foreach ($info as $armas) { ?>
            <div class="col">
                <div class="card">
                    <div class="row no-gutters">
                    <h3 class="titulo_mapas" >Nivel de arma : <?php echo $armas['nivel']; ?></h3>

                        <div class="col-md-6">
                            <?php
                            echo "<img class='imgs' src='../../img/armas/" . $armas["ruta"] . "' alt='Imagen del arma'>";
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title mi-title">Arma : <?php echo  $armas['nombre']; ?></h5>
                                <h5 class="card-title mi-title">Cuerpo : <?php echo  $armas['da_body']; ?></h5>
                                <h5 class="card-title mi-title">Cabeza : <?php echo  $armas['da_head']; ?> </h5>
                                <h5 class="card-title mi-title">Balas : <?php echo  $armas['balas']; ?> </h5>
                                <h5 class="card-title mi-title">Balas Recamara : <?php echo  $armas['recamara']; ?> </h5>
                                <br>
                                <form action="procesar_arma.php" method="get">
                                    <input type="hidden" name="id_arma" value="<?php echo $armas['id']; ?>">
                                    <input type="hidden" name="nickname" value="<?php echo $_SESSION['nickname']; ?>">
                                    <button type="submit" class="shadow__btn">Seleccionar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
