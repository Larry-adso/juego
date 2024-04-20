<?php
    include '../../../db/conexion.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conexion->query("DELETE FROM avatar WHERE id=$id");

        $_SESSION['message'] = "Avatar eliminado exitosamente";
        $_SESSION['msg_type'] = "danger";

        header("location: index.php");
    }
?>
