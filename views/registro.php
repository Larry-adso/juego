<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/registroo.css">
</head>
<body>
   
    </form>
    <form method="post" action="../php/login_register/registro.php" class="login-form">
        <h1 class="login-title">Registro</h1>

        <div class="input-box">
            <i class='bx bxs-user'></i>
            <input type="text" class="form-control" name="id" id="id" aria-describedby="idHelp" placeholder="Id">
        </div>
        <div class="input-box">
            <i class='bx bxs-user'></i>
            <input type="text" class="form-control" name="nombres" id="nombre" placeholder="Nombre">
        </div>
        <div class="input-box">
            <i class='bx bxs-user'></i>
            <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo Electronico">
        </div>
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
        </div>

        <button type="submit" class="login-btn">Registarse</button>

        <p class="register">
        Ya tienes una cuenta?
        <a href="../index.php" class="btn btn-danger" role="button">Ingresar</a>
        </p>
    </form>

</body>
</html>