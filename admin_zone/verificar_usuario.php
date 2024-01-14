<?php

function verificarUsuarioExistente($conn, $usuario)
{
    // Consulta SQL preparada para verificar si el usuario ya existe
    $sql_verificacion = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmt_verificacion = $conn->prepare($sql_verificacion);
    $stmt_verificacion->bind_param("s", $usuario);
    $stmt_verificacion->execute();
    $stmt_verificacion->store_result();

    return $stmt_verificacion->num_rows > 0;
}

?>
