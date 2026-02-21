<?php

session_start();
if (!isset($_SESSION['user_ls']))
	header("Location: index.php");
require_once("php/clsUsuario.php");
require_once("php/clsDashboard.php");
$obj = new clsUsuario;
$obj2 = new clsDashboard;
$arr_datos = $obj->version_system();
$arr_datos2 = $obj2->gestiones_ctd();
//	 echo date("m/d/Y");

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo ($arr_datos[0][1]); ?></title>
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
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>

	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>


	<script type="text/javascript" src="assets/js/plugins/visualization/dimple/dimple.min.js"></script>
	<script type="text/javascript" src="assets/js/charts/dimple/pies/pie_legend.js"></script>

	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/dashboard.js"></script>


	<!-- /theme JS files -->
</head>
<style>
	.not-active {
		pointer-events: none;
		cursor: default;
		opacity: 0.5;
		color: red;
	}
</style>

<body>

	<?php include 'cabecera.php'; ?>
	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-pie-chart8 position-left"></i> <span class="text-semibold">Mi</span> Dashboard</h4>
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
					<li class="active">Dashboard</li>
				</ul>

				<ul class="breadcrumb-elements">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gear position-left"></i>
							Opciones
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#"><i class="icon-accessibility"></i> Acceso</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->

		<!-- Content area -->
		<div class="content">

			<!-- Main charts -->
			<div class="row">
				<div class="col-lg-7">

					<!-- Traffic sources -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h7 class="panel-title" style="position: initial !important;"> Tráfico de Usuarios Mensual: <b>
									<?php
									$fecha = date('m');
									$mes = nombremes(intval($fecha));
									echo strtoupper($mes);
									function nombremes($mes)
									{
										setlocale(LC_TIME, 'spanish');
										$nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
										return $nombre;
									}
									?>
								</b></h7>
							<div class="heading-elements">
								<form class="heading-form" action="#">
									<div class="form-group">
										<label class="checkbox-inline checkbox-switchery checkbox-right switchery-xs">
											<input type="checkbox" class="switch" checked="checked">
											Live update:
										</label>
									</div>
								</form>
							</div>
						</div>

						<div class="container-fluid">
							<div class="row">
								<div class="col-lg-4">
									<ul class="list-inline text-center">
										<li>
											<a href="#" class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-plus3"></i></a>
										</li>
										<li class="text-left">
											<div class="text-semibold">Usuario</div>
											<div class="text-muted"><span id="dash_user"></span></div>
										</li>
									</ul>

									<div class="col-lg-10 col-lg-offset-1">
										<div class="content-group" id="new-visitors"></div>
									</div>
								</div>

								<div class="col-lg-4">
									<ul class="list-inline text-center">
										<li>
											<a href="#" class="btn border-warning-400 text-warning-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-watch2"></i></a>
										</li>
										<li class="text-left">
											<div class="text-semibold">Sesion</div>
											<div class="text-muted"><span id="dash_fecha"></span></div>
										</li>
									</ul>

									<div class="col-lg-10 col-lg-offset-1">
										<div class="content-group" id="new-sessions"></div>
									</div>
								</div>

								<div class="col-lg-4">
									<ul class="list-inline text-center">
										<li>
											<a href="#" class="btn border-indigo-400 text-indigo-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-people"></i></a>
										</li>
										<li class="text-left">
											<div class="text-semibold">Total online</div>
											<div class="text-muted"><span class="status-mark border-success position-left"></span> <span id="dash_online"><span></div>
										</li>
									</ul>

									<div class="col-lg-10 col-lg-offset-1">
										<div class="content-group" id="total-online"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="position-relative" id="traffic-sources"></div>
					</div>
					<!-- /traffic sources -->

				</div>

				<div class="col-lg-4">

					<!-- Members online -->
					<div class="panel bg-teal-400">
						<div class="panel-body">
							<div class="heading-elements">
								<span class="heading-text badge bg-teal-800"><?php echo rand(45 * 10, 100 * 10) / 10; ?>%</span>
							</div>

							<h3 class="no-margin"><span id="dash_logeos"></span><span class="text-muted text-size-small"> Mensual</span><br /><span id="dash_logeos_year"></span><span class="text-muted text-size-small"> Anual</span></h3>
							Registro Logeos
							<div class="text-muted text-size-small"></div>
						</div>

						<div class="container-fluid">
							<div id="members-online"></div>
						</div>
					</div>
					<!-- /members online -->

				</div>

				<div class="col-lg-4">

					<!-- Current server load -->
					<div class="panel bg-pink-400">
						<div class="panel-body">
							<div class="heading-elements">
								<ul class="icons-list">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
											<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
											<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
										</ul>
									</li>
								</ul>
							</div>

							<h3 class="no-margin"><span id="apache_sis"><?php echo rand(45 * 10, 91 * 10) / 10; ?></span>%</h3>
							Redimiento Server
							<div class="text-muted text-size-small">Apache/Base Datos</div>
						</div>

						<div id="server-load"></div>
					</div>
					<!-- /current server load -->

				</div>

				<div class="col-lg-4">

					<!-- Today's revenue -->
					<div class="panel bg-blue-400">
						<div class="panel-body">
							<div class="heading-elements">
								<ul class="icons-list">
									<li><a data-action="reload"></a></li>
								</ul>
							</div>

							<h3 class="no-margin"><span id="dash_proyectos"></span></h3>
							Total FileContacto
							<div class="text-muted text-size-small"></div>
						</div>

						<div id="today-revenue"></div>
					</div>
					<!-- /today's revenue -->

				</div>

				<!-- /quick stats boxes -->



			</div>

			<!-- /main charts -->


			<!-- Progress counters -->
			<div class="row">
				<div class="col-md-4">

					<!-- Available hours -->
					<div class="panel text-center">
						<div class="panel-body">
							<div class="heading-elements">
								<ul class="icons-list">
									<li class="dropdown text-muted">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
											<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
											<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
											<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
										</ul>
									</li>
								</ul>
							</div>

							<!-- Progress counter -->
							<div class="content-group-sm svg-center position-relative" id="hours-available-progress"></div>
							<!-- /progress counter -->

						</div>
					</div>
					<!-- /available hours -->

				</div>

				<div class="col-md-4">

					<!-- Productivity goal -->
					<div class="panel text-center">
						<div class="panel-body">
							<div class="heading-elements">
								<ul class="icons-list">
									<li class="dropdown text-muted">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
											<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
											<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
											<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
										</ul>
									</li>
								</ul>
							</div>

							<!-- Progress counter -->
							<div class="content-group-sm svg-center position-relative" id="goal-progress"></div>
							<!-- /progress counter -->


						</div>
					</div>
					<!-- /productivity goal -->

				</div>

				<div class="col-md-4">
					<div class="panel text-center">
						<div class="panel-body">
							<div class="heading-elements">
								<ul class="icons-list">
									<li class="dropdown text-muted">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i> <span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="#"><i class="icon-sync"></i> Update data</a></li>
											<li><a href="#"><i class="icon-list-unordered"></i> Detailed log</a></li>
											<li><a href="#"><i class="icon-pie5"></i> Statistics</a></li>
											<li><a href="#"><i class="icon-cross3"></i> Clear list</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="content-group-sm svg-center position-relative" id="g-progress"></div>

						</div>
					</div>
				</div>



				<div class="col-md-12">
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
							<div class="chart-container">
								<div class="chart svg-center" id="dimple-pie-legend"></div>
							</div>
						</div>
					</div>
				</div>


			</div>
			<!-- /progress counters -->


		</div>
		<!-- /content area -->



	</div>
	<!-- /main content -->

	</div>
	<!-- /page content -->

	</div>
	<!-- /page container -->
	<script>
		$(document).ready(function() {
			//Cada 10 segundos (10000 milisegundos) se ejecutará la función refrescar
			//setTimeout(refrescar, 1000);

			// Basic
			$('.select').select2();

			// Format icon
			function iconFormat(icon) {
				var originalOption = icon.element;
				if (!icon.id) {
					return icon.text;
				}
				var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

				return $icon;
			}

			// Initialize with options
			$(".select-icons").select2({
				templateResult: iconFormat,
				minimumResultsForSearch: Infinity,
				templateSelection: iconFormat,
				escapeMarkup: function(m) {
					return m;
				}
			});


			$("#btn_excel").click(function(e) {
				e.preventDefault();
				bootbox.confirm("\u00bfDesea generar archivo excel?", function(result) {
					if (result) {
						abrirNuevaVentana('excel_gestion.php?fecha_inicio=' + $('.daterange-ranges span').text().substring(0, 10) + ' 00:00:00' + '&fecha_fin=' + $('.daterange-ranges span').text().substring(13, 23) + ' 23:59:59' + '&cuenta=' + $('#cuenta').val());
					}
				});
			});


		});

		function refrescar() {
			location.reload();
		}


		function abrirNuevaVentana(url) {
			var $w = $('<a style="display: none;"  href="' + url + '"/>');
			$("body").append($w)
			$w[0].click();
			$w.remove();
		}
	</script>

</body>

</html>