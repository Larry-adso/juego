<?php
// Variables de conexión a la base de datos


// Si se ha enviado el formulario
if (isset($_POST['submit'])) {
    $nombre_imagen = $_FILES['imagen']['name'];
    $tipo_imagen = $_FILES['imagen']['type'];
    $tamano_imagen = $_FILES['imagen']['size'];
    $temp = $_FILES['imagen']['tmp_name'];

    // Ruta donde se guardará la imagen
    $ruta = "../../img/" . $nombre_imagen;

    // Guardar la imagen en la carpeta "avatar"
    move_uploaded_file($temp, $ruta);

    // Insertar la información de la imagen en la base de datos
    $sql = "INSERT INTO avatar (img) VALUES ('$ruta')";

    if ($conn->query($sql) === TRUE) {
        echo "La imagen se ha subido correctamente y se ha guardado en la base de datos.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

// Cerrar conexión
$conn->close();
?>