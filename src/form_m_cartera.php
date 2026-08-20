<?php
    require_once("php/clsUsuario.php");
    require_once("php/clsCartera.php");
    session_start();

    if (!isset($_SESSION['user_ls'])) {
        header("Location: index.php");
        exit;
    }

    $idCartera = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
    if ($idCartera <= 0) {
        header("Location: datatable_cartera.php");
        exit;
    }

    $objCartera = clsCartera::select($idCartera);
    if (empty($objCartera)) {
        header("Location: datatable_cartera.php");
        exit;
    }

    $obj = new clsUsuario;
    $arr_datos = $obj->version_system();

    /* Contexto para administrar responsables formales desde RRHH. */
    $gruposCartera = clsCartera::consulta_grupos_activos($idCartera);
    $tablasActivas = clsCartera::consulta_tablas_activas($idCartera);
    $supervisoresDisponibles = clsCartera::consulta_personal_supervisor();
    $jefesDisponibles = clsCartera::consulta_jefes_operacion();
    $responsabilidadesVigentes = clsCartera::consulta_responsabilidades_vigentes($idCartera);

    $responsabilidadesPorClave = array();
    foreach ($responsabilidadesVigentes as $responsabilidad) {
        $clave = $responsabilidad['tipo_responsable'] . ':' . (int)$responsabilidad['id_grupo_cartera'];
        $responsabilidadesPorClave[$clave] = $responsabilidad;
    }

    /* Si ya existe una responsabilidad, conservamos como sugerencia su tabla
       siempre que siga activa. Si no, una única tabla activa se autoselecciona. */
    $tablasActivasPorId = array();
    foreach ($tablasActivas as $tablaActiva) {
        $tablasActivasPorId[(int)$tablaActiva['id']] = true;
    }

    $idTablaSugerida = 0;
    $tablasUsadasPorResponsabilidades = array();
    foreach ($responsabilidadesVigentes as $responsabilidad) {
        $idTablaResponsabilidad = (int)$responsabilidad['id_tabla'];
        if ($idTablaResponsabilidad > 0 && isset($tablasActivasPorId[$idTablaResponsabilidad])) {
            $tablasUsadasPorResponsabilidades[$idTablaResponsabilidad] = true;
        }
    }
    if (count($tablasUsadasPorResponsabilidades) === 1) {
        $idsTablasResponsabilidad = array_keys($tablasUsadasPorResponsabilidades);
        $idTablaSugerida = (int)$idsTablasResponsabilidad[0];
    } elseif (count($tablasActivas) > 0) {
        /*
          No exponemos tabla_log a RRHH. Si no existe una tabla ya asociada a
          la responsabilidad, se usa internamente la tabla activa más reciente
          (consulta_tablas_activas ordena por tl.id DESC).
        */
        $idTablaSugerida = (int)$tablasActivas[0]['id'];
    }

    /*
      0 es intencional: significa que esta cartera no tiene tabla_log activa.
      Los stores aceptarán NULL y guardarán solo la responsabilidad formal.
    */
    $carteraSinTablaActiva = count($tablasActivas) === 0;

    if (count($gruposCartera) === 0) {
        $gruposSupervisor = array(
            array('id' => 0, 'nombre_grupo' => 'Cartera general', 'descripcion' => '')
        );
    } else {
        $gruposSupervisor = $gruposCartera;
    }

    function h_cartera($valor)
    {
        return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
    }
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
							<h4><a href="datatable_cartera.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Modificar</span> Cartera</h4>
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
							<li class="active">Cartera</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="datatable_cartera.php"><i class="icon-collaboration"></i> Cartera</a></li>
									<li class="divider"></li>
									
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<form action="#" class="form-m-cartera">
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
									<?php if ($objCartera['estado']==1){
										echo('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" checked="checked">');
									}else{
										echo('<input type="checkbox" id="estado" name="estado" data-on-color="success" data-off-color="danger" data-on-text="Active" data-off-text="Suspended" class="switch" >');
									}?>
									</label>
									
							</div>
							<div class="panel-body">
								<div class="row">
								<legend class="text-semibold"><i class="icon-collaboration  position-left"></i> Datos Cartera</legend>
								
									<div class="col-md-6">
										<fieldset>
										<div class="form-group">
											<label>Nombre</label>
											<input type="hidden" id="id" name="id" class="form-control" value="<?php echo $objCartera['id'];?>">
											<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Cartera I" maxlength=50 required="required" value="<?php echo utf8_encode($objCartera['cartera']);?>">
										</div>
										
										<div class="form-group">
											<label>Tramo</label>
											<input type="number" id="tramo" name="tramo" class="form-control" placeholder="123" required="required" value="<?php echo utf8_encode($objCartera['tramo']);?>">
										</div>
										<div class="form-group">
											<label>Central</label>
											<input type="text" id="central" name="central" class="form-control" placeholder="105" maxlength=50 required="required" value="<?php echo utf8_encode($objCartera['central']);?>">
										</div>
										
										 <div class="form-group">	
											<label>Tipo</label>
											<select id="tipo" name="tipo" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
													
														
														$obj = new clsCartera;
														$arr_datos = $obj->consulta_tipo();
														foreach($arr_datos as $datos)
														if($datos['id']==$objCartera['tipo']){
															echo '<option value="'.$datos['id'].'" selected>'.utf8_encode($datos['nombre']).' </option>';
													
														}else{
															echo '<option value="'.$datos['id'].'">'.utf8_encode($datos['nombre']).'</option>';
														}
														
													?> 
											</select>
										</div>
										
										<div class="form-group">	
											<label>Cliente</label>
											<select id="idcliente" name="idcliente" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
													
														$obj = new clsCartera;
														$arr_datos = $obj->consulta_cliente();
														foreach($arr_datos as $datos)
														if($datos['id']==$objCartera['idcliente']){
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
									<button type="submit" class="btn btn-primary">Registrar <i class="icon-arrow-right14 position-left"></i></button>
								</div>
							</div>
						</div>
					</form>

                    <!-- Administración formal de responsables -->
                    <form action="#" class="form-responsables-cartera">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title"><i class="icon-users4 position-left"></i> Responsables de aprobaci&oacute;n</h5>
                            </div>
                            <div class="panel-body">
                                <input type="hidden" id="resp_id_cartera" value="<?php echo (int)$idCartera; ?>">

                                <div class="alert alert-info alert-styled-left">
                                    <strong>Responsabilidad funcional:</strong>
                                    RRHH define aqu&iacute; qui&eacute;n es Supervisor y Jefe de Operaciones formal de la cartera.
                                    La cartera principal guardada en <code>personal</code> no se modifica desde esta secci&oacute;n.
                                    Si la cartera tiene una base operativa activa asociada, el acceso requerido se gestiona autom&aacute;ticamente.
                                </div>

                                <?php if ($carteraSinTablaActiva) { ?>
                                    <div class="alert alert-warning alert-styled-left">
                                        Esta cartera no tiene una base operativa activa asociada.
                                        Puede configurar Supervisor y Jefe de Operaciones normalmente; la responsabilidad formal se registrar&aacute; sin generar un acceso adicional.
                                    </div>
                                <?php } ?>

                                <!-- El identificador técnico de acceso se maneja internamente y no se muestra en RRHH. -->
                                <input type="hidden" id="resp_id_tabla" value="<?php echo (int)$idTablaSugerida; ?>">

                                <legend class="text-semibold"><i class="icon-user-tie position-left"></i> Supervisor responsable</legend>

                                <?php foreach ($gruposSupervisor as $grupoSupervisor) {
                                    $idGrupo = (int)$grupoSupervisor['id'];
                                    $claveSupervisor = 'SUPERVISOR:' . $idGrupo;
                                    $supervisorActual = isset($responsabilidadesPorClave[$claveSupervisor]) ? $responsabilidadesPorClave[$claveSupervisor] : null;
                                    $idSupervisorActual = $supervisorActual ? (int)$supervisorActual['id_personal'] : 0;
                                    $actualEncontrado = false;
                                ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>
                                                    <?php echo h_cartera($grupoSupervisor['nombre_grupo']); ?>
                                                    <?php if ($idGrupo > 0) { ?>
                                                        <span class="label label-info">Grupo <?php echo $idGrupo; ?></span>
                                                    <?php } ?>
                                                </label>
                                                <select class="select supervisor-responsable"
                                                        id="resp_supervisor_<?php echo $idGrupo; ?>"
                                                        data-grupo="<?php echo $idGrupo; ?>"
                                                        data-placeholder="Sin Supervisor configurado">
                                                    <option value="0">Sin Supervisor configurado</option>
                                                    <?php foreach ($supervisoresDisponibles as $persona) {
                                                        $esActual = ((int)$persona['id'] === $idSupervisorActual);
                                                        if ($esActual) $actualEncontrado = true;
                                                        $esVacaciones = ((int)$persona['estado'] === 4);
                                                        $disabled = ($esVacaciones && !$esActual) ? ' disabled' : '';
                                                        $selected = $esActual ? ' selected' : '';
                                                        $sufijoEstado = $esVacaciones ? ' - VACACIONES' : '';
                                                    ?>
                                                        <option value="<?php echo (int)$persona['id']; ?>"<?php echo $selected . $disabled; ?>>
                                                            <?php echo h_cartera($persona['nombre'] . ' | ' . $persona['cargo'] . $sufijoEstado); ?>
                                                        </option>
                                                    <?php } ?>
                                                    <?php if ($idSupervisorActual > 0 && !$actualEncontrado && $supervisorActual) { ?>
                                                        <option value="<?php echo $idSupervisorActual; ?>" selected>
                                                            <?php echo h_cartera($supervisorActual['personal'] . ' | ' . $supervisorActual['cargo_nombre'] . ' - NO DISPONIBLE'); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <?php if ($supervisorActual) { ?>
                                                    <span class="help-block">
                                                        Responsable formal actual: <strong><?php echo h_cartera($supervisorActual['personal']); ?></strong>
                                                        (<?php echo h_cartera($supervisorActual['cargo_nombre']); ?>).
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <legend class="text-semibold"><i class="icon-user-check position-left"></i> Jefe de Operaciones</legend>
                                <?php
                                    $claveJefe = 'JEFE_OPERACION:0';
                                    $jefeActual = isset($responsabilidadesPorClave[$claveJefe]) ? $responsabilidadesPorClave[$claveJefe] : null;
                                    $idJefeActual = $jefeActual ? (int)$jefeActual['id_personal'] : 0;
                                    $jefeActualEncontrado = false;
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Jefe de Operaciones responsable de la cartera</label>
                                            <select id="resp_jefe_operacion" class="select" data-placeholder="Sin Jefe de Operaciones configurado">
                                                <option value="0">Sin Jefe de Operaciones configurado</option>
                                                <?php foreach ($jefesDisponibles as $persona) {
                                                    $esActual = ((int)$persona['id'] === $idJefeActual);
                                                    if ($esActual) $jefeActualEncontrado = true;
                                                    $esVacaciones = ((int)$persona['estado'] === 4);
                                                    $disabled = ($esVacaciones && !$esActual) ? ' disabled' : '';
                                                    $selected = $esActual ? ' selected' : '';
                                                    $sufijoEstado = $esVacaciones ? ' - VACACIONES' : '';
                                                ?>
                                                    <option value="<?php echo (int)$persona['id']; ?>"<?php echo $selected . $disabled; ?>>
                                                        <?php echo h_cartera($persona['nombre'] . ' | ' . $persona['cargo'] . $sufijoEstado); ?>
                                                    </option>
                                                <?php } ?>
                                                <?php if ($idJefeActual > 0 && !$jefeActualEncontrado && $jefeActual) { ?>
                                                    <option value="<?php echo $idJefeActual; ?>" selected>
                                                        <?php echo h_cartera($jefeActual['personal'] . ' | ' . $jefeActual['cargo_nombre'] . ' - NO DISPONIBLE'); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <span class="help-block">El Jefe de Operaciones se administra siempre con grupo 0, incluso para una cartera segmentada.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Motivo del cambio</label>
                                            <textarea id="resp_motivo" class="form-control" rows="3" maxlength="255"
                                                      placeholder="Ej.: Actualizaci&oacute;n de responsables por RRHH"></textarea>
                                            <span class="help-block">Es obligatorio cuando existe una asignaci&oacute;n, reasignaci&oacute;n o retiro y quedar&aacute; registrado en el historial.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-success" id="btn_guardar_responsables">
                                        Guardar responsables <i class="icon-checkmark3 position-left"></i>
                                    </button>
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
        $(".form-responsables-cartera").on("submit", function(e) {
            e.preventDefault();

            var supervisores = [];
            $(".supervisor-responsable").each(function() {
                supervisores.push({
                    grupo: parseInt($(this).attr("data-grupo") || "0", 10),
                    id_personal: parseInt($(this).val() || "0", 10)
                });
            });

            var datos = {
                control: 5,
                id_cartera: parseInt($("#resp_id_cartera").val() || "0", 10),
                id_tabla: parseInt($("#resp_id_tabla").val() || "0", 10),
                jefe_operacion: parseInt($("#resp_jefe_operacion").val() || "0", 10),
                motivo: $.trim($("#resp_motivo").val() || ""),
                supervisores: JSON.stringify(supervisores)
            };

            bootbox.confirm("¿Desea guardar la configuración de responsables de esta cartera?", function(result) {
                if (!result) return;

                $("#btn_guardar_responsables").prop("disabled", true);

                $.ajax({
                    type: "POST",
                    url: "ajax/ajax_cartera.php",
                    data: datos,
                    dataType: "json"
                }).done(function(response) {
                    if (response.codigo == 1) {
                        swal({
                            title: "Mensaje del Sistema",
                            text: response.mensaje,
                            type: "success"
                        }, function() {
                            window.location.reload();
                        });
                    } else {
                        swal({
                            title: "Mensaje del Sistema",
                            text: response.mensaje || "No se pudo guardar la configuración.",
                            type: "error"
                        });
                    }
                }).fail(function(xhr) {
                    var mensaje = "No se pudo procesar la configuración de responsables.";
                    if (xhr && xhr.responseText) {
                        mensaje += " Revise la respuesta del servidor.";
                    }
                    swal({
                        title: "Mensaje del Sistema",
                        text: mensaje,
                        type: "error"
                    });
                }).always(function() {
                    $("#btn_guardar_responsables").prop("disabled", false);
                });
            });
        });
    });
</script>
</body>
</html>
