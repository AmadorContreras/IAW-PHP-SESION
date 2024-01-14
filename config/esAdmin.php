<?php
function esAdmin($usuario_id)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'obtenerInformacionUsuario.php';

    $usuario_info = obtenerInformacionUsuario($usuario_id);

     if (isset($usuario_info['admin_user']) && $usuario_info['admin_user'] == 1) {
        return $usuario_info;
     }
}
