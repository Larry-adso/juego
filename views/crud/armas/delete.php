<?php
    include '../../../db/conexion.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conexion->query("DELETE FROM armas WHERE id=$id");

        $_SESSION['message'] = "Arma eliminada exitosamente";
        $_SESSION['msg_type'] = "danger";

        header("location: ../../admin/armas.php");
    }
?>
