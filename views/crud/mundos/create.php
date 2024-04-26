<?php
include("../../../db/conexion.php");

// Verificar si se ha enviado un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha cargado un archivo principal
    if (isset($_FILES['ruta']) && $_FILES['ruta']['error'] === UPLOAD_ERR_OK) {
        // Directorio donde se almacenarán las imágenes
        $directorio = '../../../img/mapas/';

        // Nombre del archivo principal
        $nombreArchivo = basename($_FILES['ruta']['name']);

        // Ruta completa del archivo principal en el servidor
        $rutaArchivo = $directorio . $nombreArchivo;

        // Mover el archivo principal del directorio temporal al directorio de destino
        if (move_uploaded_file($_FILES['ruta']['tmp_name'], $rutaArchivo)) {
            // Obtener el nombre del formulario
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            // Obtener el nivel_m del formulario (si lo necesitas)
            $nivel_m = isset($_POST['nivel_m']) ? $_POST['nivel_m'] : '';

            // Utilizar consultas preparadas para evitar inyecciones SQL
            $sql = "INSERT INTO mapas (ruta, nombre, nivel_m) VALUES (?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sss", $rutaArchivo, $nombre, $nivel_m);

            if ($stmt->execute()) {
                echo "<script>alert('La imagen se ha subido correctamente y se ha guardado en la base de datos.');</script>";
                header("Location: ../../views/index.php");
                exit(); // Terminar el script después de redirigir
            } else {
                echo "Error al guardar el producto en la base de datos: " . $stmt->error;
            }
        }
    }
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
        <form action="" method="POST" enctype="multipart/form-data"> <!-- Agregar enctype para subir archivos -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="ruta">Ruta:</label>
                <input type="file" class="form-control" id="ruta" name="ruta" required>
            </div>
            <div class="form-group">
                <label for="nivel_m">nivel_m:</label>
                <input type="text" class="form-control" id="nivel_m" name="nivel_m" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
