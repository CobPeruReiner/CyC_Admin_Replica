<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsEfecto{
	
	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.*,b.ACCION,c.CATEGORIA,if(a.idestado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones 
					FROM efecto a
			left join accion b on a.IDACCION=b.IDACCION
			left join categoria c on a.IDCATEGORIA=c.IDCATEGORIA";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["IDEFECTO"],utf8_encode($row["EFECTO"]),utf8_encode($row["ACCION"]),utf8_encode($row["CATEGORIA"]),utf8_encode($row["DESCRIPCION"]),$row["estado"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function registrar ($nombre,$accion,$categoria,$homologo,$descripcion,$peso,$promesa) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO efecto VALUES(default,upper('$nombre'),$accion,$categoria,'$homologo','$descripcion','$peso',1,$promesa)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function select_efecto($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from efecto WHERE IDEFECTO = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function update_efecto($id,$efecto,$accion,$categoria,$homolo,$DESCRIPCION,$peso,$IDESTADO,$promesa) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE efecto set 
        		efecto=upper('$efecto'),
        		idaccion='$accion',
        		idcategoria='$categoria',
        		homolo='$homolo',
        		DESCRIPCION='$DESCRIPCION',
        		peso='$peso',
        		IDESTADO='$IDESTADO',
        		promesa=$promesa 
        		WHERE IDEFECTO =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function consulta_accion(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT idaccion as id,accion as nombre from accion where idestado=1 order by nombre";
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
	
	public static function consulta_categoria(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT idcategoria as id,categoria as nombre from categoria where idestado=1 order by nombre";
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
		$sql = "UPDATE efecto set idestado=0 where IDEFECTO='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}	

		

}
?>