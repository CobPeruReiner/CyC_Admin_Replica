<?php
require_once __DIR__ . '/clsUsuario.php';

/** Bloquea respuestas de datos/exportación sin sesión o fuera de horario. */
function admin_requerir_sesion_horario()
{
    if (session_id() === '') {
        session_start();
    }

    if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls'])) {
        http_response_code(401);
        exit('Sesión no válida.');
    }

    if (empty(clsUsuario::verificar_sesion($_SESSION['id_ls']))) {
        $mensaje = clsUsuario::ultimo_mensaje_usuario();
        session_unset();
        session_destroy();
        http_response_code(403);
        exit($mensaje !== '' ? $mensaje : 'El acceso no está permitido en este momento.');
    }
}
