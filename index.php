<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/index1.css">
</head>
<body>
   
    </form>
    <form method="post" action="php/login_register/login.php" class="login-form">
        <h1 class="login-title">Login</h1>

        <div class="input-box">
            <i class='bx bxs-user'></i>
            <input type="text" class="form-control" name="nickname" id="nickname" aria-describedby="nicknameHelp" placeholder="Nick name">
        </div>
        <div class="input-box">
            <i class='bx bxs-lock-alt'></i>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>

        <div class="remember-forgot-box">
            <label for="remember">
                <input type="checkbox" id="remember">
                Recordar
            </label>
            <a href="#">Olvidaste dx tu contraseña?</a>
        </div>

        <button type="submit" class="login-btn">Login</button>

        <p class="register">
        No tienes una cuenta?
        <a href="views/registro.php" class="btn btn-danger" role="button">Crear cuenta</a>
        </p>
    </form>

</body>
</html>