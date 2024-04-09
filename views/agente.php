<?php

if (isset($_POST['id_avatar'])) {
    // Obtener el ID del avatar seleccionado
    $id_avatar = $_POST['id_avatar'];

    // Aquí puedes realizar la consulta con el ID del avatar
    // Por ejemplo:
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
    $consulta->close();
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
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <?php foreach ($resultado as $avatar) { ?>
            <video autoplay loop class="card-img-top" onplay="startTimer(this)">
                <source src="<?php echo substr($avatar['ruta_animacion'], 3); ?>" type="video/mp4">
                <!-- Añade más elementos <source> si la animación tiene diferentes formatos -->
                Your browser does not support the video tag.
            </video>
        <?php } ?>
    </main>

    <script>
        function startTimer(videoElement) {
            setTimeout(function() {
                window.location.href = 'mundos.php';
            }, 17000); // 30 segundos
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