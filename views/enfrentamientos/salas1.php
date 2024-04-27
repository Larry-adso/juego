<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nickname'])) {
    echo '<script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "../index.php";
          </script>';
    session_destroy();
    exit(); // Terminar la ejecución del script después de redireccionar
}

include("../../db/conexion.php");

// Obtener el nickname del usuario autenticado
$usuario_autenticado = $_SESSION['nickname'];

// Obtener los datos del usuario autenticado
$sql_usuario_autenticado = "SELECT u.nickname, u.vida, a.ruta as avatar, s.id_arma 
                            FROM usuarios u
                            INNER JOIN sala s ON u.nickname = s.nickname
                            INNER JOIN avatar a ON s.id_avatar = a.id
                            WHERE u.nickname = ?";
$consulta_usuario_autenticado = $conexion->prepare($sql_usuario_autenticado);
$consulta_usuario_autenticado->bind_param("s", $usuario_autenticado);
$consulta_usuario_autenticado->execute();
$result_usuario_autenticado = $consulta_usuario_autenticado->get_result();

// Inicializar vida_maxima con un valor predeterminado
$vida_maxima = 150; // Valor predeterminado

// Verificar si se encontró el usuario autenticado
if ($result_usuario_autenticado->num_rows > 0) {
    $row_usuario_autenticado = $result_usuario_autenticado->fetch_assoc();
    $nombre_usuario_autenticado = $row_usuario_autenticado["nickname"];
    $vida_usuario_autenticado = $row_usuario_autenticado["vida"];
    $avatar_usuario_autenticado = $row_usuario_autenticado["avatar"];
    $id_arma_seleccionada = $row_usuario_autenticado["id_arma"];

    // Calcular el porcentaje de vida del usuario autenticado
    $vida_porcentaje_usuario_autenticado = ($vida_usuario_autenticado / $vida_maxima) * 150;
} else {
    echo '<script>
            alert("Lo siento ha sido eliminado ");
            window.location = "../lobby.php";
          </script>';
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Enfrentamiento</title>
    <!-- Enlaces a Bootstrap y estilos CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/enfrentamiento.css">

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
                <h1 class="inv-arm">Inventario Armas</h1>

            </div>
            <?php
            $consulta_armas = $conexion->prepare("SELECT armas.*, usuarios.nivel as usuario_nivel
                                            FROM armas 
                                            JOIN usuarios ON armas.nivel <= usuarios.nivel
                                            WHERE usuarios.nickname = ?");
            $consulta_armas->bind_param("s", $usuario_autenticado);
            $consulta_armas->execute();
            $info_armas = $consulta_armas->get_result()->fetch_all(MYSQLI_ASSOC);
            ?>
            <div class="row row-cols-1 row-cols-md-4 g-4 mi-row">
                <?php foreach ($info_armas as $arma) { ?>
                    <?php if ($arma['id'] != $id_arma_seleccionada) { ?>
                        <div class="col-md-3">
                            <div class="card-arm">
                                <div class="row no-gutters">
                                    <h3 class="titulo_mapas">Nivel de arma : <?php echo $arma['nivel']; ?></h3>
                                    <div class="col-md-6 arm-img">
                                        <?php echo "<img style='height: 80px; 'src='../../img/armas/" . $arma["ruta"] . "' alt='Imagen del arma'>"; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h5 class="card-title mi-title">Arma : <?php echo  $arma['nombre']; ?></h5>
                                            <h5 class="card-title mi-title">Cuerpo : <?php echo  $arma['da_body']; ?></h5>
                                            <h5 class="card-title mi-title">Cabeza : <?php echo  $arma['da_head']; ?> </h5>
                                            <h5 class="card-title mi-title">Balas : <?php echo  $arma['balas']; ?> </h5>
                                            <h5 class="card-title mi-title">Balas Recamara : <?php echo  $arma['recamara']; ?> </h5>
                                            <br>
                                            <form action="../game/armaf.php" method="get">
                                                <input type="hidden" name="id_arma" value="<?php echo $arma['id']; ?>">
                                                <?php
                                                // Agregar un campo oculto para cada nickname
                                                if (isset($_GET['jugadores']) && $_GET['jugadores'] !== '') {
                                                    // Obtener los jugadores del URL
                                                    $jugadores = explode(',', $_GET['jugadores']);
                                                    foreach ($jugadores as $jugador) {
                                                        echo '<input type="hidden" name="jugadores[]" value="' . $jugador . '">';
                                                    }
                                                }
                                                ?>
                                                <button type="submit" class="shadow__btn">Seleccionar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
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

            $new_resumen_e = 'ganador';

            $estados = "UPDATE sala SET resumen = ? WHERE nickname = ?";
            $stmt_estados = $conexion->prepare($estados);
            $stmt_estados->bind_param("ss", $new_resumen_e, $usuario_autenticado);
            $stmt_estados->execute();

            $sql_eliminar_jugador = "DELETE FROM sala";
            $conexion->query($sql_eliminar_jugador);

            echo '<div class="alert alert-success" role="alert">
                ¡Felicidades! ¡Eres el ganador!
              </div>';
            echo '<script>
                setTimeout(function(){
                  window.location.href = "../lobby.php";
                }, 3000);
              </script>';
            exit;
        }
    }
    ?>


    <main class="container">
        <h1 class="enfrent">Enfrentamiento</h1>
        <p class="jugadores">Los jugadores en enfrentamiento son:</p>
        <div class="row justify-content-center">
        
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
                  WHERE u.nickname = ? AND u.vida > 0";
                $consulta_jugador = $conexion->prepare($sql);
                $consulta_jugador->bind_param("s", $jugador_escapado);
                $consulta_jugador->execute();
                $result_jugador = $consulta_jugador->get_result();

                // Verificar si se encontró el jugador y mostrar su información
                if ($result_jugador->num_rows > 0) {
                    $row = $result_jugador->fetch_assoc();
                    $nombre_jugador = $row["nickname"];
                    $vida_jugador = $row["vida"];
                    $avatar_jugador = $row["avatar"];

                    // Calcular el porcentaje de vida del jugador
                    $vida_porcentaje = ($vida_jugador / $vida_maxima) * 100;

                    // Mostrar el avatar, nombre del jugador y su vida con una tarjeta y barra de progreso
                    if ($nombre_jugador != $usuario_autenticado) {
                        // Solo mostrar el botón de ataque si el jugador objetivo no es el mismo que el usuario autenticado
                        echo "<div class='col-md-3'>
                            <div class='card mi-card'>
                              <div class='card-body mi-card-body'>
                                <img src='$avatar_jugador' class='avatar-img' alt='Avatar'>
                                <h5 class='card-title jugador-title'>$nombre_jugador</h5>
                                <div class='progress'>
                                  <div class='progress-bar' role='progressbar' style='width: $vida_porcentaje%;' aria-valuenow='$vida_porcentaje' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                                <p class='card-text card-vida'>Vida: $vida_jugador</p>
                                <form action='disparar.php' method='get'>
                                  <input type='hidden' name='jugador_objetivo' value='$nombre_jugador'>";
                        // Agregar un campo oculto para cada nickname
                        if (isset($_GET['jugadores']) && $_GET['jugadores'] !== '') {
                            // Obtener los jugadores del URL
                            $jugadores = explode(',', $_GET['jugadores']);
                            foreach ($jugadores as $jugador) {
                                echo "<input type='hidden' name='jugadores[]' value='$jugador'>";
                            }
                        }
                        echo "<button type='submit' name='disparar' class='btn btn-primary'>Disparar</button>
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
      </div>   <!-- Aquí puedes incluir más contenido si es necesario -->
    </main>
    <footer>
        <!-- Aquí va tu pie de página si es necesario -->
    </footer>
    <script>
    // Recargar la página cada 3 segundos
    setInterval(function() {
      location.reload();
    }, 3000);
  </script>
    <!-- Enlaces a JavaScript y otros scripts si es necesario -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script para recargar la página cada 3 segundos -->
</body>

</html>

<?php
// Cerrar la conexión con la base de datos
$conexion->close();
?>
