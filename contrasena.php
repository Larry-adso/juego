<?php
include("db/PDO.php");
session_start();

if (isset($_POST['actualizar'])) {
  $id = $_SESSION['id'];
  $password = $_POST['password'];

  $confirmar_contrasena = $_POST['confirmar_contrasena'];

  if ($password == $confirmar_contrasena) {
    $sql = $conexion->prepare("SELECT * FROM usuarios");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($password == "" || $confirmar_contrasena == "") {
      echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
      echo '<script>window.location="views/registro.php"</script>';
    } else {
      $password = hash('sha512', $password);

      $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE id = '$id'");
      $consulta->execute();
      $consul = $consulta->fetchAll(PDO::FETCH_ASSOC);





      $insertSQL = $conexion->prepare("UPDATE usuarios SET password='$password' WHERE id = '$id' ");
      $insertSQL->execute();
      echo '<script> alert("CONTRASEÑA ACTUALIZADA CORRECTAMENTE");</script>';
      echo '<script>window.location="index.php"</script>';
      unset($_SESSION['id']);
    }
  } else {
    echo '<script>alert ("LAS CONTRASEÑAS NO COINCIDEN");</script>';
  }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Cambio de Contraseña</title>
  <link rel="stylesheet" href="css/contrasena.css">
</head>

<body>
  <div class="container">
    <h2>Cambio de Contraseña</h2>
    <form method="post" name="form1" id="form1" autocomplete="on">
      <div class="form-group">
        <label for="password">Nueva Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
      </div>

      <input type="submit" name="actualizar" value="actualizar">
      <input type="hidden" name="MM_insert" value="formreg">

      <div id="mensaje_error" class="mensaje-error"></div>
    </form>
  </div>
  <script>
    document.querySelector("form").onsubmit = function() {
      var nuevaContraseña = document.getElementById("nueva_contraseña").value;
      var confirmarContraseña = document.getElementById("confirmar_contraseña").value;
      if (nuevaContraseña !== confirmarContraseña) {
        document.getElementById("mensaje_error").innerHTML = "Las contraseñas no coinciden";
        return false; // Detiene el envío del formulario si las contraseñas no coinciden
      }
    };
  </script>
</body>

</html>