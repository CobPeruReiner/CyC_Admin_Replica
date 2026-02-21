<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";

class clsTable{
	
	public static function carteras(){
		$objConx = new clsConexion();
		$objConx->conectar();
		// $sql = "SELECT a.id,upper(concat(a.cartera,': ',c.nombre,'_',REPLACE(b.nombre,' ','_'))) as nombre FROM cartera a left join cliente b on a.idcliente=b.id left join tipo_cartera c on c.id=a.tipo where a.estado=1";
		$sql = "SELECT
		a.id,
		upper(concat(a.cartera,': ',REPLACE(b.nombre,' ','_'))) as nombre
		FROM cartera a
		left join cliente b on a.idcliente=b.id
		where a.estado=1
		ORDER BY nombre";
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
	
	
	public static function registrar_log($nombre,$cartera,$usuario) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "INSERT INTO tabla_log (id,nombre,id_cartera,fecha_registro,user_registro) VALUES (default,'$nombre','$cartera','$fecha','$usuario')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function registrar_asignacion($id_tabla,$id_usuario) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "INSERT INTO asignacion_tabla (id_tabla,id_usuario,fecha) VALUES ('$id_tabla','$id_usuario','$fecha')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function eliminar_asignacion($id_tabla) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "delete from asignacion_tabla where id_tabla = $id_tabla";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$objConx->desconectar();
		return $res;
	}
	
	public static function crear_tabla($nombre) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "CREATE TABLE IF NOT EXISTS $nombre (
					id INT AUTO_INCREMENT PRIMARY KEY,
					identificador varchar(50)
				)  ENGINE=INNODB;";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function agregar_campo($nombre,$campo,$tipo) {
		$objConx = new clsConexion();
		$objConx->conectar();
		if ($tipo==1){
		    $tipo="varchar(50)";
		}elseif($tipo==2){
		     $tipo="varchar(400)";
		}elseif($tipo==3){
		     $tipo="date";
		}elseif($tipo==4){
		     $tipo="datetime";
		}elseif($tipo==5){
		     $tipo="time";
		}elseif($tipo==6){
		     $tipo="int";
		}else{
		     $tipo="decimal(16,2)";
		}
		
    	$sql = "ALTER TABLE $nombre
	        	ADD COLUMN $campo $tipo ; ";
		
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	
	public static function agregar_key($nombre,$campo) {
		$objConx = new clsConexion();
		$objConx->conectar();
    	$sql = "alter table $nombre add index $campo ($campo); ";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	
	public static function update_ruta($id,$ruta) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE tabla_log set ruta='$ruta' WHERE id =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	
	public static function update_asigna($id,$asigna) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE tabla_log set asignacion='$asigna' WHERE id =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT c.*,concat(apellidos,', ',nombres) as usuario,'' as opciones,concat(if(estado=0,'<label>NO</label>','<label>SI</label>'), ' ',if(ruta='','','<i class=icon-file-excel></i>') ) as estado FROM tabla_log c left join personal a on c.user_registro=a.IDPERSONAL
				 ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
		
			  $arr_datos[] = array($row["id"],utf8_encode($row["nombre"]),$row["fecha_registro"],utf8_encode($row["usuario"]),utf8_encode($row["estado"]),$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	

	public static function select($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from tabla_log WHERE id = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	
	public static function select_asignacion($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from asignacion_tabla WHERE id_tabla = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos[] = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
		
		
		
	}
	
	public static function describe_table($nombre) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "describe $nombre";
		//echo $sql;
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("field"=>$row["Field"],"type"=>utf8_encode($row["Type"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
		public static function recupera_table($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from gui_table WHERE id_table = $id ";
		//echo $sql;
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("campo"=>$row["campo"],"gui"=>utf8_encode($row["gui"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

	public static function actualizar_estado($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE tabla_log set estado=1 where id='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function agregar_gui($id,$nombre,$gui) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		
    	$sql = "INSERT INTO gui_table (id,id_table,campo,gui) VALUES (default,'$id','$nombre','$gui')";
		
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function eliminar_gui($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "delete from gui_table where id_table='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	
	public static function verificar_tabla($id){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "select * from tabla_log where id=$id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}
    
    public static function registrar_log_duplicado($usuario,$id_table) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$fecha2=date("Ymd_His");	
		$sql = "INSERT INTO tabla_log (nombre,fecha_registro,user_registro,id_cartera) select  replace(nombre,SUBSTRING_INDEX(nombre, '_', -2),'$fecha2'),'$fecha','$usuario',id_cartera from tabla_log where id=$id_table";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	
	public static function create_duplicado($destino,$origen) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "CREATE TABLE IF NOT EXISTS $destino LIKE $origen ";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function eliminar_registro($tabla,$texto) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "delete from $tabla where identificador in ($texto)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$objConx->desconectar();
		return $res;
	}
	

}
?>