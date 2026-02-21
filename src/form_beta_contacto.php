<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsContacto.php");
	require_once("php/clsDashboard.php");
	session_start();
    $objD = new clsDashboard;
	$arr_contar = $objD->contadores();
	if (!isset($_SESSION['user_ls'])){
		header("Location: index.php");
	}elseif ($_REQUEST['id']=="" or $arr_contar[5][0]>625 ){
		header("Location: datatable_contacto.php");
	}else{
		$objContacto = clsContacto::select_contacto_beta($_REQUEST['id']);
		$objItem = clsContacto::select_item_contacto($_REQUEST['id']);
		//var_dump($objItem);
		if ($objContacto['estado']=="PENDIENTE"){
		    header("Location: datatable_contacto.php");
		}
		
		function isCombo($nombre, $objItem) {
    		$valor = -1;
    		for ($i=0; $i<sizeof($objItem); $i++) {
    			if (utf8_encode($objItem[$i]['nombre'])==$nombre){
        			//var_dump($objItem[$i]);
        			$valor=utf8_encode($objItem[$i]['nombre']);
        			break; 
    			}	
    		}
    		return $valor;
    	}
		//isCombo('Gimnasio', $objItem);
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
	
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	
	<script type="text/javascript" src="assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
	
	<script type="text/javascript" src="assets/js/plugins/forms/wizards/steps.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jasny_bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/extensions/cookie.js"></script>
<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/wizard_steps.js"></script>
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
						<h4><a href="datatable_contacto.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Seguimiento</span> Contacto</h4>
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
							<li><a href="wizards_steps.html">Tools</a></li>
							<li class="active">Contacto</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="#"><i class="icon-comment-discussion position-left"></i> Support</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Settings
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-user-lock"></i> Account security</a></li>
									<li><a href="#"><i class="icon-statistics"></i> Analytics</a></li>
									<li><a href="#"><i class="icon-accessibility"></i> Accessibility</a></li>
									<li class="divider"></li>
									<li><a href="#"><i class="icon-gear"></i> All settings</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">

			
		            <!-- Wizard with validation -->
		            <div class="panel panel-white">
						<div class="panel-heading">
							 <?php $estado= utf8_encode($objContacto['estado']);
    							    if($estado=="PENDIENTE"){
    							        $estado2='<label class="label bg-orange-300">'.$estado.'</label>';
    							    }elseif($estado=="EN PROCESO" OR $estado=="NO CONTACTADO"){
    							         $estado2='<label class="label bg-pink-300">'.$estado.'</label>';
    							    }elseif($estado=="CONTACTADO" ){
    							         $estado2='<label class="label bg-success-300">'.$estado.'</label>';
    							    }elseif($estado=="CERRADO" ){
    							         $estado2='<label class="label bg-info-300">'.$estado.'</label>';
    							    }else{
    							         $estado2='<label class="label bg-success-300">'.$estado.'</label>';
    							    }
    							    echo $estado2;
							    ?>
							    <i class="icon-user-tie position-left"></i> Usuario: <?php echo utf8_encode($objContacto['user']);?>
							    </br>
							    <i class="icon-calendar position-left"></i> Fecha Registro: <?php echo utf8_encode($objContacto['fecha_registro']);?>
							     <i class="icon-calendar2 position-left"></i> Fecha Análisis: <?php echo utf8_encode($objContacto['x1']);?>
							     <i class="icon-calendar3 position-left"></i>Fecha Concluido: <?php echo utf8_encode($objContacto['x2']);?>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>

	                	<form class="steps-validation" action="#">
							<h6>Contacto/Inmueble</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-6">
									
									<legend class="text-semibold"><i class="icon-user position-left"></i> Datos Contacto</legend>
													
										<div class="col-md-6">
											<div class="form-group" >
											    <input type="hidden" id="id_contacto" name="id_contacto"  class="form-control required"  value="<?php echo utf8_encode($objContacto['id']);?>" />
											<label>Nombre Completo</label>	
													<input type="text" id="nombre" name="nombre"  class="form-control required"  value="<?php echo utf8_encode($objContacto['nombre']);?>" />
													</div>
													
													<div class="form-group"> 
														<label>Teléfono</label>
														<input type="text" id="telefono" name="telefono" class="form-control required"   value="<?php echo utf8_encode($objContacto['movil']);?>" />
													</div>
													
												</div>
										<div class="col-md-6">
													<div class="form-group"> 
														<label>Dirección</label>
														<input type="text" id="direccion" name="direccion"  class="form-control required" value="<?php echo utf8_encode($objContacto['direccion']);?>" />
													</div>
												    
												    <div class="form-group"> 
														<label>Correo Electrónico</label>
														<input type="email" id="email" name="email" class="form-control required"  value="<?php echo utf8_encode($objContacto['correo']);?>" />
													</div>
										
										</div>
										<div class="col-md-12">			
													<div class="form-group"> 
														<label>Mensaje</label>
														<textarea class="form-control"  id="mensaje"  name="mensaje" maxlength=1000 ><?php echo utf8_encode($objContacto['mensaje']);?></textarea>
													</div>
													
											</div>
									
									</div>

									<div class="col-md-6">
									
									<legend class="text-semibold"><i class="icon-home8 position-left"></i> Datos Inmueble</legend>
							                        <div class="form-group" >   
														<label>Nombre </label>
														<input type="text" id="edificio" name="edificio"  class="form-control required"  value="<?php echo utf8_encode($objContacto['edificio']);?>" />	
														
							                        </div>
													 <div class="form-group" >   
														<label>Distrito</label>
														<input type="text" id="distrito" name="distrito"  class="form-control required" value="<?php echo utf8_encode($objContacto['distrito']);?>" />	
														
							                        </div>
							                        
							                        <div class="form-group" >   
														<label>Razón Cambio</label>
														<input type="text" id="razon_cambio" name="razon_cambio"  class="form-control required" value="<?php echo utf8_encode($objContacto['razon_cambio']);?>" />	
														
							                        </div>
							                        
									</div>
								</div>

							</fieldset>

						<h6>Arquitectura/Servicios</h6>
							<fieldset>
								<div class="row">
    								<div class="col-md-6">
    								    	<legend class="text-semibold"><i class="icon-home5 position-left"></i> Datos Arquitectura</legend>
    									
    									<div class="col-md-6">
    									    
    							         <div class="form-group" >   
    														<label>Tipo Inmueble </label>
    														
    														<select id="tipo_inmueble" name="tipo_inmueble" data-placeholder="Seleccione" class="select required">
    						                                        <option></option> 
    						                                        <option value="Empresarial" <?php echo $objContacto['tipo_inmueble']=='Empresarial' ? 'selected' : '' ; ?>>Empresarial</option> 
    						                                        <option value="Recreacional" <?php echo $objContacto['tipo_inmueble']=='Recreacional' ? 'selected' : '' ; ?>>Recreacional</option> 
    						                                        <option value="Residencial" <?php echo $objContacto['tipo_inmueble']=='Residencial' ? 'selected' : '' ; ?>>Residencial</option> 
    						                                    </select>
    							                        </div>
    													 <div class="form-group" >   
    														<label>M2 Promedio x Departamento</label>
    														<input type="number" min=0  id="mpromedio" name="mpromedio" class="form-control required" value="<?php echo utf8_encode($objContacto['mpromedio']);?>" />	
    														
    							                        </div>
    							                        
    							                        <div class="form-group" >   
    														<label>Cantidad E/S Peatonal</label>
    														<input type="number" min=0  id="es_peatonal" name="es_peatonal"  class="form-control required" value="<?php echo utf8_encode($objContacto['es_peatonal']);?>" />	
    														
    							                        </div>
    							                         <div class="form-group" >   
    														<label>Cantidad E/S Vehicular</label>
    														<input type="number" min=0  id="es_vehicular" name="es_vehicular"  class="form-control required" value="<?php echo utf8_encode($objContacto['es_vehicular']);?>" />	
    														
    							                        </div>
    							                        <div class="form-group" >   
    														<label>Cantidad Locales Comerciales</label></label>
    														<input type="number" min=0  id="local_comercial" name="local_comercial"  class="form-control required" value="<?php echo utf8_encode($objContacto['local_comercial']);?>" />	
    														
    							                        </div>
    									</div>
    									
    									<div class="col-md-6">
    									    	
    													 <div class="form-group" >   
    														<label>Cantidad Departamentos y Oficinas</label>
    														<input type="number" min=0  id="depa_ofi" name="depa_ofi" min=0 class="form-control required" value="<?php echo utf8_encode($objContacto['depa_ofi']);?>" />	
    														
    							                        </div>
    							                        
    							                        <div class="form-group" >   
    														<label>Cantidad Torres</label>
    														<input type="number" min=0  id="torres" name="torres"  class="form-control required" value="<?php echo utf8_encode($objContacto['torres']);?>" />	
    														
    							                        </div>
    							                         <div class="form-group" >   
    														<label>Cantidad Pisos</label>
    														<input type="number" min=0  id="pisos" name="pisos"  class="form-control required" value="<?php echo utf8_encode($objContacto['pisos']);?>" />	
    														
    							                        </div>
    							                        <div class="form-group" >   
    														<label>Cantidad Sotános</label></label>
    														<input type="number" min=0  id="sotano" name="sotano"  class="form-control required" value="<?php echo utf8_encode($objContacto['sotano']);?>" />	
    														
    							                        </div>
    							                        <div class="form-group" >   
    														<label>Antiguedad</label></label>
    														<input type="number" min=0  id="antiguedad" name="antiguedad"  class="form-control required" value="<?php echo utf8_encode($objContacto['antiguedad']);?>" />	
    														
    							                        </div>
    									</div>
                                    </div>
                                    <div class="col-md-6">
    								    	<legend class="text-semibold"><i class="icon-users4 position-left"></i> Servicios Básicos/Personal</legend>
    								    	
    								    <div class="col-md-6">
    									    <div class="form-group" >   
    														<label>Cantidad Recibo Agua</label>
    														<input type="number" min=0  id="recibo_agua" name="recibo_agua"  class="form-control required" value="<?php echo utf8_encode($objContacto['recibo_agua']);?>" />	
    														
    							                        </div>
    							                        <div class="form-group" >   
    														<label>Cantidad Recibo Luz (Áreas Comunes)</label></label>
    														<input type="number" min=0  id="recibo_luz" name="recibo_luz"  class="form-control required" value="<?php echo utf8_encode($objContacto['recibo_luz']);?>" />	
    														
    							                        </div>
    									</div>
    									
    									<div class="col-md-6">
    									    <div class="form-group" >   
    														<label>Cantidad Conserjes</label>
    														<input type="number" min=0  id="conserjes" name="conserjes"  class="form-control required" value="<?php echo utf8_encode($objContacto['conserjes']);?>" />	
    														
    							                        </div>
    							                        <div class="form-group" >   
    														<label>Cantidad Ronderos</label></label>
    														<input type="number" min=0  id="ronderos" name="ronderos"  class="form-control required" value="<?php echo utf8_encode($objContacto['ronderos']);?>" />	
    														
    							                        </div>
    							                      <div class="form-group" >   
    														<label>Cantidad Operarios Limpieza</label></label>
    														<input type="number" min=0  id="operarios" name="operarios"  class="form-control required" value="<?php echo utf8_encode($objContacto['operarios']);?>" />	
    														
    							                        </div>
    							                      <div class="form-group" > 
    														<label>Tipo de Administrador</label></label>
    															<select id="tipo_admin" name="tipo_admin" data-placeholder="Seleccione" class="select required">
    						                                        <option></option> 
    						                                        <option value="Residente" <?php echo $objContacto['tipo_admin']=='Residente' ? 'selected' : '' ; ?>>Residente</option> 
    						                                        <option value="Por Horas" <?php echo $objContacto['tipo_admin']=='Por Horas' ? 'selected' : '' ; ?>>Por Horas</option> 
    						                                        <option value="No Necesita" <?php echo $objContacto['tipo_admin']=='No Necesita' ? 'selected' : '' ; ?>>No Necesita</option> 
    						                                    </select>	
    														
    							                        </div>
    							                        
    									</div>
    								    	
    								</div>
                                    
								</div>

							</fieldset>

							<h6>Mantenimientos/Administrativos</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-6">
    								    	<legend class="text-semibold"><i class="icon-scissors position-left"></i> Datos Mantenimiento</legend>
    									
    									<div class="col-md-6">
													<div class="form-group" >   
														<label>Cantidad Ascensores</label></label>
														<input type="number" min=0  id="ascensor" name="ascensor"  class="form-control required" value="<?php echo utf8_encode($objContacto['ascensor']);?>" />	
														
													</div>
													<div class="form-group" >   
														<label>Cantidad Ascensores Discapacitados</label></label>
														<input type="number" min=0  id="ascensor_dis" name="ascensor_dis"  class="form-control required" value="<?php echo utf8_encode($objContacto['ascensor_dis']);?>" />	
														
													</div>
													<div class="form-group" >   
														<label>Cantidad Cámaras Seguridad</label></label>
														<input type="number" min=0  id="camaras" name="camaras"  class="form-control required" value="<?php echo utf8_encode($objContacto['camaras']);?>" />	
														
													</div>
													
										</div>
										<div class="col-md-6">
													<div class="form-group" >   
														<label>Cantidad Piscinas</label></label>
														<input type="number" min=0  id="piscinas" name="piscinas"  class="form-control required" value="<?php echo utf8_encode($objContacto['piscinas']);?>" />	
														
													</div>
													
													<div class="form-group" >   
														<label>Cantidad Áreas Verdes</label></label>
														<input type="number" min=0  id="areas_verde" name="areas_verde"  class="form-control required" value="<?php echo utf8_encode($objContacto['sotano']);?>" />	
														
													</div>
													<div class="form-group" >   
														<label>Cantidad Máquinas Gym</label></label>
														<input type="number" min=0  id="maq_gym" name="maq_gym"  class="form-control required" value="<?php echo utf8_encode($objContacto['maq_gym']);?>" />	
														
													</div>
													
										</div>
									</div>
								    
								    <div class="col-md-6">
    								    	<legend class="text-semibold"><i class="icon-users4 position-left"></i> Datos Administrativo</legend>
    									
    									<div class="col-md-6">
													<div class="form-group" >   
														<label>Nombre Constructura</label></label>
														<input type="text" id="constructura" name="constructura"  class="form-control required" value="<?php echo utf8_encode($objContacto['constructura']);?>" />	
														
													</div>
													<div class="form-group" >   
														<label>Junta Inscrita en RRPP</label></label>
														<select id="junta" name="junta" data-placeholder="Seleccione" class="select required">
    						                                        <option></option> 
    						                                        <option value="Si" <?php echo $objContacto['junta']=='Si' ? 'selected' : '' ; ?>>Si</option>
																	<option value="No" <?php echo $objContacto['junta']=='No' ? 'selected' : '' ; ?>>No</option>
    						                                    </select>
														<!--<input type="text" id="junta" name="junta"  class="form-control required" value="<?php echo utf8_encode($objContacto['junta']);?>" />-->	
														
													</div>
													<div class="form-group" >   
														<label>(Aprox.) Pago Cuota Mantenimiento</label></label>
														<input type="number" min=0  id="pago_mant" name="pago_mant"  class="form-control required" value="<?php echo utf8_encode($objContacto['pago_mant']);?>" />	
														
													</div>
													<div class="form-group" >   
														<label>Otras Áreas Comunes </label>
														<div class="multi-select-full">
														<select class="multiselect" multiple="multiple">
												<option value="Gimnasio" <?php echo (isCombo("Gimnasio",$objItem)=="Gimnasio"?' selected="selected"':''); ?>>Gimnasio</option>
												<option value="Sala de Internet o Estudios" <?php echo (isCombo("Sala de Internet o Estudios",$objItem)=="Sala de Internet o Estudios"?' selected="selected"':''); ?>>Sala de Internet o Estudios</option>
												<option value="Sala de Cine o TV" <?php echo (isCombo("Sala de Cine o TV",$objItem)=="Sala de Cine o TV"?' selected="selected"':''); ?>>Sala de Cine o TV</option>
												<option value="SUM" <?php echo (isCombo("SUM",$objItem)=="SUM"?' selected="selected"':''); ?>>SUM</option>
												<option value="Zona de Parrillas" <?php echo (isCombo("Zona de Parrillas",$objItem)=="Zona de Parrillas"?' selected="selected"':''); ?>>Zona de Parrillas</option>
													<option value="Zona y Juego de Niños" <?php echo (isCombo("Zona y Juego de Niños",$objItem)=="Zona y Juego de Niños"?' selected="selected"':''); ?>>Zona y Juego de Niños</option>
														<option value="Piscina" <?php echo (isCombo("Piscina",$objItem)=="Piscina"?' selected="selected"':''); ?>>Piscina</option>
														<option value="Cancha de Fulbito" <?php echo (isCombo("Cancha de Fulbito",$objItem)=="Cancha de Fulbito"?' selected="selected"':''); ?>>Cancha de Fulbito</option>
														<option value="Sauna" <?php echo (isCombo("Sauna",$objItem)=="Sauna"?' selected="selected"':''); ?>>Sauna</option>
															<option value="Sala de Videojuegos" <?php echo (isCombo("Sala de Videojuegos",$objItem)=="Sala de Videojuegos"?' selected="selected"':''); ?>>Sala de Videojuegos</option>
												
											
											</select>	
											</div>
														
													</div>
													
										</div>
										<div class="col-md-6">
												<div class="form-group" >   
														<label>Nombre del Administrador Actual</label></label>
														<input type="text" id="administrador_actual" name="administrador_actual"  class="form-control required" value="<?php echo utf8_encode($objContacto['administrador_actual']);?>" />	
														
												</div>
												<div class="form-group" >   
														<label>Es UD parte de la Junta Directiva</label></label>
														<select id="junta_dir" name="junta_dir" data-placeholder="Seleccione" class="select required">
    						                                        <option></option> 
    						                                        <option value="Si" <?php echo $objContacto['junta_dir']=='Si' ? 'selected' : '' ; ?>>Si</option>
																	<option value="No" <?php echo $objContacto['junta_dir']=='No' ? 'selected' : '' ; ?>>No</option>
    						                                    </select>
														
													</div>
													<div class="form-group" >   
														<label>(Aprox.) Presupuesto Mensual </label></label>
														<input type="text" id="presupuesto_mensual" name="presupuesto_mensual"  class="form-control required" value="<?php echo utf8_encode($objContacto['presupuesto_mensual']);?>" />	
														
													</div>
													<div class="form-group" >   
														<label>Alguna Observación</label></label>
														<textarea class="form-control required" id="observacion" name="observacion" maxlength="1000"><?php echo utf8_encode($objContacto['observacion']);?></textarea>
														
													</div>
													
										</div>
									</div>

								</div>
							</fieldset>
							
								<h6>Final</h6>
							<fieldset>
								<div class="row">
								    <div class="col-md-6">
    								    	<legend class="text-semibold"><i class="icon-star-full2 position-left"></i> Otros</legend>
    									
    									<div class="col-md-6">
													<div class="form-group" >   
														<label>¿Como se enteró por primera vez de Adminio? </label></label>
														<select id="entero" name="entero" data-placeholder="Seleccione" class="select required">
    						                                        <option></option> 
    						              <option value="Radio" <?php echo utf8_encode($objContacto['entero'])=='Radio' ? 'selected' : '' ; ?>>Radio</option><option value="Televisión" <?php echo utf8_encode($objContacto['entero'])=='Televisión' ? 'selected' : '' ; ?>>Televisión </option>
    						              <option value="Internet" <?php echo utf8_encode($objContacto['entero'])=='Internet' ? 'selected' : '' ; ?>>Internet</option>
    						            <option value="Recomendación de un amigo o familiar" <?php echo utf8_encode($objContacto['entero'])=='Recomendación de un amigo o familiar' ? 'selected' : '' ; ?>>Recomendación de un amigo o familiar</option>
    						            <option value="Trabajo" <?php echo utf8_encode($objContacto['entero'])=='Trabajo' ? 'selected' : '' ; ?>>Trabajo</option>
    						            <option value="Redes Sociales" <?php echo utf8_encode($objContacto['entero'])=='Redes Sociales' ? 'selected' : '' ; ?>> Redes Sociales</option>
    						            <option value="Otro" <?php echo utf8_encode($objContacto['entero'])=='Otro' ? 'selected' : '' ; ?>>Otro</option>
    						                                    </select>
														
													</div>
													<div class="form-group" >   
													<label>Sectorista</label>
														  <select id="sectorista" name="sectorista" data-placeholder="Seleccione" class="select" required="required">
						                            	<option></option>
														<?php 
															$obj = new clsContacto;
															$arr_datos = $obj->consulta_usuarios();
															foreach($arr_datos as $datos)
															if($datos['user']==$objContacto['sectorista']){
																echo '<option value="'.$datos['user'].'" selected>'.utf8_encode($datos['user']).' </option>';
															}else{
																echo '<option value="'.$datos['user'].'">'.utf8_encode($datos['user']).'</option>';
															}
														?> 
						                            </select>
													
														
													</div>
													<div class="form-group" >   
														<label>Cliente Contrato Servicio</label></label>
														<select id="contrato_ser" name="contrato_ser" data-placeholder="Seleccione" class="select required">
    						                                        <option></option> 
    						                                        <option value="Si" <?php echo $objContacto['contrato_ser']=='Si' ? 'selected' : '' ; ?>>Si</option>
																	<option value="No" <?php echo $objContacto['contrato_ser']=='No' ? 'selected' : '' ; ?>>No</option>
    						                                    </select>
														
													</div>
													
										</div>
									</div>

								</div>
							</fieldset>

						</form>
		            </div>
		            <!-- /wizard with validation -->


                    <!--BITACORA-->
	       
	            		<div class="page-title">
							<h4><a href="datatable_contacto.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Bitácora</span> Contacto</h4>
						</div>
						
	            	<table class="table datatable-basic-bitacora">
							<thead>
								<tr>
									<th>Id</th>
									<th>Fecha</th>
									<th>Observación</th>
									<th>Usuario</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>

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
    /*probando*/
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{ 
            orderable: false,
            width: '100px',
            targets: [ 3 ]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Buscar:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    // Basic datatable
    $('.datatable-basic').DataTable();

    // Alternative pagination
    $('.datatable-pagination').DataTable({
        pagingType: "simple",
        language: {
            paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
        }
    });

    $('.dataTables_filter input[type=search]').attr('placeholder','Escribe');

    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
    
    
	var id =  jQuery('#id_contacto').val();
    listar_bitacora(3,id);
    
    // Basic
    $('.select').select2();

    // Format icon
    function iconFormat(icon) {
        var originalOption = icon.element;
        if (!icon.id) { return icon.text; }
        var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

        return $icon;
    }

    // Initialize with options
    $(".select-icons").select2({
        templateResult: iconFormat,
        minimumResultsForSearch: Infinity,
        templateSelection: iconFormat,
        escapeMarkup: function(m) { return m; }
    });

    // Checkboxes, radios
    $(".styled").uniform({ radioClass: 'choice' });

    // File input
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-pink-400'
    });
    
     $('.multiselect').multiselect({
        onChange: function() {
            $.uniform.update();
        }
    });
    
     $('.multiselect-full').multiselect({
        buttonWidth: '100%'
    });
    
  
 
    
        // Styled checkboxes and radios
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});

})

function listar_bitacora(valida,id){
 $.ajax({
        data: {valida:valida,id:id},
        url: 'ajax/ajax_contacto.php',
        dataType: 'json',
    }).done(function(data){
            if (data.codigo==0){
                //swal({   title: "Mensaje del Sistema",   text: data.mensaje,    type: "warning" });
                $(".datatable-basic-bitacora tbody").html("");
            }else{
                //console.log(data.arr_datos);
                var table=$('.datatable-basic-bitacora').dataTable({
                    'data': data.arr_datos,
                    "responsive": true,
                    "destroy": true,
                    "order": [[ 0, "desc" ]],
                    "bProcessing": true,
                    "createdRow": function ( row, data, index ) {

                    }
                    });  

                $('.dataTables_filter input[type=search]').attr('placeholder','Escribe');

                // Enable Select2 select for the length option
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: Infinity,
                    width: 'auto'
                });
                
            }
    });
}
</script>
</body>
</html>
