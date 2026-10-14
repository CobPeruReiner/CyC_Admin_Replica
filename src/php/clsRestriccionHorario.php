<?php
require_once "clsConexion.php";

/**
 * Autoriza el uso de CyC Admin según el horario corporativo RRHH y las
 * excepciones vigentes por colaborador.
 */
class clsRestriccionHorario
{
    const CODIGO_PLATAFORMA = 'RRHH';

    private static $ultimoMensaje = '';

    public static function ultimo_mensaje()
    {
        return self::$ultimoMensaje;
    }

    private static function denegar($mensaje)
    {
        self::$ultimoMensaje = $mensaje;
        return false;
    }

    public static function puede_acceder($idPersonal)
    {
        $objConx = new clsConexion();
        $objConx->conectar();
        $permitido = self::puede_acceder_conexion($idPersonal);
        $objConx->desconectar();
        return $permitido;
    }

    public static function puede_acceder_conexion($idPersonal)
    {
        self::$ultimoMensaje = '';
        $idPersonal = (int)$idPersonal;

        if ($idPersonal <= 0) {
            return self::denegar('No se pudo validar el usuario de la sesión.');
        }

        $sql = "SELECT ID_RESTRICCION_HORARIO_PLATAFORMA, ZONA_HORARIA,
                    HORA_INICIO_LUN_VIE, HORA_FIN_LUN_VIE,
                    HORA_INICIO_SABADO, HORA_FIN_SABADO, PERMITE_DOMINGO
                FROM RESTRICCION_HORARIO_PLATAFORMA
                WHERE CODIGO_PLATAFORMA='" . self::CODIGO_PLATAFORMA . "'
                    AND ESTADO=1
                LIMIT 1";
        $res = mysql_query($sql);

        if (!$res) {
            error_log('restriccion_horario_plataforma: ' . mysql_error());
            return self::denegar('La configuración de horario no está disponible.');
        }

        $restriccion = mysql_fetch_assoc($res);
        mysql_free_result($res);

        if (!$restriccion) {
            return self::denegar('No existe un horario vigente para la plataforma.');
        }

        try {
            $ahora = new DateTime('now', new DateTimeZone($restriccion['ZONA_HORARIA']));
        } catch (Exception $e) {
            error_log('Zona horaria inválida para RRHH: ' . $e->getMessage());
            return self::denegar('La configuración de zona horaria no es válida.');
        }

        $fecha = $ahora->format('Y-m-d');
        $hora = $ahora->format('H:i:s');
        $idRestriccion = (int)$restriccion['ID_RESTRICCION_HORARIO_PLATAFORMA'];

        $sqlExcepcion = "SELECT TIPO_EXCEPCION, HORA_INICIO, HORA_FIN, MOTIVO
            FROM EXCEPCION_HORARIO_PLATAFORMA
            WHERE ID_RESTRICCION_HORARIO_PLATAFORMA=$idRestriccion
                AND IDPERSONAL=$idPersonal
                AND ESTADO=1
                AND FECHA_INICIO <= '$fecha'
                AND (FECHA_FIN IS NULL OR FECHA_FIN >= '$fecha')
            ORDER BY CASE TIPO_EXCEPCION
                WHEN 'BLOQUEAR_ACCESO' THEN 1
                WHEN 'SIN_RESTRICCION' THEN 2
                WHEN 'HORARIO_PERSONALIZADO' THEN 3
                ELSE 4 END,
                ID_EXCEPCION_HORARIO_PLATAFORMA DESC
            LIMIT 1";
        $resExcepcion = mysql_query($sqlExcepcion);

        if (!$resExcepcion) {
            error_log('excepcion_horario_plataforma: ' . mysql_error());
            return self::denegar('No se pudo validar la excepción de horario.');
        }

        $excepcion = mysql_fetch_assoc($resExcepcion);
        mysql_free_result($resExcepcion);

        if ($excepcion) {
            if ($excepcion['TIPO_EXCEPCION'] === 'BLOQUEAR_ACCESO') {
                return self::denegar('El acceso está bloqueado por una excepción vigente.');
            }

            if ($excepcion['TIPO_EXCEPCION'] === 'SIN_RESTRICCION') {
                return true;
            }

            if ($excepcion['TIPO_EXCEPCION'] === 'HORARIO_PERSONALIZADO') {
                if (empty($excepcion['HORA_INICIO']) || empty($excepcion['HORA_FIN'])) {
                    return self::denegar('La excepción de horario personalizado está incompleta.');
                }

                if (self::hora_en_rango($hora, $excepcion['HORA_INICIO'], $excepcion['HORA_FIN'])) {
                    return true;
                }

                return self::denegar('El acceso no está permitido en el horario personalizado vigente.');
            }
        }

        $diaSemana = (int)$ahora->format('N');
        if ($diaSemana >= 1 && $diaSemana <= 5) {
            if (self::hora_en_rango($hora, $restriccion['HORA_INICIO_LUN_VIE'], $restriccion['HORA_FIN_LUN_VIE'])) {
                return true;
            }
            return self::denegar('El acceso está permitido de lunes a viernes entre ' . $restriccion['HORA_INICIO_LUN_VIE'] . ' y ' . $restriccion['HORA_FIN_LUN_VIE'] . '.');
        }

        if ($diaSemana === 6) {
            if (self::hora_en_rango($hora, $restriccion['HORA_INICIO_SABADO'], $restriccion['HORA_FIN_SABADO'])) {
                return true;
            }
            return self::denegar('El acceso está permitido los sábados entre ' . $restriccion['HORA_INICIO_SABADO'] . ' y ' . $restriccion['HORA_FIN_SABADO'] . '.');
        }

        if ((int)$restriccion['PERMITE_DOMINGO'] === 1) {
            return true;
        }

        return self::denegar('La plataforma no permite accesos los domingos.');
    }

    private static function hora_en_rango($horaActual, $horaInicio, $horaFin)
    {
        if ($horaInicio === $horaFin) {
            return false;
        }

        if ($horaInicio < $horaFin) {
            return $horaActual >= $horaInicio && $horaActual < $horaFin;
        }

        // Soporta rangos que cruzan medianoche, por ejemplo 22:00 a 06:00.
        return $horaActual >= $horaInicio || $horaActual < $horaFin;
    }
}
