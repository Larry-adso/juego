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

include("../../db/PDO.php");

try {
    // Preparar y ejecutar la consulta
    $consultaTriggers = $conexion->prepare("SELECT t.*, m.nombre AS nombre_mapa, a.nombre AS nombre_arma, av.ruta AS ruta_avatar
                                           FROM trigg t
                                           LEFT JOIN mapas m ON t.deleted_id_mapa = m.id
                                           LEFT JOIN armas a ON t.deleted_id_arma = a.id
                                           LEFT JOIN avatar av ON t.deleted_id_avatar = av.id
                                           WHERE t.deleted_nickname = :nickname");
    $consultaTriggers->bindParam(':nickname', $_SESSION['nickname']);
    $consultaTriggers->execute();
    $triggers = $consultaTriggers->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Manejar errores de PDO
    echo "Error de PDO: " . $e->getMessage();
} catch (Exception $e) {
    // Manejar otros tipos de errores
    echo "Error: " . $e->getMessage();
}

$conexion = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabla de Información</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/historial.css">
</head>
<body>

<div class="container mt-5">
  <h2 style="color: #fff;">Información de juegos</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nickname</th>
          <th>Mapa</th>
          <th>Arma</th>
          <th>Avatar</th>
          <th>Resumen</th>
          <th>Fecha y hora de la partida</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($triggers)): ?>
            <?php foreach ($triggers as $trigger): ?>
            <tr>
              <td><?php echo $trigger['id']; ?></td>
              <td><?php echo $trigger['deleted_nickname']; ?></td>
              <td><?php echo $trigger['nombre_mapa']; ?></td>
              <td><?php echo $trigger['nombre_arma']; ?></td>
              <td><img src="<?php echo $trigger['ruta_avatar']; ?>" alt=""></td>
              <td><?php echo $trigger['deleted_resumen']; ?></td>
              <td><?php echo $trigger['deleted_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
              <td colspan="7">No se encontraron registros.</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
