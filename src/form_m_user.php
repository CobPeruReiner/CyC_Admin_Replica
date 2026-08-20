<?php
header('Content-Type: text/html; charset=utf-8');
require_once("php/clsUsuario.php");
require_once("php/clsSucursal.php");
session_start();

function h_usuario($valor)
{
	return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function fecha_formulario_usuario($valor)
{
	$valor = trim((string)$valor);
	if ($valor === '' || substr($valor, 0, 10) === '0000-00-00') {
		return '';
	}
	if (preg_match('/^(\d{4}-\d{2}-\d{2})/', $valor, $m)) {
		return $m[1];
	}
	return $valor;
}

if (!isset($_SESSION['user_ls'])) {
	header("Location: index.php");
	exit;
}

$idPersonal = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($idPersonal <= 0) {
	header("Location: datatable_basic.php");
	exit;
}

$objUsuario = clsUsuario::select_user($idPersonal);
$objItem = clsUsuario::select_detalle($idPersonal);
$objRefrigerio = clsUsuario::select_refrigerio_personal($idPersonal);

if (empty($objUsuario)) {
	header("Location: datatable_basic.php");
	exit;
}

function isCombo($idhorario, $objItem)
{
	foreach ($objItem as $item) {
		if ((int)$item['idhorario'] === (int)$idhorario) {
			return (int)$item['idhorario'];
		}
	}
	return -1;
}

$obj = new clsUsuario;
$arr_datos = $obj->version_system();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo h_usuario($arr_datos[0][1]); ?></title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- CUSTOM CSS -->
	<link href="assets/css/custom/form_a_user.css" rel="stylesheet" type="text/css">
	<!-- /global CSS -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->

	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
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
	<!-- /theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="assets/js/pages/picker_date.js"></script>
</head>

<body>
	<?php include 'cabecera.php'; ?>

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4><a href="datatable_basic.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Modificar</span> Usuario</h4>
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
					<li class="active">Usuarios</li>
				</ul>

				<ul class="breadcrumb-elements">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gear position-left"></i>
							Opciones
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="form_a_user.php"><i class="icon-user-lock"></i> Nuevo Usuario</a></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">
			<form action="#" class="form-m-user" method="post" accept-charset="UTF-8">
				<div class="panel panel-flat">
					<input type="hidden" id="estado_original" value="<?php echo (int)$objUsuario['IDESTADO']; ?>">
					<div class="panel-heading">
						<div class="checkbox checkbox-switch">
							<label>
								<?php if ((int)$objUsuario['IDESTADO'] === 4) {
									echo ('<input type="checkbox" id="estado" name="estado" data-on-color="warning" data-off-color="danger" data-on-text="Vacaciones" data-off-text="Suspended" class="switch" checked="checked" disabled="disabled">');
								} elseif ((int)$objUsuario['IDESTADO'] === 1) {
									echo ('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" checked="checked">');
								} else {
									echo ('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" >');
								} ?>
							</label>
						</div>
						<?php if ((int)$objUsuario['IDESTADO'] === 4) { ?>
							<span class="help-block text-warning" style="margin-left: 10px;"><i class="icon-info22 position-left"></i> Estado VACACIONES: se conserva al guardar. Para registrar un cese use la opción Dar de baja del listado.</span>
						<?php } ?>

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
							<legend class="text-semibold"><i class="icon-reading position-left"></i> Datos Personales</legend>

							<div class="col-md-4">
								<fieldset>
									<div class="form-group">
										<label>Apellido(s)</label>
										<input type="hidden" id="id_user" name="id_user" class="form-control" value="<?php echo h_usuario(isset($objUsuario['IDPERSONAL']) ? $objUsuario['IDPERSONAL'] : ''); ?>">
										<input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellido Paterno, Materno" maxlength=70 required="required" value="<?php echo h_usuario(isset($objUsuario['APELLIDOS']) ? $objUsuario['APELLIDOS'] : ''); ?>">
									</div>

									<div class="form-group">
										<label>Nombre(s)</label>
										<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre Completo" maxlength=70 required="required" value="<?php echo h_usuario(isset($objUsuario['NOMBRES']) ? $objUsuario['NOMBRES'] : ''); ?>">
									</div>

									<div class="form-group">
										<label>Sexo</label>
										<select id="sexo" name="sexo" data-placeholder="Seleccione" class="form-control" required="required">
											<option value="">Seleccione</option>
											<option value="1" <?php echo $objUsuario['SEXO'] == '1' ? 'selected' : ''; ?>>Masculino</option>
											<option value="2" <?php echo $objUsuario['SEXO'] == '2' ? 'selected' : ''; ?>>Femenino</option>
										</select>
									</div>

									<div class="form-group">
										<label>Fecha Nacimiento</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar22"></i></span>
											<input type="text" id="fechanac" name="fechanac" class="form-control pickadate" placeholder="1991-02-03" value="<?php echo h_usuario(fecha_formulario_usuario(isset($objUsuario['FECHANAC']) ? $objUsuario['FECHANAC'] : '')); ?>" />
										</div>
									</div>

									<div class="form-group">
										<label>Estado Civil</label>
										<select id="ec" name="ec" data-placeholder="Seleccione" class="select" required="required">
											<option></option>
											<?php
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_ec();
											foreach ($arr_datos as $datos)
												if ($datos['id'] == $objUsuario['ESTCIV']) {
													echo '<option value="' . h_usuario($datos['id']) . '" selected>' . h_usuario($datos['nombre']) . ' </option>';
												} else {
													echo '<option value="' . h_usuario($datos['id']) . '">' . h_usuario($datos['nombre']) . '</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group">
										<label>Documento</label>
										<input type="text" id="dni" name="dni" class="form-control" placeholder="DNI" value="<?php echo h_usuario(isset($objUsuario['DOC']) ? $objUsuario['DOC'] : ''); ?>" maxlength=10 required="required">
									</div>

									<div class="form-group">
										<label>Cargo</label>
										<select id="cargo" name="cargo" data-placeholder="Seleccione" class="select" required="required">
											<option></option>
											<?php
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_tipo();
											foreach ($arr_datos as $datos)
												if ($datos['id'] == $objUsuario['CARGO']) {
													echo '<option value="' . h_usuario($datos['id']) . '" data-requiere-cartera="' . h_usuario($datos['requiere_cartera']) . '" selected>' . h_usuario($datos['nombre']) . ' </option>';
												} else {
													echo '<option value="' . h_usuario($datos['id']) . '" data-requiere-cartera="' . h_usuario($datos['requiere_cartera']) . '">' . h_usuario($datos['nombre']) . '</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group">
										<label>Móvil</label>
										<input type="text" id="movil" name="movil" class="form-control" placeholder="979846212" maxlength=9 required="required" value="<?php echo h_usuario(isset($objUsuario['CEL']) ? $objUsuario['CEL'] : ''); ?>">
									</div>

									<div class="form-group">
										<label>Fecha Ingreso</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar22"></i></span>
											<input type="text" id="fechaing" name="fechaing" class="form-control pickadate" value="<?php echo h_usuario(fecha_formulario_usuario(isset($objUsuario['fecha_ing']) ? $objUsuario['fecha_ing'] : '')); ?>" placeholder="1991-02-03" />
										</div>
									</div>
								</fieldset>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Fecha Cese</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="icon-calendar22"></i></span>
										<input type="text" id="fechabaja" name="fechabaja" class="form-control pickadate" value="<?php echo h_usuario(fecha_formulario_usuario(isset($objUsuario['fecha_baja']) ? $objUsuario['fecha_baja'] : '')); ?>" placeholder="1991-02-03" />
									</div>
								</div>

								<fieldset>
									<div class="form-group">
										<label>Dirección</label>
										<input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" maxlength=50 required="required" value="<?php echo h_usuario(isset($objUsuario['DIRECCION']) ? $objUsuario['DIRECCION'] : ''); ?>" />
									</div>

									<div class="form-group">
										<label>Departamento</label>
										<select id="departamento" name="departamento" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											$obj = new clsSucursal;
											$arr_datos = $obj->departamentos();
											foreach ($arr_datos as $datos)
												if ($datos['id'] == $objUsuario['codDepartamento']) {
													echo '<option value="' . h_usuario($datos['id']) . '" selected>' . h_usuario($datos['nombre']) . ' </option>';
												} else {
													echo '<option value="' . h_usuario($datos['id']) . '">' . h_usuario($datos['nombre']) . '</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group">
										<label>Provincia</label>
										<select id="provincia" name="provincia" class="select">
										</select>
									</div>

									<div class="form-group">
										<label>Distrito</label>
										<select id="distrito" name="distrito" class="select">
										</select>
									</div>

									<div class="form-group">
										<label>Referencia</label>
										<input type="text" id="referencia" name="referencia" class="form-control" placeholder="Tottus de la Marina" required="required" value="<?php echo h_usuario(isset($objUsuario['REFDIR']) ? $objUsuario['REFDIR'] : ''); ?>" />
									</div>

									<div class="form-group">
										<label>Familia</label>
										<select id="fam" name="fam" data-placeholder="Seleccione" class="form-control" required="required">
											<option value="">Seleccione</option>
											<option value="1" <?php echo $objUsuario['CARFAM'] == '1' ? 'selected' : ''; ?>>Si</option>
											<option value="0" <?php echo $objUsuario['CARFAM'] == '0' ? 'selected' : ''; ?>>No</option>
										</select>
									</div>

									<div class="form-group">
										<label>Hijos</label>
										<input type="number" min=0 id="hijos" name="hijos" class="form-control" placeholder="0" value="<?php echo h_usuario(isset($objUsuario['NUMHIJ']) ? $objUsuario['NUMHIJ'] : ''); ?>" />
									</div>

									<div class="form-group">
										<label>Teléfono</label>
										<input type="text" id="telefono" name="telefono" class="form-control" placeholder="15454562" maxlength=9 required="required" value="<?php echo h_usuario(isset($objUsuario['TLF']) ? $objUsuario['TLF'] : ''); ?>" />
									</div>
								</fieldset>
							</div>

							<div class="col-md-4">
								<fieldset>
									<div class="form-group">
										<label>Email</label>
										<input type="email" id="email" name="email" class="form-control" placeholder="hola@gmail.com" required="required" value="<?php echo h_usuario(isset($objUsuario['EMAIL']) ? $objUsuario['EMAIL'] : ''); ?>" />
									</div>

									<div class="form-group">
										<label>Correo corporativo <small>(opcional)</small></label>
										<input type="email" id="correo_corporativo" name="correo_corporativo" class="form-control" placeholder="usuario@empresa.com" autocomplete="off" value="<?php echo h_usuario(isset($objUsuario['CORREO_CORPORATIVO']) ? $objUsuario['CORREO_CORPORATIVO'] : ''); ?>" />
										<span class="help-block">Puede completarse o actualizarse cuando el correo sea creado posteriormente.</span>
									</div>

									<div class="form-group">
										<label>Instucción</label>
										<select id="gi" name="gi" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_gi();
											foreach ($arr_datos as $datos)
												if ($datos['id'] == $objUsuario['GRADOINS']) {
													echo '<option value="' . h_usuario($datos['id']) . '" selected>' . h_usuario($datos['nombre']) . ' </option>';
												} else {
													echo '<option value="' . h_usuario($datos['id']) . '">' . h_usuario($datos['nombre']) . '</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group">
										<label>Sucursal</label>
										<select id="suc" name="suc" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_sucursal();
											foreach ($arr_datos as $datos)
												if ($datos['id'] == $objUsuario['IDSUCURSAL']) {
													echo '<option value="' . h_usuario($datos['id']) . '" selected>' . h_usuario($datos['nombre']) . ' </option>';
												} else {
													echo '<option value="' . h_usuario($datos['id']) . '">' . h_usuario($datos['nombre']) . '</option>';
												}
											?>
										</select>
									</div>

									<div class="form-group">
										<label>Horario</label>
										<div class="multi-select-full">
											<select class="multiselect" multiple="multiple" required="required">
												<?php
												require_once("php/clsUsuario.php");
												$obj = new clsUsuario;
												$arr_datos = $obj->consulta_horario();
												foreach ($arr_datos as $datos)
													if (isCombo($datos['id'], $objItem) == $datos['id']) {
														echo '<option value="' . h_usuario($datos['id']) . '" selected>' . h_usuario($datos['nombre']) . '</option>';
													} else {
														echo '<option value="' . h_usuario($datos['id']) . '">' . h_usuario($datos['nombre']) . '</option>';
													}
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label>Hora de almuerzo</label>
										<select id="refrigerio" name="refrigerio" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_refrigerio();
											$refrigerioActual = isset($objRefrigerio['ID_REFRIGERIO']) ? (int)$objRefrigerio['ID_REFRIGERIO'] : 0;
											foreach ($arr_datos as $datos) {
												$selected = ((int)$datos['id'] === $refrigerioActual) ? ' selected="selected"' : '';
												echo '<option value="' . h_usuario($datos['id']) . '"' . $selected . '>' . h_usuario($datos['nombre']) . '</option>';
											}
											?>
										</select>
										<span class="help-block text-info"><i class="icon-help position-right"></i> Campo obligatorio. Al cambiarlo se cierra la asignación anterior y se registra una nueva.</span>
									</div>

									<div class="form-group" id="cartera-contenedor" style="display:none;">
										<label>Cartera <span id="cartera-obligatoria" class="text-danger" style="display:none;">*</span></label>
										<select id="cartera" name="cartera" data-placeholder="Seleccione" class="select">
											<option value=""></option>
											<?php
											$carteraActual = isset($objUsuario['id_cartera']) ? (int)$objUsuario['id_cartera'] : 0;
											echo '<option value="0" data-tiene-grupos="0"' . ($carteraActual === 0 ? ' selected="selected"' : '') . '>NINGUNA CARTERA</option>';

											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_carteras_activas();
											$carteraActualEncontrada = false;
											foreach ($arr_datos as $datos) {
												$seleccionada = ((int)$datos['id'] === $carteraActual);
												if ($seleccionada) {
													$carteraActualEncontrada = true;
												}
												echo '<option value="' . h_usuario($datos['id']) . '" data-tiene-grupos="' . h_usuario($datos['tiene_grupos']) . '"' . ($seleccionada ? ' selected="selected"' : '') . '>' . h_usuario($datos['nombre']) . '</option>';
											}

											if ($carteraActual > 0 && !$carteraActualEncontrada) {
												$datosCarteraActual = clsUsuario::consulta_cartera_por_id($carteraActual);
												if (!empty($datosCarteraActual)) {
													echo '<option value="' . h_usuario($datosCarteraActual['id']) . '" data-tiene-grupos="0" selected="selected">' . h_usuario($datosCarteraActual['nombre']) . ' | ASIGNACIÓN ACTUAL</option>';
												}
											}
											?>
										</select>
										<span id="cartera-ayuda" class="help-block text-info">Selecciona la cartera principal del personal.</span>
									</div>

									<div class="form-group" id="grupo-cartera-contenedor" style="display:none;">
										<label>Grupo de cartera <span id="grupo-cartera-obligatorio" class="text-danger" style="display:none;">*</span></label>
										<select id="id_grupo_cartera" name="id_grupo_cartera" data-placeholder="Seleccione" class="select">
											<?php
											$grupoCarteraActual = isset($objUsuario['id_grupo_cartera']) ? (int)$objUsuario['id_grupo_cartera'] : 0;
											echo '<option value="0" data-id-cartera="0"' . ($grupoCarteraActual === 0 ? ' selected="selected"' : '') . '>SIN GRUPO</option>';
											$obj = new clsUsuario;
											$arr_grupos = $obj->consulta_grupos_cartera_activos();
											foreach ($arr_grupos as $grupo) {
												$seleccionadoGrupo = ((int)$grupo['id'] === $grupoCarteraActual);
												echo '<option value="' . h_usuario($grupo['id']) . '" data-id-cartera="' . h_usuario($grupo['id_cartera']) . '"' . ($seleccionadoGrupo ? ' selected="selected"' : '') . '>' . h_usuario($grupo['nombre']) . '</option>';
											}
											?>
										</select>
										<span id="grupo-cartera-ayuda" class="help-block text-info">Solo aplica para carteras segmentadas, como Scotiabank.</span>
									</div>

									<blockquote>
										<label><i class="icon-user-lock position-left"></i> Acceso</label>

										<hr>

										<div class="form-group">
											<label>Usuario</label>
											<input type="text" id="user" name="user" placeholder="admin" class="form-control" maxlength=15 required="required" value="<?php echo h_usuario(isset($objUsuario['USUARIO']) ? $objUsuario['USUARIO'] : ''); ?>">
										</div>

										<div class="form-group">
											<div>
												<label>Password</label>
												<i class="icon-add" id='password-add' style='cursor: pointer'></i>
											</div>
											<div class="password-container">
												<input id="password" name="password" type="password" class="form-control"
													placeholder="Dejar vacío para conservar la contraseña actual"
													maxlength="20"
													autocomplete="new-password"
													pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$"
													value="">
												<i class="icon-eye8 toggle-password" id='toggle-password'></i>
											</div>
											<span class="help-block text-info"><i class="icon-help position-right"></i> Déjela vacía para conservar la contraseña actual. Si escribe una nueva, debe tener mínimo 8 caracteres, incluyendo mayúscula, minúscula, número y símbolo especial</span>
										</div>
									</blockquote>
								</fieldset>
							</div>
						</div>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">Modificar <i class="icon-arrow-right14 position-right"></i></button>
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

			$('.multiselect').multiselect({
				onChange: function() {
					$.uniform.update();
				}
			});

			$('.multiselect-full').multiselect({
				buttonWidth: '100%'
			});

			var departamento = $("#departamento").val();
			cargar_provincias(departamento);

			$("#departamento").change(function(e) {
				var departamento = $(this).val();
				cargar_provincias(departamento);
			});

			$("#provincia").change(function(e) {
				var provincia = $(this).val();
				var id = $(this).val().split('|');
				console.log(id[0]);
				//console.log(provincia);
				cargar_distritos(id[0], id[1]);
			});

		});


		function cargar_provincias(id) {
			$.ajax({
				data: {
					id: id
				},
				dataType: 'html',
				url: 'ajax/cbb_provincia.php',
				success: function(response) {
					$("#provincia").html(response);
					//console.log(response);

					var departamento = $("#departamento").val();
					var provincia = '<?php echo isset($objUsuario['codProvincia']) ? $objUsuario['codProvincia'] : 0 ?>';
					//console.log(departamento+'|'+provincia);
					if (provincia > 0) {

						$("#provincia").val(departamento + '|' + provincia).trigger('change');
					}

				}
			});
		}

		function cargar_distritos(id, id2) {
			$.ajax({
				data: {
					id: id,
					id2: id2
				},
				dataType: 'html',
				url: 'ajax/cbb_distrito.php',
				success: function(response) {
					$("#distrito").html(response);

					var departamento = $("#departamento").val();
					var provincia = '<?php echo isset($objUsuario['codProvincia']) ? $objUsuario['codProvincia'] : 0 ?>';
					var distrito = '<?php echo isset($objUsuario['codDistrito']) ? $objUsuario['codDistrito'] : 0 ?>';
					//console.log(departamento+'|'+provincia);
					if (distrito > 0) {

						$("#distrito").val(departamento + '|' + provincia + '|' + distrito).trigger('change');
					}


				}
			});
		}

		// PASSWORD HANDLER
		function generatePassword(length = 10) {
			const lower = "abcdefghijklmnopqrstuvwxyz";
			const upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			const numbers = "0123456789";
			const symbols = "!@#$%^&*()_+{}:<>?|[];',./`~";

			const all = lower + upper + numbers + symbols;

			let password =
				lower[Math.floor(Math.random() * lower.length)] +
				upper[Math.floor(Math.random() * upper.length)] +
				numbers[Math.floor(Math.random() * numbers.length)] +
				symbols[Math.floor(Math.random() * symbols.length)];

			for (let i = 4; i < length; i++) {
				password += all[Math.floor(Math.random() * all.length)];
			}

			return password
				.split('')
				.sort(() => 0.5 - Math.random())
				.join('');
		}

		const password = document.getElementById('password')
		const passwordAdd = document.getElementById('password-add')
		passwordAdd.addEventListener('click', () => {
			password.value = generatePassword()
		})

		// EYE HANDLER
		const eyeIcon = document.getElementById('toggle-password')

		eyeIcon.addEventListener('click', function() {
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			this.classList.toggle('icon-eye8');
			this.classList.toggle('icon-eye-blocked');
		})
	</script>

</body>

</html>