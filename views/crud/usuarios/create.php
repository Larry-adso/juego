<?php
    include '../../../db/conexion.php';

$consulta = $conexion->prepare("SELECT * FROM estado ");
$consulta->execute();
$info = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nombres = $_POST['nombres'];
        $correo = $_POST['correo'];
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];
        $password = hash('sha512', $password);
        $nivel = $_POST['nivel'];
        $vida = $_POST['vida'];
        $puntaje = $_POST['puntaje'];
        $id_estado = $_POST['id_estado'];


        $conexion->query("INSERT INTO usuarios (id, nombres, correo, nickname, password, nivel, vida, puntaje, id_estado) VALUES ('$id', $nombres', '$da_body, '$da_head','$balas', '$recamara', '$id_tip_arma', '$ruta')");

        $_SESSION['message'] = "Usuario agregado exitosamente";
        $_SESSION['msg_type'] = "success";

        header("location: index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Agregar Nuevo Usuario</h2>
        <form action="" method="POST">
        <div class="form-group">
                <label for="id">Documento:</label>
                <input type="int" class="form-control" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="nombres">nombres:</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="text" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input type="text" class="form-control" id="nickname" name="nickname" required>
            </div>
            <div class="form-group">
                <label for="password">Contaseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="nivel">Nivel:</label>
                <input type="text" class="form-control" id="nivel" name="nivel" required>
            </div>
            <div class="form-group">
                <label for="vida">Vida:</label>
                <input type="text" class="form-control" id="vida" name="vida" required>
            </div>
            <div class="form-group">
                <label for="puntaje">Puntaje:</label>
                <input type="text" class="form-control" id="puntaje" name="puntaje" required>
            </div>
            <div class="form.group">
                <label for="id_estado" class="form-label">Estado</label>
                 <select class="form-select form-select-lg" name="id_estado" id="id_estado">
                    <?php foreach ($info as $id_estado) { ?>
                     <option value="<?php echo $id_estado['id']; ?>"> <?php echo $id_estado['id'] . ' : ' . $id_estado['estado']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

