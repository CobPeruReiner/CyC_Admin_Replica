<?php
	require_once "clsConexion.php";
	date_default_timezone_set('America/Lima');
	
	$objConx = new clsConexion();
	$objConx->conectar();
    $fecha=date("Y-m-d H:i:s");
	$myquery = "
				select X.USUARIO as 'key',IFNULL(cantidad,0) as 'value',date from (SELECT distinct c.USUARIO ,b.id_user as value,concat(DATE_FORMAT(sysdate(), '%d/%m/%y '),a.horario) as date,a.horario FROM horas as a cross join login as b left join personal as c on b.id_user=c.IDPERSONAL
where month(b.fecha)=month('$fecha') and year(b.fecha)=year('$fecha')) as X left join (
SELECT DATE_FORMAT(a.fecha,'%H:00') as hora,id_user,count(1) as cantidad 
FROM login a left join personal b on a.id_user=b.IDPERSONAL 
where month(a.fecha)=month('$fecha') and year(a.fecha)=year('$fecha')
group by b.IDPERSONAL,DATE_FORMAT(a.fecha,'%H:00')) as Y on X.value=Y.id_user and X.horario=Y.hora order by X.USUARIO asc,date asc

				";
    $query = mysql_query($myquery);
    if ( ! $query ) {
        echo mysql_error();
        die;
    }
    $data = array();
 
    for ($x = 0; $x < mysql_num_rows($query); $x++) {
        $data[] = mysql_fetch_assoc($query);
    }
    
    echo json_encode($data);     
	$objConx->desconectar();
?>