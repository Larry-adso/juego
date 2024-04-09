<?php
// Variables de conexión a la base de datos
include("../../db/conexion.php");
// Verificar si se ha enviado un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha cargado un archivo de avatar
    if (isset($_FILES['ruta']) && $_FILES['ruta']['error'] === UPLOAD_ERR_OK) {
        // Verificar si se ha cargado un archivo de animación
        if (isset($_FILES['ruta_animacion']) && $_FILES['ruta_animacion']['error'] === UPLOAD_ERR_OK) {
            // Directorio donde se almacenarán las imágenes
            $directorio = '../../img/avatar/';

            // Nombre del archivo de avatar
            $nombreArchivoAvatar = basename($_FILES['ruta']['name']);
            $rutaArchivoAvatar = $directorio . $nombreArchivoAvatar;

            // Nombre del archivo de animación
            $nombreArchivoAnimacion = basename($_FILES['ruta_animacion']['name']);
            $rutaArchivoAnimacion = $directorio . $nombreArchivoAnimacion;

            // Mover los archivos del directorio temporal al directorio de destino
            if (move_uploaded_file($_FILES['ruta']['tmp_name'], $rutaArchivoAvatar) && 
                move_uploaded_file($_FILES['ruta_animacion']['tmp_name'], $rutaArchivoAnimacion)) {
                // Obtener la descripción y el nombre del formulario
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
                $Descripcion = isset($_POST['Descripcion']) ? $_POST['Descripcion'] : '';

                // Utilizar consultas preparadas para evitar inyecciones SQL
                $sql = "INSERT INTO avatar (ruta, nombre, Descripcion, ruta_animacion) VALUES (?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ssss", $rutaArchivoAvatar, $nombre, $Descripcion, $rutaArchivoAnimacion);

                if ($stmt->execute()) {
                    echo "<script>alert('La imagen se ha subido correctamente y se ha guardado en la base de datos.');</script>";
                    header("Location: ../../views/index.php");
                    exit(); // Terminar el script después de redirigir
                } else {
                    echo "Error al guardar el producto en la base de datos: " . $stmt->error;
                }

                // Cerrar la consulta preparada
                $stmt->close();
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "No se ha seleccionado ningún archivo de animación o ha ocurrido un error al subirlo.";
        }
    } else {
        echo "No se ha seleccionado ningún archivo de avatar o ha ocurrido un error al subirlo.";
    }
}
?>