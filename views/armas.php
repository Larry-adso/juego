<?php
include("../db/conexion.php");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta SQL para obtener todas las armas
$sql = "SELECT * FROM armas";
$resultado = $conexion->query($sql);

// Convertir resultado a JSON y enviarlo al frontend
$armas = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $armas[] = $fila;
    }
    echo json_encode($armas);
} else {
    echo "0 resultados";
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Armas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/armas.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Inventario de Armas</h1>
        <div id="armas" class="row"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="script.js"></script>
</body>
</html>


