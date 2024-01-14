<?php
session_start(); // Inicia la sesión en el panel de control

// session_timeout.php
include 'config/session_timeout.php';
gestionarTimeoutSesion();

// echo 'prueba,' . $usuario_info['admin_user'];

// Verifica si el usuario no está autenticado o no es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['admin_type'] != 1) {
    header("Location: dashboard.php"); // Redirige a la página de inicio si no está autenticado o no es administrador
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <script>
        function confirmarRegistro() {
            <?php

            ?>
            let usuario = document.getElementById('user').value;
            let contrasena = document.getElementsByName('contrasena')[0].value;
            let nombre = document.getElementsByName('nombre')[0].value;
            let email = document.getElementsByName('email')[0].value;

            if (usuario && contrasena && nombre && email) {
                return confirm("¿Estás seguro de que deseas registrar al usuario " + usuario + " ?");
            } else {
                alert("Por favor, completa todos los campos obligatorios.");
                return false; // Evita que el formulario se envíe si falta algún campo
            }
        }

        function confirmarEliminar(nombreUsuario) {
            return confirm("¿Estás seguro de que deseas eliminar al usuario '" + nombreUsuario + "'?");
        }
    </script>
</head>

<body>
    <header>
        <h1 class="p1">Registro de Usuario</h1>
        <div class="p1">
            <h3> Ir a dashboard </h3>
            <button onclick="location.href='dashboard.php'">
                Dashboard
            </button>
        </div>
    </header>
    <main class="mainRegisro">
        <section class="colum1">
            <div>
                <h2>Formulario de registro</h2>
                <form id="registroForm" action="procesar_registro.php" method="POST" onsubmit="return confirmarRegistro()">
                    <label for="usuario">Usuario:</label>

                    <input id="user" type="text" name="usuario" required>
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" name="contrasena" required>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required>
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" name="email" required>
                    <label for="admin_user">Tipo de Usuario:</label>

                    <select id="admin_user" name="admin_user" required>
                        <option value="0">Usuario</option>
                        <option value="1">Administrador</option>
                    </select>

                    <label> Acabar registro </label>

                    <button type="submit" id="submitButton">Registrar</button>

                </form>
            </div>
        </section>
        <section class="colum2">
            <h2>
                Usuarios registrados
            </h2>

            <table>
                <thead>
                    <tr>
                        <th>Tipo de Usuario</th>
                        <th>ID Usuario</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php // Imprinme los usuarios en filas
                    if ($_SESSION['admin_type'] == 1) {
                        include 'admin_zone/usuarios.php';
                    } ?>
                </tbody>
            </table>

        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>