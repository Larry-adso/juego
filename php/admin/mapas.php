<?php
// Variables de conexión a la base de datos
include("../../db/conexion.php");
// Verificar si se ha enviado un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha cargado un archivo principal
    if (isset($_FILES['ruta']) && $_FILES['ruta']['error'] === UPLOAD_ERR_OK) {
        // Directorio donde se almacenarán las imágenes
        $directorio = '../../img/mapas/';

        // Nombre del archivo principal
        $nombreArchivo = basename($_FILES['ruta']['name']);

        // Ruta completa del archivo principal en el servidor
        $rutaArchivo = $directorio . $nombreArchivo;

        // Mover el archivo principal del directorio temporal al directorio de destino
        if (move_uploaded_file($_FILES['ruta']['tmp_name'], $rutaArchivo)) {
            // Obtener la descripción, el nombre y el precio del formulario
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            
            // Verificar si se han cargado los archivos de las zonas 1, 2 y 3
            if(isset($_FILES['zona1']) && $_FILES['zona1']['error'] === UPLOAD_ERR_OK &&
               isset($_FILES['zona2']) && $_FILES['zona2']['error'] === UPLOAD_ERR_OK &&
               isset($_FILES['zona3']) && $_FILES['zona3']['error'] === UPLOAD_ERR_OK) {

                // Nombre de los archivos de las zonas 1, 2 y 3
                $zona1Archivo = basename($_FILES['zona1']['name']);
                $zona2Archivo = basename($_FILES['zona2']['name']);
                $zona3Archivo = basename($_FILES['zona3']['name']);

                // Rutas completas de los archivos de las zonas 1, 2 y 3 en el servidor
                $zona1Ruta = $directorio . $zona1Archivo;
                $zona2Ruta = $directorio . $zona2Archivo;
                $zona3Ruta = $directorio . $zona3Archivo;

                // Mover los archivos de las zonas 1, 2 y 3 al directorio de destino
                if(move_uploaded_file($_FILES['zona1']['tmp_name'], $zona1Ruta) &&
                   move_uploaded_file($_FILES['zona2']['tmp_name'], $zona2Ruta) &&
                   move_uploaded_file($_FILES['zona3']['tmp_name'], $zona3Ruta)) {
                    
                    // Utilizar consultas preparadas para evitar inyecciones SQL
                    $sql = "INSERT INTO mapas (ruta, nombre, zona1, zona2, zona3) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("sssss", $rutaArchivo, $nombre, $zona1Archivo, $zona2Archivo, $zona3Archivo);

                    if ($stmt->execute()) {
                        echo "<script>alert('La imagen se ha subido correctamente y se ha guardado en la base de datos.');</script>";
                        header("Location: ../../views/index.php");
                    } else {
                        echo "Error al guardar el producto en la base de datos: " . $stmt->error;
                    }

                    // Cerrar la consulta preparada
                    $stmt->close();
                } else {
                    echo "Error al subir los archivos de las zonas 1, 2 y 3.";
                }
            } else {
                echo "No se han seleccionado los archivos de las zonas 1, 2 y 3 o ha ocurrido un error al subirlos.";
            }
        } else {
            echo "Error al subir el archivo principal.";
        }
    } else {
        echo "No se ha seleccionado ningún archivo principal o ha ocurrido un error al subirlo.";
    }
}
?>
