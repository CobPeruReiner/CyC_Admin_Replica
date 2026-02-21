<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsMenu{
	
	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.id,a.nombre,concat('<i class=',a.icono,'></i>') as icono,if(a.estado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,
				GROUP_CONCAT(concat(b.nombre,' ',if(b.estado=1,'<sub class=text-primary-300>ACTIVE</sub>','<sub class=text-danger-300>SUSPENDED</sub>')) SEPARATOR '</br>') as submenu
				,'' as opciones 
				from menu a 
				left join submenu b on a.id=b.id_menu
				GROUP BY a.nombre ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["id"],utf8_encode($row["nombre"]),utf8_encode($row["icono"]),$row["estado"],utf8_encode($row["submenu"]),$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function registrar($nombre,$icono) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "INSERT INTO menu VALUES(default,upper('$nombre'),'$icono',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function registrar_submenu($id,$nombre) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$minuscula=strtolower($nombre);
		$sql = "INSERT INTO submenu VALUES(default,'$id',upper('$nombre'),'datatable_$minuscula.php',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function listar_menu() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m");
		$sql = "SELECT id,lower(nombre) as nombre,icono FROM menu
				where estado=1
				GROUP by nombre 
				";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();

		while($row = mysql_fetch_array($res)) {
			  
			  $arr_datos[] = array($row["id"],utf8_encode($row["nombre"]),$row["icono"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function listar_submenu($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,lower(nombre) as nombre,url from submenu where estado=1 and id_menu=$id ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array($row["nombre"],$row["url"],$row["id"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function consulta_icono(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,ico as nombre FROM icono order by nombre";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("id"=>$row["id"],"nombre"=>utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	} 
	
	public static function active_menu($url){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT url, lower(b.nombre) as nombre FROM submenu a
				LEFT JOIN menu b ON a.id_menu = b.id
				WHERE url = '$url'
				AND b.estado =1";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array($row["nombre"],$row["url"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function select_menu($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from menu WHERE id = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function select_submenu($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre,url,estado,id_menu from submenu WHERE id_menu = $id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function modificar_menu($id,$nombre,$icono,$estado) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE menu set nombre=upper('$nombre'),icono='$icono',estado='$estado' where id='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function modificar_submenu($id,$nombre,$url) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE submenu set nombre=upper('$nombre'),url='$url' where id=$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function modificar_submenu_estado($id,$estado) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE submenu set estado='$estado' where id=$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function modificar_submenu_estado_cero($id,$estado) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE submenu set estado='$estado' where id_menu=$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

}
?>