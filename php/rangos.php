<?php
// Conexión a la base de datos
include("../db/PDO.php");
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

// Obtener el nickname del usuario autenticado
$nickname = $_SESSION['nickname'];

// Consulta para actualizar el nivel del usuario según su puntaje
$sql = "UPDATE usuarios SET nivel = 
            CASE
                WHEN puntaje < 500 THEN 1
                WHEN puntaje BETWEEN 500 AND 750 THEN 2
                WHEN puntaje BETWEEN 750 AND 1000 THEN 3
                WHEN puntaje BETWEEN 1000 AND 1250 THEN 4
                WHEN puntaje BETWEEN 1250 AND 1500 THEN 5
               

                -- Agrega más casos según tus necesidades
                ELSE nivel
            END
        WHERE nickname = '$nickname'";

if ($conexion->query($sql) === TRUE) {
}

?>
