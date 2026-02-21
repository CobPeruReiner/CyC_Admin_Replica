<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
	
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
				session_start();
				if (!isset($_SESSION['user_ls']))
				header("Location: index.php");
				?>
				<a href="datatable_campana.php"><i class='icon-arrow-left7'></i></a> <b> <?php echo utf8_encode($_SESSION["tipo_ls"].': '.$_SESSION['user_ls'])  ?><br/> Listado de Cargas carga_campana.csv</b>
			</h6>
</div>

<div class="content">
	<div class="row">
		<div class="col-lg-4">

<?php
set_time_limit(3000);
date_default_timezone_set('America/Lima');
$con=@mysqli_connect("localhost", "cobrwbdd_clopez", "Qazokm2020.", "cobrwbdd_sistema");
$info = fopen ("assets/archivos/carga_campana.csv" , "r" );
//$info = fopen ("carga_campana.csv" , "r" );

$nombre_archivo = "assets/archivos/carga_campana.csv";
if (file_exists($nombre_archivo)) {
    $fecha_modifica= date("Y-m-d h:i:s", filemtime($nombre_archivo));
	$fecha_actual= date("Y-m-d h:i:s");
	$sql=mysqli_query($con,"select * from carga_log where fecha_modificacion ='$fecha_modifica' and tipo='CAMPANA'");
    $cant=mysqli_num_rows($sql);
	//echo $cant;
	if ($cant==0 AND utf8_encode($_SESSION["tipo_ls"])=="ADMIN"){
    $sql="insert into carga_log (id, fecha_modificacion, fecha_carga,tipo) values(default,'$fecha_modifica','$fecha_actual','CAMPANA')";
    mysqli_query($con,$sql);
   // echo $sql;
	$id_carga=	mysqli_insert_id($con);
	//printf ("New Record has id %d.\n", mysqli_insert_id($con));
    while (($datos=fgetcsv($info,5000,",")) !== FALSE){
	  //var_dump($datos[3]);
	  if($datos[0]!="nombre"){		  
		  $cadena1 = $datos[4];
		  $caracter_b   = '/';
          $posicion_c1 = strpos($cadena1, $caracter_b);
		  
			if ($posicion_c1 === false) {
				$exd_new= $datos[3];
			}else{
				$exd = DateTime::createFromFormat('d/m/Y',$datos[4]);
				$exd_new = date_format($exd, 'Y-m-d'); // Escojemos cualquier formato que deseemos
			}
			
		  
      $linea[]=array('nombre'=>$datos[0],'cartera'=>$datos[1],'identificador'=>$datos[2],'tipo'=>$datos[3],'fecha_cam'=>$exd_new,'hora_cam'=>$datos[5],'monto'=>$datos[6],'dscto'=>$datos[7],'homolo'=>$datos[8]);
	  }

   }
   fclose ($info);
	
   $insertados=0;
   $errores=0;
   $actualizados=0;
   
   foreach($linea as $indice=>$value){
	  if($value["nombre"]!="nombre"){
		  $nombre=$value["nombre"];
		  $cartera=$value["cartera"];
		  $identificador=$value["identificador"];
		  $tipo=$value["tipo"];
		  $fecha_cam=$value["fecha_cam"].' '.$value["hora_cam"];
		  $monto=$value["monto"];
		  $dscto=$value["dscto"];
		  $homolo=$value["homolo"];
		  /*$character = array("'",'"');
		  $direccion = str_replace($character, "", $value["direccion"]);
		  //$direccion=utf8_encode($value["direccion"]);
		  $referencia=str_replace($character, "", $value["referencia"]);*/
		 
		  $sql=mysqli_query($con,"select * from campanas where identificador ='$identificador' and tipo='$tipo' and IDESTADO=1");
		  $num=mysqli_num_rows($sql);
		  if ($num==0){
			 $sql="insert into campanas (idcarga,nombre,IDCARTERA,IDENTIFICADOR,TIPO,FECHACAM,MONTO,PERCENT_DESC,HOMOLO,IDESTADO) values ($id_carga,'$nombre','$cartera','$identificador','$tipo','$fecha_cam','$monto','$dscto','$homolo',1)";
			// echo $sql;
			 if ($insert = mysqli_query($con,$sql)){
				$insertados+=1;
			 }else{
				$errores+=1;
			 }
		  }else{
			 $sql="update campanas set IDESTADO=0 where identificador='$identificador'  and tipo='$tipo' ";
			 if ($update = mysqli_query($con,$sql)){
				$actualizados+=1;
			 }else{
				$errores+=1;
			 }
		  }
	 }
   }
	
		$fecha_actual= date("Y-m-d h:i:s");
		$sql="update carga_log set registrados='$insertados' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update carga_log set actualizados='$actualizados' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update carga_log set errores='$errores' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update carga_log set fecha_fin='$fecha_actual' where id= $id_carga";
		mysqli_query($con,$sql);
		$sql="update campanas set FECHAREG='$fecha_actual' where idcarga= $id_carga";
		mysqli_query($con,$sql);	
	   echo "<i class='icon-android'></i> Registros insertados: <span class='label bg-success-400'>".number_format($insertados,2)." </span><br/>";
	   echo "Registros actualizados: <span class='label bg-info-400'>".number_format($actualizados,2)." </span><br/>";
	   echo "Errores: <span class='label bg-danger-400'>".number_format($errores,2)." </span>";
	//fin if de carga_log
	}else if ($cant==0 AND utf8_encode($_SESSION["tipo_ls"])!="ADMIN"){
		echo "<i class='icon-blocked'></i> No tiene permiso para subir el <span class='label bg-success-400'>archivo *.csv</span>";
	}else{
		echo "<i class='icon-exclamation'></i> Ya se encuentra cargado el archivo con fecha: <span class='label bg-danger-400'>".$fecha_modifica."</span>";
	}
}
   
?>

</div>

	<div class="col-lg-8">


<table id="deporte" class="table table-hover" border="0" align="center" style="font-size:12px;">
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
		$var = clsCarga::listar_cargas('CAMPANA');
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