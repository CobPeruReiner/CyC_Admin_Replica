<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";

class clsGestion{
	
	
	public static function excel2($f_inicio,$f_fin,$cliente) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT
fecha_tmk,x.nombre as cliente,d.cartera,a.IDENTIFICADOR,a.NOMCONTACTO,j.ACCION accion,e.EFECTO as efecto,f.MOTIVO as motivo,e.peso as peso,k.CATEGORIA as categoria, g.CONTACTO as contacto, a.OBSERVACION as observacion,
i.NUMERO as telefono,concat( h.DIRECCION,' ',h.DEPARTAMENTO,'/',h.PROVINCIA,'/',h.DISTRITO)  as direccion, b.USUARIO as gestor,a.PISOS as pisos, a.PUERTA as puerta,a.FACHADA as fachada,a.fecha_promesa as fecha_promesa, a.monto_promesa as monto_promesa
FROM gestion_tmk a 
LEFT JOIN personal b on a.IDPERSONAL=b.IDPERSONAL 
left join tabla_log c on c.id=a.id_table 
left join cartera d on d.id=c.id_cartera 
left join cliente x on x.id=d.idcliente
left join efecto e on e.IDEFECTO=a.IDEFECTO 
left join motivo f on f.IDMOTIVO=a.IDMOTIVO 
left join contacto g on g.IDCONTACTO=a.IDCONTACTO
left join direcciones h on h.IDDIRECCION=a.IDDIRECCION
left join telefonos i on i.IDTELEFONO=a.IDTELEFONO
left join accion j on j.IDACCION=e.IDACCION
left join categoria k on k.IDCATEGORIA=e.IDCATEGORIA
where date(fecha_tmk)  between '$f_inicio' and '$f_fin'

		";
		if ($cliente>=1){
		    	$sql=	$sql." and x.id=$cliente";
		}
		$res = mysql_query($sql) or die(mysql_error());
		echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array(utf8_encode($row["fecha_tmk"]),utf8_encode($row["cliente"]),utf8_encode($row["cartera"]),utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["NOMCONTACTO"]),utf8_encode($row["accion"]),utf8_encode($row["efecto"]),utf8_encode($row["motivo"]),utf8_encode($row["peso"]),utf8_encode($row["categoria"]),utf8_encode($row["contacto"]),utf8_encode($row["observacion"]),utf8_encode($row["telefono"]),utf8_encode($row["direccion"]),utf8_encode($row["gestor"]),utf8_encode($row["pisos"]),utf8_encode($row["puerta"]),utf8_encode($row["fachada"]),utf8_encode($row["fecha_promesa"]),utf8_encode($row["monto_promesa"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function excel($f_inicio,$f_fin,$cuenta) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT
fecha_tmk,d.cartera,a.IDENTIFICADOR,a.NOMCONTACTO,j.ACCION accion,e.EFECTO as efecto,f.MOTIVO as motivo,e.peso as peso,k.CATEGORIA as categoria, g.CONTACTO as contacto, a.OBSERVACION as observacion,
i.NUMERO as telefono,concat( h.DIRECCION,' ',h.DEPARTAMENTO,'/',h.PROVINCIA,'/',h.DISTRITO)  as direccion, b.USUARIO as gestor,a.PISOS as pisos, a.PUERTA as puerta,a.FACHADA as fachada,a.fecha_promesa as fecha_promesa, a.monto_promesa as monto_promesa
FROM gestion_tmk a 
LEFT JOIN personal b on a.IDPERSONAL=b.IDPERSONAL 
left join tabla_log c on c.id=a.id_table 
left join cartera d on d.id=c.id_cartera 
left join efecto e on e.IDEFECTO=a.IDEFECTO 
left join motivo f on f.IDMOTIVO=a.IDMOTIVO 
left join contacto g on g.IDCONTACTO=a.IDCONTACTO
left join direcciones h on h.IDDIRECCION=a.IDDIRECCION
left join telefonos i on i.IDTELEFONO=a.IDTELEFONO
left join accion j on j.IDACCION=e.IDACCION
left join categoria k on k.IDCATEGORIA=e.IDCATEGORIA
where date(fecha_tmk)  between '$f_inicio' and '$f_fin'

		";
		if ($cuenta>=1){
		    	$sql=	$sql." and a.id_table=$cuenta";
		}
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array(utf8_encode($row["fecha_tmk"]),utf8_encode($row["cartera"]),utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["NOMCONTACTO"]),utf8_encode($row["accion"]),utf8_encode($row["efecto"]),utf8_encode($row["motivo"]),utf8_encode($row["peso"]),utf8_encode($row["categoria"]),utf8_encode($row["contacto"]),utf8_encode($row["observacion"]),utf8_encode($row["telefono"]),utf8_encode($row["direccion"]),utf8_encode($row["gestor"]),utf8_encode($row["pisos"]),utf8_encode($row["puerta"]),utf8_encode($row["fachada"]),utf8_encode($row["fecha_promesa"]),utf8_encode($row["monto_promesa"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function select_cuenta($nombre) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from tabla_log WHERE nombre = '$nombre' ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function cuentas(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT c.id,concat(d.cartera,': ', c.nombre) as nom_table 
        		FROM tabla_log c 
        		left join cartera d on d.id=c.id_cartera 
        		where c.id is not null 
        		group by c.id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("id"=>$row["id"],"nombre"=>utf8_encode($row["nom_table"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	} 
	
	public static function clientes(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "sELECT distinct e.id,e.nombre as nom_table FROM tabla_log c left join cartera d on d.id=c.id_cartera left join cliente e on e.id=d.idcliente group by c.id,e.nombre";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("id"=>$row["id"],"nombre"=>utf8_encode($row["nom_table"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	} 
	
	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "
	SELECT a.*,b.USUARIO,concat(d.cartera,': ', c.nombre) as nom_table, e.EFECTO,f.MOTIVO,g.CONTACTO FROM gestion_tmk a 
	LEFT JOIN personal b on a.IDPERSONAL=b.IDPERSONAL 
	left join tabla_log c on c.id=a.id_table 
	left join cartera d on d.id=c.id_cartera
	left join efecto e on e.IDEFECTO=a.IDEFECTO 
	left join motivo f on f.IDMOTIVO=a.IDMOTIVO 
	left join contacto g on g.IDCONTACTO=a.IDCONTACTO
				 ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
	
			  $arr_datos[] = array($row["id"],utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["nom_table"]),utf8_encode($row["EFECTO"]),utf8_encode($row["MOTIVO"]),utf8_encode($row["CONTACTO"]),utf8_encode($row["USUARIO"]),$row["fecha_tmk"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	
		public static function listar_documento($documento,$tabla) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "
	SELECT a.*,b.USUARIO,concat(d.cartera,': ', c.nombre) as nom_table, e.EFECTO,f.MOTIVO,g.CONTACTO ,x.documento
FROM gestion_tmk a 
LEFT JOIN personal b on a.IDPERSONAL=b.IDPERSONAL 
left join tabla_log c on c.id=a.id_table 
left join $tabla x on x.id=a.id_registro
left join cartera d on d.id=c.id_cartera 
left join efecto e on e.IDEFECTO=a.IDEFECTO 
left join motivo f on f.IDMOTIVO=a.IDMOTIVO 
left join contacto g on g.IDCONTACTO=a.IDCONTACTO
where x.documento='$documento'

				 ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
	
			  $arr_datos[] = array($row["id"],utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["nom_table"]),utf8_encode($row["EFECTO"]),utf8_encode($row["MOTIVO"]),utf8_encode($row["CONTACTO"]),utf8_encode($row["USUARIO"]),$row["fecha_tmk"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
		
		
		public static function listar_identificador($identificador,$tabla) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "
	SELECT a.*,b.USUARIO,concat(d.cartera,': ', c.nombre) as nom_table, e.EFECTO,f.MOTIVO,g.CONTACTO ,'' as opcion,concat('<b>Fec. Promesa: </b>',DATE_FORMAT(fecha_promesa, '%d/%m/%Y') ,'<br/><b>Monto Promesa: </b> S/.') as fecha_promesa2,
	h.DIRECCION,i.NUMERO,h.DEPARTAMENTO,h.DISTRITO,h.PROVINCIA,
 case when fecha_promesa='0000-00-00' or fecha_promesa='1990-01-01' then 0 else 1 end as v_promesa,
    case when a.IDDIRECCION=0 then 0 else 1 end as v_direccion,
    case when PISOS=0 or LENGTH(PISOS)=0 then 0 else 1 end as v_piso,
   case when PUERTA=0 or LENGTH(PUERTA)=0 then 0 else 1 end as v_puerta,
   case when FACHADA=0 or LENGTH(FACHADA)=0 then 0 else 1 end as v_facha,
   DATE_FORMAT(a.fecha_tmk, '%d/%m/%Y %H:%i:%s') fecha_tmk_

FROM gestion_tmk a 
LEFT JOIN personal b on a.IDPERSONAL=b.IDPERSONAL 
left join tabla_log c on c.id=a.id_table 
left join cartera d on d.id=c.id_cartera 
left join efecto e on e.IDEFECTO=a.IDEFECTO 
left join motivo f on f.IDMOTIVO=a.IDMOTIVO 
left join contacto g on g.IDCONTACTO=a.IDCONTACTO
left join direcciones h on h.IDDIRECCION=a.IDDIRECCION
left join telefonos i on i.IDTELEFONO=a.IDTELEFONO
where a.IDENTIFICADOR='$identificador'

				 ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
	
			  $arr_datos[] = array($row["id"],$row["fecha_tmk_"],utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["EFECTO"]),utf8_encode($row["MOTIVO"]),utf8_encode($row["CONTACTO"]),utf8_encode($row["USUARIO"]),utf8_encode($row["NOMCONTACTO"]),utf8_encode($row["OBSERVACION"]),utf8_encode($row["NUMERO"]),$row["opcion"],$row["v_promesa"],$row["v_direccion"],$row["v_piso"],$row["v_puerta"],$row["v_facha"],'<b>Departamento:</b> '.utf8_encode($row["DEPARTAMENTO"]).'<br/><b>Provincia:</b> '.utf8_encode($row["PROVINCIA"]).'<br/><b>Distrito:</b> '.utf8_encode($row["DISTRITO"]).'<br/><b>Direccion:</b> '.utf8_encode($row["DIRECCION"]).'<br/><b>Piso:</b> '.utf8_encode($row["PISOS"]).'<br/><b>Puerta:</b> '.utf8_encode($row["PUERTA"]).'<br/><b>Fachada:</b> '.utf8_encode($row["FACHADA"]),utf8_encode($row["fecha_promesa2"]).' '.utf8_encode($row["monto_promesa"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	public static function buscar($tabla,$idtable,$campo1,$campo2,$campo3,$campo4) {
		$objConx = new clsConexion();
		$objConx->conectar();
	
		$sql = "SELECT * FROM $tabla ";
		
	    //echo $sql;
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos[] = array($row["id"],$row["identificador"],utf8_encode($row["$campo1"]),utf8_encode($row["$campo2"]),utf8_encode($row["$campo3"]),utf8_encode($row["$campo4"]));			
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	
	public static function listar_asignaciones($id_usuario) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select b.id, concat('<b>',c.cartera,'</b>: ',b.nombre) as nombre from asignacion_tabla a left join tabla_log b on a.id_tabla = b.id left join cartera c on c.id=b.id_cartera where a.id_usuario=$id_usuario order by b.fecha_registro desc
		limit 10
				";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();

		while($row = mysql_fetch_array($res)) {
			  
			  $arr_datos[] = array($row["id"],utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function listar_generales() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select a.id, concat('<b>',c.cartera,'</b>: ',a.nombre) as nombre
            from tabla_log a
            left join cartera c on c.id=a.id_cartera
            where a.asignacion='G'
            order by a.fecha_registro desc
            limit 5
            				";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();

		while($row = mysql_fetch_array($res)) {
			  
			  $arr_datos[] = array($row["id"],utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	
	
	
	public static function listar_asignaciones_($id_usuario) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "
		select a.id_tabla as id,d.USUARIO,concat('<b>',c.cartera,'</b>: ',b.nombre) as nombre,
DATE_FORMAT(b.fecha_registro, '%d/%m/%Y %H:%i:%s') fecha_registro,e.USUARIO AS u_registro,case when b.asignacion='A' then 'ASIGNADA' ELSE 'GENERAL' END AS asignacion,
concat('<a href=assets/archivos/',b.ruta,' target=_blank><i class=icon-file-excel></i></a>') as ruta
from asignacion_tabla a 
left join tabla_log b on a.id_tabla = b.id 
left join cartera c on c.id=b.id_cartera
left join personal d on a.id_usuario=d.IDPERSONAL
left join personal e on b.user_registro=e.IDPERSONAL
where a.id_usuario=$id_usuario
order by b.fecha_registro desc

		
				";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();

		while($row = mysql_fetch_array($res)) {
			  
			  $arr_datos[] = array($row["id"],utf8_encode($row["USUARIO"]),utf8_encode($row["nombre"]),utf8_encode($row["fecha_registro"]),utf8_encode($row["u_registro"]),utf8_encode($row["asignacion"]),utf8_encode($row["ruta"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	

	public static function gui_tbl($id,$id_gui) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from gui_table where id_table=$id and gui=$id_gui";
		//echo $sql;
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("id_table"=>$row["id_table"],"campo"=>utf8_encode($row["campo"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	
	public static function gui_tbl2($tabla,$identificador) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "
	            SELECT * FROM $tabla where identificador= '$identificador'";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	
	public static function asignar($identificador,$id_tabla,$id_usuario) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "INSERT INTO gestion_tmk (IDGESTION,fecha_asignacion,IDENTIFICADOR,IDTABLE,IDPERSONAL,estado) VALUES (default,'$fecha','$identificador',$id_tabla,$id_usuario,'PENDIENTE')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	

	public static function actualizar($FECHAGESTION,$IDENTIFICADOR,$IDTABLE,$IDEFECTO,$IDMOTIVO,$IDCONTACTO,$OBSERVACION,$IDTELEFONO,$IDDIRECCION,$IDPERSONAL,$NOMCONTACTO,$PISOS,$PUERTA,$FACHADA) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "UPDATE GESTION SET
	            FECHAGESTION='$FECHAGESTION',
                IDENTIFICADOR='$IDENTIFICADOR',
                IDTABLE='$IDENTIFICADOR',
                IDEFECTO='$IDENTIFICADOR',
                IDMOTIVO='$IDENTIFICADOR',
                IDCONTACTO='$IDENTIFICADOR',
                OBSERVACION='$IDENTIFICADOR',
                IDTELEFONO='$IDENTIFICADOR',
                IDDIRECCION='$IDENTIFICADOR',
                IDPERSONAL='$IDENTIFICADOR',
                NOMCONTACTO='$IDENTIFICADOR',
                PISOS='$IDENTIFICADOR',
                PUERTA='$IDENTIFICADOR',
                FACHADA='$IDENTIFICADOR',
		";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$objConx->desconectar();
		return $res;
	}
	
	
	public static function insertar($IDENTIFICADOR,$IDTABLE,$IDEFECTO,$IDMOTIVO,$IDCONTACTO,$OBSERVACION,$IDTELEFONO,$IDDIRECCION,$IDPERSONAL,$NOMCONTACTO,$PISOS,$PUERTA,$FACHADA,$id,$fecha_promesa,$monto_promesa) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "insert into gestion_tmk values (default,'$fecha','$IDENTIFICADOR',$IDTABLE,$IDEFECTO,$IDMOTIVO,$IDCONTACTO,'$OBSERVACION','$IDTELEFONO','$IDDIRECCION',$IDPERSONAL,'$NOMCONTACTO','$PISOS','$PUERTA','$FACHADA',null,null,1,$id,'$fecha_promesa','$monto_promesa')
		";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	

	public static function insertar_telefono($documento,$cuenta,$telefono,$id_user) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");	
		$sql = "insert into telefonos values (default,'$documento','$fecha','$cuenta','$telefono','GESTION',0,'$id_user',1)
		";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function verificar_tabla($id){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from tabla_log where id=$id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function verificar_registro($tabla,$idtable){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from $tabla where identificador not in (select IDENTIFICADOR from gestion_tmk WHERE IDTABLE=$idtable)  limit 1";
		$res = mysql_query($sql) or die(mysql_error());
		//echo $sql; 
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function verificar_registro_2($tabla,$id){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from $tabla where id=$id limit 1";
		$res = mysql_query($sql) or die(mysql_error());
		//echo $sql; 
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function verificar_ctd($idtable,$usuario){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * FROM gestion_tmk WHERE IDTABLE=$idtable and IDPERSONAL=$usuario";
		$res = mysql_query($sql) or die(mysql_error());
		//echo $sql; 
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function motivos($id){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT IDMOTIVO as id,MOTIVO as nombre FROM motivo 
		WHERE IDEFECTO=$id and IDESTADO=1
		order by MOTIVO asc";
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
	
	public static function direcciones($documento){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT IDDIRECCION as id,concat(DEPARTAMENTO,': ', DIRECCION) as nombre FROM direcciones  
		    where DOC='$documento' and IDESTADO=1
		    order by DIRECCION asc";
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
	
	public static function telefonos($documento){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT IDTELEFONO as id,NUMERO as nombre FROM telefonos 
		        where DOC='$documento' and IDESTADO=1
		        order by NUMERO asc";
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
	
	public static function contactos($id){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT IDCONTACTO as id,CONTACTO as nombre FROM contacto WHERE IDEFECTO=$id  and IDESTADO=1
		order by CONTACTO asc";
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
	
	
	
		public static function listar_pago($identificador) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT c.*,upper(concat(a.cartera,': ',b.nombre)) as cartera,
		if(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones, 
		DATE_FORMAT(FECHAPAG, '%d/%m/%Y') as FECHAPAG_
		FROM pagos c
				left join cartera a  on a.id=c.IDCARTERA
				left join cliente b on a.idcliente=b.id
				where c.IDENTIFICADOR='$identificador'
				 ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["IDPAGO"],utf8_encode($row["PAGOS"]),utf8_encode($row["cartera"]),utf8_encode($row["TIPO"]),utf8_encode($row["FECHAPAG_"]),$row["IDENTIFICADOR"],$row["MONTO"],utf8_encode($row["HOMOLO"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function listar_campana($identificador) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT c.*,upper(concat(a.cartera,': ',b.nombre)) as cartera,d.nombre as tipo_c,
		if(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones,
		DATE_FORMAT(FECHACAM, '%d/%m/%Y') as FECHACAM_
		FROM campanas c
				left join cartera a  on a.id=c.IDCARTERA
				left join cliente b on a.idcliente=b.id
				left join tipo_campana d on c.tipo=d.id
                where c.IDENTIFICADOR='$identificador'
				 ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["ID"],utf8_encode($row["nombre"]),utf8_encode($row["cartera"]),utf8_encode($row["tipo_c"]),utf8_encode($row["FECHACAM_"]),utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["MONTO"]),utf8_encode($row["PERCENT_DESC"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
    


}
?>