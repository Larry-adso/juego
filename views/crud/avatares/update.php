<?php
    include '../../../db/conexion.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $img = $_POST['img'];

        $mysqli->query("UPDATE avatar SET nombre='$nombre', img='$img' WHERE id=$id");

        $_SESSION['message'] = "Avatar actualizado exitosamente";
        $_SESSION['msg_type'] = "success";

        header("location: index.php");
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $conexion->query("SELECT * FROM avatar WHERE id=$id");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nombre = $row['nombre'];
            $ruta = $row['ruta'];
            $Descripcion = $row['Descripcion'];
            $ruta_animacion = $row['ruta_animacion'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Avatar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Actualizar Avatar</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group">
                <label for="ruta">Ruta:</label>
                <input type="file" class="form-control" id="ruta" name="ruta" value="<?php echo $ruta; ?>" required>
            </div>
            <div class="form-group">
                <label for="Descripcion">Descripcion:</label>
                <input type="text" class="form-control" id="Descripcion" name="Descripcion" value="<?php echo $Descripcion; ?>" required>
            </div>
            <div class="form-group">
                <label for="ruta_animacion">Ruta Animacion:</label>
                <input type="file" class="form-control" id="ruta_animacion" name="ruta_animacion" value="<?php echo $ruta_animacion; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
