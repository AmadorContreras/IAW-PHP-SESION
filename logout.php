<?php
session_start(); // Inicia la sesión en la página de cierre de sesión

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige a la página de inicio
header("Location: index.php");
exit();
?>
