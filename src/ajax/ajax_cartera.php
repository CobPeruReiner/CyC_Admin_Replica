<?php
date_default_timezone_set('America/Lima');
header('Content-Type: application/json; charset=utf-8');

$responce = new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

try {
    if (!isset($_REQUEST['control'])) {
        throw new Exception('Control no especificado.');
    }

    require_once("../php/clsUsuario.php");
    require_once("../php/clsCartera.php");
    session_start();

    if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
        $responce->codigo = 2;
        $responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
        echo json_encode($responce);
        exit;
    }

    $verificar = clsUsuario::verificar_sesion($_SESSION['id_ls']);
    if (sizeof($verificar) == 0) {
        $responce->codigo = 3;
        $responce->mensaje = 'Usuario no válido, Inicie Sesión';
        echo json_encode($responce);
        exit;
    }

    $control = (int)$_REQUEST['control'];

    if ($control === 1) {
        clsCartera::registrar(
            utf8_decode($_REQUEST['nombre']),
            $_REQUEST['tipo'],
            utf8_decode($_REQUEST['tramo']),
            utf8_decode($_REQUEST['central']),
            $_REQUEST['idcliente']
        );
        $responce->codigo = 1;
        $responce->mensaje = 'Cartera registrada';

    } elseif ($control === 2) {
        $arr_datos = clsCartera::listar();
        if (sizeof($arr_datos) > 0) {
            $responce->codigo = 1;
            $responce->arr_datos = $arr_datos;
            $responce->mensaje = 'Listado Cartera';
        } else {
            $responce->mensaje = 'No se encontraron registros';
        }

    } elseif ($control === 3) {
        if (!isset($_REQUEST['id'])) {
            throw new Exception('No se recibió la cartera a modificar.');
        }
        clsCartera::update(
            $_REQUEST['id'],
            utf8_decode($_REQUEST['nombre']),
            $_REQUEST['tipo'],
            utf8_decode($_REQUEST['tramo']),
            utf8_decode($_REQUEST['central']),
            $_REQUEST['idcliente'],
            $_REQUEST['estado']
        );
        $responce->codigo = 1;
        $responce->mensaje = 'Cartera actualizada';

    } elseif ($control === 5) {
        /*
          Administración formal de responsables desde RRHH.
          Esto NO cambia personal.id_cartera; solo CARTERA_RESPONSABLE,
          historial y, cuando exista una base operativa activa asociada,
          el acceso mínimo correspondiente mediante los stores de BD.
        */
        $idCartera = isset($_REQUEST['id_cartera']) ? (int)$_REQUEST['id_cartera'] : 0;
        $idTabla = isset($_REQUEST['id_tabla']) ? (int)$_REQUEST['id_tabla'] : 0;
        $jefe = isset($_REQUEST['jefe_operacion']) ? (int)$_REQUEST['jefe_operacion'] : 0;
        $motivo = isset($_REQUEST['motivo']) ? trim($_REQUEST['motivo']) : '';
        $supervisoresJson = isset($_REQUEST['supervisores']) ? $_REQUEST['supervisores'] : '[]';
        $supervisores = json_decode($supervisoresJson, true);

        if (!is_array($supervisores)) {
            throw new Exception('La configuración de supervisores no es válida.');
        }

        $cambios = clsCartera::guardar_responsables(
            $idCartera,
            $idTabla,
            $supervisores,
            $jefe,
            (int)$_SESSION['id_ls'],
            $motivo
        );

        $responce->codigo = 1;
        $responce->mensaje = 'Responsables de la cartera actualizados correctamente.';
        $responce->cambios = $cambios;

    } elseif ($control === 4) {
        clsCartera::baja($_REQUEST['id']);
        $responce->codigo = 1;
        $responce->mensaje = 'Cartera dada de baja';

    } else {
        throw new Exception('Control no válido.');
    }

} catch (Exception $e) {
    $responce->codigo = 0;
    $responce->mensaje = $e->getMessage();
}

echo json_encode($responce);
