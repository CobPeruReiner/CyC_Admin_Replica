<?php
	session_start();
	if (!isset($_SESSION['user_ls']))
	header("Location: index.php");
	require_once("php/clsUsuario.php");
	$obj = new clsUsuario;
	$arr_datos = $obj->version_system();
	
	
//print_r("'".str_replace(",", "','",'1111,222,333')."'");
	
	
	

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

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
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
							<h4><i class="icon-database-add position-left"></i> <span class="text-semibold">Administraci&oacute;n</span> Tablas</h4>
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
							<li class="active">Tablas</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="form_a_table.php"><i class="icon-database-add"></i> Nueva Tabla</a></li>
									<li class="divider"></li>
									<!--<li><a href="carga_direccion.php"><i class="icon-libreoffice"></i> Cargar CSV</a></li>-->
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


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
							<thead>
								<tr>
									<th>Id</th>
									<th>Nombre</th>
									<th>Fecha Registro</th>
									<th>Usuario</th>
									<th>Archivo</th>
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
	listar(2);
	
	
});
	
function listar(control){
 $.ajax({
        data: {control:control},
        url: 'ajax/ajax_table.php',
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
                    "createdRow": function ( row, data, index ) {
                        var texto = $('td', row).find('label').text();
                        if(texto=="NO"){
                            $('td', row).find('label').addClass('label bg-danger-400');
                            
                        }else{
                             $('td', row).find('label').addClass('label bg-success-400');
							 /*$('td', row).find('.btn_carga').removeClass('btn_carga').addClass('not-active');*/
                        }


                    },
                     "columnDefs":[{   "targets": 5, 
                                        "data": null, 
                                        "render": function ( data, type, row, meta ) {
                                          return  '<input class="txt_id" type="hidden" value="'+data[0]+'"/><button class="btn_carga" type="button" title="Subir CSV"><i class="icon-upload" style="font-size: 12px;"></i> </button><button title="Cargar" class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_gui" type="button" title="Campos"><i class="icon-windows8" style="font-size: 12px;"></i> </button><button class="btn_plantilla" type="button" title="Plantilla"><i class="icon-newspaper" style="font-size: 12px;"></i> </button><button class="btn_duplicar" type="button" title="Duplicar"><i class="icon-copy4" style="font-size: 12px;"></i> </button><button class="btn_remove" type="button" title="Eliminar"><i class="icon-database-remove" style="font-size: 12px;"></i> </button>'
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
    $(".btn_carga").unbind();
    $(".btn_carga").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();        
        console.log(id);
        
		bootbox.confirm({
            title: "Cargar Csv: "+id,
            message: "<input type='file' id='file-es' name='file-es' />",
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
			   
				var file = $.trim($("#file-es").val());
				var extension = file.substr(file.length - 4, 4).toUpperCase();
				console.log(extension);
                if( result==false || result=="false"){
                    console.log("nulo");
                }else if($("#file-es").val()=="" || file.length==0){
                    swal({   title: "Mensaje del Sistema",   text: "Seleccione Csv",    type: "warning" });
                    return false;
                }else if(extension!='.CSV'){
                    swal({   title: "Mensaje del Sistema",   text: extension+" No es una extensión permitida",    type: "warning" });
                    return false;
                }else{
                   update_ruta(id,3);
                }
            }
        });
		
    });
	
	
	$(".btn_remove").unbind();
    $(".btn_remove").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();        
        console.log(id);
        
        bootbox.confirm({
            title: "Eliminar registros en la cuenta (separado por coma): ej. 12345678,87654321",
            message: "<input class='form-control' type='text' id='identificador' name='identificador' />",
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
			   
				var texto = $.trim($("#identificador").val());
				
                if( result==false || result=="false"){
                    console.log("nulo");
                }else if($("#identificador").val()=="" || identificador.length<=4){
                    swal({   title: "Mensaje del Sistema",   text: "Ingrese identificador",    type: "warning" });
                    return false;
                }else{
                    //console.log(id+'///'+texto+'///'+9);
                   eliminar_valores(id,texto,9);
                }
            }
        });
        
    });
    
	$(".btn_duplicar").unbind();
    $(".btn_duplicar").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();        
        console.log(id);
        bootbox.confirm("&#191;Desea duplicar cuenta?", function(result) {
            if (result){
               duplicar(id,8);
            }
        }); 
    });
    
    
	$(".btn_update").unbind();
    $(".btn_update").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();        
        console.log(id);
        bootbox.confirm("&#191;Desea ejecutar carga csv?", function(result) {
            if (result){
                window.location='carga_table.php?id=' + id;
            }
        }); 
    });
    
    $(".btn_gui").unbind();
    $(".btn_gui").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();        
        console.log(id);
        bootbox.confirm("&#191;Desea seleccionar GUI?", function(result) {
            if (result){
                window.location='form_table.php?id=' + id;
            }
        }); 
    });
    
    $(".btn_plantilla").unbind();
    $(".btn_plantilla").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();        
        console.log(id);
        bootbox.confirm("&#191;Desea descargar plantilla?", function(result) {
            if (result){
                window.location='plantilla.php?id=' + id;
            }
        }); 
    });
}



function eliminar_valores(id,texto,control) {

    $.ajax({
		data: {id:id,texto:texto,control:control },
		dataType: 'json',
		url: 'ajax/ajax_table.php',
		success:  function (response) {
			console.log(response);
			if (response.codigo==1){
					 swal({   title: "Mensaje del Sistema", text: response.mensaje, type: "info" });
			}else{
			     swal({   title: "Mensaje del Sistema", text: "ERROR", type: "error" });
			}
		}
	});
    
}


function duplicar(id,control) {

    $.ajax({
		data: {id:id,control:control },
		dataType: 'json',
		url: 'ajax/ajax_table.php',
		success:  function (response) {
			console.log(response);
			if (response.codigo==1){
					listar(2);
			}else{
			     swal({   title: "Mensaje del Sistema", text: "ERROR", type: "error" });
			}
		}
	});
    
}

function update_ruta(id,control) {
    $.ajaxFileUpload({
        async: false,
        url: 'ajax/ajax_table.php',
        type: 'post',
        secureuri: false,
        fileElementId:"file-es",
        dataType: 'json',
        data: {campo_archivo: "file-es",descripcion: 'File',id:id,control:control},
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                window.location='datatable_table.php';
            }else if(response.codigo>=2){
                swal({   title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
            }else{
                bootbox.dialog({
                closeButton: false,
                message: response.mensaje,
                    buttons: {
                                danger: {
                                    label: "Cerrar",
                                    className: "btn-danger",
                                    callback: function () {
                                        window.location='datatable_table.php';
                                        }
                                    }
                            }
                });
            }
        },
        error: function (dato) {
            console.log("ERROR");
            console.log(dato);
        }
    });
}

</script>

<!--<link href="assets/css/input-file.css" rel="stylesheet" type="text/css">-->	
<script type="text/javascript" src="assets/js/ajaxfileupload.js"></script>
<script src="assets/js/input-file.min.js"></script>
	
</body>
</html>
