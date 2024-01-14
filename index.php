<?php
session_start(); // Inicia la sesión en la página principal

// Verifica si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php"); // Redirige al panel de control si ya está autenticado
    exit();
}

// Resto del contenido de la página principal
include 'header.php';
?>
<section>
    <h1>Bienvenido a mi Sitio</h1>
</section>
<section class="index">

    <button onclick="location.href='login.php'">
        Iniciar sesión
    </button>
</section>
<?php include 'footer.php'; ?>