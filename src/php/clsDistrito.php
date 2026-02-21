<?php
	require_once "clsConexion.php";
	date_default_timezone_set('America/Lima');
	
	$objConx = new clsConexion();
	$objConx->conectar();
	/*$myquery = "SELECT replace(distrito,'BREÑA','HOLA') as Distrito,count(1) as Cantidad FROM contacto where LENGTH( distrito) >=1 and distrito!='BREÑA' group by distrito order by count(1) desc  ";*/
	//$myquery("SET NAMES 'utf8'");
	
	$myquery = "
	SELECT  distrito  as Distrito,count(1) as Cantidad 
	FROM contacto_beta
	where LENGTH( distrito) >=1 
	group by distrito order by count(1) desc ";
	
    $query = mysql_query($myquery);
    if (!$query) {
        echo mysql_error();
        die;
    }

    $data = array();
    
    for ($x = 0; $x < mysql_num_rows($query); $x++) {
         $data[] = mysql_fetch_assoc($query);
        
    }
    //print_r( $data);
     echo json_encode($data );     
     
	$objConx->desconectar();
?>