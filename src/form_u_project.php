<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsProject.php");
	session_start();
	if (!isset($_SESSION['user_ls'])){
		header("Location: index.php");
	}elseif ($_REQUEST['id']=="" ){
		header("Location: datatable_project.php");
	}else{
		$objProject = clsProject::select_project($_REQUEST['id']);
		//var_dump($objProject[0]['consulting']);
	}

	$obj = new clsUsuario;
	$arr_datos = $obj->version_system();
	$sociedad = $obj->sociedad_system();
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
	<script type="text/javascript" src="assets/js/plugins/forms/wizards/steps.min.js"></script>
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
	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
	<script type="text/javascript" src="assets/js/pages/wizard_steps.js"></script>
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
							<h4><a href="datatable_project.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Plan</span> de Trabajo</h4>
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
							<li class="active">Plan de Trabajo</li>
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
		
							<!-- Basic setup -->
		            <div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Workflow <?php echo $objProject[0]['consulting'];?></h6>
							<h6 class="panel-title"><b>Cliente:</b> <?php echo $objProject[0]['cliente'];?></h6>
							<h6 class="panel-title"><b>Normas:</b> <?php echo $objProject[0]['normas'];?></h6>
							<h6 class="panel-title"><b>Fecha Inicio/Fin:</b> <?php echo $objProject[0]['fecha_inicio'].' - '.$objProject[0]['fecha_fin'];?></h6>
							<h6 class="panel-title"><b>Duración: </b> <?php echo $objProject[0]['plazo'].' días';?></h6>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>

	                	<form class="steps-basic" action="#">
							<h6>DISEÑO DE SISTEMA DOCUMENTARIO</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="hidden" id="id_project" name="id_project" class="form-control" value="<?php echo $_REQUEST['id'];?>">
											<?php	
												$obj = new clsProject;
												$arr_datos = $obj->select_project($_REQUEST['id']);
												echo '<table border=0 class="table">';
												echo '<tr>
														<td><b>ACTIVIDAD</b></td>
														<td><b>ESTADO</b></td>
													  </tr>';
												foreach($arr_datos as $datos)
												if($datos['id_elemento']==1){
													/*RECUPERA DATOS*/
													$checked_pe = ($datos['estado_e']=="PENDIENTE") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Pendiente' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Pendiente';
													$checked_pr = ($datos['estado_e']=="PROGRAMADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Programado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Programado';
													$checked_ej = ($datos['estado_e']=="EJECUTADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Ejecutado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Ejecutado';
													$fecha_inicio_e = ($datos['fecha_inicio_e']=="0000-00-00") ? $objProject[0]['fecha_inicio'] : $datos['fecha_inicio_e'];
													$fecha_fin_e = ($datos['fecha_fin_e']=="0000-00-00") ? $objProject[0]['fecha_fin'] : $datos['fecha_fin_e'];
													/*FIN RECUPERA DATOS*/

													echo '<tr data-item='.$datos['id_subelemento'].'><td>'.$datos['sub_elemento'].'<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" class="form-control daterange-weeknumbers" value="'.$fecha_inicio_e.' - '.$fecha_fin_e.'"></div></td>';
													echo '<td><div class="form-group">
																<div class="radio">
																	<label>'.$checked_pe.'
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_pr.'				
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_ej.'
																	</label>
																</div>

															</div></td></tr>';
														
												}
												echo '</table>';
											?> 
										</div>
											
									</div>

								
								</div>

							</fieldset>

							<h6>PLANIFICAR</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?php	
												$obj = new clsProject;
												$arr_datos = $obj->select_project($_REQUEST['id']);
												echo '<table border=0 class="table">';
												echo '<tr>
														<td><b>ACTIVIDAD</b></td>
														<td><b>ESTADO</b></td>
													  </tr>';
												foreach($arr_datos as $datos)
												if($datos['id_elemento']==2){
													/*RECUPERA DATOS*/
													$checked_pe = ($datos['estado_e']=="PENDIENTE") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Pendiente' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Pendiente';
													$checked_pr = ($datos['estado_e']=="PROGRAMADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Programado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Programado';
													$checked_ej = ($datos['estado_e']=="EJECUTADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Ejecutado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Ejecutado';
													$fecha_inicio_e = ($datos['fecha_inicio_e']=="0000-00-00") ? $objProject[0]['fecha_inicio'] : $datos['fecha_inicio_e'];
													$fecha_fin_e = ($datos['fecha_fin_e']=="0000-00-00") ? $objProject[0]['fecha_fin'] : $datos['fecha_fin_e'];
													/*FIN RECUPERA DATOS*/

													echo '<tr data-item='.$datos['id_subelemento'].'><td>'.$datos['sub_elemento'].'<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" class="form-control daterange-weeknumbers" value="'.$fecha_inicio_e.' - '.$fecha_fin_e.'"></div></td>';
													echo '<td><div class="form-group">
																<div class="radio">
																	<label>'.$checked_pe.'
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_pr.'				
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_ej.'
																	</label>
																</div>

															</div></td></tr>';
														
												}
												echo '</table>';
											?> 
											
										</div>
									</div>

								
								</div>
							</fieldset>

							<h6>HACER</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?php	
												$obj = new clsProject;
												$arr_datos = $obj->select_project($_REQUEST['id']);
												echo '<table border=0 class="table">';
												echo '<tr>
														<td><b>ACTIVIDAD</b></td>
														<td><b>ESTADO</b></td>
													  </tr>';
												foreach($arr_datos as $datos)
												if($datos['id_elemento']==3){
													/*RECUPERA DATOS*/
													$checked_pe = ($datos['estado_e']=="PENDIENTE") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Pendiente' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Pendiente';
													$checked_pr = ($datos['estado_e']=="PROGRAMADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Programado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Programado';
													$checked_ej = ($datos['estado_e']=="EJECUTADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Ejecutado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Ejecutado';
													$fecha_inicio_e = ($datos['fecha_inicio_e']=="0000-00-00") ? $objProject[0]['fecha_inicio'] : $datos['fecha_inicio_e'];
													$fecha_fin_e = ($datos['fecha_fin_e']=="0000-00-00") ? $objProject[0]['fecha_fin'] : $datos['fecha_fin_e'];
													/*FIN RECUPERA DATOS*/

													echo '<tr data-item='.$datos['id_subelemento'].'><td>'.$datos['sub_elemento'].'<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" class="form-control daterange-weeknumbers" value="'.$fecha_inicio_e.' - '.$fecha_fin_e.'"></div></td>';
													echo '<td><div class="form-group">
																<div class="radio">
																	<label>'.$checked_pe.'
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_pr.'				
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_ej.'
																	</label>
																</div>

															</div></td></tr>';
														
												}
												echo '</table>';
											?> 
											
										</div>
									</div>

								
								</div>
							</fieldset>

							<h6>VERIFICAR</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?php	
												$obj = new clsProject;
												$arr_datos = $obj->select_project($_REQUEST['id']);
												echo '<table border=0 class="table">';
												echo '<tr>
														<td><b>ACTIVIDAD</b></td>
														<td><b>ESTADO</b></td>
													  </tr>';
												foreach($arr_datos as $datos)
												if($datos['id_elemento']==4){
													/*RECUPERA DATOS*/
													$checked_pe = ($datos['estado_e']=="PENDIENTE") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Pendiente' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Pendiente';
													$checked_pr = ($datos['estado_e']=="PROGRAMADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Programado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Programado';
													$checked_ej = ($datos['estado_e']=="EJECUTADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Ejecutado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Ejecutado';
													$fecha_inicio_e = ($datos['fecha_inicio_e']=="0000-00-00") ? $objProject[0]['fecha_inicio'] : $datos['fecha_inicio_e'];
													$fecha_fin_e = ($datos['fecha_fin_e']=="0000-00-00") ? $objProject[0]['fecha_fin'] : $datos['fecha_fin_e'];
													/*FIN RECUPERA DATOS*/

													echo '<tr data-item='.$datos['id_subelemento'].'><td>'.$datos['sub_elemento'].'<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" class="form-control daterange-weeknumbers" value="'.$fecha_inicio_e.' - '.$fecha_fin_e.'"></div></td>';
													echo '<td><div class="form-group">
																<div class="radio">
																	<label>'.$checked_pe.'
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_pr.'				
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_ej.'
																	</label>
																</div>

															</div></td></tr>';
														
												}
												echo '</table>';
											?> 
											
										</div>
									</div>

								
								</div>
							</fieldset>

							<h6>MEJORA</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?php	
												$obj = new clsProject;
												$arr_datos = $obj->select_project($_REQUEST['id']);
												echo '<table border=0 class="table">';
												echo '<tr>
														<td><b>ACTIVIDAD</b></td>
														<td><b>ESTADO</b></td>
													  </tr>';
												foreach($arr_datos as $datos)
												if($datos['id_elemento']==5){
													/*RECUPERA DATOS*/
													$checked_pe = ($datos['estado_e']=="PENDIENTE") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Pendiente' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Pendiente';
													$checked_pr = ($datos['estado_e']=="PROGRAMADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Programado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Programado';
													$checked_ej = ($datos['estado_e']=="EJECUTADO") ? '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled" checked>Ejecutado' : '<input type="radio" name="availability'.$datos['id_subelemento'].'" class="styled">Ejecutado';
													$fecha_inicio_e = ($datos['fecha_inicio_e']=="0000-00-00") ? $objProject[0]['fecha_inicio'] : $datos['fecha_inicio_e'];
													$fecha_fin_e = ($datos['fecha_fin_e']=="0000-00-00") ? $objProject[0]['fecha_fin'] : $datos['fecha_fin_e'];
													/*FIN RECUPERA DATOS*/

													echo '<tr data-item='.$datos['id_subelemento'].'><td>'.$datos['sub_elemento'].'<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" class="form-control daterange-weeknumbers" value="'.$fecha_inicio_e.' - '.$fecha_fin_e.'"></div></td>';
													echo '<td><div class="form-group">
																<div class="radio">
																	<label>'.$checked_pe.'
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_pr.'				
																	</label>
																</div>

																<div class="radio">
																	<label>'.$checked_ej.'
																	</label>
																</div>

															</div></td></tr>';
														
												}
												echo '</table>';
											?> 
											
										</div>
									</div>

								
								</div>
							</fieldset>

						</form>
		            </div>
		            <!-- /basic setup -->
			

	
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
