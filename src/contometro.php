<?php
	session_start();
	if (!isset($_SESSION['user_ls']))
	header("Location: index.php");
	require_once("php/clsUsuario.php");
	require_once("php/clsContacto.php");
	$obj = new clsUsuario;
	$arr_datos = $obj->version_system();
	$objTasa = clsContacto::tasas();
	//var_dump($objTasa);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8">	
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
	
		<script type="text/javascript" src="assets/js/plugins/velocity/velocity.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/velocity/velocity.ui.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/buttons/spin.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/buttons/ladda.min.js"></script>
	
	
	<script type="text/javascript" src="assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
	
	<!-- /core JS files -->
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/tables/handsontable/handsontable.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/prism.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/handsontable_cells.js"></script>
	
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
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Administraci&oacute;n</span> Cont&oacute;metros</h4>
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
							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
							<li><a href="#">Tools</a></li>
							<li class="active">Cont&oacute;metros</li>
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
									<li><a href="#"><i class="icon-home2"></i> Nuevo Edificio</a></li>
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

					<!-- Data validation -->
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
									<div class="col-md-12">
									    <a title="Alcantarillado" href="#" class="label label-primary label-icon"><label id="btn_alcan"><?php echo $objTasa[1]['valor']; ?></label> <i class="icon-wrench"></i> <?php echo $objTasa[1]['unidad']; ?></a>
									    <span title="Agua" class="label label-success label-rounded label-icon"><label id="btn_agua"><?php echo $objTasa[0]['valor']; ?></label> <i class="icon-home4"></i> <?php echo $objTasa[0]['unidad']; ?></span>
									<legend class="text-semibold"><i class="icon-home8 position-left"></i> Datos Inmueble</legend>
													
										<div class="col-md-4">
												<div class="form-group">
						                            <select id="edificio" name="edificio" data-placeholder="Seleccione" class="select" required="required">
						                            	<option></option>
													<?php
															require_once("php/clsContacto.php");
															$obj = new clsContacto;
															$arr_datos = $obj->consulta_edificios();
															foreach($arr_datos as $datos)
															echo '<option value="'.$datos['cant_depa'].'">'.$datos['nombre'].'</option>';
														?> 
						                            </select>
											</div>
													
										</div>
										<div class="col-md-4">
												<div class="form-group">
						                            <select id="numero" name="numero" disabled data-placeholder="Seleccione" class="select" required="required">
											
						                            </select>
						                        
											</div>	
										
										</div>
								        <div class="col-md-4">
												<div class="form-group">
						                            <select id="ano" name="ano" disabled data-placeholder="Seleccione" class="select" required="required">
											<option value="2020">2020</option>
						                            </select>
						                        
											</div>	
										
										</div>
									
									</div>
									<!--
									<div class="col-md-12">
									    <div class="col-md-4">
												<div class="form-group">
												    <label>Mes</label>
						                            <select id="mes" name="mes"  data-placeholder="Seleccione" class="select" required="required">
											<option value="enero">Enero</option>
											<option value="febrero">Febrero</option>
											<option value="marzo">Marzo</option>
											<option value="abril">Abril</option>
											<option value="mayo">Mayo</option>
											<option value="junio">Junio</option>
											<option value="julio">Julio</option>
											<option value="julio">Agosto</option>
											<option value="septiembre">Septiembre</option>
											<option value="octubre">Octubre</option>
											<option value="noviembre">Noviembre</option>
											<option value="diciembre">Diciembre</option>
						                            </select>
						                        
											</div>	
										
										</div>
										
									    <div class="col-md-4">
												<div class="form-group">
												    <label>Lectura</label>
    														<input type="number" min=0  id="lectura" name="lectura"  class="form-control required" />
												    </div>	
										
										</div>
									    <div class="col-md-4">
												<div class="form-group">
												    <label>Consumo</label>
    														<input type="number" min=0  id="consumo" name="consumo"  class="form-control required" />
												    </div>	
										
										</div>
									</div>-->
									
									
									    
                                <div class="col-md-12">
                                     <div class="col-md-4">
										<div class="form-group">
                                   
                                        </div>	
										
									</div>
								    <div class="col-md-4">
												<div class="form-group">
                                   
                                         </div>	
    										
    								</div>
								
                                      <div class="col-md-4">
												<div class="form-group">
                                    <button type="button" data-loading-text="<i class='icon-spinner4 spinner position-left'></i> Loading state" class="btn btn-default btn-loading"><i class="icon-spinner4 position-left"></i> Agregar</button>
                                     </div>	
										
										</div>
										
                                </div>
                                <div class="col-md-12"> 
                                
							
                                    <legend class="text-semibold"><i class="icon-file-openoffice position-left"></i> Detalle Mensual</legend>
                                    </div>
								    
								    
								</div>

                            <div class="form-group has-feedback has-feedback-left">
								<input type="text" id="hot_search_callback_input" class="form-control" placeholder="Search">
								<div class="form-control-feedback">
									<i class="icon-search4 text-size-small"></i>
								</div>
							</div>
							
							<div class="hot-container content-group">
							    
							    
								<div id="hot_validation"></div>
							</div>

							<p>Consola: </p>
							<pre class="language-javascript"><code id="hot_validation_console">// Validation callback</code></pre>
						</div>
					</div>
					<!-- /data validation -->

		
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

    $("#edificio").change(function(e) {				
		$("#numero").removeAttr("disabled");	
		var id = $(this).val();
		var dep=$("#edificio option:selected" ).text();
		buscar_depa(id,dep);
		
		
	});
	
	 $('.btn-loading').click(function () {
	        var btn = $(this);
            var edificio =  $("#edificio option:selected" ).text();
            var numero =  jQuery('#numero').val();
            var ano =  jQuery('#ano').val();
            var valida =  6;
            //console.log(valida);
            
            if (edificio==""){
                 swal({   title: "Mensaje del Sistema", text: "Seleccione Edificio",  type: "error" });
            }else if(numero==""){
                 swal({   title: "Mensaje del Sistema", text: "Seleccione Un. Inmobiliaria",  type: "error" });
            }else{
            
                bootbox.confirm("¿Desea insertar inmueble al detalle?", function(result) {
                    if (result){    
                        registrar_detalle(edificio,numero,ano,valida)
                        btn.button('loading')
                        setTimeout(function () {
                            
                            window.location='contometro.php';	
                            btn.button('reset')
                        }, 3000)
                    }
                });
            
            }
            
   
    });
    
    
    
	
	
});


function registrar_detalle(edificio,numero,ano,valida) {
    $.ajax({
        data: {edificio:edificio,numero:numero,ano:ano,valida:valida},
        dataType: 'json',
        url: 'ajax/ajax_contacto.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
               window.location='contometro.php';	
            }else if(response.codigo>1){
                swal({   title: "Mensaje del Sistema", text: response.mensaje,  type: "error" });
            }
        }
    });
}

function buscar_depa(id,dep) {
		$.ajax({
			data: {id: id,dep:dep},
			dataType: 'html',
			url: 'php/cbb_edificio.php',
			success:  function (response) {
			   // console.log(response);
				$("#numero").html(response);
			}
		});
	}
</script>
</body>
</html>
