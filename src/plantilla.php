<?php


set_time_limit(3000);
require_once("php/clsTable.php");
$objTable = clsTable::select($_REQUEST['id']);
$objDescribe = clsTable::describe_table($objTable[1]);


header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="plantilla_'.$objTable[1].'.xls"');
header("Pragma: no-cache");
header("Expires: 0");


	$str_tbody = "";
	for ($i=1; $i < sizeof($objDescribe); $i++) {
			$valor = $objDescribe[$i]['field'];
			$str_tbody .= '<td class="colorTr"><p>'.$valor.'</p></td>' ;	

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
	background-color: #E0D9D7;
	font-family:calibri;
}
</style>

<table class="table" >
<thead>	
<tr>
<td colspan="9" class="centrar" ><h2 style='text-align:center;'> Plantilla: <?php echo $objTable[1]; ?></h2></td>
</tr>

<tr>
<?php echo $str_tbody; ?>
</tr>
						
</thead>
<tbody></tbody>


</table>

</head>
<html>