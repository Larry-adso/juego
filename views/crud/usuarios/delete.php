<?php
    include '../../../db/conexion.php';

    if (isset($_GET['nickname'])) {
        $nickname = $_GET['nickname'];
        $conexion->query("DELETE FROM usuarios WHERE nickname=$nickname");

        $_SESSION['message'] = "usuario eliminado exitosamente";
        $_SESSION['msg_type'] = "danger";

        header("location: index.php");
    }
?>
