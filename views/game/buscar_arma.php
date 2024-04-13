<?php
// Conexión a la base de datos (suponiendo que tienes una tabla llamada 'armas' con columnas 'nombre' y 'ruta')
include("../../db/conexion.php");

// Consulta para seleccionar una fila aleatoria de la tabla 'armas'
$sql = "SELECT id, nombre, ruta FROM armas ORDER BY RAND() LIMIT 1";
$result = $conexion->query($sql);

// Mostrar el resultado
if ($result->num_rows > 0) {
    // Mostrar solo una fila aleatoria
    $row = $result->fetch_assoc();
    echo "<h2>Nombres: " . $row["nombre"] . "</h2>";
    echo "<img src='../../img/armas/" . $row["ruta"] . "' alt='Imagen del arma'>";
    echo "<a href='procesar_arma.php?id_arma=" . $row["id"] . "'>Elegir arma</a>";
} else {
    echo "No se encontraron armas.";
}
$conexion->close();
?>
