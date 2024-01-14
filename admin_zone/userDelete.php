<?php
session_start();
// Verifica si el usuario no está autenticado o no es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['admin_type'] != 1) {
    header("Location: ../dashboard.php"); // Redirige a la página de inicio si no está autenticado o no es administrador
    exit();
}

$mensaje = '';
// Realiza la conexión a la base de datos (ajusta los valores según tu configuración)
$archivoConf = '../config/conn_conf.php';

if (file_exists($archivoConf)) {
    require_once $archivoConf;
} else {
    $mensaje = "El archivo ". $archivoConf ." no existe. Verifica la ruta.";
    die();
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $mensaje = "Conexión fallida: " . $conn->connect_error;
    die();
}

// Verifica si se proporcionó un ID válido a través de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuario = $_GET['id'];
    $nombreUsuario = $_GET['nombre'];

    // Consulta SQL preparada para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = ?";

    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta SQL fue exitosa
    if ($stmt) {
        $stmt->bind_param("i", $idUsuario);  // "i" indica que $idUsuario es un entero
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $mensaje = "Usuario '" . $nombreUsuario . "' eliminado exitosamente.";
            // echo "Usuario '" . $nombreUsuario . "' eliminado exitosamente.";
        } else {
            $mensaje = "No se encontró el usuario con el ID proporcionado.";
            // echo "No se encontró el usuario con el ID proporcionado.";
        }

        $stmt->close();
    } else {
        $mensaje = "Error en la preparación de la consulta SQL: " . $conn->error;
        // echo "Error en la preparación de la consulta SQL: " . $conn->error;
    }
} else {
    $mensaje =  "ID de usuario no válido.";
    echo "ID de usuario no válido.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/styles.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body>
        <div class="alertas">
            <h2><?php echo $mensaje ?></h2>
            <!-- Se genera boton para volver solo si el usuario es admin -->
        <?php if ($_SESSION['admin_type'] == 1) : ?>
            <br>
            <button onclick="location.href='../registro.php'">
                Volver
            </button>
        <?php endif; ?>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>