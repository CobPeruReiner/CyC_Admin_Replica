<?php
	
	session_start();
	
	if (!isset($_SESSION['user_ls'])){
	    echo "<script> setTimeout(window.close(), 2000); </script>";
	}elseif ($_REQUEST['id']=="" ){
		echo "<script> setTimeout(window.close(), 2000); </script>";
	}else{
        require_once("php/clsGestion.php");
        require_once("php/clsTable.php");
       	require_once("php/clsUsuario.php");
    	$obj = new clsUsuario;
    	$arr_datos = $obj->version_system();
	    
	    $objTable = clsGestion::select_cuenta($_REQUEST['cuenta']);
	    	$objDescribe2 = clsGestion::gui_tbl2($_REQUEST['cuenta'],$_REQUEST['identificador']);
	}
	 
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
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
	
	
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switch.min.js"></script>
	
	<script type="text/javascript" src="assets/js/core/app.js"></script>
		
		
	<script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>
	
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>

	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jasny_bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/extensions/cookie.js"></script>
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
<style>
.not-active {
   pointer-events: none;
   cursor: default;
   opacity: 0.5;
   color: red;
}

.panel-body {
    padding: 0px !important;
}

.panel-flat > .panel-heading {
    padding-top: 0px !important;
    padding-bottom: 10px !important;
     background-color: transparent !important;
}
</style>
<body>
<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

			

				<!-- Content area -->
				<div class="content">

				<div class="panel panel-flat">
												
					<form class="form-gestion" action="#">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<h5 class="panel-title">GESTIÓN TMK</h5>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                		<li><a data-action="reload"></a></li>
				                		<li><a data-action="close"></a></li>
				                	</ul>
			                	</div>
							</div>

							<div class="panel-body">
								<input id="doc_" name="doc_" type="hidden" value='<?php echo isset($objDescribe2["documento"]) ? utf8_encode($objDescribe2["documento"]) : utf8_encode($objDescribe2["DOCUMENTO"]); ?>' />
								
						<div class="col-md-12">
						    <div class="col-md-4">
									
									<div class="form-group">
											
									<select id="efecto" name="efecto" data-placeholder="Efecto" class="select" required="required">
										<option value=""></option>
											<?php
												require_once("php/clsMotivo.php");
												$obj = new clsMotivo;
												$arr_datos = $obj->consulta_efecto2();
												foreach($arr_datos as $datos)
												echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
											?> 
									</select>
							    	</div>
									
									<div class="form-group">
										
									<select id="motivo" name="motivo" data-placeholder="Motivo" class="select"  required="required">
										<option value=""></option>
										
									</select>
						            </div>
						
								    <div class="form-group">
											
									<select id="contacto" name="contacto" data-placeholder="Contacto" class="select"  required="required" >
										<option value=""></option>
										
									</select>
									
									</div>
									
									  <div class="form-group">
											<textarea class="form-control required" id="descripcion" name="Observacion" maxlength="500" required="required" placeholder="Observación"></textarea>
							           </div>
						    
						    </div>
						    <div class="col-md-4">
							
									  <div class="form-group" style="display:flex;">
										<a title="Teléfono" id="telefono_click" name="telefono_click"><i class="icon-phone-plus"></i></a> 
											<select id="telefono" name="telefono" data-placeholder="Teléfono" class="select"  >
												<option value=""></option>
													<?php
													
												$doc=	isset($objDescribe2["documento"]) ? utf8_encode($objDescribe2["documento"]) : utf8_encode($objDescribe2["DOCUMENTO"]);
													
														require_once("php/clsGestion.php");
														$obj = new clsGestion;
														$arr_datos = $obj->telefonos($doc);
														foreach($arr_datos as $datos)
														echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
													?> 
											</select>
										</div>
								
							
							
								
							      <div class="form-group">
									<select id="direccion" name="direccion" data-placeholder="Direccion" class="select" required="required"  >
										<option value=""></option>
											<?php
												require_once("php/clsGestion.php");
												$obj = new clsGestion;
												$arr_datos = $obj->direcciones($doc);
												foreach($arr_datos as $datos)
												echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
											?> 
									</select>
									</div>
									
								
								
									<div class="form-group">
									<input type="text" id="nom_contacto" name="nom_contacto" class="form-control" placeholder="Nombre Contacto" maxlength="100" aria-required="true">
								    </div>
									
								
								
								<div class="form-group">
								
									<input type="text" id="pisos" name="pisos" class="form-control" maxlength="20" placeholder="Pisos" required="required">
									
								</div>
								
							</div>
							
							<div class="col-md-4">
								
								<div class="form-group">
									<input type="text" id="puerta" name="puerta" class="form-control" placeholder="Puerta" maxlength="20" required="required">
									
								</div>
								
								<div class="form-group">
									<input type="text" id="fachada" name="fachada" class="form-control" placeholder="Fachada" maxlength="50" required="required">
									
								</div>
								
								<div id="fec_promesa_" class="form-group">
									
									<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" id="fec_promesa" name="fec_promesa"  class="form-control pickadate_ges" placeholder="Fec. Pago" /> 

										</div>
												
									
								</div>
								
								<div class="form-group" id="monto_promesa_">
								
									<input type="text" id="monto_promesa" name="monto_promesa" class="form-control" placeholder="Monto" min=1 max="1000" >
									
								</div>
								
								</div>
						</div>
								
								<div class="text-left">
								    
										<button type="submit" class="btn btn-primary" >Enviar <i class="icon-arrow-right14 position-right"></i></button>
								</div>
									
									
							
														
							
								
							</div>
						</div>
					</form>
							                	
		            </div>

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
    
     $("#fec_promesa_").hide();
	 $("#monto_promesa_").hide();
	 
	$("#telefono_click").click(function(e) {	
	    
	   
	          
								
									 bootbox.confirm({
                                        title: "<i class='icon-phone'></i> Agregar Telefono",
                                        message: "<input class='form-control' type='text' id='telefono_' name='telefono_' maxlength=9 />",
                                        buttons: {
                                            cancel: {
                                                label: 'Cancel'
                                            },
                                            confirm: {
                                                label: '<i class="icon-check" style="font-size: 12px;"></i> Ok'
                                            }
                                        },
                                        callback: function (result) {
                                           // console.log('This was logged in the callback: ' + id);
                                           console.log(result);
                            			   
                            			 
                                    	var telefono_ =  jQuery('#telefono_').val();
                                    		var doc_gestion =  jQuery('#doc_').val();
                                    		
	var cuenta_ =  '<?php echo $_REQUEST['cuenta']; ?>';
	console.log(doc_);
                            				
                                            if( result==false || result=="false"){
                                                console.log("nulo");
                                            }else if($("#telefono_").val()=="" || telefono_.length<=4){
                                                swal({   title: "Mensaje del Sistema",   text: "Ingrese Teléfono",    type: "warning" });
                                                return false;
                                            }else{
                                                	registrar_telefono(doc_gestion,cuenta_,telefono_,9);
                                            }
                                        }
                                    });
									
									
								      
								           
	});
	
	  $("#efecto").change(function(e) {				
			var efecto = $(this).val();
			efecto=efecto.split('|')[0];
			var efecto2=$(this).val().split('|')[1]; 
			console.log(efecto);
			console.log(efecto2);
			
			
			if (efecto2==1){
			    $("#fec_promesa_").show();
	            $("#monto_promesa_").show();
	            $("#fec_promesa").attr({'required':'required'});
	            $("#monto_promesa").attr({'required':'required'});
	            
			}else{
			    $("#fec_promesa_").hide();
                $("#monto_promesa_").hide();
                 $("#fec_promesa").val("");
                 $("#monto_promesa").val("");
                 $("#fec_promesa").removeAttr( "required" );
                 $("#monto_promesa").removeAttr( "required" );
			}
			
			cargar_motivo(efecto);
			cargar_contacto(efecto);
			
			
		});
		
		
	
		$(".form-gestion").on("submit",function(e){
						e.preventDefault();
						console.log(e);
						if(e.result===true){			
										
							var cuenta =  '<?php echo $_REQUEST['cuenta']; ?>';
							var id =  '<?php echo $_REQUEST['id']; ?>';
							var id_cuenta =  '<?php echo $objTable['id']; ?>';
							var identificador = '<?php echo $_REQUEST['identificador']; ?>';
							
							var observacion =  jQuery('#descripcion').val();
							var efecto =  jQuery('#efecto').val();
							var motivo =  jQuery('#motivo').val();
							var contacto =  jQuery('#contacto').val();
							var telefono =  jQuery('#telefono').val();
							var direccion =  jQuery('#direccion').val();
							var nom_contacto =  jQuery('#nom_contacto').val();
							var pisos =  jQuery('#pisos').val();
							var puerta =  jQuery('#puerta').val();
							var fachada =  jQuery('#fachada').val();
							
							var fecha_promesa =  jQuery('#fec_promesa').val();
							var monto_promesa =  jQuery('#monto_promesa').val();
							
							
							console.log(cuenta);
							console.log(id);
							console.log(id_cuenta);
							console.log(identificador);
							
							var control=5;
							
								bootbox.confirm("¿Desea guardar gestión?", function(result) {
								if (result){    
								    
								    	registrar(id,id_cuenta,identificador,observacion,efecto,motivo,contacto,telefono,direccion,nom_contacto,pisos,puerta,fachada,control,fecha_promesa,monto_promesa);
								}
								
								});
							
						
							
							
						}
		});
		


	
});




function registrar_telefono(doc_gestion,cuenta_,telefono_,control) {
    $.ajax({
        data: {doc_gestion:doc_gestion,cuenta_:cuenta_,telefono_:telefono_,control:control},
        dataType: 'json',
        url: 'ajax/ajax_gestion.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                
               // window.location='datatable_mi_bandeja.php';
                location.reload();
                
                
            }else if(response.codigo>=2){
                swal({ title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
            }
        }
    });
}

function registrar(id,id_cuenta,identificador,observacion,efecto,motivo,contacto,telefono,direccion,nom_contacto,pisos,puerta,fachada,control,fecha_promesa,monto_promesa) {
    $.ajax({
        data: {id:id,id_cuenta:id_cuenta,identificador:identificador,observacion:observacion,efecto:efecto,motivo:motivo,contacto:contacto,telefono:telefono,direccion:direccion,nom_contacto:nom_contacto,pisos:pisos,puerta:puerta,fachada:fachada,control:control,fecha_promesa:fecha_promesa,monto_promesa:monto_promesa},
        dataType: 'json',
        url: 'ajax/ajax_gestion.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                
              
              var cuenta =  '<?php echo $_REQUEST['cuenta']; ?>';
							var id =  '<?php echo $_REQUEST['id']; ?>';
							var identificador = '<?php echo $_REQUEST['identificador']; ?>';
        console.log(id+'/'+cuenta+'/'+identificador);
        
        	
        
                 window.opener.document.location="form_gestion.php?id="+id+"&cuenta="+cuenta+"&identificador="+identificador
                window.close();
                
            }else if(response.codigo>=2){
                swal({ title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
            }
        }
    });
}



function cargar_motivo(id) {
		$.ajax({
			data: {id:id},
			dataType: 'html',
			url: 'ajax/cbb_motivo.php',
			success:  function (response) {
				$("#motivo").html(response);
			}
		});
	}
	
function cargar_contacto(id) {
		$.ajax({
			data: {id:id},
			dataType: 'html',
			url: 'ajax/cbb_contacto.php',
			success:  function (response) {
				$("#contacto").html(response);
			}
		});
	}




</script>

	
</body>
</html>
