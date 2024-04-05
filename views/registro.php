<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/registro.css"> <!-- Enlace a archivo CSS para los estilos -->
</head>

<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form method="post" action="../php/login_register/registro.php">
            <div class="form-group">
                <label for="id">id:</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <!-- Puedes agregar más campos según tus necesidades -->
            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>

</html>