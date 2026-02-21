<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsTable.php");
	session_start();
	if (!isset($_SESSION['user_ls'])){
		header("Location: index.php");
	}elseif ($_REQUEST['id']=="" ){
		header("Location: datatable_table.php");
	}else{
	    $objTable = clsTable::select($_REQUEST['id']);
		$objDescribe = clsTable::describe_table($objTable[1]);
		$objRecupera = clsTable::recupera_table($_REQUEST['id']);
       /* var_dump($objRecupera[0]['campo']);
        var_dump($objDescribe[1]['field']);*/
        
        //var_dump( $objTable['id_cartera']);
        
        $objItem = clsTable::select_asignacion($_REQUEST['id']);
		//var_dump($objItem);
		function isCombo($id_usuario, $objItem){
    		$valor = -1;
    		for ($i=0; $i<sizeof($objItem); $i++) {
    		    
    			if ($objItem[$i]['id_usuario']==$id_usuario){
        			var_dump($objItem[$i]);
        			$valor=$objItem[$i]['id_usuario'];
        			break; 
    			}
    		}
    		return $valor;
    	}
    	
    	
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
		<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
		
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>
	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>

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
							<h4><a href="datatable_table.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Table</span> <?php echo $objTable[1];?></h4>
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
							<li class="active">Table</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="datatable_table.php"><i class="icon-checkbox-checked"></i> Table</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
				    	<form action="#" class="form-m-gui">
				
					<div class="row" id="item_table">
							   
				
				<div class="col-md-4">
				
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
							    
							   	<div class="form-group">	
												  <label>Asignación</label>
													<select id="tipo" name="tipo" data-placeholder="Seleccione" class="form-control" required="required">
														<option value="">Seleccione</option>
														<option value="G" <?php echo $objTable['asignacion']=='G' ? 'selected' : '' ; ?>>General</option>
														<option value="A" <?php echo $objTable['asignacion']=='A' ? 'selected' : '' ; ?>>Asignada</option>
													</select>
											</div> 
											
							    	<div class="form-group">
							    	  <label>Usuarios(s)</label>
													<div class="multi-select-full">
														<select id="usuario" name="usuario" class="multiselect" multiple="multiple" required="required">
															<?php
																require_once("php/clsUsuario.php");
																$obj = new clsUsuario;
																$arr_datos = $obj->consulta_usuario($objTable['id_cartera']);
										foreach($arr_datos as $datos)			
																	if (isCombo($datos['id'],$objItem)==$datos['id']){
																	echo '<option value="'.$datos['id'].'" selected>'.($datos['nombre']).'</option>';
																}else{
																	echo '<option value="'.$datos['id'].'">'.($datos['nombre']).'</option>';
																}
																
																
															?> 
													</select>
													</div>
												</div>
							 
							 
							  <div class="text-left">
								    
									<button type="submit" class="btn btn-primary">Modificar <i class="icon-arrow-right14 position-left"></i></button>
								</div>
							 
							 </div>
							 
							
							 
				    </div>
				</div>
							    	
							    	
							    	
							    	
				<div class="col-md-4">
				
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
							    
							    
							    <div class="col-md-12">
							        
										<fieldset>
										<input  type="hidden" class="form-control" placeholder="idtable" id="idtable" name="idtable" value="<?php echo $objTable[0]; ?>">
										
												<?php
												for ($i=1; $i < sizeof($objDescribe)/2;$i++) {
												?>
												<div class="form-group" style="display: inline-flex;">
													<span class="label label-flat label-rounded label-icon border-teal text-teal-600"><?php echo round($i); ?></span>
														<input readonly type="text" class="form-control" placeholder="Campo" id="nombre_<?php echo $i;?>" name="nombre_<?php echo $i;?>" value="<?php echo ($objDescribe[$i]['field']); ?>">
										
									
										
											
														<select id="gui_<?php echo $i;?>" name="gui_<?php echo $i;?>" data-placeholder="Seleccione" class="form-control" required>
											<option value="">Seleccione</option>
												<option value="1" <?php echo $objRecupera[$i-1]['gui']=='1' ? 'selected' : '' ; ?> >GUI 1</option>
												<option value="2" <?php echo $objRecupera[$i-1]['gui']=='2' ? 'selected' : '' ; ?> >GUI 2</option>
												<option value="3" <?php echo $objRecupera[$i-1]['gui']=='3' ? 'selected' : '' ; ?> >GUI 3</option>
												
												</select>
										</div>
												
												<?php } ?>
												
									
										</fieldset>
										
									</div>
									
								
								
							
							</div>
						</div>
				

	                </div>
	                
	                
	                <div class="col-md-4">
				
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
							    
									<div class="col-md-12">
									
												<?php
												
												if ((sizeof($objDescribe)-1)%2==0){
												    $par=(sizeof($objDescribe)/2                )+1;
												    $contador=1;
												}else{
												    $par=(sizeof($objDescribe)/2             );
												     $contador=0;
												}
												
												
												for ($i=$par; $i < sizeof($objDescribe);$i++) {
												    
												    //	echo $i;
												    
												?>
												
												<div class="form-group" style="display: inline-flex;">
												<span class="label label-flat label-rounded label-icon border-teal text-teal-600"><?php echo round($i)-$contador; ?></span>
												
														<input readonly type="text" class="form-control" placeholder="Campo" id="nombre_<?php echo round($i)-$contador;?>" name="nombre_<?php echo round($i)-$contador;?>" value="<?php echo ($objDescribe[$i]['field']); ?>">
										
										
											
														<select id="gui_<?php echo round($i)-$contador;?>" name="gui_<?php echo round($i)-$contador;?>" data-placeholder="Seleccione" class="form-control" required >
												<option value="">Seleccione</option>
												<option value="1" <?php echo $objRecupera[$i-1]['gui']=='1' ? 'selected' : '' ; ?> >GUI 1</option>
												<option value="2" <?php echo $objRecupera[$i-1]['gui']=='2' ? 'selected' : '' ; ?> >GUI 2</option>
												<option value="3" <?php echo $objRecupera[$i-1]['gui']=='3' ? 'selected' : '' ; ?> >GUI 3</option>
												</select>
										</div>
												
												<?php } ?>
												
									
										
									</div>
									
									
								
							</div>
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
	
	if ($("#tipo").val()=="G"){
	    $('#usuario').attr("disabled","disabled");
	}
	
    $('#usuario').multiselect({
        onChange: function() {
            $.uniform.update();
        }
    });
    

	$("#tipo").change(function(e) {				
		var tipo = $(this).val();
		if (tipo=="G"){
		     $('#usuario').attr("disabled","disabled");
		      $(".multi-select-full").find(":button").attr("disabled","disabled");
		      
		      $('#usuario option:selected').each(function() {
                    $(this).prop('selected', false);
                })
        
                $('#usuario').multiselect('refresh');
                $.uniform.update();
        
		}else{
		     $('#usuario').removeAttr("disabled");
		     $(".multi-select-full").find(":button").removeAttr('disabled');
            $(".multi-select-full").find(":button").removeClass('disabled');
            
            
            $('#usuario option:selected').each(function() {
                $(this).prop('selected', false);
            })
    
            $('#usuario').multiselect('refresh');
            $.uniform.update();
        
        
		}
		
	});
    
    
    
 $(".form-m-gui").on("submit",function(e){
        e.preventDefault();
        console.log(e);
        if(e.result===true){
            var id =  jQuery('#idtable').val();
            var asigna =  $("#tipo").val();
            var arr_items3 =  $("#usuario").val();
       

			var arr_items = new Array();
			var arr_items2 = new Array();
			for (var i=1;i<=25;i++) {
				var $control = $("#item_table").find("#nombre_"+i );
				var $control2 = $("#item_table").find("#gui_"+i );
				//console.log($control.length);
				if ($control.length==1) {
					arr_items.push([$control.val(), $control2.val()]);
				}
			}	
			
			for (var i=26;i<=50;i++) {
				var $control = $("#item_table").find("#nombre_"+i );
				var $control2 = $("#item_table").find("#gui_"+i );
				//console.log($control.length);
				if ($control.length==1) {
					arr_items2.push([$control.val(), $control2.val()]);
				}
			}	
			
			
			console.log(arr_items);
			console.log(arr_items2);
					
            bootbox.confirm("¿Desea agregar Interfaz de Usuario?", function(result) {
                if (result){    
                    gui(id,arr_items,4,arr_items2,asigna,arr_items3); 
                }
            });
        }
    });
	
				
				
});
			
 function gui(id,arr_items,control,arr_items2,asigna,arr_items3){
    $.ajax({
        data: {id:id,arr_items:arr_items,control:control,arr_items2:arr_items2,asigna:asigna,arr_items3:arr_items3},
        dataType: 'json',
        url: 'ajax/ajax_table.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                
                //window.location='datatable_table.php';
                asignacion(id,arr_items3,7);
                gui2(id,arr_items2,6);
                
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
                                    callback: function () { window.location='datatable_table.php'; }
                                    }
                            }
                });
            }
        }
    });
}		


 function gui2(id,arr_items2,control){
    $.ajax({
        data: {id:id,arr_items2:arr_items2,control:control},
        dataType: 'json',
        url: 'ajax/ajax_table.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                
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
                                    callback: function () { window.location='datatable_table.php'; }
                                    }
                            }
                });
            }
        }
    });
}	


function asignacion(id,arr_items3,control){
    $.ajax({
        data: {id:id,arr_items3:arr_items3,control:control},
        dataType: 'json',
        url: 'ajax/ajax_table.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                console.log("Se insertaron asignaciones");
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
                                    callback: function () { window.location='datatable_table.php'; }
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
