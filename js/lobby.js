function showPlayButton() {
    var playButton = document.getElementById("play-button");
    playButton.classList.remove("hidden");
}

function startGame() {
    // Obtener el ID de usuario del enlace en el botón "Jugar"
    var userId = '<?php echo $nombreUsuario; ?>';
    // Redirigir al usuario a la página de selección de avatar con su ID de usuario
    window.location.href = 'selecccion_de_avatar.php?id=' + userId;
}

