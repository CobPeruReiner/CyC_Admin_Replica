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
							<h4><a href="datatable_cliente.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Registrar</span> Formulario</h4>
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
							<li class="active">Formulario</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="datatable_cliente.php"><i class="icon-user-check"></i> Formulario</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<form action="#" class="form-a-cliente">
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
								
								
									<div class="col-md-3">
									    <legend class="text-semibold"><i class="icon-check position-left"></i> Datos Generales</legend>
									    
										<fieldset>
										<div class="form-group">
											<label>SAN</label>
											<input type="text" id="san" name="san" class="form-control" placeholder="HPEXXXXX" maxlength=50 required="required">
										</div>
										
										<div class="form-group">
											<label>Tipo Gestión</label>
												<select id="tipo_gestion" name="tipo_gestion" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Welcome">Welcome</option>
												<option value="Pre Welcome">Pre Welcome</option>
												
												</select>
										</div>
										
											<div class="form-group">	
											<label>Distribuidor</label>
											<select id="distribuidor" name="distribuidor" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
														require_once("php/clsFormulario.php");
														$obj = new clsFormulario;
														$arr_datos = $obj->distribuidor();
														foreach($arr_datos as $datos)
														echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
													?> 
											</select>
										</div>

										 <div class="form-group">	
											<label>Dealer</label>
											<select id="dealer" name="dealer" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													
											</select>
										</div>
										
										<div class="form-group">	
											<label>Tipicación</label>
											<select id="tipi" name="tipi" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
														require_once("php/clsFormulario.php");
														$obj = new clsFormulario;
														$arr_datos = $obj->tipis();
														foreach($arr_datos as $datos)
														echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
													?> 
													
											</select>
										</div>
										
											<div class="form-group">	
											<label>Tipicación 2</label>
											<select id="tipi2" name="tipi2" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												
													
											</select>
										</div>
										
										<div class="form-group">	
											<label>Validación Datos</label>
											<select id="validacion" name="validacion" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Exitosa">Exitosa</option>
												<option value="No Exitosa">No Exitosa</option>
													
											</select>
										</div>
										
										<div class="form-group">	
											<label>Ingreso Datos</label>
											<select id="ingreso" name="ingreso" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Correcto">Correcto</option>
												<option value="Incorrecto">Incorrecto</option>
													
											</select>
										</div>
										
										<div class="form-group">	
											<label>Welcome</label>
											<select id="welcome" name="welcome" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
										
										<div class="form-group">
											<label>Observación</label>
											<textarea class="form-control required" id="observacion" name="observacion" maxlength="500" ></textarea>
										</div>
										
									
										</fieldset>
										
									</div>
									
									
									<div class="col-md-3">
									
										<legend class="text-semibold"><i class="icon-user position-left"></i> Datos Cliente</legend>
										
										<fieldset> 
										<div class="form-group">
											<label>Nombre Completo</label>
											<input type="text" id="nombre" name="nombre" class="form-control" placeholder="" maxlength=50 required="required">
										</div>
										
										<div class="form-group">
											<label>Documento</label>
											<input type="text" id="documento" name="documento" class="form-control" placeholder="" maxlength=12 required="required">
										</div>
										
										<div class="form-group">
											<label>Dirección</label>
											<input type="text" id="direccion" name="direccion" class="form-control" placeholder="" maxlength=100 required="required">
										</div>
										
										<div class="form-group">
											<label>Email</label>
											<input type="text" id="email" name="email" class="form-control" placeholder="" maxlength=50 required="required">
										</div>
										
										</fieldset>
										
								    </div>
										
									
									<div class="col-md-3">
									
										<legend class="text-semibold"><i class="icon-phone position-left"></i> Datos Plan</legend>
										
										<fieldset> 
										<div class="form-group">
											<label>Plan Contratado</label>
											<select id="p_contratado" name="p_contratado" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
										<div class="form-group">
											<label>Reducción Velocidad</label>
											<select id="r_velocidad" name="r_velocidad" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
										<div class="form-group">
											<label>Datos [GB]</label>
										    <select id="gb" name="gb" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
										<div class="form-group">
											<label>Cant. Equipos</label>
											<select id="c_equipos" name="c_equipos" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
											<div class="form-group">
											<label>Velocidad D/C</label>
											<select id="velocidad_dc" name="velocidad_dc" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
											<div class="form-group">
											<label>Contrato Indefenido</label>
											<select id="contrato_indef" name="contrato_indef" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
											<div class="form-group">
											<label>Distribución GB</label>
											<select id="d_gb" name="d_gb" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
										<div class="form-group">
											<label>Permanencia</label>
											<select id="permanencia" name="permanencia" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
										<div class="form-group">
											<label>Costo</label>
											<select id="costo" name="costo" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
										</div>
										
											<div class="form-group">
											<label>Restricciones Servicio</label>
											<select id="restricciones" name="costo" data-placeholder="restricciones" class="select" required="required">
												<option value=""></option>
												<option value="Si">Si</option>
												<option value="No">No</option>
													
											</select>
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
				
	$("#distribuidor").change(function(e) {				
		var distribuidor = $(this).val();
		cargar_dealer(distribuidor);
	});
	
	$("#tipi").change(function(e) {				
		var tipi = $(this).val();
		tipi2(tipi);
	});			
				
				
});

function cargar_dealer(id) {
	$.ajax({
		data: {id:id},
		dataType: 'html',
		url: 'ajax/cbb_dealer.php',
		success:  function (response) {
			$("#dealer").html(response);
		}
	});
}


function tipi2(id) {
	$.ajax({
		data: {id:id},
		dataType: 'html',
		url: 'ajax/cbb_tipi.php',
		success:  function (response) {
			$("#tipi2").html(response);
		}
	});
}

			
		

</script>
</body>
</html>
