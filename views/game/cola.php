<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Campos de la Tabla Sala</title>
    <!-- Agregar los enlaces a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/cola.css">
    <style>
        #contador {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3em;
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h1>Jugadores en cola</h1>
    </header>

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

    $consulta = "SELECT s.id, s.nickname, m.nombre AS nombre_mapa, a.nombre AS nombre_avatar
                 FROM sala s
                 INNER JOIN mapas m ON s.id_mapa = m.id
                 INNER JOIN avatar a ON s.id_avatar = a.id";

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

    <a href="../enfrentamientos/inir.php" id="iniciarBatallaBtn" class="btn btn-primary mi-btn" onclick="startCountdown()">Iniciar Batalla</a>
    <div id="contador"></div>
    <!-- Agregar el script de Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function startCountdown() {
            var count = 10;
            var counter = setInterval(function() {
                document.getElementById('contador').innerText = count;
                count--;
                if (count < 0) {
                    clearInterval(counter);
                    document.getElementById('contador').innerText = 'Batalla iniciada';
                    // Aquí puedes agregar la función que deseas ejecutar al llegar a 0, por ejemplo:
                    // functionToExecute();
                }
            }, 1000);
        }
    </script>
</body>

</html>
