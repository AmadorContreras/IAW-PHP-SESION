<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// session_timeout.php
include 'config/session_timeout.php';
gestionarTimeoutSesion();

session_start(); // Inicia la sesión en el panel de control

// Verifica si el usuario no está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php"); // Redirige a la página de inicio si no está autenticado
    exit();
}

// Obtén información del usuario desde la base de datos
$usuario_id = $_SESSION['usuario_id'];
include 'obtenerInformacionUsuario.php';
$usuario_info = obtenerInformacionUsuario($usuario_id);

// Resto del contenido del panel de control
include 'header.php';
?>
<section>
    <h1>Panel de Control</h1>
</section>
<section class="dashboar">
    <h2>Bienvenid@, <?php echo $usuario_info['nombre']; ?>!</h2>
    <?php if ($usuario_info['admin_user'] == 1) : ?>
        <button onclick="location.href='registro.php'">
            Registrar nuevo Usuario
        </button>
    <?php endif; ?>

    <button onclick="location.href='logout.php'">
        Cerrar sesión
    </button>
</section>
<?php include 'footer.php'; ?>