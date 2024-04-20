<?php
    include '../../db/conexion.php';

    // Mostrar mensajes de éxito o error
    if(isset($_SESSION['message'])) {
        echo '<div class="alert alert-'.$_SESSION['msg_type'].' alert-dismissible fade show" role="alert">
                '.$_SESSION['message'].'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        unset($_SESSION['message']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREAR AVATARES</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">CRUD AVATARES</h2>
        <a href="../crud/avatares/create.php" class="btn btn-primary mb-4">Agregar Nuevo Avatar</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $conexion->query("SELECT * FROM avatar");
                    while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><img src="<?php echo $row['img']; ?>" class="avatar-img" alt="<?php echo $row['nombre']; ?>"></td>
                        <td>
                            <a href="../crud/avatares/update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../crud/avatares/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
