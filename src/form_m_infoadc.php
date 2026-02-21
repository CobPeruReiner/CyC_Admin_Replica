<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsInfoadc.php");
	session_start();
	if (!isset($_SESSION['user_ls'])){
		header("Location: index.php");
	}elseif ($_REQUEST['id']=="" ){
		header("Location: datatable_infoadc.php");
	}else{
		$objInfoadc = clsInfoadc::select($_REQUEST['id']);
	}
	$obj = new clsUsuario;
	$arr_datos = $obj->version_system();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo($arr_datos[0][1]); ?></title>
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
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switch.min.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>
	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/inputs/touchspin.min.js"></script>
		
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="assets/js/pages/picker_date.js"></script>
	<!-- /theme JS files -->
</head>

<body>
<?php include 'cabecera.php'; ?>

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><a href="datatable_infoadc.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Modificar</span> Información Adc</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>
								Estadísticas</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Calendario</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="#"><i class="icon-home2 position-left"></i> Inicio</a></li>
							<li class="active">Información Adc</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="datatable_infoadc.php"><i class="icon-database-add"></i> Información Adc</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<form action="#" class="form-m-infoadc">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>
							
							<div class="checkbox checkbox-switch">
									<label>
									<?php if ($objInfoadc['IDESTADO']==1){
										echo('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" checked="checked">');
									}else{
										echo('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" >');
									}?>
									</label>
							</div>
							
							<div class="panel-body">
								<div class="row">
								<legend class="text-semibold"><i class="icon-database-add position-left"></i> Datos Información Adc</legend>
								
									<div class="col-md-6">
										<fieldset>
										 <div class="form-group">	
											<label>Cartera</label>
											<input type="hidden" id="id" name="id" class="form-control" value="<?php echo $objInfoadc['IDINFOADI'];?>">
											
											<select id="cartera" name="cartera" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
														$obj = new clsInfoadc;
														$arr_datos = $obj->carteras();
														foreach($arr_datos as $datos)
														if($datos['id']==$objInfoadc['IDCARTERA']){
															echo '<option value="'.$datos['id'].'" selected>'.utf8_encode($datos['nombre']).' </option>';
													
														}else{
															echo '<option value="'.$datos['id'].'">'.utf8_encode($datos['nombre']).'</option>';
														}
													?> 
											</select>
										</div>
										
										<div class="form-group">
											<label>Identificador</label>
											<input type="text" id="identificador" name="identificador" class="form-control" placeholder="937734" maxlength=50 value="<?php echo $objInfoadc['IDENTIFICADOR'];?>" required="required">
										</div>
										
										
										<div class="form-group">	
											<label>Dato 1</label>
											<input type="text" id="dato1" name="dato1" class="form-control" placeholder="I" value="<?php echo $objInfoadc['DATO1'];?>" maxlength=100 required="required">
										</div>
										
										<div class="form-group">	
											<label>Dato 2</label>
											<input type="text" id="dato2" name="dato2" class="form-control" value="<?php echo $objInfoadc['DATO2'];?>" placeholder="II" maxlength=100 required="required">
										</div>
										
										<div class="form-group">	
											<label>Dato 3</label>
											<input type="text" id="dato3" name="dato3" class="form-control" placeholder="III" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO3'];?>">
										</div>
										
										<div class="form-group">	
											<label>Dato 4</label>
											<input type="text" id="dato4" name="dato4" class="form-control" placeholder="IV" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO4'];?>" >
										</div>
										 
										</fieldset>
										
									</div>
									
									<div class="col-md-6">
										<fieldset>
											
											<div class="form-group">	
											<label>Dato 5</label>
											<input type="text" id="dato5" name="dato5" class="form-control" placeholder="V" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO5'];?>">
										</div>
										
										<div class="form-group">	
											<label>Dato 6</label>
											<input type="text" id="dato6" name="dato6" class="form-control" placeholder="VI" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO6'];?>">
										</div>
										
										<div class="form-group">	
											<label>Dato 7</label>
											<input type="text" id="dato7" name="dato7" class="form-control" placeholder="VII" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO7'];?>">
										</div>
										
										<div class="form-group">	
											<label>Dato 8</label>
											<input type="text" id="dato8" name="dato8" class="form-control" placeholder="VIII" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO8'];?>">
										</div>
										
										<div class="form-group">	
											<label>Dato 9</label>
											<input type="text" id="dato9" name="dato9" class="form-control" placeholder="IX" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO9'];?>">
										</div>
										
										<div class="form-group">	
											<label>Dato 10</label>
											<input type="text" id="dato10" name="dato10" class="form-control" placeholder="X" maxlength=100 required="required" value="<?php echo $objInfoadc['DATO10'];?>">
										</div>
											
										</fieldset>
									</div>
										
								</div>
								
								<div class="text-left">
									<button type="submit" class="btn btn-primary">Modificar <i class="icon-arrow-right14 position-left"></i></button>
								</div>
							</div>
						</div>
					</form>

	
				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

<script>
			$(function() {
				
				
				
				
			});
			
			
		

</script>
</body>
</html>
