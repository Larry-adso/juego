<?php
include("../../db/PDO.php");

session_start();

if (isset($_GET["nickname"])) {
    $nickname = $_GET["nickname"];

    // Prepara la consulta para obtener el correo electrónico asociado al nickname
    $consulta = $conexion->prepare("SELECT correo FROM usuarios WHERE nickname = :nickname");
    $consulta->bindParam(':nickname', $nickname);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $correo = $resultado['correo'];

        $statement = $conexion->prepare("UPDATE usuarios SET id_estado = 1 WHERE correo = :correo");
        $statement->bindParam(':correo', $correo);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $titulo = "Activacion de cuenta";
            $msj = "Su cuenta ha sido activada, ya puedes iniciar sesión";
            $tucorreo = "From: senatrabajos2022@gmail.com";

            if (mail($correo, $titulo, $msj, $tucorreo)) {
                echo '<script>alert("Se informó al usuario ' . $correo . ' que su cuenta está activada.");
                window.location = "../index.php";
                </script>';
            } else {
                echo "Error al enviar el correo.";
            }
        } else {
            echo "No se pudo actualizar el estado del usuario.";
        }
    } else {
        echo "No se encontró ningún usuario con ese nickname.";
    }
} else {
    echo "No se proporcionó ningún nickname.";
}
?>
