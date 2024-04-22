<?php

include '../../../db/conexion.php';

$consulta = $conexion->prepare("SELECT * FROM tp_armas ");
$consulta->execute();
$info = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Arma</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Agregar Nueva Arma</h2>
        <form action="../../../php/admin/armas.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="da_body">Daño cuerpo:</label>
                <input type="text" class="form-control" id="da_body" name="da_body" required>
            </div>
            <div class="form-group">
                <label for="da_head">Daño cabeza:</label>
                <input type="text" class="form-control" id="da_head" name="da_head" required>
            </div>
            <div class="form-group">
                <label for="balas">Balas:</label>
                <input type="text" class="form-control" id="balas" name="balas" required>
            </div>
            <div class="form-group">
                <label for="recamara">Recamara:</label>
                <input type="text" class="form-control" id="recamara" name="recamara" required>
            </div>
            <div class="form-group">
                <label for="id_tip_arma" class="form-label">Tipo de arma</label>
                <select class="form-select form-select-lg" name="id_tip_arma" id="id_tip_arma">
                    <?php foreach ($info as $arma) { ?>
                        <option value="<?php echo $arma['id']; ?>"> <?php echo $arma['id'] . ' : ' . $arma['tipo_arma']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nivel">Nivel:</label>
                <input type="text" class="form-control" id="nivel" name="nivel" required>
            </div>
            <div class="form-group">
                <label for="ruta">Ruta:</label>
                <input type="file" class="form-control" id="ruta" name="ruta" required>
            </div>

            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
