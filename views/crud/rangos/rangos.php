<?php
include '../../../db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    // Manejo del archivo subido
    $nombre_archivo = $_FILES['ruta_rango']['name']; // Obtener solo el nombre del archivo
    $archivo_temporal = $_FILES['ruta_rango']['tmp_name'];
    $ruta_destino = '../../../img/rangos/' . $nombre_archivo;

    // Moviendo el archivo a la carpeta "img"
    if (move_uploaded_file($archivo_temporal, $ruta_destino)) {
        // Insertar el nombre del archivo en la base de datos
        $conexion->query("INSERT INTO rangos (id, nombre, ruta_rango) VALUES ('$id', '$nombre', '$nombre_archivo')");

        // Establecer un mensaje de éxito
        $_SESSION['message'] = "rango agregada exitosamente";
        $_SESSION['msg_type'] = "success";

        header("location: rangos.php");
    } else {
        // Si la carga del archivo falla, mostrar un mensaje de error
        $_SESSION['message'] = "Error al subir el archivo";
        $_SESSION['msg_type'] = "error";
        header("location: rangon.php"); // Cambiar esto a donde quieras redirigir en caso de error
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Arma</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Agregar Rango</h2>
        <form action="" method="POST" enctype="multipart/form-data"> <!-- Agregando enctype="multipart/form-data" para subir archivos -->
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="ruta_rango">ruta_rango:</label>
                <input type="file" class="form-control" id="ruta_rango" name="ruta_rango" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
