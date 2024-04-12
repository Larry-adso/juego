<?php
include("../../db/conexion.php");

$consulta = $conexion->prepare("SELECT * FROM tp_armas ");
$consulta->execute();
$info = $consulta->get_result()->fetch_all(MYSQLI_ASSOC);

?>
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
        <br>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="../../php/admin/armas.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <h2 style="text-align: center;">Guardar armas </h2>
                                    <hr>
                                    <br>
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                    <br>
                                    <label for="da_body" class="form-label">Daño en el cuerpo:</label>
                                    <input type="text" class="form-control" id="da_body" name="da_body">
                                </div>
                                <div class="mb-3">
                                    <label for="da_head" class="form-label">daño en la cabeza:</label>
                                    <input type="text" class="form-control" id="da_head" name="da_head" required>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="balas" class="form-label">cantidad de balas:</label>
                                    <input type="text" class="form-control" id="balas" name="balas" required>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="recamara" class="form-label">balas en la recamara:</label>
                                    <input type="text" class="form-control" id="recamara" name="recamara" required>
                                </div>
                                <div class="mb-3">
                                    <label for="id_tip_arma" class="form-label">Tipo de arma</label>
                                    <select class="form-select form-select-lg" name="id_tip_arma" id="id_tip_arma">
                                        <?php foreach ($info as $arma) { ?>
                                            <option value="<?php echo $arma['id']; ?>"> <?php echo $arma['id'] . ' : ' . $arma['tipo_arma']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="ruta" class="form-label">Selecciona una ruta:</label>   
                                    <input type="file" class="form-control" id="ruta" name="ruta" required>
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