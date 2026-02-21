<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsUsuario
{

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
		$sql = "SELECT id,nombre FROM cargo order by nombre";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_distrito()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT codDistrito,distrito FROM ubigeo where departamento='LIMA' and provincia='LIMA'";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("codDistrito" => $row["codDistrito"], "distrito" => utf8_encode($row["distrito"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_ec()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM estado_civil order by id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_gi()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM grado_ins order by id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_sucursal()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT idsucursal as id,concat(sucursal,' | ',distrito) as nombre FROM sucursal order by idsucursal";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_horario()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "
			SELECT
				a.idhorario AS id,
				CONCAT(a.horainicio,'-',a.horafin,' | ',b.nombre,' | ',a.horario) AS nombre
			FROM horario a
			LEFT JOIN horario_dia b
				ON a.dias=b.id
			WHERE a.IDESTADO = 1
			ORDER BY idhorario
		";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}


	public static function consulta_usuario($id_cartera)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.IDPERSONAL as id,concat(a.APELLIDOS,', ',a.NOMBRES) as nombre FROM personal a where id_cartera=$id_cartera
				order by apellidos asc";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	// public static function registrar_empleado($APELLIDOS,$NOMBRES,$FECHANAC,$SEXO,$DOC,$ESTCIV,$CARFAM,$NUMHIJ,$DIRECCION,$DISTRITO,$DPTO,$REFDIR,$TLF,$CEL,$EMAIL,$GRADOINS,$CARGO,$IDSUCURSAL,$USUARIO,$PASSWORD,$cartera,$FECHAING) {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$fecha=date("Y-m-d H:i:s");

	// 	$sql = "
	// 		INSERT INTO personal (
	// 		APELLIDOS, NOMBRES, FECHANAC, SEXO, DOC, ESTCIV, CARFAM, NUMHIJ,
	// 		DIRECCION, DISTRITO, DPTO, REFDIR, TLF, CEL, EMAIL, GRADOINS, CARGO,
	// 		IDSUCURSAL, USUARIO, PASSWORD, IDESTADO, fecha_registro, fecha_baja,
	// 		id_cartera, api_token, fecha_ing, TIPO_PERSONAL, ANYDESK
	// 		) VALUES(
	// 		upper('$APELLIDOS'),upper('$NOMBRES'),'$FECHANAC','$SEXO','$DOC','$ESTCIV','$CARFAM','$NUMHIJ',
	// 		'$DIRECCION','$DISTRITO','$DPTO','$REFDIR','$TLF','$CEL','$EMAIL','$GRADOINS','$CARGO',
	// 		'$IDSUCURSAL',upper('$USUARIO'),md5('$PASSWORD'),1,'$fecha','0000-00-00',$cartera,null,'$FECHAING','HUMANO',null
	// 		)";
	// 	//echo($sql);
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	$res = mysql_insert_id();
	// 	$objConx->desconectar();
	// 	return $res;
	// }

	public static function registrar_empleado($APELLIDOS, $NOMBRES, $FECHANAC, $SEXO, $DOC, $ESTCIV, $CARFAM, $NUMHIJ, $DIRECCION, $DISTRITO, $DPTO, $REFDIR, $TLF, $CEL, $EMAIL, $GRADOINS, $CARGO, $IDSUCURSAL, $USUARIO, $PASSWORD, $cartera, $FECHAING)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");

		// (opcional) sanear para evitar problemas con comillas
		$APELLIDOS  = mysql_real_escape_string($APELLIDOS);
		$NOMBRES    = mysql_real_escape_string($NOMBRES);
		$FECHANAC   = mysql_real_escape_string($FECHANAC);
		$SEXO       = mysql_real_escape_string($SEXO);
		$DOC        = mysql_real_escape_string($DOC);
		$ESTCIV     = mysql_real_escape_string($ESTCIV);
		$CARFAM     = mysql_real_escape_string($CARFAM);
		$NUMHIJ     = mysql_real_escape_string($NUMHIJ);
		$DIRECCION  = mysql_real_escape_string($DIRECCION);
		$DISTRITO   = mysql_real_escape_string($DISTRITO);
		$DPTO       = mysql_real_escape_string($DPTO);
		$REFDIR     = mysql_real_escape_string($REFDIR);
		$TLF        = mysql_real_escape_string($TLF);
		$CEL        = mysql_real_escape_string($CEL);
		$EMAIL      = mysql_real_escape_string($EMAIL);
		$GRADOINS   = mysql_real_escape_string($GRADOINS);
		$CARGO      = mysql_real_escape_string($CARGO);
		$IDSUCURSAL = mysql_real_escape_string($IDSUCURSAL);
		$USUARIO    = mysql_real_escape_string($USUARIO);
		$PASSWORD   = mysql_real_escape_string($PASSWORD);
		$FECHAING   = mysql_real_escape_string($FECHAING);
		$cartera    = mysql_real_escape_string($cartera);

		// Si la tabla está vacía, empezará en 1001 (ajusta el 1000 si quieres otro base)
		mysql_query("SET @anexo := (SELECT COALESCE(MAX(ANEXO_BACKUP), 1000) + 1 FROM personal)") or die(mysql_error());

		$sql = "
			INSERT INTO personal (
				APELLIDOS, NOMBRES, FECHANAC, SEXO, DOC, ESTCIV, CARFAM, NUMHIJ,
				DIRECCION, DISTRITO, DPTO, REFDIR, TLF, CEL, EMAIL, GRADOINS, CARGO,
				IDSUCURSAL, USUARIO, PASSWORD, IDESTADO, fecha_registro, fecha_baja,
				id_cartera, api_token, fecha_ing, TIPO_PERSONAL, ANYDESK, ANEXO_BACKUP
			) VALUES (
				UPPER('$APELLIDOS'), UPPER('$NOMBRES'), '$FECHANAC', '$SEXO', '$DOC', '$ESTCIV', '$CARFAM', '$NUMHIJ',
				'$DIRECCION', '$DISTRITO', '$DPTO', '$REFDIR', '$TLF', '$CEL', '$EMAIL', '$GRADOINS', '$CARGO',
				'$IDSUCURSAL', UPPER('$USUARIO'), MD5('$PASSWORD'), 1, '$fecha', '0000-00-00',
				$cartera, NULL, '$FECHAING', 'HUMANO', NULL, @anexo
			)
		";
		$res = mysql_query($sql) or die(mysql_error());
		$id  = mysql_insert_id();

		mysql_query("UNLOCK TABLES") or die(mysql_error());

		$objConx->desconectar();
		return $id; // puedes luego consultar el anexo con este ID si lo necesitas
	}

	public static function registrar_item($id_horario, $id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "INSERT INTO horario_personal VALUES(default,$id_horario,$id)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
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

	// public static function baja_user($id)
	// {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$fecha = date("Y-m-d H:i:s");
	// 	$sql = "UPDATE personal set fecha_baja='$fecha',idestado=0 where idpersonal='$id'";
	// 	//echo($sql);
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	$res = mysql_insert_id();
	// 	$objConx->desconectar();
	// 	return $res;
	// }

	public static function baja_user($id, $idUsuarioModifica)
	{
		$objConx = new clsConexion();
		$objConx->conectar(); // activa la conexión por defecto

		// Variable de sesión para el trigger (misma conexión por defecto)
		$idUsuarioModifica = (int)$idUsuarioModifica;
		mysql_query("SET @id_usuario_modifica := {$idUsuarioModifica}") or die(mysql_error());

		$fecha = date("Y-m-d H:i:s");
		$sql = "UPDATE personal SET fecha_baja='{$fecha}', idestado=0 WHERE idpersonal='{$id}'";

		// Ejecutar el UPDATE usando la conexión por defecto
		$res = mysql_query($sql) or die(mysql_error());

		// Mantengo tu return
		$res = mysql_insert_id();

		$objConx->desconectar();
		return $res;
	}

	public static function acceso($usuario, $pass)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT idpersonal,concat(nombres,' ',apellidos) as empleado,usuario,C.nombre as tipo 
				FROM personal A left join cargo C on C.id=A.cargo
				where A.usuario='$usuario' and A.password=md5('$pass') and A.idestado=1";
		//echo $sql;
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function verificar_sesion($id_usuario)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "select * from login 
				where id_user='$id_usuario' 
				 and date(fecha)= date('$fecha')
				";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
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
		$sql = "select * from personal where doc='$dni' ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= funcion para verificar el DNI =============================================

	public static function verificar_dni_update($dni, $user)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from personal where doc='$dni' and idpersonal=$user";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= funcion para verificar el user =============================================

	public static function verificar_nombre_user($user)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from personal where usuario=UPPER('$user')";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= funcion para verificar el password =============================================

	public static function verificar_password($password, $id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from personal where password='$password' and idpersonal=$id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// ============================================= funcion para listar los usuarios =============================================

	public static function listar_user()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT CONCAT(YEAR(b.fecha_registro),'-', LPAD(b.idpersonal,5,'0') ) as idpersonal,concat(nombres,' ',apellidos) as empleado,b.DOC as dni,b.password,usuario as user,c.nombre as tipo,car.cartera AS cartera, if(IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones FROM personal b left join cargo c on c.id=b.CARGO LEFT JOIN cartera car ON b.id_cartera=car.id order by b.IDPERSONAL desc";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array($row["idpersonal"], utf8_encode($row["empleado"]), $row["dni"], utf8_encode($row["password"]), utf8_encode($row["user"]), $row["tipo"], $row["cartera"], $row["estado"], $row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	// ============================================= FUNCION PARA EXPORTAR A EXCEL =============================================

	public static function excel()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT CONCAT(YEAR(b.fecha_registro),'-', LPAD(b.idpersonal,5,'0') ) as idpersonal,concat(nombres,' ',apellidos) as empleado,
					FECHANAC, if(SEXO=1,'M','F') as sexo ,b.DOC as dni, d.nombre as ESTCIV,CARFAM,NUMHIJ,b.DIRECCION,b.DISTRITO,b.DPTO,b.REFDIR,
					b.TLF,b.CEL,b.EMAIL,e.nombre as GRADOINS,c.nombre as CARGO,
					f.SUCURSAL as sucursal,usuario as user,b.fecha_registro,
					if(b.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado, car.cartera
					FROM personal b 
					left join cargo c on c.id=b.CARGO
					left join estado_civil d on d.id=b.ESTCIV
					left join grado_ins e on e.id=b.GRADOINS
					left join sucursal f on f.IDSUCURSAL=b.IDSUCURSAL
					left join cartera car on car.id = b.id_cartera        
					order by 2 asc
		";

		// $sql = "SELECT CONCAT(YEAR(fecha_registro),'-', LPAD(b.idpersonal,5,'0') ) as idpersonal,concat(nombres,' ',apellidos) as empleado,FECHANAC, if(SEXO=1,'M','F') as sexo ,b.DOC as dni, d.nombre as ESTCIV,CARFAM,NUMHIJ,b.DIRECCION,b.DISTRITO,b.DPTO,b.REFDIR,b.TLF,b.CEL,b.EMAIL,e.nombre as GRADOINS,c.nombre as CARGO,
		//     f.SUCURSAL as sucursal,usuario as user,fecha_registro,
		//     if(b.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado
		//     FROM personal b 
		//     left join cargo c on c.id=b.CARGO
		//     left join estado_civil d on d.id=b.ESTCIV
		//     left join grado_ins e on e.id=b.GRADOINS
		//     left join sucursal f on f.IDSUCURSAL=b.IDSUCURSAL
		//     order by b.IDPERSONAL desc
		// ";

		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array(utf8_encode($row["idpersonal"]), utf8_encode($row["empleado"]), utf8_encode($row["FECHANAC"]), utf8_encode($row["sexo"]), utf8_encode($row["dni"]), utf8_encode($row["ESTCIV"]), utf8_encode($row["CARFAM"]), utf8_encode($row["NUMHIJ"]), utf8_encode($row["DIRECCION"]), utf8_encode($row["DISTRITO"]), utf8_encode($row["DPTO"]), utf8_encode($row["REFDIR"]), utf8_encode($row["TLF"]), utf8_encode($row["CEL"]), utf8_encode($row["EMAIL"]), utf8_encode($row["GRADOINS"]), utf8_encode($row["CARGO"]), utf8_encode($row["sucursal"]), utf8_encode($row["user"]), utf8_encode($row["fecha_registro"]), utf8_encode($row["estado"]), utf8_encode($row["cartera"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	// =============================================  FUNCION PARA LISTAR USUARIOS ONLINE =============================================

	public static function listar_user_online()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d");
		$sql = "SELECT distinct usuario as user,ut.nombre as tipo from login ll
				left join personal uu on uu.idpersonal=ll.id_user
				left join cargo ut on uu.cargo=ut.id 
				where ll.tipo='IN' and date(ll.fecha)= date('$fecha')
				order by uu.usuario desc";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array(utf8_encode($row["user"]), utf8_encode($row["tipo"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	// =============================================  FUNCION PARA LISTAR USUARIO POR ID =============================================

	public static function select_user($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from personal
			a left join ubigeo b on a.DPTO=b.departamento and a.DISTRITO=b.distrito
		WHERE idpersonal = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// =============================================  FUNCION PARA MOSTRAR HORARIO POR ID USUARIO =============================================

	public static function select_detalle($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT idhorario,id 
		from horario_personal 
		WHERE idpersonal = $id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	// =============================================  FUNCION PARA ACTUALIZAR USUARIO =============================================

	// public static function update_empleado($id, $estado, $APELLIDOS, $NOMBRES, $FECHANAC, $SEXO, $DOC, $ESTCIV, $CARFAM, $NUMHIJ, $DIRECCION, $DISTRITO, $DPTO, $REFDIR, $TLF, $CEL, $EMAIL, $GRADOINS, $CARGO, $IDSUCURSAL, $USUARIO, $PASSWORD, $cartera, $FECHAING, $FECHABAJA)
	// {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$fecha = date("Y-m-d H:i:s");
	// 	if ($PASSWORD == "SI") {
	// 		$sql = "UPDATE personal set IDESTADO=$estado,APELLIDOS=upper('$APELLIDOS'),NOMBRES=upper('$NOMBRES'),FECHANAC='$FECHANAC',SEXO='$SEXO',DOC='$DOC',ESTCIV=$ESTCIV,CARFAM='$CARFAM',NUMHIJ=$NUMHIJ,DIRECCION='$DIRECCION',DISTRITO='$DISTRITO',DPTO='$DPTO',REFDIR='$REFDIR',TLF='$TLF',CEL='$CEL',EMAIL='$EMAIL',GRADOINS='$GRADOINS',CARGO=$CARGO,IDSUCURSAL=$IDSUCURSAL,USUARIO='$USUARIO',fecha_baja='$FECHABAJA',id_cartera=$cartera,fecha_ing='$FECHAING' WHERE idpersonal =$id";
	// 	} else {
	// 		$sql = "UPDATE personal set IDESTADO=$estado,APELLIDOS=upper('$APELLIDOS'),NOMBRES=upper('$NOMBRES'),FECHANAC='$FECHANAC',SEXO='$SEXO',DOC='$DOC',ESTCIV=$ESTCIV,CARFAM='$CARFAM',NUMHIJ=$NUMHIJ,DIRECCION='$DIRECCION',DISTRITO='$DISTRITO',DPTO='$DPTO',REFDIR='$REFDIR',TLF='$TLF',CEL='$CEL',EMAIL='$EMAIL',GRADOINS='$GRADOINS',CARGO=$CARGO,IDSUCURSAL=$IDSUCURSAL,USUARIO='$USUARIO',PASSWORD=md5('$PASSWORD'),fecha_baja='$FECHABAJA',id_cartera=$cartera,fecha_ing='$FECHAING'  WHERE idpersonal =$id";
	// 	}
	// 	//echo($sql);
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	$res = mysql_insert_id();
	// 	$objConx->desconectar();
	// 	return $res;
	// }

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
		$FECHAING,
		$FECHABAJA,
		$idUsuarioModifica
	) {
		$objConx = new clsConexion();
		$objConx->conectar(); // activa la conexión por defecto

		// Variable de sesión para el trigger (misma conexión por defecto)
		$idUsuarioModifica = (int)$idUsuarioModifica;
		mysql_query("SET @id_usuario_modifica := {$idUsuarioModifica}") or die(mysql_error());

		$fecha = date("Y-m-d H:i:s");

		if ($PASSWORD == "SI") {
			$sql = "UPDATE personal SET IDESTADO=$estado, APELLIDOS=upper('$APELLIDOS'), NOMBRES=upper('$NOMBRES'),
            FECHANAC='$FECHANAC', SEXO='$SEXO', DOC='$DOC', ESTCIV=$ESTCIV, CARFAM='$CARFAM', NUMHIJ=$NUMHIJ,
            DIRECCION='$DIRECCION', DISTRITO='$DISTRITO', DPTO='$DPTO', REFDIR='$REFDIR', TLF='$TLF',
            CEL='$CEL', EMAIL='$EMAIL', GRADOINS='$GRADOINS', CARGO=$CARGO, IDSUCURSAL=$IDSUCURSAL,
            USUARIO='$USUARIO', fecha_baja='$FECHABAJA', id_cartera=$cartera, fecha_ing='$FECHAING'
            WHERE idpersonal =$id";
		} else {
			$sql = "UPDATE personal SET IDESTADO=$estado, APELLIDOS=upper('$APELLIDOS'), NOMBRES=upper('$NOMBRES'),
            FECHANAC='$FECHANAC', SEXO='$SEXO', DOC='$DOC', ESTCIV=$ESTCIV, CARFAM='$CARFAM', NUMHIJ=$NUMHIJ,
            DIRECCION='$DIRECCION', DISTRITO='$DISTRITO', DPTO='$DPTO', REFDIR='$REFDIR', TLF='$TLF',
            CEL='$CEL', EMAIL='$EMAIL', GRADOINS='$GRADOINS', CARGO=$CARGO, IDSUCURSAL=$IDSUCURSAL,
            USUARIO='$USUARIO', PASSWORD=md5('$PASSWORD'), fecha_baja='$FECHABAJA', id_cartera=$cartera,
            fecha_ing='$FECHAING' WHERE idpersonal =$id";
		}

		// Ejecutar el UPDATE usando la conexión por defecto
		$res = mysql_query($sql) or die(mysql_error());

		// Mantengo tu return
		$res = mysql_insert_id();

		$objConx->desconectar();
		return $res;
	}
}
