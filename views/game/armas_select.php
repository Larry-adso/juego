<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Armas Aleatorias</title>
</head>
<body>
    <h1>Armas Aleatorias</h1>
    <button onclick="buscarArma()" id="buscarBtn">Buscar Arma Aleatoria</button>
    <div id="resultado"></div>
    <script>
        function buscarArma() {
            // Eliminar el botón después de hacer clic en él
            document.getElementById("buscarBtn").remove();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("resultado").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "buscar_arma.php", true);
            xhttp.send();
        }
    </script>
</body>
</html>
