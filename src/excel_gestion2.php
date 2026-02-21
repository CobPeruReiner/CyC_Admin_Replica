<?php

header('Content-type: application/vnd.ms-excel');
//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="rpte_gestion_cliente'.date("Y-m-d").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");


require_once("php/clsGestion.php");

$arr_datos = clsGestion::excel2($_REQUEST['fecha_inicio'],$_REQUEST['fecha_fin'],$_REQUEST['cliente']);

    function retornarValor($arr_) {
    	$strTD = "";
    	return $strTD;
    }

	$str_tbody = "";
	$f_1=0;
	$f_2=0;

	for ($i=0; $i < sizeof($arr_datos); $i++) {
		$str_tbody .= '<tr>';
		for ($j=0; $j < sizeof($arr_datos[0]) ; $j++) {
			$valor = $arr_datos[$i][$j];
			/*if($j==11){
			    if ($valor=="SI"){
    				$f_1+=1;
    				$str_tbody .= '<td class="f_1">'.$valor.'</td>';
			    }else{
			        $f_1+=0;
			      	$str_tbody .= '<td class="f_1">'.$valor.'</td>';  
			    }
			}else if($j==12){
			   if ($valor=="SI"){
    				$f_2+=1;
    				$str_tbody .= '<td class="f_2">'.$valor.'</td>';
			   }else{
			        $f_2+=0;
			      	$str_tbody .= '<td class="f_2">'.$valor.'</td>';  
			   }
			}else{*/
				$str_tbody .= '<td class="centrar">'.$valor.'</td>' ;	
			//}
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
<td colspan="5" class="centrar" ><h2 style='text-align:center;'> Reporte Gestión: <?php echo $_REQUEST['fecha_inicio'].' - '.$_REQUEST['fecha_fin']; ?></h2></td>
</tr>

<tr>

<td class='colorTr'><p>Fec. Gestión</p></td>
<td class='colorTr'><p>Cliente</p></td>
<td class='colorTr'><p>Cartera</p></td>
<td class='colorTr'><p>Identificador</p></td>
<td class='colorTr'><p>Nom. Contacto</p></td>
<td class='colorTr'><p>Accción</p></td>
<td class='colorTr'><p>Efecto</p></td>
<td class='colorTr'><p>Motivo</p></td>
<td class='colorTr'><p>Peso</p></td>
<td class='colorTr'><p>Categoria</p></td>
<td class='colorTr'><p>Contacto</p></td>
<td class='colorTr'><p>Observación</p></td>
<td class='colorTr'><p>Telefono</p></td>
<td class='colorTr'><p>Dirección</p></td>
<td class='colorTr'><p>Usuario</p></td>
<td class='colorTr'><p>Pisos</p></td>
<td class='colorTr'><p>Puerta</p></td>
<td class='colorTr'><p>Fachada</p></td>
<td class='colorTr'><p>Fec. Promesa</p></td>
<td class='colorTr'><p>Monto Promesa</p></td>

	 
</tr>
						
</thead>
<tbody class="" ><?php echo $str_tbody; ?></tbody>
<!--<tfoot>
<td colspan=9></td>
<td style="border=1; text-align:right;"><b>TOTAL</b></td>
<td style="background: lightgray !important;"><b style="color:red;"><?php echo $f_1; ?><b></td>
<td style="background: lightgray !important;"><b style="color:red;"><?php echo $f_2; ?><b></td>
</tfoot>-->

</table>

</head>
<html>