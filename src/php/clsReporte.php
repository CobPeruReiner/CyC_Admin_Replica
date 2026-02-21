<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";

class clsReporte{
	
	
	public static function excel2($f_inicio,$f_fin,$cliente) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT PAGOS as nombre, FECHAREG as fecha_registro,a.IDENTIFICADOR,FECHAPAG,MONTO,HOMOLO,IDESTADO,d.cartera,d.tramo,central,x.nombre as cliente FROM pagos a left join cartera d on d.id=a.idcartera left join cliente x on x.id=d.idcliente 
            where date(FECHAPAG)  between '$f_inicio' and '$f_fin'

		";
		if ($cliente>=1){
		    $sql=	$sql." and x.id=$cliente";
		}
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array(utf8_encode($row["nombre"]),utf8_encode($row["fecha_registro"]),utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["FECHAPAG"]),utf8_encode($row["MONTO"]),utf8_encode($row["HOMOLO"]),utf8_encode($row["IDESTADO"]),utf8_encode($row["cartera"]),utf8_encode($row["tramo"]),utf8_encode($row["central"]),utf8_encode($row["cliente"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function excel($f_inicio,$f_fin,$cuenta) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT PAGOS as nombre, FECHAREG as fecha_registro,a.IDENTIFICADOR,FECHAPAG,MONTO,HOMOLO,IDESTADO,d.cartera,d.tramo,central,x.nombre as cliente FROM pagos a left join cartera d on d.id=a.idcartera left join cliente x on x.id=d.idcliente 
            where date(FECHAPAG)  between '$f_inicio' and '$f_fin'

		";
		if ($cuenta>=1){
		    $sql=	$sql." and d.id=$cuenta";
		}
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array(utf8_encode($row["nombre"]),utf8_encode($row["fecha_registro"]),utf8_encode($row["IDENTIFICADOR"]),utf8_encode($row["FECHAPAG"]),utf8_encode($row["MONTO"]),utf8_encode($row["HOMOLO"]),utf8_encode($row["IDESTADO"]),utf8_encode($row["cartera"]),utf8_encode($row["tramo"]),utf8_encode($row["central"]),utf8_encode($row["cliente"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function excel_promesa($f_inicio,$f_fin,$cuenta,$cliente) {
	    

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
            where a.fecha_promesa !='0000-00-00 00:00:00' 
			        and date(fecha_promesa)  between '$f_inicio' and '$f_fin'

		";
		if ($cliente>=1){
		    	$sql=	$sql." and x.id=$cliente";
		}
		
		if ($cuenta>=1){
		    	$sql=	$sql." and d.id=$cuenta";
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
	
		public static function cuentas2(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,cartera as nombre from cartera ";
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
	
		public static function clientes2(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT distinct e.id,e.nombre as nom_table FROM cartera d left join cliente e on e.id=d.idcliente";
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
	
		public static function listar_reporte($fecha_i,$fecha_f,$cuenta,$cliente) {
		set_time_limit(3000);    
		$objConx = new clsConexion();
		$objConx->conectar();

		$sql = "
                    SELECT 
			        DATE_FORMAT(FECHAPAG, '%Y-%m-%d')  as fecha_pago,
			        format(sum(monto),2) as total,
			        d.cartera as cartera,
			        count(1) as ctd 
			        FROM pagos a
			        left join cartera d on d.id=a.idcartera 
                    left join cliente x on x.id=d.idcliente
			        where date(FECHAPAG) between '$fecha_i' and '$fecha_f' ";
			        
		if ($cliente>=1){
		    	$sql=	$sql." and x.id=$cliente";
		}
		
		if ($cuenta>=1){
		    	$sql=	$sql." and d.id=$cuenta";
		}
		
			       $sql=	$sql." group by date(FECHAPAG), d.cartera
			        order by FECHAPAG desc

				 ";
				 
		
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
	
			  $arr_datos[] = array($row["fecha_pago"],utf8_encode($row["cartera"]),utf8_encode($row["ctd"]),utf8_encode($row["total"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
		
		
		}
	
	
	public static function listar_promesa($fecha_i,$fecha_f,$cuenta,$cliente) {
		set_time_limit(3000); 	    
		$objConx = new clsConexion();
		$objConx->conectar();
		
		$sql = "    
		SELECT DATE_FORMAT(a.fecha_promesa, '%Y-%m-%d')  as fecha_promesa, sum(a.monto_promesa) as total, d.cartera as cartera, count(1) as ctd FROM gestion_tmk a 
		left join tabla_log c on c.id=a.id_table 
		left join cartera d on d.id=c.id_cartera 
		left join cliente x on x.id=d.idcliente 
		where a.fecha_promesa !='0000-00-00 00:00:00' 
			        and date(fecha_promesa) between '$fecha_i' and '$fecha_f' ";
			        
		if ($cliente>=1){
		    	$sql=	$sql." and x.id=$cliente";
		}
		
		if ($cuenta>=1){
		    	$sql=	$sql." and d.id=$cuenta";
		}
		
			       $sql=	$sql." group by date(fecha_promesa), d.cartera
			        order by fecha_promesa desc

				 ";
				 
		
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
	
			  $arr_datos[] = array($row["fecha_promesa"],utf8_encode($row["cartera"]),utf8_encode($row["ctd"]),utf8_encode($row["total"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
		
		
		}
		
		public static function listar_efectos_user($fecha_i,$fecha_f,$cuenta,$cliente) {
		set_time_limit(3000);    

		$objConx = new clsConexion();
		$objConx->conectar();
		
		$sql = "    
		            SELECT b.usuario,count(1) as gestiones,
		            sum(case when k.CATEGORIA='CONTACTO DIRECTO' then 1 else 0 end )as cd, 
		            sum(case when k.CATEGORIA='NO CONTACTO' then 1 else 0 end )as nc, 
		            sum(case when k.CATEGORIA='CONTACTO INDIRECTO' then 1 else 0 end )as ci, 
		            sum(case when k.CATEGORIA='GESTION ADMINISTRATIVA' then 1 else 0 end )as ga, 
		            sum(case when fecha_promesa!='0000-00-00' then 1 else 0 end ) as ctd_prom 
		            FROM gestion_tmk a 
		            LEFT JOIN personal b on a.IDPERSONAL=b.IDPERSONAL 
		            left join tabla_log c on c.id=a.id_table 
		            left join cartera d on d.id=c.id_cartera 
		            left join cliente x on x.id=d.idcliente 
		            left join efecto e on e.IDEFECTO=a.IDEFECTO 
		            left join categoria k on k.IDCATEGORIA=e.IDCATEGORIA 
		     
		            
			        where date(fecha_tmk) between '$fecha_i' and '$fecha_f' ";
			        
		if ($cliente>=1){
		    	$sql=	$sql." and x.id=$cliente";
		}
		
		if ($cuenta>=1){
		    	$sql=	$sql." and d.id=$cuenta";
		}
		
			       $sql=	$sql." group by b.usuario 
			       order by b.usuario desc ";
				 
		
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
	
			  $arr_datos[] = array(utf8_encode($row["usuario"]),utf8_encode($row["gestiones"]),utf8_encode($row["cd"]),utf8_encode($row["nc"]),utf8_encode($row["ci"]),utf8_encode($row["ga"]),utf8_encode($row["ctd_prom"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
		
		
		}
		
		
		public static function listar_login_user($fecha_i,$fecha_f) {
		set_time_limit(3000);

		$objConx = new clsConexion();
		$objConx->conectar();
		
		// $sql = "    
		//             SELECT c.tipo,min(c.fecha) as fecha_login, min(fecha_tmk) as min_tmk,max(fecha_tmk) as max_tmk, TIMEDIFF(max(fecha_tmk),min(fecha_tmk)) as calculo_tmk, TIMEDIFF(max(fecha_tmk),min(c.fecha)) as calculo_login, concat(b.NOMBRES,' ',b.APELLIDOS) as nombre_user,b.USUARIO as usuario, count(distinct a.id) as gestiones 
		//             FROM gestion_tmk a 
		//             LEFT join personal b on a.IDPERSONAL=b.IDPERSONAL 
		//             LEFT join login c on a.IDPERSONAL=c.id_user and date(a.fecha_tmk)=date(c.fecha) and c.tipo='IN' 
		            
		            
		// 	        where date(fecha_tmk) between '$fecha_i' and '$fecha_f' 
		// 	        group by b.usuario
			        
		// 	       order by b.usuario desc ";

		/*
		$sql = "    
		SELECT '' tipo,convert(fecha_tmk,date) fecha_login,  min(a.fecha_tmk) as min_tmk,max(a.fecha_tmk) as max_tmk, 
		TIMEDIFF(max(a.fecha_tmk),min(a.fecha_tmk)) as calculo_tmk, '' calculo_login, 
		concat(b.NOMBRES,' ',b.APELLIDOS) as nombre_user,b.USUARIO as usuario, count(distinct a.id) as gestiones 
		FROM gestion_tmk a 
		LEFT join personal b on a.IDPERSONAL=b.IDPERSONAL 
		where date(fecha_tmk) between '$fecha_i' and '$fecha_f' 
		group by b.usuario,convert(fecha_tmk,DATE); ";
		*/

		$sql = "    
			SELECT
				'' tipo,
				CONVERT(fecha_tmk, DATE) fecha_login,
				MIN(a.fecha_tmk) AS min_tmk,
				MAX(a.fecha_tmk) AS max_tmk,
				SEC_TO_TIME(TIMESTAMPDIFF(SECOND, MIN(a.fecha_tmk), MAX(a.fecha_tmk))) AS calculo_tmk,
				'' calculo_login,
				CONCAT(b.NOMBRES, ' ', b.APELLIDOS) AS nombre_user,
				b.USUARIO AS usuario,
				c.SUCURSAL AS sucursal_user,
				COUNT(DISTINCT a.id) AS gestiones 
			FROM gestion_tmk a 
			LEFT JOIN personal b
				ON a.IDPERSONAL = b.IDPERSONAL
			LEFT JOIN sucursal c
				ON b.IDSUCURSAL = c.IDSUCURSAL
			WHERE 
				fecha_tmk >= '$fecha_i' 
				AND fecha_tmk <= '$fecha_f'
				AND a.estado = '1'
			GROUP BY b.usuario, fecha_login;
		";
				 
		
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
	
			  $arr_datos[] = array(utf8_encode($row["nombre_user"]),utf8_encode($row["usuario"]),utf8_encode($row["gestiones"]),utf8_encode($row["fecha_login"]),utf8_encode($row["min_tmk"]),utf8_encode($row["max_tmk"]),utf8_encode($row["calculo_tmk"]),utf8_encode($row["calculo_login"]),utf8_encode($row["sucursal_user"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
		
		
		}
	


}
?>