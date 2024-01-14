<?php

function obtenerInformacionUsuario($idUsuario) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    
    // $archivoConf = 'config/conn_conf.php';
    $archivoConf = './config/conn_conf.php';
    
    if (file_exists($archivoConf)) {
        require_once $archivoConf;
        
    } else {
        die("El archivo $archivoConf no existe. Verifica la ruta.");
    }
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    // Consulta SQL preparada para obtener información del usuario por ID
    $sql = "SELECT admin_user, nombre, email, fecha_registro FROM usuarios WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idUsuario);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    // Verifica si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtiene la información del usuario
        $row = $result->fetch_assoc();
        $usuarioInfo = array(
            'admin_user' => $row['admin_user'],
            'nombre' => $row['nombre'],
            'email' => $row['email'],
            'fecha_registro' => $row['fecha_registro']
        );

        
        // Cierra la conexión a la base de datos
        $stmt->close();
        $conn->close();
        
        return $usuarioInfo;
    } else {
        // No se encontró información para el ID proporcionado
        // Cierra la conexión a la base de datos
        $stmt->close();
        $conn->close();
        return null;
    }
}
?>
