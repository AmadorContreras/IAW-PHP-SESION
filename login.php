<?php
session_start(); // Inicia la sesión en la página de inicio de sesión

// Verifica si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php"); // Redirige al panel de control si ya está autenticado
    exit();
}
include 'validarCredenciales.php';
// Verifica si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aquí debes validar las credenciales del usuario desde la base de datos
    $usuario_valido = validarCredenciales($_POST['usuario'], $_POST['contrasena']);

    if ($usuario_valido) {
        $_SESSION['usuario_id'] = $usuario_valido['id'];
        $_SESSION['admin_type'] = $usuario_valido['admin_type'];

        // Regenera el ID de sesión
        session_regenerate_id();

        // Redirige al panel de control después del inicio de sesión
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
// session_timeout.php
include 'config/session_timeout.php';
gestionarTimeoutSesion();

// Resto del contenido de la página de inicio de sesión
include 'header.php';
?>
<section>
    <h1>Iniciar Sesión</h1>
    <h1><?php if (isset($error)) {echo "<p>$error</p>";}?></h1>
</section>
<section class="formIndex">
    <form method="post" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <input type="submit" value="Iniciar sesión">
    </form>
</section>
<?php include 'footer.php'; ?>