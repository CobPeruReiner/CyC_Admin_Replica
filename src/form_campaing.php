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
	
	}
	 
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="euc-jp">	
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
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

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

			<!-- Main content -->
			<div class="content-wrapper">

			


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
						<table class="table datatable-campana" style="font-size: 11px;">
							<thead style="background: #e6e4e4;">
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th>Cartera</th>
									<th>Tipo</th>
									<th>Fecha</th>
									<th>Identificador</th>
									<th>Monto</th>
									<th>Dscto</th>
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


<script>

	
$(function() {	
    
     var identificador=	'<?php echo $_REQUEST['identificador']; ?>';
	console.log(identificador);

	listar_campana(identificador,7);
	
	
});




function listar_campana(identificador,control){
 $.ajax({
        data: {identificador:identificador,control:control},
        url: 'ajax/ajax_gestion.php',
        dataType: 'json',
    }).done(function(data){
        
       // console.log(data.arr_datos.length);
            if (data.codigo==0){
			
				$(".datatable-campana tbody").html("");
			}else{
			    
			  /*  new PNotify({
                        title: 'Mensaje de alerta',
                        text: 'Tiene '+ data.arr_datos.length +' campañas, favor de visualizar detalle',
                        icon: 'icon-blocked',
                        type: 'danger'
                });*/
    
    
                var table=$('.datatable-campana').dataTable({
                    'data': data.arr_datos,
                    "responsive": true,
                    "destroy": true,
                    "order": [[ 0, "desc" ]],
                    "bProcessing": true
                    
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
