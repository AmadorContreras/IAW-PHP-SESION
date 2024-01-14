<?php

function generarMensaje($mensaje) {
    echo '<!DOCTYPE html>
    <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="css/styles.css" rel="stylesheet" type="text/css" />
        </head>
        
        <body>
            <div class="alertas">
                <h2>' . $mensaje . '</h2>
                <!-- Se genera botón para volver solo si el usuario es admin -->
            ' . (isset($_SESSION['admin_type']) && $_SESSION['admin_type'] == 1 ? '
                <br>
                <button onclick="location.href=\'registro.php\'">
                    Volver
                </button>' : '') . '
            </div>
        </body>';
    
    include 'footer.php';

    echo '</html>';
}

?>

