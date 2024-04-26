<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nickname'])) {
    echo '<script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "../index.php";
          </script>';
    session_destroy();
    die();
}

include("../db/PDO.php");

try {
    // Preparar y ejecutar la consulta
    $consultaUsuario = $conexion->prepare("SELECT nickname FROM usuarios WHERE nickname = :nickname");
    $consultaUsuario->bindParam(':nickname', $_SESSION['nickname']);
    $consultaUsuario->execute();
    $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

    // Comprobar si se obtuvo el nombre de usuario correctamente
    if (!$usuario) {

        throw new Exception("El usuario no fue encontrado en la base de datos");
    }

    $nombreUsuario = $usuario['nickname'];
} catch (PDOException $e) {
    // Manejar errores de PDO
    echo "Error de PDO: " . $e->getMessage();
} catch (Exception $e) {
    // Manejar otros tipos de errores
    echo "Error: " . $e->getMessage();
}
$user = $conexion->prepare("SELECT * FROM usuarios");

// Ejecutar la consulta
$user->execute();

// Obtener todos los resultados
$td_users = $user->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú admin</title>

    <link rel="stylesheet" href="../css/nav.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open">
            </i>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <i class="fab fa-youtube"></i>
            <p>: <?php echo $nombreUsuario; ?></p>
        </div>

        <div class="options__menu">

            <a href="../php/login_register/cerrar.php" class="selected">
                <div class="option">
                    <i class="fas fa-home" title="Inicio"></i>
                    <h4>cerrar</h4>
                </div>
            </a>

            <a href="lobby.php">
                <div class="option">
                    <i class="far fa-file" title="Portafolio"></i>
                    <h4>jugar</h4>
                </div>
            </a>

            <a href="admin/avatar.php">
                <div class="option">
                    <i class="far fa-file" title="Portafolio"></i>
                    <h4>avatar crear</h4>
                </div>
            </a>

            <a href="mundos.php">
                <div class="option">
                    <i class="fas fa-video" title="Cursos"></i>
                    <h4>mundos ver</h4>
                </div>
            </a>


            <a href="selecccion_de_avatar.php">
                <div class="option">
                    <i class="far fa-id-badge" title="Contacto"></i>
                    <h4>avatar confirmSelection</h4>
                </div>
            </a>

            <a href="admin/mapas.php">
                <div class="option">
                    <i class="far fa-address-card" title="Nosotros"></i>
                    <h4>mapas crear</h4>
                </div>
            </a>

            <a href="admin/armas.php">
                <div class="option">
                    <i class="far fa-address-card" title="Nosotros"></i>
                    <h4>armas crear</h4>
                </div>
            </a>

            <a href="admin/usuarios.php">
                <div class="option">
                    <i class="far fa-address-card" title="Nosotros"></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

        </div>
    </div>

    <main>

        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 10px;
                text-align: left;
            }
        </style>

        <h2>Formulario de Usuarios</h2>

        <table>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Nickname</th>
                <th>Vida</th>
                <th>Nivel</th>
                <th>Puntaje</th>
                <th>Estado</th>
                <!-- Falta una columna para Tipo de Usuario -->
                <th>Tipo de Usuario</th>

                <th>Acciones</th>
            </tr>
            <?php
            // Verificar si hay resultados
            if (count($td_users) > 0) {
                foreach ($td_users as $dd) {
            ?>
                    <tr>
                        <td><?php echo $dd['nombres']; ?></td>
                        <td><?php echo $dd['correo']; ?></td>
                        <td><?php echo $dd['nickname']; ?></td>
                        <td><?php echo $dd['vida']; ?></td>
                        <td><?php echo $dd['nivel']; ?></td>
                        <td><?php echo $dd['puntaje']; ?></td>
                        <td><?php echo $dd['id_estado']; ?></td>
                        <td><?php echo $dd['tp_user']; ?></td>
                        <td>
                            <a href="../crud/armas/update.php?id=<?php echo $row['nickname']; ?>" class="btn btn-primary btn-sm" style="display: inline-block; padding: 5px 10px; background-color: #007bff; color: #fff; text-decoration: none; border: 1px solid #007bff; border-radius: 3px;">Ativar</a>
                            <a href="../crud/usuarios/delete.php?id=<?php echo $row['nickname']; ?>" class="btn btn-danger btn-sm" style="display: inline-block; padding: 5px 10px; background-color: #dc3545; color: #fff; text-decoration: none; border: 1px solid #dc3545; border-radius: 3px; margin-left: 5px;">Desactivar</a>
                        </td>

                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8">No se encontraron registros.</td>
                </tr>
            <?php } ?>
        </table>


</body>

</html>


</main>

<script src="../js/nav.js"></script>

</body>

</html>