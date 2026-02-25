<?php
require_once("../php/clsUsuario.php");
session_start();
clsUsuario::registrar_user_out($_SESSION['id_ls']);
unset($_SESSION["nombre_ls"]);
unset($_SESSION["tipo_ls"]);
unset($_SESSION["user_ls"]);
unset($_SESSION["id_ls"]);
session_unset();
$responce = new stdClass();
$responce->mensaje = "Ha cerrado sesión correctamente";
echo json_encode($responce);
