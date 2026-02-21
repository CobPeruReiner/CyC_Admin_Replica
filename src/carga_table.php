<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
</head>
<body>
<div class="panel-heading">
			<h6 class="panel-title" style="position: initial !important;">
				<?php 
				set_time_limit(3000);
				require_once("php/clsTable.php");
				$objTable = clsTable::select($_REQUEST['id']);
				session_start();
				if (!isset($_SESSION['user_ls'])){
					header("Location: index.php");
				}elseif ($_REQUEST['id']=="" ){
					header("Location: datatable_table.php");
				}
				?>
				<a href="datatable_table.php"><i class='icon-arrow-left7'></i></a> <b> <?php echo utf8_encode($_SESSION["tipo_ls"].': '.$_SESSION['user_ls'])  ?><br/> Listado de Cargas <?php $objTable[1]?></b>
			</h6>
</div>

<div class="content">
	<div class="row">
		<div class="col-lg-4">

<?php


$objDescribe = clsTable::describe_table($objTable[1]);
//var_dump($objDescribe[1]['field']);

date_default_timezone_set('America/Lima');
$con=@mysqli_connect("localhost", "cobrwbdd_clopez", "Qazokm2020.", "cobrwbdd_sistema");
$info = fopen ("assets/archivos/".$objTable[7] , "r" );
$nombre_archivo = "assets/archivos/".$objTable[7];

if (file_exists($nombre_archivo)) {
    $fecha_modifica= date("Y-m-d h:i:s", filemtime($nombre_archivo));
	$fecha_actual= date("Y-m-d h:i:s");
	$sql=mysqli_query($con,"select * from carga_log where fecha_modificacion ='$fecha_modifica' and tipo='$objTable[1]'");
    $cant=mysqli_num_rows($sql);
	//echo $cant;
	if ($cant==0 AND utf8_encode($_SESSION["id_ls"])==$objTable[5]){
	
   
	//printf ("New Record has id %d.\n", mysqli_insert_id($con));
	$lista=array();
	

	

    while (($datos=fgetcsv($info,10000,',')) !== FALSE){
	  //var_dump($datos[0]);


	
	  if($datos[0]!=$objDescribe[1]['field']){		  
		/*$cadena1 = $datos[4];
		$caracter_b   = '/';
        $posicion_c1 = strpos($cadena1, $caracter_b);
		  
			if ($posicion_c1 === false) {
				$exd_new= $datos[3];
			}else{
				$exd = DateTime::createFromFormat('d/m/Y',$datos[4]);
				$exd_new = date_format($exd, 'Y-m-d'); // Escojemos cualquier formato que deseemos
			}*/
			
			
			$data=array();
			
				for ($i=1; $i < sizeof($objDescribe);$i++) {
					//$data[] = array($objDescribe[$i]['field'] => $datos[$i-1]);
					//	print_r($data);
					//array_push($data, $objDescribe[$i]['field'],$datos[$i-1]);
					$data[$objDescribe[$i]['field']]=$datos[$i-1];
				}
				
				
				array_push($lista,$data);
			
		
			
			//print_r($lista);
			
			/*echo '<br/><br/><br/>';

			$linea[]=array('nombre'=>$datos[0],'documento'=>$datos[1],'monto'=>$datos[2]);
					
			
			//print_r($linea);
			
			echo '<br/><br/><br/>';*/
			
			
	  }

   }
   

   //print_r(strlen($lista[1]["identificador"]));
   
   $valida = $lista[1]["identificador"];

    if (strpos($valida, '|') !== false) {
        $xyz= 'si';
    }else if (strpos($valida, ';') !== false){ 
         $xyz= 'si';
    }else{
         $xyz= 'no';
    }
   // print_r($xyz);

   //print_r($lista[1]);
   fclose ($info);
	
   $insertados=0;
   $errores=0;
   $actualizados=0;
   
   if($xyz= 'no' AND strlen($lista[1]["identificador"])<=20){
       
        $sql="insert into carga_log (id, fecha_modificacion, fecha_carga,tipo) values(default,'$fecha_modifica','$fecha_actual','$objTable[1]')";
    mysqli_query($con,$sql);
	$id_carga=	mysqli_insert_id($con);
   
   foreach($lista as $indice=>$value){
		 
		 $idt=($value['identificador']);
		 $sql=mysqli_query($con,"select * from $objTable[1] where identificador ='$idt' ");
		 $num=mysqli_num_rows($sql);
		  
		  //print_r("select * from $objTable[1] where identificador ='$idt'");
		  //print_r($sql);
		  //print_r( $num);
		  
		//print_r($value[$objDescribe[1]['field']]);
				
		//if($value["nombre"]!=$objDescribe[1]['field'] ){
		 
		  if ($num==0){
		      
		     $sql="insert into $objTable[1] (id"; 
    		 $fields="";
    		 $values="";
    				  
    		  for ($i=1; $i < sizeof($objDescribe);$i++) {
    			   $$objDescribe[$i]['field']=$value[$objDescribe[$i]['field']];
    			
    	
    				$fields .= ','.$objDescribe[$i]['field'];
    				$values .= ",'".$$objDescribe[$i]['field']."'";
    				
    					
    		  }
    		  
    		$sql= $sql.$fields.') values(null'.$values.')' ;
		
		
		//	 echo $sql;
			 if ($insert = mysqli_query($con,$sql)){
				$insertados+=1;
			 }else{
				$errores+=1;
			 }
		  }else{
			 $sql="update $objTable[1] set identificador='$idt'";
			 $fields="";
    				  
    		  for ($i=1; $i < sizeof($objDescribe);$i++) {
    			   $$objDescribe[$i]['field']=$value[$objDescribe[$i]['field']];
    
    				$fields .= ','.$objDescribe[$i]['field']."='".$$objDescribe[$i]['field']."'";
    				
    					
    		  }
    		  
    		  $sql= $sql.$fields." where identificador='$idt' ";
			 
			 
		//	echo  $sql;
			 
			 
			 if ($update = mysqli_query($con,$sql)){
				$actualizados+=1;
			 }else{
				$errores+=1;
			 }
		  }
		//}
    }
    
    	$id_tabla=$_REQUEST['id'];
		$id_user=utf8_encode($_SESSION["id_ls"]);
		$fecha_actual= date("Y-m-d h:i:s");
		$sql="update carga_log set registrados='$insertados' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update carga_log set actualizados='$actualizados' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update carga_log set errores='$errores' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update carga_log set fecha_fin='$fecha_actual' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update tabla_log set fecha_modifica='$fecha_actual',estado=1,user_modifica=$id_user where id= $id_tabla";
		mysqli_query($con,$sql);
		//echo $sql;
	
	   echo "<i class='icon-android'></i> Insertados: <span class='label bg-success-400'>".number_format($insertados,2)." </span><br/>";
	   echo "Actualizados: <span class='label bg-info-400'>".number_format($actualizados,2)." </span><br/>";
	   echo "Errores: <span class='label bg-danger-400'>".number_format($errores,2)." </span>"; 
   
   }else{
       
      echo "El archivo no es delimitado por comas <span class='label bg-danger-400'><i class='icon-blocked'></i></span>";
   }
  
  
  

  
	
    
    
	//fin if de carga_log
	}else if ($cant==0 AND utf8_encode($_SESSION["id_ls"])!=$objTable[5]){
		echo "<i class='icon-blocked'></i> UD. no es propietario de esta cuenta <span class='label bg-success-400'>archivo *.csv</span>";
	}else{
		echo "<i class='icon-exclamation'></i> Ya se encuentra cargado el archivo con fecha: <span class='label bg-danger-400'>".$fecha_modifica."</span>";

	}
	
}else{
	echo "<i class='icon-blocked'></i> No se encuentra <span class='label bg-danger-400'>archivo csv</span>";
}
   
   
?>

</div>

<div class="col-lg-8">
<table class="table table-hover" border="0" align="center" style="font-size:12px;">
	<thead>
	<tr style="background-color:#424242;" >
		<td><h5 style="color:#fff;  font-size:12px;">Id</h5></td>	
		<td><h5 style="color:#fff;  font-size:12px;">Fec. Modificación</h5></td>	
		<td><h5 style="color:#fff;  font-size:12px;">Fec. Carga</h5></td>	
		<td><h5 style="color:#fff;  font-size:12px;">Fec. Fin</h5></td>	
		<td><h5 style="color:#fff;  font-size:12px;">Tiempo</h5></td>	
		<td><h5 style="color:#fff;  font-size:12px;">Registrados</h5></td>	
		<td><h5 style="color:#fff;  font-size:12px;">Actualizados</h5></td>	
		<td><h5 style="color:#fff;  font-size:12px;">Errores</h5></td>	
	</tr>
	</thead>
	
	<tbody>
	<?php

		require_once("php/clsCarga.php");
		$var = clsCarga::listar_cargas($objTable[1]);
		for ($i=0; $i < sizeof($var);$i++) {
			echo "<tr>";									
			echo "<td >".$var[$i][0]."</td>";
			echo "<td >".$var[$i][1]."</td>";
			echo "<td >".$var[$i][2].' <sup>'.$var[$i][8]."</sup></td>";
			echo "<td >".$var[$i][3]."</td>";
			echo "<td >".$var[$i][4]."</td>";
				if ($var[$i][5]>0){
					echo "<td style='color: #088A08'>". $var[$i][5] ."</td>";
				}else if($var[$i][5]<=0){
					echo "<td style='color: #FA5858'> ".$var[$i][5]."</td>";
				}else{
					echo "<td style='color: #0174DF'>".$var[$i][5]."</td>";
				}
			echo "<td >".$var[$i][6]."</td>";
				if($var[$i][7]>=1){
					echo "<td style='color: #FA5858'> ".$var[$i][7]."</td>";
				}else{
					echo "<td style='color: #0174DF'>".$var[$i][7]."</td>";
				}
			
			echo "</tr>";
		}
	
	?>
	</tbody>
</table>
		
</div>
</div>
</div>

</body>
</html>