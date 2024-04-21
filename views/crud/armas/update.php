<?php
    include '../../../db/conexion.php';

$consulta = $conexion->prepare("SELECT * FROM tp_armas ");
$consulta->execute();
$info = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $da_body = $_POST['da_body'];
        $da_head = $_POST['da_head'];
        $balas = $_POST['balas'];
        $recamara = $_POST['recamara'];
        $arma = $_POST['id_tip_arma'];
        $ruta = $_POST['ruta'];

        $mysqli->query("UPDATE armas SET nombre='$nombre', da_body='$da_body', nombre='$da_head', balas='$balas', recamara='$recamara', id_tip_arma='$arma', ruta='$ruta' WHERE id=$id");

        $_SESSION['message'] = "Arma actualizado exitosamente";
        $_SESSION['msg_type'] = "success";

        header("location: index.php");
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $conexion->query("SELECT * FROM armas WHERE id=$id");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nombre = $row['nombre'];
            $da_body = $row['da_body'];
            $da_head = $row['da_head'];
            $balas = $row['balas'];
            $recamara = $row['recamara'];
            $arma = $row['id_tip_arma'];
            $ruta = $row['ruta'];
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Armas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Actualizar Arma</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group">
                <label for="da_body">Daño cuerpo:</label>
                <input type="text" class="form-control" id="da_body" name="da_body" value="<?php echo $da_body; ?>" required>
            </div>
            <div class="form-group">
                <label for="da_head">Daño cabeza:</label>
                <input type="text" class="form-control" id="da_head" name="da_head" value="<?php echo $da_head; ?>" required>
            </div>
            <div class="form-group">
                <label for="balas">Balas:</label>
                <input type="text" class="form-control" id="balas" name="balas" value="<?php echo $balas; ?>" required>
            </div>
            <div class="form-group">
                <label for="recamara">Recamara:</label>
                <input type="text" class="form-control" id="recamara" name="recamara" value="<?php echo $recamara; ?>" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
           
            <div class="form-group">
                <label for="ruta">Ruta:</label>
                <input type="file" class="form-control" id="ruta" name="ruta" value="<?php echo $ruta; ?>" required>
            </div>
            <div class="form.group">
                <label for="id_tip_arma" class="form-label">Tipo de arma</label>
                 <select class="form-select form-select-lg" name="id_tip_arma" id="id_tip_arma" value="<?php echo $arma; ?>" required>>
                    <?php foreach ($info as $arma) { ?>
                     <option value="<?php echo $arma['id']; ?>"> <?php echo $arma['id'] . ' : ' . $arma['tipo_arma']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
