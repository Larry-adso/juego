<?php
    include '../../../db/conexion.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conexion->query("DELETE FROM usuarios WHERE id=$id");

        $_SESSION['message'] = "usuario eliminado exitosamente";
        $_SESSION['msg_type'] = "danger";

        header("location: index.php");
    }
?>
