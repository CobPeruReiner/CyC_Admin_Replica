<?php
require_once("php/clsUsuario.php");
require_once("php/clsTable.php");
session_start();
if (!isset($_SESSION['user_ls'])) {
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
	<title><?php echo ($arr_datos[0][1]); ?></title>
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
					<h4><a href="datatable_basic.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Registrar</span> Usuario</h4>
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
			<form action="#" class="form-user">
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
							<legend class="text-semibold"><i class="icon-reading position-left"></i> Datos Personales</legend>

							<div class="col-md-4">
								<fieldset>

									<div class="form-group">
										<label>Apellido(s)</label>
										<input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellido Paterno, Materno" maxlength=70 required="required">
									</div>

									<div class="form-group">
										<label>Nombre(s)</label>
										<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre Completo" maxlength=70 required="required">
									</div>
									<div class="form-group">
										<label>Sexo</label>
										<select id="sexo" name="sexo" data-placeholder="Seleccione" class="form-control" required="required">
											<option value="">Seleccione</option>
											<option value="1">Masculino</option>
											<option value="2">Femenino</option>
										</select>
									</div>

									<div class="form-group">
										<label>Fecha Nacimiento</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar22"></i></span>
											<input type="text" id="fechanac" name="fechanac" class="form-control pickadate" placeholder="1991-02-03" />
										</div>
									</div>

									<div class="form-group">
										<label>Estado Civil</label>
										<select id="ec" name="ec" data-placeholder="Seleccione" class="select" required="required">
											<option></option>
											<?php
											require_once("php/clsUsuario.php");
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_ec();
											foreach ($arr_datos as $datos)
												echo '<option value="' . $datos['id'] . '">' . $datos['nombre'] . '</option>';
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Documento</label>
										<input type="text" id="dni" name="dni" class="form-control" placeholder="DNI" maxlength=10 required="required">
									</div>
									<div class="form-group">
										<label>Cargo</label>
										<select id="cargo" name="cargo" data-placeholder="Seleccione" class="select" required="required">
											<option></option>
											<?php
											require_once("php/clsUsuario.php");
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_tipo();
											foreach ($arr_datos as $datos)
												echo '<option value="' . $datos['id'] . '">' . $datos['nombre'] . '</option>';
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Móvil</label>
										<input type="text" id="movil" name="movil" class="form-control" placeholder="979846212" maxlength=9 required="required">
									</div>

									<div class="form-group">
										<label>Fecha Ingreso</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar22"></i></span>
											<input type="text" id="fechaing" name="fechaing" class="form-control pickadate" placeholder="1991-02-03" />
										</div>
									</div>

								</fieldset>
							</div>

							<div class="col-md-4">

								<fieldset>

									<div class="form-group">
										<label>Dirección</label>
										<input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" maxlength=50 required="required">
									</div>
									<div class="form-group">
										<label>Departamento</label>
										<select id="departamento" name="departamento" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											require_once("php/clsSucursal.php");
											$obj = new clsSucursal;
											$arr_datos = $obj->departamentos();
											foreach ($arr_datos as $datos)
												echo '<option value="' . $datos['id'] . '">' . $datos['nombre'] . '</option>';
											?>
										</select>
									</div>

									<div class="form-group">
										<label>Provincia</label>
										<select id="provincia" name="provincia" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>

										</select>
									</div>

									<div class="form-group">
										<label>Distrito</label>
										<select id="distrito" name="distrito" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>

										</select>
									</div>

									<div class="form-group">
										<label>Referencia</label>
										<input type="text" id="referencia" name="referencia" class="form-control" placeholder="Tottus de la Marina" required="required" />
									</div>
									<div class="form-group">
										<label>Familia</label>
										<select id="fam" name="fam" data-placeholder="Seleccione" class="form-control" required="required">
											<option value="">Seleccione</option>
											<option value="1">Si</option>
											<option value="0">No</option>
										</select>
									</div>

									<div class="form-group">
										<label>Hijos</label>
										<input type="number" min=0 id="hijos" name="hijos" class="form-control" placeholder="0" />
									</div>
									<div class="form-group">
										<label>Teléfono</label>
										<input type="text" id="telefono" name="telefono" class="form-control" placeholder="15454562" maxlength=9 required="required">
									</div>

								</fieldset>
							</div>

							<div class="col-md-4">

								<fieldset>

									<div class="form-group">
										<label>Email</label>
										<input type="email" id="email" name="email" class="form-control" placeholder="hola@gmail.com" required="required" />
									</div>
									<div class="form-group">
										<label>Instucción</label>
										<select id="gi" name="gi" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											require_once("php/clsUsuario.php");
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_gi();
											foreach ($arr_datos as $datos)
												echo '<option value="' . $datos['id'] . '">' . $datos['nombre'] . '</option>';
											?>
										</select>
									</div>



									<div class="form-group">
										<label>Sucursal</label>
										<select id="suc" name="suc" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											require_once("php/clsUsuario.php");
											$obj = new clsUsuario;
											$arr_datos = $obj->consulta_sucursal();
											foreach ($arr_datos as $datos)
												echo '<option value="' . $datos['id'] . '">' . $datos['nombre'] . '</option>';
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
													echo '<option value="' . $datos['id'] . '">' . $datos['nombre'] . '</option>';
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label>Cartera</label>
										<select id="cartera" name="cartera" data-placeholder="Seleccione" class="select" required="required">
											<option value=""></option>
											<?php
											$obj = new clsTable;
											$arr_datos = $obj->carteras();
											foreach ($arr_datos as $datos)
												echo '<option value="' . $datos['id'] . '">' . $datos['nombre'] . '</option>';
											?>
										</select>
									</div>


									<blockquote>
										<label><i class="icon-user-lock position-left"></i> Acceso</label>
										<hr>
										<div class="form-group">
											<label>Usuario</label>
											<input type="text" id="user" name="user" placeholder="admin" class="form-control" maxlength=15 required="required">
										</div>

										<div class="form-group">
											<div>
												<label>Password</label>
												<i class="icon-add" id='password-add' style='cursor: pointer'></i>
											</div>
											<div class="password-container">
												<input
													id="password"
													name="password"
													type="password"
													class="form-control"
													placeholder="**********"
													maxlength="20"
													required="required"
													pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$">
												<i class="icon-eye8 toggle-password" id='toggle-password'></i>
											</div>
											<span class="help-block text-info">
												<i class="icon-help position-right"></i>
												La contraseña debe tener mínimo 8 caracteres, incluyendo mayúscula, minúscula, número y símbolo especial
											</span>
										</div>
									</blockquote>


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
				}
			});
		}

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

			return password.split('').sort(() => 0.5 - Math.random()).join('');
		}

		const password = document.getElementById('password');

		const passwordAdd = document.getElementById('password-add');

		passwordAdd.addEventListener('click', () => {
			password.value = generatePassword();
		});

		const eyeIcon = document.getElementById('toggle-password');

		eyeIcon.addEventListener('click', function() {
			const type = password.type === 'password' ? 'text' : 'password';
			password.type = type;

			this.classList.toggle('icon-eye8');
			this.classList.toggle('icon-eye-blocked');
		});
	</script>
</body>

</html>