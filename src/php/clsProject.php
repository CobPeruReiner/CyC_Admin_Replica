<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsProject{
	
	public static function consulta_clientes(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM cliente where estado_activo=1 order by nombre ";
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

	public static function consulta_auditores(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT concat(a.nombres,' ',apellidoPat,' ',apellidoMat) as nombre_completo,a.id FROM empleado a inner join user b on a.iduser=b.id where b.estado_activo=1 order by nombre_completo ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("id"=>$row["id"],"nombre_completo"=>utf8_encode($row["nombre_completo"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}  

	public static function select_project($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.id,consulting,date(a.fecha_inicio) as fecha_inicio,date(a.fecha_fin) as fecha_fin,a.normas,a.plazo,c.nombre as sub_elemento,date(b.fecha_inicio) as fecha_inicio_e,date(b.fecha_fin) as fecha_fin_e,b.id_elemento as id_subelemento,d.nombre as elemento,d.id as id_elemento,e.nombre as cliente,b.estado as estado_e
				from amvproject a 
				inner join detalle_project b on a.id=b.id_project
				inner join sub_elemento_pep c on c.id=b.id_elemento
				inner join elemento_pep d on d.id=c.id_elemento
				inner join cliente e on e.id=a.cliente
				where d.estado_activo=1 and c.estado_activo=1 and a.id = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id"=>$row["id"],"consulting"=>utf8_encode($row["consulting"]),"sub_elemento"=>utf8_encode($row["sub_elemento"]),"elemento"=>utf8_encode($row["elemento"]),"id_elemento"=>$row["id_elemento"],"id_subelemento"=>$row["id_subelemento"],"cliente"=>utf8_encode($row["cliente"]),"fecha_inicio"=>$row["fecha_inicio"],"fecha_fin"=>$row["fecha_fin"],"normas"=>utf8_encode($row["normas"]),"plazo"=>$row["plazo"],"fecha_inicio_e"=>$row["fecha_inicio_e"],"fecha_fin_e"=>$row["fecha_fin_e"],"estado_e"=>$row["estado_e"]);		
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

	public static function listar_project() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT A.id,consulting,B.nombre as cliente,date(fecha_inicio) as fecha_inicio,concat('<label>',date(fecha_fin),'</label>') as fecha_fin,normas,plazo,'' as opciones FROM amvproject A inner join cliente B on A.cliente=B.id";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["id"],utf8_encode($row["consulting"]),utf8_encode($row["cliente"]),$row["fecha_inicio"],$row["fecha_fin"],utf8_encode($row["normas"]),$row["plazo"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

	public static function registrar($consulting,$cliente,$fecha_inicio,$fecha_fin,$normas,$plazo,$auditor) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO amvproject (consulting,cliente,fecha_inicio,fecha_fin,normas,plazo,auditor,fecha_registro) VALUES('$consulting','$cliente','$fecha_inicio','$fecha_fin','$normas','$plazo','$auditor','$fecha')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;  
	}

	public static function registrar_elemento($id_elemento,$id_project) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "INSERT INTO detalle_project (id_elemento,id_project,estado) VALUES($id_elemento,'$id_project','PENDIENTE')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function update($id_project,$id,$fecha_inicio,$fecha_fin,$estado) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE detalle_project set fecha_inicio='$fecha_inicio',fecha_fin='$fecha_fin',estado=upper('$estado') where id_project=$id_project and id_elemento=$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
}

?>