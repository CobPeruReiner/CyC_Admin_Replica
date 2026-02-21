<?php
	require_once("php/clsUsuario.php");
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
	<script type="text/javascript" src="assets/js/plugins/forms/inputs/typeahead/handlebars.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/inputs/alpaca/alpaca.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/inputs/alpaca/price_format.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switch.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/uploaders/fileinput.min.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>
	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
	<script type="text/javascript" src="assets/js/pages/alpaca_advanced.js"></script>
	<script type="text/javascript" src="assets/js/pages/uploader_bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="assets/js/pages/picker_date.js"></script>
	<script type="text/javascript" src="assets/js/ajaxfileupload.js"></script>

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
							<h4><a href="datatable_basic.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Registrar</span> Medio de Prueba</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Medio de Prueba</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Settings
									<span class="caret"></span>
								</a>

								
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<form class="form-file" >
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
							
									<div class="col-md-8">

										<fieldset>
											<legend class="text-semibold"><i class="icon-magic-wand position-left"></i> Datos Norma ISO</legend>
											<div class="form-group">
												<div id="alpaca-option-norma"></div>
											</div>
																						
											
										</fieldset>

										<fieldset>
											<legend class="text-semibold"><i class="icon-file-pdf position-left"></i> Datos Fichero</legend>
											<div class="form-group">
												<label>Versión</label>
												<div id="alpaca-version"></div>
											</div>

											<div class="form-group">
												<label>Lenguaje</label>
												 <select id="language" name="language" data-placeholder="Seleccione" class="select" required="required">
						                            	<option></option>
														<?php
															require_once("php/clsFile.php");
															$obj = new clsFile;
															$arr_datos = $obj->consulta_languages();
															foreach($arr_datos as $datos)
															echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
														?> 
						                        </select>
											</div>

											<div class="form-group">
												<label >Fichero</label>
												<div class="">
													<!--<input type="file" name="file-es[]"  class="file-input-ajax" multiple="multiple">-->
													<input type="file" id="file-es" name="file-es" class="file-input-ajax" >
													<span class="help-block">This scenario uses asynchronous/parallel uploads. Uploading itself is turned off in live preview.</span>
													<div class="alert alert-success" role="alert"></div>
												</div>
											</div>
											<div class="form-group">
												<label >Fecha Caducidad</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar5"></i></span>
													<input type="text" class="form-control pickadate" placeholder="YY/mm/dd" required="required">
												</div>

											</div>
											<div class="form-group">
												<div class="checkbox checkbox-switch">
													<label>
														<input type="checkbox" data-on-color="info" data-off-color="danger" data-on-text="Public" data-off-text="Private" class="switch" checked="checked" >
													</label>
												</div>
											</div>

										</fieldset>
									</div>
								</div>

								<div class="text-right">
									<button type="submit" class="btn btn-primary">Registrar <i class="icon-arrow-right14 position-right"></i></button>
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

</body>
</html>
