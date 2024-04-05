<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../../db/conexion.php";
    // Verifica si hay errores de conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtiene los datos del formulario
    $usuario_ingresado = $_POST['nickname'];
    $contraseña_ingresada = $_POST['password'];

    // Consulta SQL para buscar el usuario en la base de datos
    $consulta = "SELECT * FROM usuarios WHERE nickname = '$usuario_ingresado' AND password = '$contraseña_ingresada'";
    $resultado = $conexion->query($consulta);

    // Verifica si se encontró el usuario en la base de datos
    if ($resultado->num_rows == 1) {
        // Inicia la sesión
        session_start();

        // Guarda el nombre de usuario en la sesión
        $_SESSION['usuario'] = $usuario_ingresado;

        // Redirecciona a una página de inicio de sesión exitoso
        header("Location: ../../views/index.php");
        exit();
    } else {
        // Mensaje de error si las credenciales son incorrectas
        $mensaje_error = "Usuario o contraseña incorrectos.";
    }

    // Cierra la conexión con la base de datos
    $conexion->close();
}
