<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsMapa{
	
	public static function carteras(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.id,upper(concat(a.cartera,': ',b.nombre)) as nombre FROM cartera a
				left join cliente b on a.idcliente=b.id
				where a.estado=1 ";
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
	
	
	public static function registrar($cartera,$identificador,$dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8,$dato9,$dato10) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO infoadicional (IDINFOADI,FECHAREG,IDCARTERA,IDENTIFICADOR,DATO1,DATO2,DATO3,DATO4,DATO5,DATO6,DATO7,DATO8,DATO9,DATO10,IDESTADO) VALUES (default,'$fecha',$cartera,'$identificador','$dato1','$dato2','$dato3','$dato4','$dato5','$dato6','$dato7','$dato8','$dato9','$dato10',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function update($ID,$cartera,$identificador,$dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8,$dato9,$dato10,$idestado) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE infoadicional set IDCARTERA='$cartera',IDENTIFICADOR='$identificador',DATO1='$dato1',DATO2='$dato2',DATO3='$dato3',DATO4='$dato4',DATO5='$dato5',DATO6='$dato6',DATO7='$dato7',DATO8='$dato8',DATO9='$dato9',DATO10='$dato10',IDESTADO='$idestado' WHERE IDINFOADI  =$ID";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	

	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT *,
				if(idestado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones 
				FROM google_maps_php_mysql
				 ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
		
			  $arr_datos[] = array($row["id"],utf8_encode($row["nombre"]),utf8_encode($row["direccion"]),utf8_encode($row["lat"]),utf8_encode($row["lng"]),$row["estado"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	

	public static function select($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from infoadicional
			 WHERE IDINFOADI = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	
	
	public static function baja($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE infoadicional set IDESTADO=0 where IDINFOADI='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}	


}
?>