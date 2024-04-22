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
    <title>Crear Armas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">CRUD ARMAS</h2>
        <a href="../crud/armas/create.php" class="btn btn-primary mb-4">Agregar Nueva Arma</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Daño Cuerpo</th>
                    <th>Daño Cabeza</th>
                    <th>Balas</th>
                    <th>Recamara</th>
                    <th>Tipo Arma</th>
                    <th>Nivel</th>
                    <th>Ruta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $result = $conexion->query("SELECT * FROM armas");
                    while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['da_body']; ?></td>
                        <td><?php echo $row['da_head']; ?></td>
                        <td><?php echo $row['balas']; ?></td>
                        <td><?php echo $row['recamara']; ?></td>
                        <td><?php echo $row['id_tip_arma']; ?></td>
                        <td><?php echo $row['nivel']; ?></td>

                        <td><img src="../../img/armas/<?php echo $row['ruta']; ?>" class="arma-img" alt="<?php echo $row['nombre']; ?>" width="120px"></td>
                        <td>
                            <a href="../crud/armas/update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../crud/armas/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
