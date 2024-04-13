<!doctype html>
<html lang="en">

<head>
    <title>avatar</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
  <br><br><br><br><br><br>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="../../php/admin/mapas.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <h2 style="text-align: center;" >Guardar Mapa </h2>
                                    <hr>
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                                <div class="mb-3">
                                    <label for="ruta" class="form-label">Selecciona una foto del mapa:</label>
                                    <input type="file" class="form-control" id="ruta" name="ruta" required>
                                </div>
                                <div class="mb-3">
                                    <label for="zona1" class="form-label">Selecciona una foto zona 1:</label>
                                    <input type="file" class="form-control" id="zona1" name="zona1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="zona2" class="form-label">Selecciona una foto zona 2:</label>
                                    <input type="file" class="form-control" id="zona2" name="zona2" required>
                                </div>
                                <div class="mb-3">
                                    <label for="zona3" class="form-label">Selecciona una foto zona 3:</label>
                                    <input type="file" class="form-control" id="zona3" name="zona3" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
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
