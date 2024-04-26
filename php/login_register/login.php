<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../../db/conexion.php";
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $password = hash('sha512', $password);

    $consulta = "SELECT * FROM usuarios WHERE nickname = '$nickname' AND password = '$password'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        if ($usuario['tp_user'] == 1) {
            session_start();
            $_SESSION['nickname'] = $nickname;
            header("Location: ../../views/index.php");
            exit();
        } elseif ($usuario['tp_user'] == 2) {
            session_start();
            $_SESSION['nickname'] = $nickname;
            header("Location: ../../views/lobby.php");
            exit();
        }
    } else {
        $mensaje_error = "Usuario o contraseña incorrectos.";
        header("Location: ../../index.php");
    }
    $conexion->close();
}
?>
