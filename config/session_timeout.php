<?php
// session_timeout.php

function gestionarTimeoutSesion()
{
    // Establecer el tiempo de espera (en segundos)
    // $inactive = 600;
    $inactive = 600;

    // Comprobar si $_SESSION["timeout"] está configurado
    if (isset($_SESSION["timeout"])) {
        // Calcular el "tiempo de vida" de la sesión.
        $sessionTTL = time() - $_SESSION["timeout"];
        if ($sessionTTL > $inactive) {

            // Limpiar y regenerar la ID de sesión
            session_regenerate_id(true);

            // Destruir la sesión
            session_destroy();

            // Mostrar mensaje de alerta
            echo "<script>alert('Sesión cerrada'); window.location.href = 'login.php';</script>";
            exit();
        }
    }

    $_SESSION["timeout"] = time();
}
