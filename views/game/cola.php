<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Campos de la Tabla Sala</title>
</head>
<body>

<?php
// Incluir el archivo de conexión a la base de datos
include("../../db/conexion.php");

// Consulta SQL para obtener los campos de la tabla sala
$consulta = "SELECT id, id_avatar, nickname, id_mapa, id_arma, puntos FROM sala";

// Ejecutar la consulta
$resultado = $conexion->query($consulta);

// Verificar si se encontraron filas
if ($resultado->num_rows > 0) {
    // Mostrar los campos en una tabla
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nickname</th>
                <th>ID Mapa</th>
                <th>ID Avatar</th>
                <th>ID Arma</th>
                <th>Puntos</th>
            </tr>";
    // Recorrer cada fila de resultados
    while($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>".$fila['id']."</td>
                <td>".$fila['nickname']."</td>
                <td>".$fila['id_mapa']."</td>
                <td>".$fila['id_avatar']."</td>
                <td>".$fila['id_arma']."</td>
                <td>".$fila['puntos']."</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros en la tabla sala.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

</body>
</html>
