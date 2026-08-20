<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsUsuario
{
	private static $ultimoMensajeUsuario = '';

	private static function establecer_mensaje_usuario($mensaje)
	{
		self::$ultimoMensajeUsuario = trim((string)$mensaje);
	}

	public static function ultimo_mensaje_usuario()
	{
		return self::$ultimoMensajeUsuario;
	}

	private static function limpiar_mensaje_usuario()
	{
		self::$ultimoMensajeUsuario = '';
	}

	private static function mensaje_amigable_permisos($error, $alternativo = 'No se pudo completar la operación. Intente nuevamente.')
	{
		$error = (string)$error;
		if (stripos($error, 'mantiene responsabilidades activas') !== false) {
			return 'Antes de cambiar el cargo o la cartera, retire o reasigne la responsabilidad actual.';
		}
		if (stripos($error, 'asignada en Intranet') !== false || stripos($error, 'asignacion_tabla') !== false) {
			return 'La cartera o el grupo seleccionado no es válido para el contexto del personal.';
		}
		if (stripos($error, 'cartera seleccionada') !== false || stripos($error, 'grupo no es valido') !== false || stripos($error, 'grupo no es válido') !== false) {
			return 'Revise la cartera y el grupo seleccionados.';
		}
		if (stripos($error, 'sin aprobador') !== false) {
			return 'La estructura de aprobación requiere revisión antes de continuar.';
		}
		return $alternativo;
	}

	private static function ejecutar_call_permisos($sql, $contexto, $mensajeAlternativo)
	{
		$res = mysql_query($sql);
		if (!$res) {
			$error = mysql_error();
			self::registrar_error_mysql($contexto);
			self::establecer_mensaje_usuario(self::mensaje_amigable_permisos($error, $mensajeAlternativo));
			return false;
		}
		if (is_resource($res)) {
			mysql_free_result($res);
		}
		return true;
	}

	private static function configurar_conexion_utf8()
	{
		/*
		 * La aplicación y las tablas trabajan en UTF-8 real. No usar
		 * utf8_encode()/utf8_decode() cuando la conexión ya es utf8mb4.
		 */
		if (!@mysql_set_charset('utf8mb4')) {
			mysql_query("SET NAMES utf8mb4 COLLATE utf8mb4_general_ci");
		}
	}

	private static function escapar($valor)
	{
		return mysql_real_escape_string((string)$valor);
	}

	private static function registrar_error_mysql($contexto)
	{
		error_log($contexto . ': ' . mysql_error());
	}

	public static function cargos_con_cartera_obligatoria()
	{
		/*
		 * Cargos cuyo contexto funcional depende de cartera.
		 * Incluye Gestor de Canales Digitales (12).
		 */
		return array(11, 12, 13, 14, 15, 16, 23);
	}

	public static function cargo_requiere_cartera($idCargo)
	{
		return in_array((int)$idCargo, self::cargos_con_cartera_obligatoria(), true);
	}

	public static function cargos_alta_sin_cartera()
	{
		/*
		 * Arquitectura RRHH: los cargos que requieren cartera (incluidos 15 y 16)
		 * se registran con su cartera principal desde el alta.
		 */
		return array();
	}

	public static function cargo_permite_alta_sin_cartera($idCargo)
	{
		/* Compatibilidad con pantallas antiguas: actualmente ningún cargo aplica. */
		return false;
	}


	public static function changelog()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT *,date(fecha_create) as fecha_create2,SUBSTRING(nombre,10,5) as version,REPLACE(SUBSTRING(nombre,10,5),'.','_') as guion FROM version order by id desc ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array($row["nombre"], $row["id"], $row["comentario"], $row["fecha_create2"], $row["version"], $row["guion"]);
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function version_system()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from version order by id desc limit 1 ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function sociedad_system()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from sociedad_co WHERE estado_activo=1 limit 1 ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function consulta_tipo()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT id, nombre FROM cargo ORDER BY nombre";
		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array(
					"id" => $row["id"],
					"nombre" => $row["nombre"],
					"requiere_cartera" => self::cargo_requiere_cartera($row["id"]) ? 1 : 0,
					"alta_sin_cartera" => self::cargo_permite_alta_sin_cartera($row["id"]) ? 1 : 0
				);
			}
		} else {
			self::registrar_error_mysql('consulta_tipo');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function consulta_distrito()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT codDistrito, distrito FROM ubigeo WHERE departamento='LIMA' AND provincia='LIMA'";
		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array("codDistrito" => $row["codDistrito"], "distrito" => $row["distrito"]);
			}
		} else {
			self::registrar_error_mysql('consulta_distrito');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function consulta_ec()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT id, nombre FROM estado_civil ORDER BY id";
		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array("id" => $row["id"], "nombre" => $row["nombre"]);
			}
		} else {
			self::registrar_error_mysql('consulta_ec');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function consulta_gi()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT id, nombre FROM grado_ins ORDER BY id";
		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array("id" => $row["id"], "nombre" => $row["nombre"]);
			}
		} else {
			self::registrar_error_mysql('consulta_gi');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function consulta_sucursal()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT
			tb1.IDSUCURSAL AS id,
			CONCAT(tb1.SUCURSAL, ' | ', tb1.DISTRITO) AS nombre
		FROM sucursal tb1
		WHERE tb1.IDESTADO = 1
		ORDER BY tb1.IDSUCURSAL";

		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array("id" => $row["id"], "nombre" => $row["nombre"]);
			}
		} else {
			self::registrar_error_mysql('consulta_sucursal');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function consulta_horario()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT
			a.idhorario AS id,
			CONCAT(a.horainicio, '-', a.horafin, ' | ', b.nombre, ' | ', a.horario) AS nombre
		FROM horario a
		LEFT JOIN horario_dia b ON a.dias = b.id
		WHERE a.IDESTADO = 1
		ORDER BY a.idhorario";

		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array("id" => $row["id"], "nombre" => $row["nombre"]);
			}
		} else {
			self::registrar_error_mysql('consulta_horario');
		}

		$objConx->desconectar();
		return $arr_datos;
	}


	public static function consulta_carteras_activas()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		/*
		 * Una cartera se considera activa para operación cuando existe en
		 * tabla_log con estado=0 y la cartera mantiene estado=1.
		 * En la interfaz se muestra únicamente el nombre de la cartera.
		 */
		$sql = "SELECT
				ca.id AS id,
				ca.cartera AS nombre,
				MIN(tl.id) AS id_tabla,
				CASE WHEN COUNT(DISTINCT cg.id) > 0 THEN 1 ELSE 0 END AS tiene_grupos
			FROM tabla_log tl
			INNER JOIN cartera ca
				ON tl.id_cartera = ca.id
			LEFT JOIN CARTERA_GRUPO cg
				ON cg.id_cartera = ca.id
				AND cg.activo = 1
			WHERE ca.estado = 1
			  AND tl.estado = 0
			GROUP BY ca.id, ca.cartera
			ORDER BY ca.cartera";

		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array(
					"id" => $row["id"],
					"id_tabla" => $row["id_tabla"],
					"nombre" => $row["nombre"],
					"tiene_grupos" => (int)$row["tiene_grupos"]
				);
			}
		} else {
			self::registrar_error_mysql('consulta_carteras_activas');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function consulta_carteras_responsables_vigentes()
	{
		/* Alias temporal para no romper llamadas existentes. */
		return self::consulta_carteras_activas();
	}

	public static function consulta_carteras_con_grupo_vigente()
	{
		/* Compatibilidad con llamadas antiguas. */
		return self::consulta_carteras_activas();
	}

	public static function consulta_grupos_cartera_activos()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT id, id_cartera, nombre_grupo
			FROM CARTERA_GRUPO
			WHERE activo = 1
			ORDER BY id_cartera, nombre_grupo";

		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array(
					"id" => $row["id"],
					"id_cartera" => $row["id_cartera"],
					"nombre" => $row["nombre_grupo"]
				);
			}
		} else {
			self::registrar_error_mysql('consulta_grupos_cartera_activos');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function cartera_tiene_grupos_activos($idCartera)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$idCartera = (int)$idCartera;
		if ($idCartera <= 0) {
			$objConx->desconectar();
			return false;
		}

		$res = mysql_query("SELECT 1 FROM CARTERA_GRUPO WHERE id_cartera=$idCartera AND activo=1 LIMIT 1");
		$tiene = $res && mysql_num_rows($res) === 1;
		if (!$res) {
			self::registrar_error_mysql('cartera_tiene_grupos_activos');
		}

		$objConx->desconectar();
		return $tiene;
	}

	public static function validar_grupo_cartera($idCartera, $idGrupoCartera, $idCargo = 0)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$idCartera = (int)$idCartera;
		$idGrupoCartera = (int)$idGrupoCartera;
		$idCargo = (int)$idCargo;

		if ($idCartera <= 0) {
			$objConx->desconectar();
			return $idGrupoCartera === 0;
		}

		$resCartera = mysql_query("SELECT 1 FROM cartera WHERE id=$idCartera AND estado=1 LIMIT 1");
		if (!$resCartera || mysql_num_rows($resCartera) !== 1) {
			if (!$resCartera) self::registrar_error_mysql('validar_grupo_cartera: cartera');
			$objConx->desconectar();
			return false;
		}

		/* Jefe de Operaciones siempre usa grupo 0, aun en cartera segmentada. */
		if ($idCargo === 15) {
			$objConx->desconectar();
			return $idGrupoCartera === 0;
		}

		$resTieneGrupos = mysql_query("SELECT 1 FROM CARTERA_GRUPO WHERE id_cartera=$idCartera AND activo=1 LIMIT 1");
		if (!$resTieneGrupos) {
			self::registrar_error_mysql('validar_grupo_cartera: tiene_grupos');
			$objConx->desconectar();
			return false;
		}

		$tieneGrupos = mysql_num_rows($resTieneGrupos) === 1;
		if (!$tieneGrupos) {
			$objConx->desconectar();
			return $idGrupoCartera === 0;
		}

		if ($idGrupoCartera <= 0) {
			$objConx->desconectar();
			return false;
		}

		$resGrupo = mysql_query("SELECT 1 FROM CARTERA_GRUPO WHERE id=$idGrupoCartera AND id_cartera=$idCartera AND activo=1 LIMIT 1");
		$valido = $resGrupo && mysql_num_rows($resGrupo) === 1;
		if (!$resGrupo) {
			self::registrar_error_mysql('validar_grupo_cartera: grupo');
		}

		$objConx->desconectar();
		return $valido;
	}

	public static function validar_cartera_activa_contexto($idCartera, $idGrupoCartera = 0, $idCargo = 0)
	{
		/*
		 * Valida solamente disponibilidad de cartera/grupo. NO exige que ya exista
		 * CARTERA_RESPONSABLE; RRHH puede configurar la responsabilidad después.
		 */
		return self::validar_grupo_cartera($idCartera, $idGrupoCartera, $idCargo);
	}

	public static function validar_cartera_responsable_vigente($idCartera, $idGrupoCartera = 0, $idCargo = 0)
	{
		/* Alias temporal conservado por compatibilidad con código antiguo. */
		return self::validar_cartera_activa_contexto($idCartera, $idGrupoCartera, $idCargo);
	}

	public static function validar_cartera_con_grupo_vigente($idCartera)
	{
		/* Compatibilidad con llamadas antiguas para carteras no segmentadas. */
		return self::validar_cartera_activa_contexto($idCartera, 0, 0);
	}


	public static function consulta_cartera_por_id($idCartera)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$idCartera = (int)$idCartera;
		$res = mysql_query("SELECT id, cartera AS nombre FROM cartera WHERE id=$idCartera LIMIT 1");
		$arr_datos = array();

		if ($res && ($row = mysql_fetch_assoc($res))) {
			$arr_datos = array("id" => $row["id"], "nombre" => $row["nombre"]);
		} elseif (!$res) {
			self::registrar_error_mysql('consulta_cartera_por_id');
		}

		$objConx->desconectar();
		return $arr_datos;
	}


	public static function consulta_usuario($id_cartera)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$id_cartera = (int)$id_cartera;
		$sql = "SELECT a.IDPERSONAL AS id, CONCAT(a.APELLIDOS, ', ', a.NOMBRES) AS nombre
			FROM personal a
			WHERE a.id_cartera = $id_cartera
			ORDER BY a.APELLIDOS ASC";
		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array("id" => $row["id"], "nombre" => $row["nombre"]);
			}
		} else {
			self::registrar_error_mysql('consulta_usuario');
		}

		$objConx->desconectar();
		return $arr_datos;
	}


	public static function consulta_refrigerio()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT
			IDREFRIGERIO AS id,
			CONCAT(
				TIME_FORMAT(HORAINICIO, '%H:%i'),
				' - ',
				TIME_FORMAT(HORAFIN, '%H:%i'),
				CASE WHEN REFRIGERIO IS NULL OR TRIM(REFRIGERIO) = '' THEN '' ELSE CONCAT(' | ', REFRIGERIO) END
			) AS nombre
		FROM refrigerio
		WHERE IDESTADO=1
		ORDER BY HORAINICIO, HORAFIN, IDREFRIGERIO";

		$res = mysql_query($sql);
		$arr_datos = array();
		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array('id' => $row['id'], 'nombre' => $row['nombre']);
			}
		} else {
			self::registrar_error_mysql('consulta_refrigerio');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function validar_refrigerio($idRefrigerio)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$idRefrigerio = (int)$idRefrigerio;
		$res = mysql_query("SELECT IDREFRIGERIO FROM refrigerio WHERE IDREFRIGERIO=$idRefrigerio AND IDESTADO=1 LIMIT 1");
		$valido = $res && mysql_num_rows($res) === 1;

		if (!$res) {
			self::registrar_error_mysql('validar_refrigerio');
		}
		$objConx->desconectar();
		return $valido;
	}

	public static function select_refrigerio_personal($idPersonal)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$idPersonal = (int)$idPersonal;
		$sql = "SELECT
			pr.ID,
			pr.ID_REFRIGERIO,
			r.REFRIGERIO,
			r.HORAINICIO,
			r.HORAFIN
		FROM personal_refrigerio pr
		INNER JOIN refrigerio r ON r.IDREFRIGERIO=pr.ID_REFRIGERIO
		WHERE pr.ID_PERSONAL=$idPersonal AND pr.IDESTADO=1
		ORDER BY pr.ID DESC
		LIMIT 1";

		$res = mysql_query($sql);
		$arr_datos = array();
		if ($res && ($row = mysql_fetch_assoc($res))) {
			$arr_datos = $row;
		} elseif (!$res) {
			self::registrar_error_mysql('select_refrigerio_personal');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function verificar_nombre_user_update($user, $idPersonal)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$user = self::escapar(trim($user));
		$idPersonal = (int)$idPersonal;
		$res = mysql_query("SELECT IDPERSONAL FROM personal WHERE USUARIO=UPPER('$user') AND IDPERSONAL<>$idPersonal");
		$arr_datos = array();
		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = $row;
			}
		} else {
			self::registrar_error_mysql('verificar_nombre_user_update');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function registrar_empleado($APELLIDOS, $NOMBRES, $FECHANAC, $SEXO, $DOC, $ESTCIV, $CARFAM, $NUMHIJ, $DIRECCION, $DISTRITO, $DPTO, $REFDIR, $TLF, $CEL, $EMAIL, $GRADOINS, $CARGO, $IDSUCURSAL, $USUARIO, $PASSWORD, $cartera, $idGrupoCartera, $FECHAING, $IDREFRIGERIO = 0, $USUARIO_REGISTRO = 0, $HORARIOS = array())
	{
		self::limpiar_mensaje_usuario();
		/* Compatibilidad: si alguna llamada antigua no envía id_grupo_cartera,
		 * el parámetro recibido aquí será la fecha de ingreso. En ese caso
		 * se desplazan los argumentos y el grupo queda en 0.
		 */
		if (!is_numeric($idGrupoCartera)) {
			$HORARIOS = $USUARIO_REGISTRO;
			$USUARIO_REGISTRO = $IDREFRIGERIO;
			$IDREFRIGERIO = $FECHAING;
			$FECHAING = $idGrupoCartera;
			$idGrupoCartera = 0;
		}

		$SEXO = (int)$SEXO;
		$ESTCIV = (int)$ESTCIV;
		$CARFAM = (int)$CARFAM;
		$NUMHIJ = (int)$NUMHIJ;
		$GRADOINS = (int)$GRADOINS;
		$CARGO = (int)$CARGO;
		$IDSUCURSAL = (int)$IDSUCURSAL;
		$cartera = (int)$cartera;
		$idGrupoCartera = (int)$idGrupoCartera;
		/*
		 * Alta de personal:
		 * - Cargos sin cartera: se registran sin contexto de cartera.
		 * - Todo cargo que requiere cartera (incluidos Jefe/Supervisor) la recibe
		 *   directamente desde RRHH. Esto NO crea responsabilidad formal.
		 */
		if (!self::cargo_requiere_cartera($CARGO)) {
			$cartera = 0;
			$idGrupoCartera = 0;
		} elseif ($cartera <= 0) {
			$idGrupoCartera = 0;
		}
		if ($CARGO === 15) {
			$idGrupoCartera = 0;
		}
		$IDREFRIGERIO = (int)$IDREFRIGERIO;
		$USUARIO_REGISTRO = (int)$USUARIO_REGISTRO;
		$carteraSql = $cartera > 0 ? (string)$cartera : 'NULL';
		$grupoCarteraSql = $idGrupoCartera > 0 ? (string)$idGrupoCartera : '0';

		if (
			$IDREFRIGERIO <= 0 ||
			$USUARIO_REGISTRO <= 0 ||
			!is_array($HORARIOS) ||
			count($HORARIOS) === 0 ||
			(self::cargo_requiere_cartera($CARGO) && $cartera <= 0) ||
			($cartera > 0 && !self::validar_cartera_activa_contexto($cartera, $idGrupoCartera, $CARGO)) ||
			($cartera <= 0 && $idGrupoCartera !== 0)
		) {
			return false;
		}

		/* La validación de cartera abre y cierra su propia conexión.
		 * Abrimos la conexión transaccional después para evitar que mysql_*
		 * reutilice y cierre el mismo enlace.
		 */
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$APELLIDOS = self::escapar(trim($APELLIDOS));
		$NOMBRES = self::escapar(trim($NOMBRES));
		$FECHANAC = self::escapar(trim($FECHANAC));
		$DOC = self::escapar(trim($DOC));
		$DIRECCION = self::escapar(trim($DIRECCION));
		$DISTRITO = self::escapar(trim($DISTRITO));
		$DPTO = self::escapar(trim($DPTO));
		$REFDIR = self::escapar(trim($REFDIR));
		$TLF = self::escapar(trim($TLF));
		$CEL = self::escapar(trim($CEL));
		$EMAIL = self::escapar(trim($EMAIL));
		$USUARIO = self::escapar(trim($USUARIO));
		$FECHAING = self::escapar(trim($FECHAING));
		$fecha = date('Y-m-d H:i:s');

		$passwordHash = password_hash($PASSWORD, PASSWORD_BCRYPT);
		if ($passwordHash === false) {
			$objConx->desconectar();
			return false;
		}
		$passwordHash = self::escapar($passwordHash);

		mysql_query('START TRANSACTION');

		$resRefrigerio = mysql_query("SELECT IDREFRIGERIO FROM refrigerio WHERE IDREFRIGERIO=$IDREFRIGERIO AND IDESTADO=1 LIMIT 1");
		if (!$resRefrigerio || mysql_num_rows($resRefrigerio) !== 1) {
			self::registrar_error_mysql('registrar_empleado: refrigerio invalido');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		if (!mysql_query("SET @anexo := (SELECT COALESCE(MAX(ANEXO_BACKUP), 1000) + 1 FROM personal)")) {
			self::registrar_error_mysql('registrar_empleado: anexo');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		$sql = "INSERT INTO personal (
			APELLIDOS, NOMBRES, FECHANAC, SEXO, DOC, ESTCIV, CARFAM, NUMHIJ,
			DIRECCION, DISTRITO, DPTO, REFDIR, TLF, CEL, EMAIL, GRADOINS, CARGO,
			IDSUCURSAL, USUARIO, PASSWORD, IDESTADO, fecha_registro, fecha_baja,
			id_cartera, id_grupo_cartera, api_token, fecha_ing, TIPO_PERSONAL, ANYDESK, ANEXO_BACKUP
		) VALUES (
			UPPER('$APELLIDOS'), UPPER('$NOMBRES'), '$FECHANAC', $SEXO, '$DOC',
			$ESTCIV, $CARFAM, $NUMHIJ, '$DIRECCION', '$DISTRITO', '$DPTO',
			'$REFDIR', '$TLF', '$CEL', '$EMAIL', $GRADOINS, $CARGO,
			$IDSUCURSAL, UPPER('$USUARIO'), '$passwordHash', 1,
			'$fecha', '0000-00-00', $carteraSql, $grupoCarteraSql, NULL, '$FECHAING',
			'HUMANO', NULL, @anexo
		)";

		if (!mysql_query($sql)) {
			self::registrar_error_mysql('registrar_empleado: personal');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		$id = (int)mysql_insert_id();

		$horariosUnicos = array();
		foreach ($HORARIOS as $idHorario) {
			$idHorario = (int)$idHorario;
			if ($idHorario > 0) {
				$horariosUnicos[$idHorario] = $idHorario;
			}
		}

		if (count($horariosUnicos) === 0) {
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		$listaHorarios = implode(',', $horariosUnicos);
		$resHorariosValidos = mysql_query("SELECT COUNT(*) AS total FROM horario WHERE IDESTADO=1 AND idhorario IN ($listaHorarios)");
		$filaHorariosValidos = $resHorariosValidos ? mysql_fetch_assoc($resHorariosValidos) : false;
		if (!$filaHorariosValidos || (int)$filaHorariosValidos['total'] !== count($horariosUnicos)) {
			self::registrar_error_mysql('registrar_empleado: horarios invalidos');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		foreach ($horariosUnicos as $idHorario) {
			if (!mysql_query("INSERT INTO horario_personal (idhorario, idpersonal) VALUES ($idHorario, $id)")) {
				self::registrar_error_mysql('registrar_empleado: horario');
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}
		}

		$sqlRefrigerio = "INSERT INTO personal_refrigerio
			(ID_PERSONAL, ID_REFRIGERIO, FECHA_INICIO, FECHA_FIN, IDESTADO, USUARIO_REGISTRO, FECHA_REGISTRO)
			VALUES ($id, $IDREFRIGERIO, NOW(), NULL, 1, $USUARIO_REGISTRO, NOW())";

		if (!mysql_query($sqlRefrigerio)) {
			self::registrar_error_mysql('registrar_empleado: personal_refrigerio');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		if (!mysql_query('COMMIT')) {
			self::registrar_error_mysql('registrar_empleado: commit');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		$objConx->desconectar();
		return $id;
	}

	public static function registrar_item($id_horario, $id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$id_horario = (int)$id_horario;
		$id = (int)$id;
		if ($id_horario <= 0 || $id <= 0) {
			$objConx->desconectar();
			return false;
		}

		$res = mysql_query("INSERT INTO horario_personal (idhorario, idpersonal) VALUES ($id_horario, $id)");
		if (!$res) {
			self::registrar_error_mysql('registrar_item');
			$objConx->desconectar();
			return false;
		}

		$insertId = mysql_insert_id();
		$objConx->desconectar();
		return $insertId;
	}

	public static function eliminar_item($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "delete from horario_personal where idpersonal=$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$objConx->desconectar();
	}

	public static function registrar_user_in($id_user)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO login VALUES(default,'IN','$fecha','$id_user')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function registrar_user_out($id_user)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO login VALUES(default,'OUT','$fecha','$id_user')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function baja_user($id, $idUsuarioModifica, $motivo = 'Baja registrada desde RR.HH.')
	{
		self::limpiar_mensaje_usuario();
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$id = (int)$id;
		$idUsuarioModifica = (int)$idUsuarioModifica;
		$motivo = self::escapar(trim((string)$motivo));
		if ($motivo === '') {
			$motivo = 'Baja registrada desde RR.HH.';
		}

		if ($id <= 0 || $idUsuarioModifica <= 0) {
			self::establecer_mensaje_usuario('No se pudo identificar al personal.');
			$objConx->desconectar();
			return false;
		}

		mysql_query('START TRANSACTION');
		mysql_query("SET @id_usuario_modifica := {$idUsuarioModifica}");

		$resPersonal = mysql_query("SELECT IDPERSONAL FROM personal WHERE IDPERSONAL=$id AND IDESTADO IN (1,4) AND TIPO_PERSONAL='HUMANO' FOR UPDATE");
		if (!$resPersonal || mysql_num_rows($resPersonal) !== 1) {
			self::registrar_error_mysql('baja_user: personal no activo');
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('El personal ya se encuentra inactivo o no está disponible.');
			$objConx->desconectar();
			return false;
		}

		$fecha = date('Y-m-d H:i:s');
		if (!mysql_query("UPDATE personal SET fecha_baja='$fecha', IDESTADO=0 WHERE IDPERSONAL=$id AND IDESTADO IN (1,4)")) {
			self::registrar_error_mysql('baja_user: update personal');
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('No se pudo registrar la baja.');
			$objConx->desconectar();
			return false;
		}

		$sqlCore = "CALL sp_procesar_cese_personal_core($id, $idUsuarioModifica, '$motivo', 1, @rh_resp_cerradas, @rh_perm_cerrados, @rh_perm_reasignados, @rh_perm_sin_aprobador, @rh_perm_sin_cambio)";
		if (!self::ejecutar_call_permisos($sqlCore, 'baja_user: sp_procesar_cese_personal_core', 'No se pudo completar la baja. Revise la estructura de permisos.')) {
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		if (!mysql_query('COMMIT')) {
			self::registrar_error_mysql('baja_user: commit');
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('No se pudo completar la baja.');
			$objConx->desconectar();
			return false;
		}

		$objConx->desconectar();
		return true;
	}

	public static function acceso($usuario, $pass)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$usuario = mysql_real_escape_string($usuario);

		$sql = "
			SELECT 
					A.IDPERSONAL as idpersonal,
					CONCAT(A.nombres,' ',A.apellidos) as empleado,
					A.usuario,
					A.password,
					A.EMAIL as email
			FROM personal A
			WHERE A.usuario='$usuario'
			AND A.idestado=1
			AND A.TIPO_PERSONAL='HUMANO'
			LIMIT 1
    ";

		$res = mysql_query($sql);

		if (!$res || mysql_num_rows($res) == 0) {
			$objConx->desconectar();
			return array();
		}

		$row = mysql_fetch_array($res);

		$hash = $row['password'];

		$loginCorrecto = false;

		if (!empty($hash)) {
			if ($hash[0] === '$') {
				if (password_verify($pass, $hash)) {
					$loginCorrecto = true;

					if (password_needs_rehash($hash, PASSWORD_BCRYPT)) {
						$nuevoHash = password_hash($pass, PASSWORD_BCRYPT);

						$id = (int)$row['idpersonal'];

						mysql_query("UPDATE personal SET password='" . mysql_real_escape_string($nuevoHash) . "' WHERE idpersonal=$id");
					}
				}
			} else {
				if (md5($pass) === $hash) {
					$loginCorrecto = true;

					$nuevoHash = password_hash($pass, PASSWORD_BCRYPT);

					$id = (int)$row['idpersonal'];

					mysql_query("UPDATE personal SET password='" . mysql_real_escape_string($nuevoHash) . "' WHERE idpersonal=$id");
				}
			}
		}

		if ($loginCorrecto) {
			unset($row['password']);

			$objConx->desconectar();

			return array($row);
		}

		$objConx->desconectar();

		return array();
	}

	public static function verificar_sesion($id_usuario)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$id_usuario = (int)$id_usuario;
		$fecha = date('Y-m-d H:i:s');
		$sql = "SELECT id_user FROM login
			WHERE id_user=$id_usuario
			AND DATE(fecha)=DATE('$fecha')";
		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = $row;
			}
		} else {
			self::registrar_error_mysql('verificar_sesion');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function verificar_logeo($id_usuario, $tipo)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "select * from login where id_user='$id_usuario' and date(fecha)= date('$fecha') and tipo='$tipo'";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function eliminar_logeo($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "delete from login where tipo='OUT' and id_user='$id' and date(fecha)= date('$fecha')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$objConx->desconectar();
	}


	public static function verificar_dni($dni)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$dni = self::escapar(trim($dni));
		$res = mysql_query("SELECT IDPERSONAL FROM personal WHERE DOC='$dni'");
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = $row;
			}
		} else {
			self::registrar_error_mysql('verificar_dni');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= funcion para verificar el DNI =============================================

	public static function verificar_dni_update($dni, $user)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$dni = self::escapar(trim($dni));
		$user = (int)$user;
		$res = mysql_query("SELECT IDPERSONAL FROM personal WHERE DOC='$dni' AND IDPERSONAL<>$user");
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = $row;
			}
		} else {
			self::registrar_error_mysql('verificar_dni_update');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= funcion para verificar el user =============================================

	public static function verificar_nombre_user($user)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$user = self::escapar(trim($user));
		$res = mysql_query("SELECT IDPERSONAL FROM personal WHERE USUARIO=UPPER('$user')");
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = $row;
			}
		} else {
			self::registrar_error_mysql('verificar_nombre_user');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= funcion para verificar el password =============================================

	public static function verificar_password($passwordPlano, $id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$id = (int)$id;
		$sql = "SELECT CONTRASENA
			FROM HISTORIAL_CAMBIOS_CONTRASENA
			WHERE ID_USUARIO=$id
			ORDER BY ID_HIST_CAMBIO_CONTRASENA DESC
			LIMIT 10";

		$res = mysql_query($sql);
		if (!$res) {
			self::registrar_error_mysql('verificar_password');
			$objConx->desconectar();
			return false;
		}

		while ($row = mysql_fetch_assoc($res)) {
			$hash = $row['CONTRASENA'];
			if ($hash === null || $hash === '') {
				continue;
			}

			if (isset($hash[0]) && $hash[0] === '$') {
				if (password_verify($passwordPlano, $hash)) {
					$objConx->desconectar();
					return true;
				}
			} elseif (md5($passwordPlano) === $hash) {
				$objConx->desconectar();
				return true;
			}
		}

		$objConx->desconectar();
		return false;
	}

	// ============================================= funcion para listar los usuarios =============================================

	public static function listar_user()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$sql = "SELECT
			CONCAT(COALESCE(YEAR(b.fecha_registro), YEAR(b.fecha_ing), YEAR(CURDATE())), '-', LPAD(b.idpersonal, 5, '0')) AS idpersonal,
			CONCAT(b.NOMBRES, ' ', b.APELLIDOS) AS empleado,
			b.DOC AS dni,
			'********' AS password,
			b.USUARIO AS user,
			c.nombre AS tipo,
			COALESCE(car.cartera, 'NINGUNA CARTERA') AS cartera,
			CASE WHEN b.IDESTADO=1 THEN '<label>ACTIVE</label>' WHEN b.IDESTADO=4 THEN '<label>VACACIONES</label>' ELSE '<label>SUSPENDED</label>' END AS estado,
			'' AS opciones
		FROM personal b
		LEFT JOIN cargo c ON c.id=b.CARGO
		LEFT JOIN cartera car ON b.id_cartera=car.id
		ORDER BY b.IDPERSONAL DESC";

		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array(
					$row['idpersonal'],
					$row['empleado'],
					$row['dni'],
					$row['password'],
					$row['user'],
					$row['tipo'],
					$row['cartera'],
					$row['estado'],
					$row['opciones']
				);
			}
		} else {
			self::registrar_error_mysql('listar_user');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= FUNCION PARA EXPORTAR A EXCEL =============================================

	public static function excel()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();
		$sql = "SELECT CONCAT(YEAR(b.fecha_registro),'-', LPAD(b.idpersonal,5,'0') ) as idpersonal,concat(nombres,' ',apellidos) as empleado,
					FECHANAC, if(SEXO=1,'M','F') as sexo ,b.DOC as dni, d.nombre as ESTCIV,CARFAM,NUMHIJ,b.DIRECCION,b.DISTRITO,b.DPTO,b.REFDIR,
					b.TLF,b.CEL,b.EMAIL,e.nombre as GRADOINS,c.nombre as CARGO,
					f.SUCURSAL as sucursal,usuario as user,b.fecha_registro,
					CASE WHEN b.IDESTADO=1 THEN '<label>ACTIVE</label>' WHEN b.IDESTADO=4 THEN '<label>VACACIONES</label>' ELSE '<label>SUSPENDED</label>' END as estado, car.cartera
					FROM personal b 
					left join cargo c on c.id=b.CARGO
					left join estado_civil d on d.id=b.ESTCIV
					left join grado_ins e on e.id=b.GRADOINS
					left join sucursal f on f.IDSUCURSAL=b.IDSUCURSAL
					left join cartera car on car.id = b.id_cartera        
					order by 2 asc
		";

		$res = mysql_query($sql);

		$arr_datos = array();
		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array($row["idpersonal"], $row["empleado"], $row["FECHANAC"], $row["sexo"], $row["dni"], $row["ESTCIV"], $row["CARFAM"], $row["NUMHIJ"], $row["DIRECCION"], $row["DISTRITO"], $row["DPTO"], $row["REFDIR"], $row["TLF"], $row["CEL"], $row["EMAIL"], $row["GRADOINS"], $row["CARGO"], $row["sucursal"], $row["user"], $row["fecha_registro"], $row["estado"], $row["cartera"]);
			}
		} else {
			self::registrar_error_mysql('excel');
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// =============================================  FUNCION PARA LISTAR USUARIOS ONLINE =============================================

	public static function listar_user_online()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();
		$fecha = date("Y-m-d");
		$sql = "SELECT distinct usuario as user,ut.nombre as tipo from login ll
				left join personal uu on uu.idpersonal=ll.id_user
				left join cargo ut on uu.cargo=ut.id 
				where ll.tipo='IN' and date(ll.fecha)= date('$fecha')
				order by uu.usuario desc";
		$res = mysql_query($sql);
		$arr_datos = array();
		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = array($row["user"], $row["tipo"]);
			}
		} else {
			self::registrar_error_mysql('listar_user_online');
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// =============================================  FUNCION PARA LISTAR USUARIO POR ID =============================================

	public static function select_user($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$id = (int)$id;
		$sql = "SELECT
			a.IDPERSONAL, a.APELLIDOS, a.NOMBRES, a.FECHANAC, a.SEXO, a.DOC,
			a.ESTCIV, a.CARFAM, a.NUMHIJ, a.DIRECCION, a.DISTRITO, a.DPTO,
			a.REFDIR, a.TLF, a.CEL, a.EMAIL, a.GRADOINS, a.CARGO, a.IDSUCURSAL,
			a.USUARIO, a.IDESTADO, a.fecha_baja, a.id_cartera, a.id_grupo_cartera, a.fecha_ing,
			b.codDepartamento, b.codProvincia, b.codDistrito
		FROM personal a
		LEFT JOIN ubigeo b ON a.DPTO=b.departamento AND a.DISTRITO=b.distrito
		WHERE a.IDPERSONAL=$id
		LIMIT 1";

		$res = mysql_query($sql);
		$arr_datos = array();

		if ($res && ($row = mysql_fetch_assoc($res))) {
			$arr_datos = $row;
		} elseif (!$res) {
			self::registrar_error_mysql('select_user');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	// =============================================  FUNCION PARA MOSTRAR HORARIO POR ID USUARIO =============================================

	public static function select_detalle($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$id = (int)$id;
		$res = mysql_query("SELECT idhorario, id FROM horario_personal WHERE idpersonal=$id");
		$arr_datos = array();

		if ($res) {
			while ($row = mysql_fetch_assoc($res)) {
				$arr_datos[] = $row;
			}
		} else {
			self::registrar_error_mysql('select_detalle');
		}

		$objConx->desconectar();
		return $arr_datos;
	}

	public static function update_empleado(
		$id,
		$estado,
		$APELLIDOS,
		$NOMBRES,
		$FECHANAC,
		$SEXO,
		$DOC,
		$ESTCIV,
		$CARFAM,
		$NUMHIJ,
		$DIRECCION,
		$DISTRITO,
		$DPTO,
		$REFDIR,
		$TLF,
		$CEL,
		$EMAIL,
		$GRADOINS,
		$CARGO,
		$IDSUCURSAL,
		$USUARIO,
		$PASSWORD,
		$cartera,
		$idGrupoCartera,
		$FECHAING,
		$FECHABAJA,
		$idUsuarioModifica,
		$IDREFRIGERIO = 0,
		$HORARIOS = null
	) {
		self::limpiar_mensaje_usuario();
		/* Compatibilidad: si alguna llamada antigua no envía id_grupo_cartera,
		 * el parámetro recibido aquí será la fecha de ingreso. En ese caso
		 * se desplazan los argumentos y el grupo queda en 0.
		 */
		if (!is_numeric($idGrupoCartera)) {
			$HORARIOS = $IDREFRIGERIO;
			$IDREFRIGERIO = $idUsuarioModifica;
			$idUsuarioModifica = $FECHABAJA;
			$FECHABAJA = $FECHAING;
			$FECHAING = $idGrupoCartera;
			$idGrupoCartera = 0;
		}

		$id = (int)$id;
		$estado = (int)$estado;
		$SEXO = (int)$SEXO;
		$ESTCIV = (int)$ESTCIV;
		$CARFAM = (int)$CARFAM;
		$NUMHIJ = (int)$NUMHIJ;
		$GRADOINS = (int)$GRADOINS;
		$CARGO = (int)$CARGO;
		$IDSUCURSAL = (int)$IDSUCURSAL;
		$cartera = (int)$cartera;
		$idGrupoCartera = (int)$idGrupoCartera;
		/* Solo los cargos operativos definidos administran cartera principal desde RR.HH. */
		if (!self::cargo_requiere_cartera($CARGO)) {
			$cartera = 0;
			$idGrupoCartera = 0;
		} elseif ($cartera <= 0) {
			$idGrupoCartera = 0;
		}
		if ($CARGO === 15) {
			$idGrupoCartera = 0;
		}
		$idUsuarioModifica = (int)$idUsuarioModifica;
		$IDREFRIGERIO = (int)$IDREFRIGERIO;
		$carteraSql = $cartera > 0 ? (string)$cartera : 'NULL';
		$grupoCarteraSql = $idGrupoCartera > 0 ? (string)$idGrupoCartera : '0';

		$edicionVacaciones = ($estado === 4);
		if (
			$id <= 0 ||
			$IDREFRIGERIO <= 0 ||
			$idUsuarioModifica <= 0 ||
			(!$edicionVacaciones && self::cargo_requiere_cartera($CARGO) && $cartera <= 0) ||
			(!$edicionVacaciones && $cartera > 0 && !self::validar_cartera_activa_contexto($cartera, $idGrupoCartera, $CARGO)) ||
			($cartera <= 0 && $idGrupoCartera !== 0)
		) {
			return false;
		}

		/* La validación de cartera abre y cierra su propia conexión.
		 * Abrimos la conexión transaccional después para evitar que mysql_*
		 * reutilice y cierre el mismo enlace.
		 */
		$objConx = new clsConexion();
		$objConx->conectar();
		self::configurar_conexion_utf8();

		$APELLIDOS = self::escapar(trim($APELLIDOS));
		$NOMBRES = self::escapar(trim($NOMBRES));
		$FECHANAC = self::escapar(trim($FECHANAC));
		$DOC = self::escapar(trim($DOC));
		$DIRECCION = self::escapar(trim($DIRECCION));
		$DISTRITO = self::escapar(trim($DISTRITO));
		$DPTO = self::escapar(trim($DPTO));
		$REFDIR = self::escapar(trim($REFDIR));
		$TLF = self::escapar(trim($TLF));
		$CEL = self::escapar(trim($CEL));
		$EMAIL = self::escapar(trim($EMAIL));
		$USUARIO = self::escapar(trim($USUARIO));
		$FECHAING = self::escapar(trim($FECHAING));
		$FECHABAJA = self::escapar(trim($FECHABAJA));

		mysql_query('START TRANSACTION');
		mysql_query("SET @id_usuario_modifica := $idUsuarioModifica");

		$resPersonalActual = mysql_query("SELECT IDESTADO, CARGO, IFNULL(id_cartera,0) AS id_cartera, IFNULL(id_grupo_cartera,0) AS id_grupo_cartera FROM personal WHERE IDPERSONAL=$id AND TIPO_PERSONAL='HUMANO' FOR UPDATE");
		if (!$resPersonalActual || mysql_num_rows($resPersonalActual) !== 1) {
			self::registrar_error_mysql('update_empleado: personal no encontrado');
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('El personal no está disponible para modificar.');
			$objConx->desconectar();
			return false;
		}
		$personalActual = mysql_fetch_assoc($resPersonalActual);
		$estadoAnterior = (int)$personalActual['IDESTADO'];
		$cargoAnterior = (int)$personalActual['CARGO'];
		$carteraAnterior = (int)$personalActual['id_cartera'];
		$grupoAnterior = (int)$personalActual['id_grupo_cartera'];

		if (!in_array($estado, array(0, 1, 4), true)) {
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('El estado del personal no es válido.');
			$objConx->desconectar();
			return false;
		}

		/*
		 * IDESTADO=4 = vacaciones. Una modificación normal de RR.HH. conserva
		 * dicho estado; no puede convertirlo accidentalmente en cese o activo.
		 */
		if ($estadoAnterior === 4) {
			$estado = 4;
		}

		$cambioContexto = ($cargoAnterior !== $CARGO || $carteraAnterior !== $cartera || $grupoAnterior !== $idGrupoCartera);
		$esReingreso = ($estadoAnterior === 0 && $estado === 1);

		/* La baja siempre se procesa por baja_user(), con motivo e historial. */
		if (($estadoAnterior === 1 || $estadoAnterior === 4) && $estado === 0) {
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('Para registrar una baja, use la opción Dar de baja del listado.');
			$objConx->desconectar();
			return false;
		}

		/*
		 * Los CORE actuales de cambio de contexto están definidos para estado 0/1.
		 * Durante vacaciones permitimos actualizar datos generales, pero bloqueamos
		 * cargo/cartera/grupo para no alterar la ruta de aprobación con estado 4.
		 */
		if ($estadoAnterior === 4 && $cambioContexto) {
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('El personal se encuentra de vacaciones. El cargo o la cartera deben modificarse cuando retorne a estado activo.');
			$objConx->desconectar();
			return false;
		}

		if ($estadoAnterior !== 4) {
			$sqlValidar = "CALL sp_validar_actualizacion_personal_core($id, $estado, $CARGO, $carteraSql, $grupoCarteraSql, $idUsuarioModifica)";
			if (!self::ejecutar_call_permisos($sqlValidar, 'update_empleado: sp_validar_actualizacion_personal_core', 'No se puede aplicar este cambio en este momento.')) {
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}
		}

		if ($esReingreso) {
			$sqlReingreso = "CALL sp_preparar_reingreso_personal_core($id, $idUsuarioModifica, 'Reingreso registrado desde RR.HH.', @rh_resp_heredadas, @rh_reasignados_heredados, @rh_sin_aprobador_heredados, @rh_sin_cambio_heredados)";
			if (!self::ejecutar_call_permisos($sqlReingreso, 'update_empleado: sp_preparar_reingreso_personal_core', 'No se pudo preparar el reingreso.')) {
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}
		}

		$resRefrigerio = mysql_query("SELECT IDREFRIGERIO FROM refrigerio WHERE IDREFRIGERIO=$IDREFRIGERIO AND IDESTADO=1 LIMIT 1");
		if (!$resRefrigerio || mysql_num_rows($resRefrigerio) !== 1) {
			self::registrar_error_mysql('update_empleado: refrigerio invalido');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		$passwordSql = '';
		if ($PASSWORD !== null && trim($PASSWORD) !== '') {
			$passwordHash = password_hash($PASSWORD, PASSWORD_BCRYPT);
			if ($passwordHash === false) {
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}
			$passwordHash = self::escapar($passwordHash);
			$passwordSql = ", PASSWORD='$passwordHash'";
		}

		$sql = "UPDATE personal SET
			IDESTADO=$estado,
			APELLIDOS=UPPER('$APELLIDOS'),
			NOMBRES=UPPER('$NOMBRES'),
			FECHANAC='$FECHANAC',
			SEXO=$SEXO,
			DOC='$DOC',
			ESTCIV=$ESTCIV,
			CARFAM=$CARFAM,
			NUMHIJ=$NUMHIJ,
			DIRECCION='$DIRECCION',
			DISTRITO='$DISTRITO',
			DPTO='$DPTO',
			REFDIR='$REFDIR',
			TLF='$TLF',
			CEL='$CEL',
			EMAIL='$EMAIL',
			GRADOINS=$GRADOINS,
			CARGO=$CARGO,
			IDSUCURSAL=$IDSUCURSAL,
			USUARIO=UPPER('$USUARIO'),
			fecha_baja='$FECHABAJA',
			id_cartera=$carteraSql,
			id_grupo_cartera=$grupoCarteraSql,
			fecha_ing='$FECHAING'
			$passwordSql
		WHERE IDPERSONAL=$id";

		if (!mysql_query($sql)) {
			self::registrar_error_mysql('update_empleado: personal');
			mysql_query('ROLLBACK');
			self::establecer_mensaje_usuario('No se pudieron guardar los cambios.');
			$objConx->desconectar();
			return false;
		}

		if ($estado === 1 && ($esReingreso || $cambioContexto)) {
			$motivoPost = $esReingreso ? 'Reingreso registrado desde RR.HH.' : 'Actualización de cargo o cartera desde RR.HH.';
			$sqlPost = "CALL sp_post_actualizacion_personal_core($id, $idUsuarioModifica, '$motivoPost', @rh_perm_propios, @rh_reasignados_aprobador, @rh_sin_aprobador_aprobador, @rh_sin_cambio_aprobador)";
			if (!self::ejecutar_call_permisos($sqlPost, 'update_empleado: sp_post_actualizacion_personal_core', 'Los datos cambiaron, pero no se pudo actualizar la ruta de aprobación.')) {
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}
		}

		$resActual = mysql_query("SELECT ID, ID_REFRIGERIO FROM personal_refrigerio WHERE ID_PERSONAL=$id AND IDESTADO=1 ORDER BY ID DESC LIMIT 1 FOR UPDATE");
		if (!$resActual) {
			self::registrar_error_mysql('update_empleado: consultar refrigerio');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		$actual = mysql_fetch_assoc($resActual);
		if ($actual && (int)$actual['ID_REFRIGERIO'] === $IDREFRIGERIO) {
			$idAsignacionActual = (int)$actual['ID'];
			if (!mysql_query("UPDATE personal_refrigerio SET IDESTADO=0, FECHA_FIN=NOW() WHERE ID_PERSONAL=$id AND IDESTADO=1 AND ID<>$idAsignacionActual")) {
				self::registrar_error_mysql('update_empleado: cerrar refrigerios duplicados');
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}
		} else {
			if (!mysql_query("UPDATE personal_refrigerio SET IDESTADO=0, FECHA_FIN=NOW() WHERE ID_PERSONAL=$id AND IDESTADO=1")) {
				self::registrar_error_mysql('update_empleado: cerrar refrigerio');
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}

			$sqlRefrigerio = "INSERT INTO personal_refrigerio
				(ID_PERSONAL, ID_REFRIGERIO, FECHA_INICIO, FECHA_FIN, IDESTADO, USUARIO_REGISTRO, FECHA_REGISTRO)
				VALUES ($id, $IDREFRIGERIO, NOW(), NULL, 1, $idUsuarioModifica, NOW())";
			if (!mysql_query($sqlRefrigerio)) {
				self::registrar_error_mysql('update_empleado: insertar refrigerio');
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}
		}

		if ($HORARIOS !== null) {
			if (!is_array($HORARIOS) || count($HORARIOS) === 0) {
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}

			if (!mysql_query("DELETE FROM horario_personal WHERE idpersonal=$id")) {
				self::registrar_error_mysql('update_empleado: borrar horarios');
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}

			$horariosUnicos = array();
			foreach ($HORARIOS as $idHorario) {
				$idHorario = (int)$idHorario;
				if ($idHorario > 0) {
					$horariosUnicos[$idHorario] = $idHorario;
				}
			}

			if (count($horariosUnicos) === 0) {
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}

			$listaHorarios = implode(',', $horariosUnicos);
			$resHorariosValidos = mysql_query("SELECT COUNT(*) AS total FROM horario WHERE IDESTADO=1 AND idhorario IN ($listaHorarios)");
			$filaHorariosValidos = $resHorariosValidos ? mysql_fetch_assoc($resHorariosValidos) : false;
			if (!$filaHorariosValidos || (int)$filaHorariosValidos['total'] !== count($horariosUnicos)) {
				self::registrar_error_mysql('update_empleado: horarios invalidos');
				mysql_query('ROLLBACK');
				$objConx->desconectar();
				return false;
			}

			foreach ($horariosUnicos as $idHorario) {
				if (!mysql_query("INSERT INTO horario_personal (idhorario, idpersonal) VALUES ($idHorario, $id)")) {
					self::registrar_error_mysql('update_empleado: insertar horario');
					mysql_query('ROLLBACK');
					$objConx->desconectar();
					return false;
				}
			}
		}

		if (!mysql_query('COMMIT')) {
			self::registrar_error_mysql('update_empleado: commit');
			mysql_query('ROLLBACK');
			$objConx->desconectar();
			return false;
		}

		$objConx->desconectar();
		return true;
	}

	public static function getAttempts($usuario)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$usuario = mysql_real_escape_string($usuario);

		$sql = "
        SELECT INTENTOS_CYCWEB_ADMIN
        FROM personal
        WHERE USUARIO = '$usuario'
        LIMIT 1
    ";

		$res = mysql_query($sql);

		if (!$res) {
			error_log("MySQL Error getAttempts: " . mysql_error());
			$objConx->desconectar();
			return 0;
		}

		$row = mysql_fetch_assoc($res);

		$objConx->desconectar();

		return $row ? intval($row['INTENTOS_CYCWEB_ADMIN']) : 0;
	}

	public static function incAttempts($usuario)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$usuario = mysql_real_escape_string($usuario);

		$sql = "
        UPDATE personal
        SET INTENTOS_CYCWEB_ADMIN = INTENTOS_CYCWEB_ADMIN + 1
        WHERE USUARIO = '$usuario'
    ";

		$res = mysql_query($sql);

		if (!$res) {
			error_log("MySQL Error incAttempts: " . mysql_error());
			$objConx->desconectar();
			return 0;
		}

		$sql2 = "
        SELECT INTENTOS_CYCWEB_ADMIN
        FROM personal
        WHERE USUARIO = '$usuario'
        LIMIT 1
    ";

		$res2 = mysql_query($sql2);

		$intentos = 0;

		if ($res2) {
			$row = mysql_fetch_assoc($res2);
			$intentos = intval($row['INTENTOS_CYCWEB_ADMIN']);
		}

		$objConx->desconectar();

		return $intentos;
	}

	public static function resetAttempts($usuario)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$usuario = mysql_real_escape_string($usuario);

		$sql = "
        UPDATE personal
        SET INTENTOS_CYCWEB_ADMIN = 0
        WHERE USUARIO = '$usuario'
    ";

		$res = mysql_query($sql);

		if (!$res) {
			error_log("MySQL Error resetAttempts: " . mysql_error());
		}

		$objConx->desconectar();
	}

	public static function bloquearUsuario($usuario)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$usuario = mysql_real_escape_string($usuario);

		$sql = "
        UPDATE personal
        SET IDESTADO = 5
        WHERE USUARIO = '$usuario'
        AND IDESTADO = 1
    ";

		$res = mysql_query($sql);

		if (!$res) {
			error_log("MySQL Error bloquearUsuario: " . mysql_error());
		}

		$objConx->desconectar();
	}

	public static function getByDocumento($doc)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$doc = mysql_real_escape_string($doc);

		$sql = "
			SELECT
				A.IDPERSONAL as idpersonal,
				CONCAT(A.nombres,' ',A.apellidos) as empleado,
				A.usuario,
				A.password,
				A.EMAIL as email,
				A.DOC as dni
			FROM personal A
			WHERE A.DOC = '$doc'
			AND A.idestado = 1
			AND A.TIPO_PERSONAL = 'HUMANO'
			LIMIT 1
		";

		$res = mysql_query($sql);

		if (!$res || mysql_num_rows($res) == 0) {
			$objConx->desconectar();
			return array();
		}

		$row = mysql_fetch_assoc($res);

		unset($row['password']);

		$objConx->desconectar();

		return array($row);
	}

	public static function validarPassword($password)
	{
		return preg_match(
			'/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/',
			$password
		);
	}

	public static function updatePasswordByDocumento($doc, $password)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$doc = mysql_real_escape_string($doc);

		/* validar password */
		if (!self::validarPassword($password)) {
			$objConx->desconectar();
			return array(
				"ok" => false,
				"mensaje" => "La contraseña debe tener mínimo 8 caracteres, incluir mayúscula, minúscula, número y símbolo"
			);
		}

		$nuevoHash = password_hash($password, PASSWORD_BCRYPT);
		$nuevoHash = mysql_real_escape_string($nuevoHash);

		$sql = "
		UPDATE personal
		SET password = '$nuevoHash'
		WHERE DOC = '$doc'
		AND idestado = 1
		AND TIPO_PERSONAL = 'HUMANO'
		LIMIT 1
	";

		$res = mysql_query($sql);

		if (!$res) {
			error_log("MySQL Error updatePasswordByDocumento: " . mysql_error());
			$objConx->desconectar();

			return array(
				"ok" => false,
				"mensaje" => "Error al actualizar contraseña"
			);
		}

		$afectadas = mysql_affected_rows();

		$objConx->desconectar();

		if ($afectadas <= 0) {
			return array(
				"ok" => false,
				"mensaje" => "No se pudo actualizar la contraseña"
			);
		}

		return array(
			"ok" => true
		);
	}
}
