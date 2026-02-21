<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsTable.php");
	date_default_timezone_set('America/Lima');
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
							<h4><a href="datatable_table.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Crear</span> Table Tmk</h4>
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
							<li class="active">Table Tmk</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="datatable_table.php"><i class="icon-database-insert"></i> Table Tmk</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<form action="#" class="form-a-table">
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
								<legend class="text-semibold"><i class="icon-database-insert position-left"></i> Datos Table Tmk</legend>
								
									<div class="col-md-6">
										<fieldset>
										 <div class="form-group">	
											<label>Cartera</label>
											<select id="cartera" name="cartera" data-placeholder="Seleccione" class="select" required="required">
												<option value=""></option>
													<?php
														$obj = new clsTable;
														$arr_datos = $obj->carteras();
														foreach($arr_datos as $datos)
														echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
													?> 
											</select>
										</div>
										
										<div class="form-group">
											<label>Nombre</label>
											<input type="text" id="nombre" name="nombre" class="form-control" placeholder="PRUEBA_2020" maxlength=50 required="required" readonly>
										</div>
										
										 
										</fieldset>
										
									</div>
									
									<div class="col-md-3">
										<fieldset>
											
										<div class="form-group">	
											<label>Campos</label>
											<div class="field_wrapper">
												<div style="display: -webkit-box;">
													<input type="text" class="form-control" id="field_name" name="field_name" readonly />
													<select id="tipo" name="tipo" data-placeholder="Seleccione" class="form-control" readonly >
												
													<option value="1">Texto</option>
														<option value="2">Largo</option>
													<option value="3">Fecha</option>
													<option value="4">Fecha/Hora</option>
													<option value="5">Hora</option>
													<option value="6">Número</option>
													<option value="7">Monto</option>
													</select>
													<a href="javascript:void(0);" class="add_button" title="Add field"><i class="icon-add"></i></a>
												</div>
											</div>
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
					
					$("#field_name").val("identificador");
					$("#tipo").val("1");
					
					$("#cartera").change(function(e) {
							var fecha='<?php echo date("_Ymd_hmi")?>';
							
							const removeAccents = (str) => {
							  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
							} 
							
							var nombre =$("#cartera option:selected" ).text().split(': ')[1];
							
							$("#nombre").val(removeAccents(nombre.replace(' ','_'))+fecha);
					});
			

					var maxField = 48; //Input fields increment limitation
					var addButton = $('.add_button'); //Add button selector
					var wrapper = $('.field_wrapper'); //Input field wrapper
					 
					var fieldHTML = '<div style="display: -webkit-box;"><input type="text" name="field_name[]" class="form-control" /><select id="tipo" name="tipo" data-placeholder="Seleccione" class="form-control" ><option value="1">Texto</option><option value="2">Largo</option><option value="3">Fecha</option><option value="4">Fecha/Hora</option><option value="5">Hora</option><option value="6">Número</option><option value="7">Monto</option></select><a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="icon-diff-removed"></i></a></div>'; //New input field html 
				
					var x = 1; //Initial field counter is 1
				
					
					$(wrapper).append(fieldHTML); // Add field html
					$(wrapper).append(fieldHTML); // Add field html
					
						
					$(addButton).click(function(){ //Once add button is clicked
						if(x < maxField){ //Check maximum number of input fields
							x++; //Increment field counter
							$(wrapper).append(fieldHTML); // Add field html
						
						}
					});
					
					$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
						e.preventDefault();
						$(this).parent('div').remove(); //Remove field html
						$('.select_wrapper').parent('div').remove(); 
						x--; //Decrement field counter
					});
					
					
					$(".form-a-table").on("submit",function(e){
						e.preventDefault();
						console.log(e);
						if(e.result===true){			
												
							var nombre =  jQuery('#nombre').val();
							var cartera =  jQuery('#cartera').val();
							
							var arr_input = new Array();
							$(".field_wrapper").find("input[type=text]").each(function (i, e) {
							if ($(this).val()!='')	
							    {
							    const removeAccents = (str) => {
    							  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    							} 
    							
    							var campo = removeAccents($(this).val().replace(' ','_'));
							    
								  	arr_input.push([i ,campo]);
							    }
							});

							var arr_select = new Array();
							var arr_select2 = new Array();
							$(".field_wrapper").find("select").each(function (i, e) {
							if ($(this).val()!=''){
							    if (i<=25){
							    	arr_select.push([i ,$(this).val(),arr_input[i][1]]);
							    }
							    
							    if (i>=26){
							    	arr_select2.push([i ,$(this).val(),arr_input[i][1]]);
							    }
							    
							    
							}	
									
							});
							console.log(arr_select);
							console.log(arr_select2);

							bootbox.confirm("¿Desea crear tabla MYSQL?", function(result) {
								if (result){    
									if (arr_input.length==0){
										swal({   title: "Mensaje del Sistema",   text: "Ingresar un campo (nombre,documento,otro)",    type: "warning" });
									}else if (arr_select.length==0){
										swal({   title: "Mensaje del Sistema",   text: "Seleccionar tipo de dato",    type: "warning" });
									}/*else if (arr_select.length!= arr_input.length){
										swal({   title: "Mensaje del Sistema",   text: "Complete tipo de datos/nombre campo",    type: "warning" });
									}*/else{
										registrar_table(nombre,cartera,arr_select,1,arr_select2);
										
										
    									/*$(".field_wrapper").find("select").each(function (i, e) {
                							if ($(this).val()!='')	
                							
                							registrar_campo(nombre,arr_input[i][1],$(this).val(),5); 
                
                									
                							});*/
							
									}
									
								}
							});
						}
					});
				
				
			});
			
			
function registrar_table(nombre,cartera,arr_select,control,arr_select2) {
    $.ajax({
        data: {nombre:nombre,cartera:cartera,arr_select:arr_select,control:control,arr_select2:arr_select2},
        dataType: 'json',
        url: 'ajax/ajax_table.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                
                
                registrar_table2(nombre,arr_select2);
    
                //window.location='datatable_table.php';
            }else if(response.codigo>=2){
                swal({ title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
            }else{
                bootbox.dialog({
                closeButton: false,
                message:"ERROR",
                    buttons: {
                                danger: {
                                    label: "Cerrar",
                                    className: "btn-danger",
                                    callback: function () { window.location='form_a_table.php'; }
                                    }
                            }
                });
            }
        }
    });
}

function registrar_table2(nombre,arr_select2) {
    $.ajax({
        data: {nombre:nombre,arr_select2:arr_select2},
        dataType: 'json',
        url: 'ajax/ajax_table2.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                
                console.log("tabla2 creada");
                window.location='datatable_table.php';
            }else if(response.codigo>=2){
                swal({ title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
            }else{
                bootbox.dialog({
                closeButton: false,
                message:"ERROR",
                    buttons: {
                                danger: {
                                    label: "Cerrar",
                                    className: "btn-danger",
                                    callback: function () { window.location='form_a_table.php'; }
                                    }
                            }
                });
            }
        }
    });
}

function registrar_campo(nombre,campo,tipo) {
    $.ajax({
        data: {nombre:nombre,campo:campo,tipo:tipo},
        dataType: 'json',
        url: 'ajax/ajax_table.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
              //  window.location='datatable_table.php';
              
              console.log("agregado")
            }else if(response.codigo>=2){
                swal({ title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
            }else{
                bootbox.dialog({
                closeButton: false,
                message:"ERROR",
                    buttons: {
                                danger: {
                                    label: "Cerrar",
                                    className: "btn-danger",
                                    callback: function () { window.location='form_a_table.php'; }
                                    }
                            }
                });
            }
        }
    });
}
</script>
</body>
</html>
