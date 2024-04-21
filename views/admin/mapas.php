<?php
    include '../../db/conexion.php';
    session_start();

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
    <title>Crear Mapas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">CRUD MAPAS</h2>
        <a href="../crud/mundos/create.php" class="btn btn-primary mb-4">Agregar Nuevo Mapa</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ruta</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $conexion->query("SELECT * FROM mapas");
                    while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><img src="<?php echo $row['ruta']; ?>" class="mapa-img" alt="<?php echo $row['nombre']; ?>" width="120px"></td>
                        <td><?php echo $row['nivel']; ?></td>
                        <td>
                            <a href="../crud/mundos/update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../crud/mundos/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
