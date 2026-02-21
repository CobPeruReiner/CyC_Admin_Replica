<?php


header('Content-type: application/vnd.ms-excel');
//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header('Content-Disposition: attachment; filename="rpte_gestion_'.date("Y-m-d").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");

require_once("php/clsReporte.php");

$arr_datos = clsReporte::listar_login_user($_REQUEST['fecha_inicio'],$_REQUEST['fecha_fin']);

    function retornarValor($arr_) {
    	$strTD = "";
    	return $strTD;
    }

	$str_tbody = "";

	for ($i=0; $i < sizeof($arr_datos); $i++) {
		$str_tbody .= '<tr>';
		for ($j=0; $j < sizeof($arr_datos[0]) ; $j++) {
			$valor = $arr_datos[$i][$j];
			
				$str_tbody .= '<td class="centrar">'.$valor.'</td>' ;	
			
		}	
		$str_tbody .= '</tr>';
	}
?>

<html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<style>
.centrar{
	font-family:calibri;
}

.colorTr{
	background-color: #85e2ec;
	font-family:calibri;
}
</style>

<table class="table" >
<thead>	
<tr>
<td colspan="5" class="centrar" ><h2 style='text-align:center;'> Reporte Promesa: <?php echo $_REQUEST['fecha_inicio'].' - '.$_REQUEST['fecha_fin']; ?></h2></td>
</tr>

<tr>
    
    
<td class='colorTr'><p>Asesor</p></td>
<td class='colorTr'><p>Usuario</p></td>
<td class='colorTr'><p>Cartera</p></td>
<td class='colorTr'><p>Primer Logeo</p></td>
<td class='colorTr'><p>Primer Gestión</p></td>
<td class='colorTr'><p>Ultima Gestión</p></td>
<td class='colorTr'><p>Dif. Tmk</p></td>
<td class='colorTr'><p>Dif. Login</p></td>
<td class='colorTr'><p>Sede</p></td>

	 
</tr>
						
</thead>
<tbody class="" ><?php echo $str_tbody; ?></tbody>


</table>


</head>
<html>