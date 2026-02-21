<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";

class clsCarga{

		public static function listar_excel($f_inicio,$f_fin) {
			$objConx = new clsConexion();
			$objConx->conectar();
			$sql = "
			select a.telefono,a.documento,a.nombres,a.fecha_nac,a.departamento,a.provincia,a.distrito,a.direccion,a.referencia,a.tel_referencia,a.plan,a.ciclo,a.vendedor,a.fecha_tmk,a.hora_tmk,a.folio,a.email,a.tipo,
					case when id_estado=1 then '<label>Generado</label>'
												  when id_estado=2 then '<label>Asignado</label>'
												  when id_estado=3 then '<label>En Análisis</label>'
												  else '<label>Concluido</label>' end as estado_nombre,
												  b.user,a.fecha_asignacion,a.fecha_analisis,a.fecha_concluido,a.num_sec,a.estado1,a.estado2,a.afiliacion,a.observacion,TIMEDIFF(fecha_concluido,fecha_asignacion) as trans
					from carga_tmk a
					left join user b on a.id_user=b.id 
			where date(fecha_tmk) between '$f_inicio' and '$f_fin'
			";
			$res = mysql_query($sql) or die(mysql_error());
			//echo($sql);
			$arr_datos = array();
			while($row = mysql_fetch_array($res)) {
				  
				  $arr_datos[] = array($row["telefono"],utf8_encode($row["documento"]),utf8_encode($row["nombres"]),utf8_encode($row["fecha_nac"]),utf8_encode($row["departamento"]),utf8_encode($row["provincia"]),utf8_encode($row["distrito"]),utf8_encode($row["direccion"]),utf8_encode($row["referencia"]),utf8_encode($row["tel_referencia"]),utf8_encode($row["plan"]),utf8_encode($row["ciclo"]),utf8_encode($row["vendedor"]),utf8_encode($row["fecha_tmk"]),utf8_encode($row["hora_tmk"]),utf8_encode($row["folio"]),utf8_encode($row["email"]),utf8_encode($row["tipo"]),utf8_encode($row["estado_nombre"]),utf8_encode($row["user"]),utf8_encode($row["fecha_asignacion"]),utf8_encode($row["fecha_analisis"]),utf8_encode($row["fecha_concluido"]),utf8_encode($row["trans"]),utf8_encode($row["num_sec"]),utf8_encode($row["estado1"]),utf8_encode($row["estado2"]),utf8_encode($row["afiliacion"]),htmlentities($row["observacion"],ENT_COMPAT,'ISO-8859-1'));
				  
				  
			}
			$objConx->desconectar();
			if ($res)
			return $arr_datos;
			return $res;
	}
	

	public static function listar_cargas($tipo){
			$objConx = new clsConexion();
			$objConx->conectar();
			$fecha=date("Y-m");
			$sql = "
					SELECT *,CONCAT(ELT(WEEKDAY(fecha_carga) + 1, 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES','VIERNES', 'SABADO', 'DOMINGO')) as dia,
					TIMEDIFF(fecha_fin,fecha_carga) as trans
					FROM carga_log
					where tipo='$tipo'
					order by id desc
					limit 100
			";
			$res = mysql_query($sql) or die(mysql_error());
			//echo($sql);
			$arr_datos = array();

			while($row = mysql_fetch_array($res)) {
				  
				  $arr_datos[] = array($row["id"],$row["fecha_modificacion"],$row["fecha_carga"],$row["fecha_fin"],$row["trans"],$row["registrados"],$row["actualizados"],$row["errores"],$row["dia"]);
			}
			$objConx->desconectar();
			if ($res)
			return $arr_datos;
			return $res;
	}


}

?>