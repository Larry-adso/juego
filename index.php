<!doctype html>
<html lang="en">

<head>
    <title>bienvenida</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="css/index1.css">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Estilos personalizados -->
    <style>

    </style>
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ingrese sus datos</h5>
                <form action="php/login_register/login.php" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Nick name</label>
                        <input type="text" class="form-control" name="nickname" id="" aria-describedby="emailHelpId" placeholder="nick name" />
                        <small id="emailHelpId" class="form-text text-muted">Help text</small>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="" placeholder="" />
                    </div>
                    <button type="submit" class="btn btn-success">iniciar a jugar</button>
                    <a name="" id="" class="btn btn-danger" href="views/registro.php" role="button">crear cuenta/form></a>

                </form>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>