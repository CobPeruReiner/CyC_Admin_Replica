<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";

class clsCartera
{
    public static function listar()
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT a.*, c.nombre as tipo, b.nombre as cliente,
                       IF(a.estado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,
                       '' as opciones
                FROM cartera a
                LEFT JOIN cliente b ON a.idcliente=b.id
                LEFT JOIN tipo_cartera c ON c.id=a.tipo";
        $res = mysql_query($sql) or die(mysql_error());
        $arr_datos = array();
        while ($row = mysql_fetch_array($res)) {
            $arr_datos[] = array(
                $row["id"],
                utf8_encode($row["cartera"]),
                $row["tramo"],
                $row["central"],
                $row["tipo"],
                utf8_encode($row["cliente"]),
                $row["estado"],
                $row["opciones"]
            );
        }
        $objConx->desconectar();
        return $res ? $arr_datos : $res;
    }

    public static function consulta_cliente()
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT id,nombre FROM cliente ORDER BY nombre";
        $res = mysql_query($sql) or die(mysql_error());
        $arr_datos = array();
        while ($row = mysql_fetch_array($res)) {
            $arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
        }
        $objConx->desconectar();
        return $res ? $arr_datos : $res;
    }

    public static function consulta_tipo()
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT id,nombre FROM tipo_cartera ORDER BY nombre";
        $res = mysql_query($sql) or die(mysql_error());
        $arr_datos = array();
        while ($row = mysql_fetch_array($res)) {
            $arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
        }
        $objConx->desconectar();
        return $res ? $arr_datos : $res;
    }

    public static function registrar($nombre, $tipo, $tramo, $central, $idcliente)
    {
        $objConx = new clsConexion();
        $objConx->conectar();

        $nombre    = mysql_real_escape_string($nombre);
        $tramo     = mysql_real_escape_string($tramo);
        $central   = mysql_real_escape_string($central);
        $tipo      = (int)$tipo;
        $idcliente = (int)$idcliente;
        $fecha     = date("Y-m-d H:i:s");
        $idAnalista = isset($_SESSION['IDPERSONAL']) ? (int)$_SESSION['IDPERSONAL'] : 'DEFAULT';

        $sql = "INSERT INTO cartera
                (cartera, tipo, tramo, central, idcliente, fecha_registro, fecha_baja, estado, idAnalistabd)
                VALUES
                (UPPER('$nombre'), $tipo, '$tramo', '$central', $idcliente, '$fecha', DEFAULT, 1, $idAnalista)";

        mysql_query($sql) or die(mysql_error());
        $id = mysql_insert_id();
        $objConx->desconectar();
        return $id;
    }

    public static function select($id)
    {
        $id = (int)$id;
        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT * FROM cartera WHERE id = $id";
        $res = mysql_query($sql) or die(mysql_error());
        $arr_datos = array();
        while ($row = mysql_fetch_array($res)) {
            $arr_datos = $row;
        }
        $objConx->desconectar();
        return $arr_datos;
    }

    public static function update($id, $nombre, $tipo, $tramo, $central, $idcliente, $estado)
    {
        $objConx = new clsConexion();
        $objConx->conectar();

        $id        = (int)$id;
        $nombre    = mysql_real_escape_string($nombre);
        $tipo      = (int)$tipo;
        $tramo     = mysql_real_escape_string($tramo);
        $central   = mysql_real_escape_string($central);
        $idcliente = (int)$idcliente;
        $estado    = ((int)$estado === 1) ? 1 : 0;

        $sql = "UPDATE cartera
                SET cartera=UPPER('$nombre'), tipo=$tipo, tramo='$tramo', central='$central',
                    idcliente=$idcliente, estado=$estado
                WHERE id=$id";
        $res = mysql_query($sql) or die(mysql_error());
        $objConx->desconectar();
        return $res;
    }

    public static function baja($id)
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        $id = (int)$id;
        $fecha = date("Y-m-d H:i:s");
        $sql = "UPDATE cartera SET estado=0, fecha_baja='$fecha' WHERE id=$id";
        $res = mysql_query($sql) or die(mysql_error());
        $objConx->desconectar();
        return $res;
    }

    /* ================================================================
       RESPONSABILIDADES DE CARTERA - ADMINISTRADAS POR RRHH
       ================================================================ */

    public static function consulta_grupos_activos($idCartera)
    {
        $idCartera = (int)$idCartera;
        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT id, id_cartera, nombre_grupo, descripcion
                FROM CARTERA_GRUPO
                WHERE id_cartera=$idCartera
                  AND activo=1
                ORDER BY id";
        $res = mysql_query($sql) or die(mysql_error());
        $datos = array();
        while ($row = mysql_fetch_assoc($res)) {
            $datos[] = array(
                'id' => (int)$row['id'],
                'id_cartera' => (int)$row['id_cartera'],
                'nombre_grupo' => utf8_encode($row['nombre_grupo']),
                'descripcion' => utf8_encode((string)$row['descripcion'])
            );
        }
        $objConx->desconectar();
        return $datos;
    }

    public static function consulta_tablas_activas($idCartera)
    {
        $idCartera = (int)$idCartera;
        $objConx = new clsConexion();
        $objConx->conectar();

        /*
          Consulta INTERNA para resolver el id_tabla de acceso.
          No se usa para construir la grilla principal de Carteras:
          esa grilla sigue saliendo de cartera y conserva activas/inactivas,
          Cliente y Estado.

          Si una cartera activa no tiene tabla_log activa, este método devuelve
          0 filas. Ese escenario es válido: la responsabilidad formal se
          registrará con CARTERA_RESPONSABLE.id_tabla = NULL.
        */
        $sql = "SELECT tl.id, tl.nombre, ca.cartera
                FROM tabla_log tl
                INNER JOIN cartera ca
                    ON tl.id_cartera = ca.id
                WHERE ca.id=$idCartera
                  AND ca.estado=1
                  AND tl.estado=0
                ORDER BY ca.cartera, tl.id DESC";
        $res = mysql_query($sql) or die(mysql_error());
        $datos = array();
        while ($row = mysql_fetch_assoc($res)) {
            $datos[] = array(
                'id' => (int)$row['id'],
                'cartera' => utf8_encode($row['cartera'])
            );
        }
        $objConx->desconectar();
        return $datos;
    }

    public static function consulta_personal_supervisor()
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        /*
          No se filtra por CARGO=16: la responsabilidad formal SUPERVISOR
          la determina CARTERA_RESPONSABLE. Esto permite casos válidos como
          Coordinador de Operaciones que funcionalmente actúa como Supervisor.
        */
        $sql = "SELECT p.IDPERSONAL AS id,
                       CONCAT(p.APELLIDOS, ', ', p.NOMBRES) AS nombre,
                       p.CARGO AS id_cargo,
                       c.nombre AS cargo,
                       p.IDESTADO AS estado
                FROM personal p
                LEFT JOIN cargo c ON c.id=p.CARGO
                WHERE p.TIPO_PERSONAL='HUMANO'
                  AND p.IDESTADO IN (1,4)
                  AND p.CARGO IN (13, 16)
                ORDER BY p.APELLIDOS, p.NOMBRES";
        $res = mysql_query($sql) or die(mysql_error());
        $datos = array();
        while ($row = mysql_fetch_assoc($res)) {
            $datos[] = array(
                'id' => (int)$row['id'],
                'nombre' => utf8_encode($row['nombre']),
                'id_cargo' => (int)$row['id_cargo'],
                'cargo' => utf8_encode((string)$row['cargo']),
                'estado' => (int)$row['estado']
            );
        }
        $objConx->desconectar();
        return $datos;
    }

    public static function consulta_jefes_operacion()
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT p.IDPERSONAL AS id,
                       CONCAT(p.APELLIDOS, ', ', p.NOMBRES) AS nombre,
                       p.CARGO AS id_cargo,
                       c.nombre AS cargo,
                       p.IDESTADO AS estado
                FROM personal p
                LEFT JOIN cargo c ON c.id=p.CARGO
                WHERE p.TIPO_PERSONAL='HUMANO'
                  AND p.CARGO=15
                  AND p.IDESTADO IN (1,4)
                ORDER BY p.APELLIDOS, p.NOMBRES";
        $res = mysql_query($sql) or die(mysql_error());
        $datos = array();
        while ($row = mysql_fetch_assoc($res)) {
            $datos[] = array(
                'id' => (int)$row['id'],
                'nombre' => utf8_encode($row['nombre']),
                'id_cargo' => (int)$row['id_cargo'],
                'cargo' => utf8_encode((string)$row['cargo']),
                'estado' => (int)$row['estado']
            );
        }
        $objConx->desconectar();
        return $datos;
    }

    public static function consulta_responsabilidades_vigentes($idCartera)
    {
        $idCartera = (int)$idCartera;
        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT cr.id,
                       cr.id_tabla,
                       cr.id_cartera,
                       cr.id_grupo_cartera,
                       cr.id_personal,
                       cr.tipo_responsable,
                       p.IDESTADO AS estado_personal,
                       p.CARGO AS cargo_personal,
                       c.nombre AS cargo_nombre,
                       CONCAT(p.APELLIDOS, ', ', p.NOMBRES) AS personal
                FROM CARTERA_RESPONSABLE cr
                LEFT JOIN personal p ON p.IDPERSONAL=cr.id_personal
                LEFT JOIN cargo c ON c.id=p.CARGO
                WHERE cr.id_cartera=$idCartera
                  AND cr.activo=1
                  AND (cr.fecha_inicio IS NULL OR cr.fecha_inicio<=NOW())
                  AND (cr.fecha_fin IS NULL OR cr.fecha_fin>NOW())
                ORDER BY cr.tipo_responsable, cr.id_grupo_cartera";
        $res = mysql_query($sql) or die(mysql_error());
        $datos = array();
        while ($row = mysql_fetch_assoc($res)) {
            $datos[] = array(
                'id' => (int)$row['id'],
                'id_tabla' => (int)$row['id_tabla'],
                'id_cartera' => (int)$row['id_cartera'],
                'id_grupo_cartera' => (int)$row['id_grupo_cartera'],
                'id_personal' => (int)$row['id_personal'],
                'tipo_responsable' => $row['tipo_responsable'],
                'estado_personal' => (int)$row['estado_personal'],
                'cargo_personal' => (int)$row['cargo_personal'],
                'cargo_nombre' => utf8_encode((string)$row['cargo_nombre']),
                'personal' => utf8_encode((string)$row['personal'])
            );
        }
        $objConx->desconectar();
        return $datos;
    }

    private static function responsabilidad_actual($idCartera, $idGrupo, $tipo)
    {
        $idCartera = (int)$idCartera;
        $idGrupo = (int)$idGrupo;
        $tipo = strtoupper(trim($tipo));
        if (!in_array($tipo, array('SUPERVISOR', 'JEFE_OPERACION'))) {
            throw new Exception('Tipo de responsable no válido.');
        }

        $objConx = new clsConexion();
        $objConx->conectar();
        $sql = "SELECT id, id_tabla, id_personal
                FROM CARTERA_RESPONSABLE
                WHERE id_cartera=$idCartera
                  AND id_grupo_cartera=$idGrupo
                  AND tipo_responsable='$tipo'
                  AND activo=1
                  AND (fecha_inicio IS NULL OR fecha_inicio<=NOW())
                  AND (fecha_fin IS NULL OR fecha_fin>NOW())";
        $res = mysql_query($sql);
        if (!$res) {
            $error = mysql_error();
            $objConx->desconectar();
            throw new Exception($error);
        }

        $cantidad = mysql_num_rows($res);
        if ($cantidad > 1) {
            $objConx->desconectar();
            throw new Exception('Existe más de un responsable activo para el mismo contexto. Debe depurarse antes de continuar.');
        }

        $actual = null;
        if ($cantidad === 1) {
            $row = mysql_fetch_assoc($res);
            $actual = array(
                'id' => (int)$row['id'],
                'id_tabla' => (int)$row['id_tabla'],
                'id_personal' => (int)$row['id_personal']
            );
        }
        $objConx->desconectar();
        return $actual;
    }

    private static function ejecutar_procedimiento($sql)
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        $res = mysql_query($sql);
        if (!$res) {
            $error = mysql_error();
            $objConx->desconectar();
            throw new Exception($error);
        }

        $salida = array();
        if (is_resource($res)) {
            $row = mysql_fetch_assoc($res);
            if ($row) {
                foreach ($row as $clave => $valor) {
                    $salida[$clave] = is_string($valor) ? utf8_encode($valor) : $valor;
                }
            }
            mysql_free_result($res);
        }
        $objConx->desconectar();
        return $salida;
    }

    private static function aplicar_responsabilidad($idCartera, $idTabla, $idGrupo, $tipo, $idPersonalDeseado, $usuarioRegistro, $motivo)
    {
        $idCartera = (int)$idCartera;
        $idTabla = (int)$idTabla;
        $idGrupo = (int)$idGrupo;
        $idPersonalDeseado = (int)$idPersonalDeseado;
        $usuarioRegistro = (int)$usuarioRegistro;
        $tipo = strtoupper(trim($tipo));

        $actual = self::responsabilidad_actual($idCartera, $idGrupo, $tipo);
        $idActual = $actual ? (int)$actual['id_personal'] : 0;

        if ($idActual === $idPersonalDeseado) {
            return array(
                'tipo' => $tipo,
                'grupo' => $idGrupo,
                'accion' => 'SIN_CAMBIO',
                'id_personal' => $idPersonalDeseado
            );
        }

        $motivoSql = '';
        if ($idPersonalDeseado > 0 || $idActual > 0) {
            if (trim($motivo) === '') {
                throw new Exception('Debe indicar el motivo del cambio de responsables.');
            }
            $objConx = new clsConexion();
            $objConx->conectar();
            $motivoSql = mysql_real_escape_string(utf8_decode($motivo));
            $objConx->desconectar();
        }

        if ($idPersonalDeseado <= 0) {
            if ($idActual <= 0) {
                return array(
                    'tipo' => $tipo,
                    'grupo' => $idGrupo,
                    'accion' => 'SIN_CAMBIO',
                    'id_personal' => 0
                );
            }

            $sql = "CALL sp_retirar_responsabilidad_cartera(
                        $idCartera,
                        $idGrupo,
                        '$tipo',
                        $usuarioRegistro,
                        '$motivoSql'
                    )";
            $salida = self::ejecutar_procedimiento($sql);
            return array(
                'tipo' => $tipo,
                'grupo' => $idGrupo,
                'accion' => 'RETIRO',
                'id_personal_anterior' => $idActual,
                'resultado' => $salida
            );
        }

        /*
          id_tabla es opcional para la responsabilidad formal.
          - Si existe una tabla_log activa, la UI envía su id de forma interna.
          - Si la cartera no tiene tabla_log activa, se envía SQL NULL.
            En ese caso los stores NO intentan crear asignacion_tabla.
        */
        $idTablaSql = ($idTabla > 0) ? (string)$idTabla : 'NULL';

        if ($idActual > 0) {
            $sql = "CALL sp_reasignar_responsable_cartera(
                        $idTablaSql,
                        $idCartera,
                        $idGrupo,
                        $idPersonalDeseado,
                        '$tipo',
                        $usuarioRegistro,
                        '$motivoSql'
                    )";
            $salida = self::ejecutar_procedimiento($sql);
            return array(
                'tipo' => $tipo,
                'grupo' => $idGrupo,
                'accion' => 'REASIGNACION',
                'id_personal_anterior' => $idActual,
                'id_personal_nuevo' => $idPersonalDeseado,
                'resultado' => $salida
            );
        }

        $sql = "CALL sp_asignar_responsable_cartera(
                    $idTablaSql,
                    $idCartera,
                    $idGrupo,
                    $idPersonalDeseado,
                    '$tipo',
                    'ASIGNACION',
                    $usuarioRegistro,
                    '$motivoSql'
                )";
        $salida = self::ejecutar_procedimiento($sql);
        return array(
            'tipo' => $tipo,
            'grupo' => $idGrupo,
            'accion' => 'ASIGNACION',
            'id_personal_nuevo' => $idPersonalDeseado,
            'resultado' => $salida
        );
    }

    public static function guardar_responsables($idCartera, $idTabla, $supervisores, $jefeOperacion, $usuarioRegistro, $motivo)
    {
        $idCartera = (int)$idCartera;
        $idTabla = (int)$idTabla;
        $usuarioRegistro = (int)$usuarioRegistro;
        $jefeOperacion = (int)$jefeOperacion;

        if ($idCartera <= 0) {
            throw new Exception('La cartera no es válida.');
        }
        if ($usuarioRegistro <= 0) {
            throw new Exception('El usuario de registro no es válido.');
        }
        if (!is_array($supervisores)) {
            $supervisores = array();
        }

        /* Grupos válidos definidos por BD. Si no hay segmentación, solo grupo 0. */
        $grupos = self::consulta_grupos_activos($idCartera);
        $gruposPermitidos = array();
        if (count($grupos) === 0) {
            $gruposPermitidos[0] = true;
        } else {
            foreach ($grupos as $grupo) {
                $gruposPermitidos[(int)$grupo['id']] = true;
            }
        }

        $cambios = array();
        foreach ($supervisores as $fila) {
            $grupo = isset($fila['grupo']) ? (int)$fila['grupo'] : -1;
            $idPersonal = isset($fila['id_personal']) ? (int)$fila['id_personal'] : 0;

            if (!isset($gruposPermitidos[$grupo])) {
                throw new Exception('Se recibió un grupo de cartera que no está activo para esta cartera.');
            }

            $cambios[] = self::aplicar_responsabilidad(
                $idCartera,
                $idTabla,
                $grupo,
                'SUPERVISOR',
                $idPersonal,
                $usuarioRegistro,
                $motivo
            );
        }

        /* Jefe de Operaciones siempre es general: grupo 0. */
        $cambios[] = self::aplicar_responsabilidad(
            $idCartera,
            $idTabla,
            0,
            'JEFE_OPERACION',
            $jefeOperacion,
            $usuarioRegistro,
            $motivo
        );

        return $cambios;
    }
}
