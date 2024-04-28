<?php
include("db/PDO.php");
session_start();

if (isset($_POST['recuperar'])) {
  $correo = $_POST['correo'];

  $sql = $conexion->prepare("SELECT * FROM usuarios WHERE correo='$correo'");
  $sql->execute();
  $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

  $digitos = "sakur02ue859y2u389rhdewirh102385y1285013289";
  $longitud = 4;
  $codigo = substr(str_shuffle($digitos), 0, $longitud);

  $insert = $conexion->prepare("UPDATE usuarios SET token='$codigo' Where correo='$correo'");
  $insert->execute();
  $fila1 = $insert->fetchAll(PDO::FETCH_ASSOC);

  //codigo de envio
  $paracorreo = "$correo";
  $titulo = "Recuperar Contraseña";
  $msj = "Su codigo de verificacion es: '$codigo'";

  $tucorreo = "From:senatrabajos2022@gmail.com";
  if (mail($paracorreo, $titulo, $msj, $tucorreo)) {
    echo '<script> alert ("Su codigo ha sido enviado al correo anteriormente digitado");</script>';
    echo '<script>window.location="code.php"</script>';
  } else {
    echo "Error";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restablecer Contraseña</title>
  <link rel="stylesheet" href="css/recuperar.css">
</head>

<body>
  <div class="container">
    <h2>¿Olvidaste tu contraseña?</h2>
    <form method="post" name="form1" id="form1" autocomplete="on">
      <div class="input-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required>
      </div>
      <button type="submit" name="recuperar" class="btn btn-primary">Restablecer</button>
    </form>
  </div>

  <script src="script.js"></script>
</body>

</html>

