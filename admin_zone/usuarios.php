<?php
// Verifica si el usuario no está autenticado o no es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['admin_type'] != 1) {
    header("Location: dashboard.php"); // Redirige a la página de inicio si no está autenticado o no es administrador
    exit();
}
// Realiza la conexión a la base de datos (ajusta los valores según tu configuración)
$archivoConf = 'config/conn_conf.php';

if (file_exists($archivoConf)) {
    require_once $archivoConf;
} else {
    die("El archivo $archivoConf no existe. Verifica la ruta.");
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener la lista de usuarios
$sql = "SELECT admin_user,id, usuario, nombre, email FROM usuarios";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    // Imprimir la lista de usuarios

    while ($fila = $resultado->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . EsAdmin($fila['admin_user']) . '</td>';
        echo '<td>' . $fila['id'] . '</td>';
        echo '<td>' . $fila['usuario'] . '</td>';
        echo '<td>' . $fila['nombre'] . '</td>';
        echo '<td>' . $fila['email'] . '</td>';
        echo '<td><a href="admin_zone/userDelete.php?id=' . $fila['id'] . '&nombre=' . urlencode($fila['usuario']) . '" onclick="return confirmarEliminar(\'' . $fila['usuario'] . '\');">Eliminar</a></td>';

        echo '</tr>';
    }
} else {
    echo 'No hay usuarios registrados.';
}
function EsAdmin($admin_user){
    return ($admin_user == 1) ? 'Administrador' : (($admin_user == 0) ? 'Usuario' : 'Error COMPROBAR');
}


// Cierra la conexión a la base de datos
$conn->close();
?>
