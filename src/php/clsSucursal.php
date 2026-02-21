<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsSucursal{


	public static function registrar($nombre,$distrito,$departamento,$direccion,$telefono) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO sucursal (IDSUCURSAL,SUCURSAL,DISTRITO,DPTO,DIRECCION,TLF,IDESTADO) VALUES (default,UPPER('$nombre'),UPPER('$distrito'),UPPER('$departamento'),'$direccion','$telefono',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	

	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT *,if(IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones from sucursal ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["IDSUCURSAL"],utf8_encode($row["SUCURSAL"]),$row["DISTRITO"],$row["DIRECCION"],$row["TLF"],$row["estado"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	
	public static function select($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * FROM sucursal a left join ubigeo b on a.DPTO=b.departamento and a.DISTRITO=b.distrito
			WHERE a.IDSUCURSAL = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function update($id,$nombre,$distrito,$departamento,$direccion,$telefono,$estado) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE sucursal set sucursal=UPPER('$nombre'),distrito=UPPER('$distrito'),dpto=UPPER('$departamento'),direccion='$direccion',tlf='$telefono',idestado='$estado' WHERE IDSUCURSAL =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function departamentos(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT codDepartamento as id,upper(departamento) as nombre FROM ubigeo where codDepartamento!=0 group by  codDepartamento order by departamento asc";
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
	
	public static function provincias($id){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT concat(codDepartamento,'|',codProvincia) as id,upper(provincia) as nombre FROM ubigeo where codDepartamento=$id group by codProvincia order by provincia asc";
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
	
	public static function distritos($id,$id2){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT concat(codDepartamento,'|',codProvincia,'|',codDistrito) as id,upper(distrito) as nombre FROM ubigeo where codDepartamento=$id and codProvincia=$id2 group by codDistrito order by distrito asc";
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
	
	public static function baja($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE sucursal set idestado=0 where idsucursal='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}	


}
?>