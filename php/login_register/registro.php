
<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $id = $_POST['id'];

    $nombres = $_POST['nombres'];
    $correo = $_POST['correo'];
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $password = hash('sha512', $password);
    // Incluye el archivo de conexión a la base de datos
    include("../../db/conexion.php");

    // Verifica si hay errores de conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Escapa los valores para evitar inyección SQL
    $id = $conexion->real_escape_string($id);

    $nombres = $conexion->real_escape_string($nombres);
    $correo = $conexion->real_escape_string($correo);
    $nickname = $conexion->real_escape_string($nickname);
    $password = $conexion->real_escape_string($password);

    // Prepara la consulta SQL para insertar los datos
    $consulta = "INSERT INTO `usuarios` (`id`,`nombres`, `correo`, `nickname`, `password`, `vida`,  `nivel`, `puntaje`, `id_estado`,tp_user) 
                 VALUES ('$id','$nombres', '$correo', '$nickname', '$password', '150', '0', '0', '1','2')";

    // Ejecuta la consulta
    if ($conexion->query($consulta) === TRUE) {
        header("Location: ../../index.php");
    } else {
        echo "Error: " . $consulta . "<br>" . $conexion->error;
    }

    // Cierra la conexión
    $conexion->close();
}
