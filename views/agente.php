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
if (isset($_GET['id_avatar'])) {
    $id_avatar = $_GET['id_avatar'];

    include("../db/conexion.php");
    $consulta = $conexion->prepare("SELECT * FROM avatar WHERE id = ?");
    $consulta->bind_param("i", $id_avatar);
    $consulta->execute();
    $resultado = $consulta->get_result();
    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        // Obtener los datos del avatar
        $avatar = $resultado->fetch_assoc();
        // Ahora puedes utilizar los datos del avatar como lo desees
        // Puedes mostrar más detalles o realizar otras operaciones con los datos recuperados
    } else {
        echo "No se encontró ningún avatar con el ID proporcionado.";
    }
    // Cerrar la conexión y liberar los recursos
    $conexion->close();
} else {
    // Si no se recibió un ID de avatar, muestra un mensaje de error o redirecciona a otra página
    echo "No se proporcionó un ID de avatar válido.";
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <main>
        <?php foreach ($resultado as $avatar) { ?>
            <?php if (!empty($avatar['ruta_animacion'])) { ?>
                <video autoplay loop class="card-img-top" onplay="startTimer(this)">
                    <source src="<?php echo substr($avatar['ruta_animacion'], 3); ?>" type="video/mp4">
                    <!-- Añade más elementos <source> si la animación tiene diferentes formatos -->
                    Your browser does not support the video tag.
                </video>
            <?php } else { ?>
                <script>
                    // Si la ruta de la animación está vacía, redirecciona a procesar_seleccion.php
                    window.location.href = 'game/procesar_seleccion.php?id_avatar=<?php echo $id_avatar; ?>&nickname=<?php echo $_SESSION['nickname']; ?>';
                </script>
            <?php } ?>
        <?php } ?>
    </main>

    <script>
        function startTimer(videoElement) {
            setTimeout(function() {
                // Obtener el ID del avatar seleccionado
                var id_avatar = <?php echo $id_avatar; ?>;
                // Obtener el nombre de usuario que inició sesión
                var nickname = '<?php echo $_SESSION['nickname']; ?>';
                // Redireccionar a la página de procesamiento con el ID del avatar y el nombre de usuario
                window.location.href = 'game/procesar_seleccion.php?id_avatar=' + id_avatar + '&nickname=' + nickname;
            }, 8500); // 30 segundos
        }
    </script>

    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>