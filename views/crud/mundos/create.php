<?php
    include '../../../db/conexion.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $ruta = $_POST['ruta'];
        $nivel = $_POST['nivel'];


        $conexion->query("INSERT INTO mundos (nombre, ruta, nivel) VALUES ('$nombre', '$ruta', '$nivel')");

        $_SESSION['message'] = "Avatar agregado exitosamente";
        $_SESSION['msg_type'] = "success";

        header("location: index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Mapa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Agregar Nuevo Mapa</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="ruta">Ruta:</label>
                <input type="file" class="form-control" id="ruta" name="ruta" required>
            </div>
            <div class="form-group">
                <label for="nivel">Nivel:</label>
                <input type="text" class="form-control" id="nivel" name="nivel" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

