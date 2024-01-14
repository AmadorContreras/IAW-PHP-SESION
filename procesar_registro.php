<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Inicia la sesión

// session_timeout.php
include 'config/session_timeout.php';
gestionarTimeoutSesion();

// Incluir el archivo que contiene la función generarPaginaMensaje
include 'admin_zone/mensaje.php';

// Redirige a la página de inicio si no está autenticado o no es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['admin_type'] != 1) {
    header("Location: dashboard.php");
    exit();
}
$mensaje = '';

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION['admin_type'] == 1)) {

    // Realiza la conexión a la base de datos (ajustar los valores según la configuración)
    $archivoConf = 'config/conn_conf.php';

    if (file_exists($archivoConf)) {
        require_once $archivoConf;
    } else {
        $mensaje = "El archivo " . $archivoConf . " no existe. Verifica la ruta.";
        // Llamar a la función para generar la página y mostrar el mensaje 
        generarMensaje($mensaje);
        die();
    }
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        $mensaje = "Conexión fallida: " . $conn->connect_error;
        // Llamar a la función para generar la página y mostrar el mensaje 
        generarMensaje($mensaje);
        die();
    }
    // Verificar la existencia de los campos en el formulario
    if (isset($_POST["admin_user"], $_POST["usuario"], $_POST["contrasena"], $_POST["nombre"], $_POST["email"])) {
        // Obtiene los datos del formulario después de limpiar y validar la entrada

        // Validación de admin_user | no puede ser distinto a 0 o 1
        $admin_user = limpiarEntrada($_POST["admin_user"]);
        if ($admin_user != 0 && $admin_user != 1) {
            $mensaje = 'Formulario erroneo : Tipo de Administrador erroneo';
            // echo 'Formulario erroneo : Tipo de Administrador erroneo';
            // Llamar a la función para generar la página y mostrar el mensaje 
            generarMensaje($mensaje);
            die(); // Se detiene por introducir datos erroneos en el formulario
        }

        $usuario = limpiarEntrada($_POST["usuario"]);
        $contrasena = limpiarEntrada($_POST["contrasena"]);
        $nombre = limpiarEntrada($_POST["nombre"]);
        $email = limpiarEntrada($_POST["email"]);


        // Verificar si el usuario ya existe
        require_once 'admin_zone/verificar_usuario.php';
        if (verificarUsuarioExistente($conn, $usuario)) {
            $mensaje = 'El nombre de usuario ( "' . ($_POST['usuario']) . '" ) ya existe. Por favor, elige otro.';
            // echo "El nombre de usuario ya existe. Por favor, elige otro.";
        } else {
            // Hash de la contraseña utilizando password_hash
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

            // Consulta SQL preparada para insertar un nuevo usuario
            $sql = "INSERT INTO usuarios (admin_user, usuario, contrasena, nombre, email) VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            // Verificar si la preparación de la consulta SQL fue exitosa
            if (!$stmt) {
                $mensaje = "Error en la preparación de la consulta SQL: " . $conn->error;
                // Llamar a la función para generar la página y mostrar el mensaje 
                generarMensaje($mensaje);
                die();
                $conn->close();
            }

            // Bindeo de parámetros
            $stmt->bind_param("issss", $admin_user, $usuario, $contrasena_hash, $nombre, $email);

            if ($stmt->execute()) {
                $mensaje = "Usuario ('" . $_POST["usuario"] . "') registrado exitosamente.";
                // echo "Usuario " . $_POST["usuario"] . " registrado exitosamente.";
            } else {
                $mensaje = "Error al registrar el usuario: " . $stmt->error;
                // echo "Error al registrar el usuario: " . $stmt->error;
            }

            // Cierra la conexión a la base de datos
            $stmt->close();
        }


        $conn->close();
    } else {
        $mensaje = "Faltan campos en el formulario.";
        // echo "Faltan campos en el formulario.";
    }
} else {
    $mensaje = "Error al registrar el usuario o No tienes permisos para realizar esta acción.";
    // echo "Error al registrar el usuario";
    // echo "No tienes permisos para realizar esta acción.";
    exit();
}

// Función para limpiar y validar la entrada
function limpiarEntrada($dato)
{
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Llamar a la función para generar la página y mostrar el mensaje 
generarMensaje($mensaje);
?>

