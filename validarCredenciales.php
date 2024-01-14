<?php

function validarCredenciales($usuario, $contrasena) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
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

    // Consulta SQL preparada para validar credenciales
    $sql = "SELECT admin_user, id, nombre, contrasena FROM usuarios WHERE usuario = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $usuario);
    $stmt->execute();

    $result = $stmt->get_result();

    // Verifica si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtiene la información del usuario
        $row = $result->fetch_assoc();

        // Verifica la contraseña utilizando password_verify
        if (password_verify($contrasena, $row['contrasena'])) {
            $usuarioInfo = array(
                'admin_type' => $row['admin_user'],
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );

            // Cierra la conexión a la base de datos
            $stmt->close();
            $conn->close();

            return $usuarioInfo;
        }
    }

    // Credenciales no válidas o usuario no encontrado
    // Cierra la conexión a la base de datos
    $stmt->close();
    $conn->close();
    return null;
}
?>
