<?php
	
	session_start();
	
	if (!isset($_SESSION['user_ls'])){
	    echo "<script> setTimeout(window.close(), 2000); </script>";
	}elseif ($_REQUEST['id']=="" ){
		echo "<script> setTimeout(window.close(), 2000); </script>";
	}else{
        require_once("php/clsGestion.php");
        require_once("php/clsTable.php");
        $objTable = clsGestion::verificar_tabla($_REQUEST['id']);
        $objTable2 = clsTable::describe_table($objTable[0]['nombre']);
		//var_dump($objTable2[2]['field']);

    	require_once("php/clsUsuario.php");
    	$obj = new clsUsuario;
    	$arr_datos = $obj->version_system();
	
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
						<table class="table datatable-table" style="font-size: 11px;">
							<thead style="background: #e6e4e4;">
								<tr>
									<th>#</th>
									<th>Identificador</th>
									<th><?php echo $objTable2[2]['field'];?></th>
									<th><?php echo $objTable2[3]['field'];?></th>
									<th><?php echo $objTable2[4]['field'];?></th>
									<th><?php echo $objTable2[5]['field'];?></th>
									<th>Opciones</th>
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
    
    var table='<?php echo $objTable[0]['nombre']?>';
    var id_table='<?php echo $objTable[0]['id']?>';
    var campo1='<?php echo $objTable2[2]['field']?>';
    var campo2='<?php echo $objTable2[3]['field']?>';
    var campo3='<?php echo $objTable2[4]['field']?>';
    var campo4='<?php echo $objTable2[5]['field']?>';
	listar(3,table,id_table,campo1,campo2,campo3,campo4);
	
	
});


function listar(control,table,id_table,campo1,campo2,campo3,campo4){
 $.ajax({
        data: {control:control,table:table,id_table:id_table,campo1:campo1,campo2:campo2,campo3:campo3,campo4:campo4},
        url: 'ajax/ajax_gestion.php',
        dataType: 'json',
    }).done(function(data){
            if (data.codigo==0){
				swal({   title: "Mensaje del Sistema",   text: data.mensaje,    type: "warning" });
				$(".datatable-table tbody").html("");
			}else{
			    
                var table=$('.datatable-table').dataTable({
                    'data': data.arr_datos,
                    "responsive": true,
                    "destroy": true,
                    "order": [[ 0, "desc" ]],
                    "bProcessing": true,
                     "columnDefs":[{   "targets": 6, 
                                        "data": data, 
                                        "render": function ( data, type, row, meta ) {
                                 
                                          return  '<input class="txt_id" type="hidden" value="'+data[0]+'"/><input class="txt_identificador" type="hidden" value="'+data[1]+'"/><button class="btn_asignar" type="button" title="Asignar"><i class="icon-check" style="font-size: 12px;"></i> </button>'
                                        }
								   }]
					});  

				$('.dataTables_filter input[type=search]').attr('placeholder','Escribe');

				// Enable Select2 select for the length option
				$('.dataTables_length select').select2({
					minimumResultsForSearch: Infinity,
					width: 'auto'
				});
				
					btn_table();

                $('input[type=search]').keyup(function(e) {
                    btn_table();
                }); 

                $(document).on('click', '.paginate_button', function (e) {
                    btn_table();
                });	

                $(".dataTables_length select").change(function(e) {
                    btn_table();
                }); 
                
			}
    });
}



function btn_table(){
   
    $(".btn_asignar").unbind();
    $(".btn_asignar").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();
        var cuenta='<?php echo $objTable[0]['nombre']?>';
        var identificador=$(this).parent().find(".txt_identificador").val();
        console.log(id+'/'+cuenta+'/'+identificador);
        
        //bootbox.confirm("&#191;Desea ver detalle del registro?", function(result) {
          //  if (result){
                //opener.location.reload();
                window.opener.document.location="form_gestion.php?id="+id+"&cuenta="+cuenta+"&identificador="+identificador
                //window.close();
            //}
        //}); 
    
    });
	
}

function asignar(id,id_table,control) {

    $.ajax({
		data: {id:id,id_table:id_table,control:control },
		dataType: 'json',
		url: 'ajax/ajax_gestion.php',
		success:  function (response) {
			console.log(response);
			if (response.codigo==1){
				    console.log(response.mensaje);
				    opener.location.reload();
               //window.close();
			}else{
			     swal({   title: "Mensaje del Sistema", text: reponse.mensaje, type: "error" });
			}
		}
	});
    
}
	



</script>

	
</body>
</html>
