<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../../db/conexion.php";
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $password = hash('sha512', $password);

    $consulta = "SELECT id, tp_user, id_estado FROM usuarios WHERE nickname = '$nickname' AND password = '$password'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        session_start();
        $_SESSION['id'] = $usuario['id']; // Guardar el ID del usuario en la sesión
        $_SESSION['nickname'] = $nickname;
        if ($usuario['id_estado'] == 2) {
            $mensaje_error = "Su cuenta está bloqueada. Espere a que un administrador le habilite el acceso.";
            // Redirigir con mensaje de alerta
            echo '<script>
                    alert("' . $mensaje_error . '");
                    window.location = "../../index.php";
                  </script>';
            exit();
        } elseif ($usuario['tp_user'] == 1) {
            header("Location: ../../views/index.php");
            exit();
        } elseif ($usuario['tp_user'] == 2) {
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
