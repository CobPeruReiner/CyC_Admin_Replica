<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsAccion.php");
	session_start();
	if (!isset($_SESSION['user_ls'])){
		header("Location: index.php");
	}elseif ($_REQUEST['id']=="" ){
		header("Location: datatable_accion.php");
	}else{
		$objAccion= clsAccion::select_accion($_REQUEST['id']);
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
							<h4><a href="datatable_accion.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Modificar</span> Acción</h4>
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
							<li class="active">Acción</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="datatable_accion.php"><i class="icon-checkbox-checked"></i> Acción</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<form action="#" class="form-m-accion">
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
									<?php if ($objAccion['IDESTADO']==1){
										echo('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" checked="checked">');
									}else{
										echo('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" >');
									}?>
									</label>
									
							</div>
	
							<div class="panel-body">
								<div class="row">
								<legend class="text-semibold"><i class="icon-checkbox-checked position-left"></i> Datos Acción</legend>
								
									<div class="col-md-6">
										<fieldset>
										<div class="form-group">
											<label>Nombre</label>
											<input type="hidden" id="id" name="id" class="form-control" value="<?php echo $objAccion['IDACCION'];?>">
											<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Accion I" maxlength=50 required="required" value="<?php echo $objAccion['ACCION'];?>">
										</div>
										
										 <div class="form-group">	
											<label>Tipo</label>
											<select id="tipo" name="tipo" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
																												
														$obj = new clsAccion;
														$arr_datos = $obj->consulta_tipo();
														foreach($arr_datos as $datos)
														if($datos['id']==$objAccion['TIPO']){
															echo '<option value="'.$datos['id'].'" selected>'.utf8_encode($datos['nombre']).' </option>';
													
														}else{
															echo '<option value="'.$datos['id'].'">'.utf8_encode($datos['nombre']).'</option>';
														}
											
													?> 
											</select>
										</div>
										
										<div class="form-group">	
											<label>Cartera</label>
											<select id="cartera" name="cartera" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
														$obj = new clsAccion;
														$arr_datos = $obj->consulta_cartera();
														foreach($arr_datos as $datos)
														if($datos['id']==$objAccion['idcartera']){
															echo '<option value="'.$datos['id'].'" selected>'.utf8_encode($datos['nombre']).' </option>';
													
														}else{
															echo '<option value="'.$datos['id'].'">'.utf8_encode($datos['nombre']).'</option>';
														}
														
													?> 
											</select>
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
