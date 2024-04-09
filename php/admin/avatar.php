
<?php
// Variables de conexión a la base de datos
include("../../db/conexion.php");
// Verificar si se ha enviado un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha cargado un archivo
    if (isset($_FILES['ruta']) && $_FILES['ruta']['error'] === UPLOAD_ERR_OK) {
        // Directorio donde se almacenarán las imágenes
        $directorio = '../../img/avatar/';

        // Nombre del archivo
        $nombreArchivo = basename($_FILES['ruta']['name']);

        // Ruta completa del archivo en el servidor
        $rutaArchivo = $directorio . $nombreArchivo;

        // Mover el archivo del directorio temporal al directorio de destino
        if (move_uploaded_file($_FILES['ruta']['tmp_name'], $rutaArchivo)) {
            // Obtener la descripción, el nombre y el precio del formulario
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $Descripcion = isset($_POST['Descripcion']) ? $_POST['Descripcion'] : '';


            // Utilizar consultas preparadas para evitar inyecciones SQL
            $sql = "INSERT INTO avatar ( ruta, nombre,Descripcion) VALUES ( ?, ?,?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sss", $rutaArchivo, $nombre, $Descripcion);

            if ($stmt->execute()) {

                echo "<script>alert('La imagen se ha subido correctamente y se ha guardado en la base de datos.');</script>";
                header("Location: ../../views/index.php");
            } else {
                echo "Error al guardar el producto en la base de datos: " . $stmt->error;
            }

            // Cerrar la consulta preparada
            $stmt->close();
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "No se ha seleccionado ningún archivo o ha ocurrido un error al subirlo.";
    }
}
?>