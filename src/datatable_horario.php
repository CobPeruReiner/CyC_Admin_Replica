<?php
session_start();
if (!isset($_SESSION['user_ls']))
	header("Location: index.php");
require_once("php/clsUsuario.php");
$obj = new clsUsuario;
$arr_datos = $obj->version_system();
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
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
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
					<h4><i class="icon-watch2 position-left"></i> <span class="text-semibold">Administraci&oacute;n</span> Horarios</h4>
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
					<li class="active">Horario</li>
				</ul>

				<ul class="breadcrumb-elements">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gear position-left"></i>
							Opciones
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="form_a_horario.php"><i class="icon-watch"></i> Nuevo Horaio</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

			<!-- Basic datatable -->
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

				<table class="table datatable-horario" style="font-size: 11px;">
					<thead>
						<tr>
							<th>Id</th>
							<th>Nombre</th>
							<th>Tipo</th>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Estado</th>
							<th class="text-center">Opciones</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>


			</div>
			<!-- /basic datatable -->

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