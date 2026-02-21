<?php
header('Content-type: application/vnd.ms-excel');
//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="rpte_usuarios_'.date("Y-m-d").'.xls"');
header("Pragma: no-cache");
header("Expires: 0");

require_once("php/clsUsuario.php");

$arr_datos = clsUsuario::excel();

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
	background-color: #E0D9D7;
	font-family:calibri;
}
</style>

<table class="table" >
<thead>	
<tr>
<td colspan="5" class="centrar" ><h2 style='text-align:center;'> Reporte Personal: <?php echo date("Y-m-d"); ?></h2></td>
</tr>

<tr>

<td class='colorTr'><p>	Id	</p></td>
<td class='colorTr'><p>	Empleado	</p></td>
<td class='colorTr'><p>	Fec. Nac	</p></td>
<td class='colorTr'><p>	Sexo	</p></td>
<td class='colorTr'><p>	Documento	</p></td>
<td class='colorTr'><p>	Est. Civil	</p></td>
<td class='colorTr'><p>	Cargo Fam.	</p></td>
<td class='colorTr'><p>	Num. Hijos	</p></td>
<td class='colorTr'><p>	Dirección	</p></td>
<td class='colorTr'><p>	Distrito	</p></td>
<td class='colorTr'><p>	Departamento	</p></td>
<td class='colorTr'><p>	Referencia	</p></td>
<td class='colorTr'><p>	Teléfono	</p></td>
<td class='colorTr'><p>	Móvil	</p></td>
<td class='colorTr'><p>	Email	</p></td>
<td class='colorTr'><p>	Instrucción	</p></td>
<td class='colorTr'><p>	Cargo	</p></td>
<td class='colorTr'><p>	Sucursal	</p></td>
<td class='colorTr'><p>	Usuario	</p></td>
<td class='colorTr'><p>	Fec. Registro	</p></td>
<td class='colorTr'><p>	Estado	</p></td>
<td class='colorTr'><p>	Cartera	</p></td>
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