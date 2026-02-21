<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsDashboard{


public static function gestiones_ctd(){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
// 		$sql = "select count(1) as ctd, date(max(fecha_tmk)) as fecha_max, time(max(fecha_tmk)) as hora_max, (select count(1) as ctd from gestion_tmk where year(fecha_tmk)=year('$fecha') and month(fecha_tmk)=month('$fecha')) as ctd_mes
// from gestion_tmk ";
		// $sql = "SELECT 200483941 AS ctd, STR_TO_DATE('2024-12-03', '%Y-%m-%d') AS fecha_max, TIME('16:04:13') AS hora_max, 3536445 AS ctd_mes";
		$sql = "SELECT 'bienvenidos'";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
}


public static function dashboard($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "SELECT usuario as user,password,b.fecha FROM personal a 
				inner join login b on a.IDPERSONAL=b.id_user
				where date(b.fecha)=date('$fecha') and b.id_user=$id
				order by b.fecha desc
				limit 1";
		
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array(utf8_encode($row["user"]),utf8_encode($row["password"]),$row["fecha"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

public static function contadores() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "select count(1) as cantidad,'LogeoMes' as nombre from login 
				where tipo='IN' and year(fecha)=year('$fecha') and month(fecha)=month('$fecha')
				union 
			   	select count(1) as cantidad,'Usuarios' from personal
				where IDESTADO=1
				union
				select count(1) as cantidad,'LogeoAno' from login 
				where tipo='IN' and year(fecha)=year('$fecha')
		";
		$res = mysql_query($sql) or die(mysql_error());
		
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["cantidad"],$row["nombre"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

public static function logeos_hh() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "select distinct x.horario,IFNULL(cantidad,0) as cantidad from (select a.horario from horas a cross join login) as x left join ( select DATE_FORMAT(fecha,'%H:00') as horario,count(1) as cantidad from login where tipo='IN' and year(fecha)=year('$fecha') and month(fecha)=month('$fecha')
			group by DATE_FORMAT(fecha,'%H:00') ) as y on x.horario=y.horario
	        order by  x.horario asc
	        limit 24";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["horario"],$row["cantidad"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

public static function ultimos_ficheros() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "
	select DATE_FORMAT(fecha,'%d/%m/%y') as fecha,sum(alpha) as alpha from ( 
        		SELECT cast(fecha_registro as date) as fecha,count(1) as alpha 
				FROM contacto_beta where year(fecha_registro)=year('$fecha') 
        		group by cast(fecha_registro as date) 
				UNION 
        		SELECT cast(fecha_registro as date) as fecha2,count(1) as alpha2
        		FROM unete 
				where year(fecha_registro)=year('$fecha')
        		group by cast(fecha_registro as date) 
        		UNION 
        		SELECT cast(fecha_carga as date) as fecha3,count(1) as alpha3 
        		FROM libro_reclamo 
				where year(fecha_carga)=year('$fecha')
        		group by cast(fecha_carga as date) 
    )as t
    group by fecha
    order by  cast(fecha as date) DESC
    limit 7
				";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["fecha"],$row["alpha"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}


}

?>