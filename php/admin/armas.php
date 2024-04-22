<?php
include("../../db/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopilar datos del formulario
    $nombre = $_POST["nombre"];
    $da_body = $_POST["da_body"];
    $da_head = $_POST["da_head"];
    $balas = $_POST["balas"];
    $recamara = $_POST["recamara"];
    $id_tip_arma = $_POST["id_tip_arma"];
    $nivel = $_POST["nivel"];
    
    // Recopilar datos de la imagen
    if (isset($_FILES["ruta"]) && $_FILES["ruta"]["error"] === UPLOAD_ERR_OK) {
        // Procesar la imagen
        $ruta = $_FILES["ruta"]["name"];
        $ruta_temporal = $_FILES["ruta"]["tmp_name"];
        $ruta_destino = "../../img/armas/" . $ruta;
        move_uploaded_file($ruta_temporal, $ruta_destino);
    } else {
        // Manejar el caso donde no se cargó un archivo
        $ruta = ""; // O proporcionar un valor predeterminado según sea necesario
    }

    // Preparar la consulta SQL
    $consulta = $conexion->prepare("INSERT INTO armas (nombre, da_body, da_head, balas, recamara, id_tip_arma, ruta, nivel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Vincular parámetros
    $consulta->bind_param("sssiisss", $nombre, $da_body, $da_head, $balas, $recamara, $id_tip_arma, $ruta, $nivel);

    // Ejecutar la consulta
    $consulta->execute();

    // Verificar si la inserción fue exitosa
    if ($conexion->affected_rows > 0) {
        echo "<script>alert('se ha guardado en la base de datos.');
        window.location.href = '../../views/admin/armas.php';
        </script>";
    } else {
        echo "Error al insertar los datos.";
    }

    // Cerrar la consulta
    $consulta->close();
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>