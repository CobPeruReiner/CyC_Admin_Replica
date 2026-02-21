<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsPago.php");
	session_start();
	if (!isset($_SESSION['user_ls'])){
		header("Location: index.php");
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
							<h4><a href="datatable_pago.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Registrar</span> Pago</h4>
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
							<li class="active">Pago</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="datatable_pago.php"><i class="icon-coins"></i> Pago</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<form action="#" class="form-a-pago">
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

							<div class="panel-body">
								<div class="row">
								<legend class="text-semibold"><i class="icon-coin-dollar position-left"></i> Datos Pago</legend>
								
									<div class="col-md-6">
										<fieldset>
										<div class="form-group">
											<label>Nombre</label>
											<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Cobranzas Perú" maxlength=50 required="required">
										</div>
										
										<div class="form-group">
											<label>Identificador</label>
											<input type="text" id="identificador" name="identificador" class="form-control" placeholder="00112233-AMV" maxlength=50 required="required">
										</div>
										
										 <div class="form-group">	
											<label>Cartera</label>
											<select id="cartera" name="cartera" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
														$obj = new clsPago;
														$arr_datos = $obj->carteras();
														foreach($arr_datos as $datos)
														echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
													?> 
											</select>
										</div>
										
										 <div class="form-group">	
											<label>Tipo</label>
											<input type="text" id="tipo" name="tipo" class="form-control" placeholder="Lorem Ipsum" maxlength=50 required="required">
										</div>


										
										</fieldset>
										
									</div>
									
									<div class="col-md-6">
										<fieldset>
											<div class="form-group">
												<label>Fecha </label>
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" id="fechapago" name="fechapago" required="required" class="form-control pickadate2" placeholder="<?php echo date('Y-m-d');?>" /> 
													<input class="form-control" type="time" id="hora" name="hora" required="required">

												</div>
											</div>
											
											<div class="form-group">
												<label>Monto</label>
												<div class="input-group">
													<input type="text" id="monto" name="monto" value="" required="required" class="touchspin-postfix2" placeholder="1200">
												</div>
											</div>
											
											<div class="form-group">
												<label>Homolo</label>
												<input type="text" id="homolo" name="homolo" class="form-control" placeholder="Homolo 1" maxlength=50 required="required">
											</div>
											
											
											
										</fieldset>
									</div>
										
								</div>
								
								<div class="text-left">
									<button type="submit" class="btn btn-primary">Registrar <i class="icon-arrow-right14 position-left"></i></button>
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
				
				 // Touchspin
					$(".touchspin-postfix").TouchSpin({
						min: 0,
						max: 100,
						step: 0.1,
						decimals: 2,
						postfix: '%'
					});
					
					$(".touchspin-postfix2").TouchSpin({
						min: 0,
						max: 10000,
						step: 0.1,
						decimals: 2,
						postfix: '$'
					});
				
				
				
			});
			
		

</script>
</body>
</html>
