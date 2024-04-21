<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Campos de la Tabla Sala</title>
    <!-- Agregar los enlaces a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php
    include("../../db/conexion.php");
    session_start();

    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['nickname'])) {
        echo '<script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "../index.php";
          </script>';
        session_destroy();
        die();
    }
    // Incluir el archivo de conexión a la base de datos
    include("../../db/conexion.php");

    // Consulta SQL para obtener los campos de la tabla sala con los nombres del mapa, el arma y el avatar
    $consulta = "SELECT s.id, s.nickname, m.nombre AS nombre_mapa, a.nombre AS nombre_avatar, ar.nombre AS nombre_arma
                 FROM sala s
                 INNER JOIN mapas m ON s.id_mapa = m.id
                 INNER JOIN avatar a ON s.id_avatar = a.id
                 INNER JOIN armas ar ON s.id_arma = ar.id";

    // Ejecutar la consulta
    $resultado = $conexion->query($consulta);

    // Verificar si se encontraron filas
    if ($resultado->num_rows > 0) {
        // Mostrar los campos en una tabla con estilos de Bootstrap
        echo "<div class='container'>
                <table class='table table-striped table-bordered'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Nickname</th>
                            <th>Mapa</th>
                            <th>Avatar</th>
                            <th>Arma</th>
                        </tr>
                    </thead>
                    <tbody>";
        // Recorrer cada fila de resultados
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>" . $fila['id'] . "</td>
                    <td>" . $fila['nickname'] . "</td>
                    <td>" . $fila['nombre_mapa'] . "</td>
                    <td>" . $fila['nombre_avatar'] . "</td>
                    <td>" . $fila['nombre_arma'] . "</td>
                </tr>";
        }
        echo "</tbody>
            </table>
        </div>";
    } else {
        echo "No se encontraron registros en la tabla sala.";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>

    <a href="../enfrentamientos/inir.php">iniciar</a>
    <script>
    setTimeout(function() {
      location.reload();
    }, 3000);
  </script>
    <!-- Agregar el script de Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
