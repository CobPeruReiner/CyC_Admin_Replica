<?php
	session_start();
	if (!isset($_SESSION['user_ls']))
	header("Location: index.php");
	require_once("php/clsUsuario.php");
	$obj = new clsUsuario;
	$arr_datos = $obj->version_system();
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
	
			<script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
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
							<h4><i class="icon-man-woman position-left"></i> <span class="text-semibold">Mi</span> Bandeja de Gestión</h4>
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
							<li class="active">Bandeja</li>
						</ul>

						<ul class="breadcrumb-elements">
						    
						    
						     <li>
						     <?php
						        $date = date("Y-m-d");
                                $mod_date = strtotime($date."- 7 days");
                                $resta_fecha= date("Y-m-d",$mod_date) .' / '.  $date ;
						     ?>
							    <div class="input-group">
											<input type="text" style=" width: 106% !important;" class="form-control daterange-left" value="<?php echo  $resta_fecha .' - '. date('Y-m-d'); ?>"> 
											<span class="input-group-addon"><i class="icon-calendar22"></i></span>
										</div>
							    
							</li>
							<!--<li><button id="btn_buscar" name="btn_buscar" type="button" class="btn btn-primary"><i class="icon-zoomin3 position-right"></i></button></li>-->
							
							<li>
									<button type="button" id="btn_excel" class="btn border-success text-success-600 btn-flat btn-icon btn-rounded legitRipple"><i class="icon-file-excel"></i></button>
							</li>
							
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
								    
								    	<?php
									require_once("php/clsGestion.php");
									$table = clsGestion::listar_asignaciones($_SESSION["id_ls"]);
									$general = clsGestion::listar_generales();
									
									//echo sizeof($table);
									
								//	if (sizeof($table)>0) {
									for ($i=0; $i < sizeof($table);$i++) {
									    
									   echo '<li style="display: inline-flex;"><input class="txt_id" type="hidden" value="'.$table[$i][1].'"/><a class="btn_a0" href="#" style="font-size: 10px;"><i class="icon-android"></i></a><p style="font-size: 10px;">'. $table[$i][1] .'</p></li>';
									    	
									}
									
									//a class="btn_a0" href="javascript:ventana_buscar('.$table[$i][0].')" style="font-size: 10px;"><i class="icon-search4"></i></a>
									    
									//}else{
									    echo '<li class="divider"></li>';
									    
									    for ($i=0; $i < sizeof($general);$i++) {
									    
									    echo'<li style="display: inline-flex;"><input class="txt_id" type="hidden" value="'.$general[$i][1].'"/><a id="btn_a0" href="#" style="font-size: 10px;"><i class="icon-users"></i>'. $general[$i][1] .'</a></li>';
									    
									    }
								//	}
									    
									 ?>
									
									
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
									<th>#</th>
									<th>Usuario</th>
									<th>Cuenta</th>
									<th>Fec. Registro</th>
									<th>User Registro</th>
									<th>Tipo</th>
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
	
	$(".btn_a0").click(function (e) {
        var cuenta = $(this).parent().find(".txt_id").val();       
        separador = ": ",
        textoseparado = cuenta.split(separador);
                                        
        console.log(textoseparado[1]);
         window.location='form_gestion.php?id=0&cuenta='+textoseparado[1]+'&identificador=000';
        
    });
    
    
    $("#btn_excel").click(function(e) {
		e.preventDefault();
        bootbox.confirm("\u00bfDesea generar archivo excel?", function(result) {
    		if (result){
    			abrirNuevaVentana('excel_gestion.php?fecha_inicio=' +  jQuery('.daterange-left').val().substring(0, 10)+ ' 00:00:00' + '&fecha_fin='+ jQuery('.daterange-left').val().substring(13, 23)+ ' 23:59:59');
    		}
    	}); 
    });

 $('.daterange-left').daterangepicker({
        opens: 'left',
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-default',
        locale: {
            format: 'YYYY-MM-DD',
            separator: " / ",
            applyLabel: "Aceptar",
            cancelLabel: "Cancel",
        daysOfWeek: [
            "Do",
            "Lu",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sab"
        ],
        monthNames: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        firstDay: 1
        }
       
    });
    

	
});

function asignar(id,control) {

    $.ajax({
		data: {id:id,control:control },
		dataType: 'json',
		url: 'ajax/ajax_gestion.php',
		success:  function (response) {
			console.log(response);
			if (response.codigo==1){
					listar(2);
				
			}else{
			     swal({   title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
			}
		}
	});
    
}
	
function listar(control){
 $.ajax({
        data: {control:control},
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
                    "createdRow": function ( row, data, index ) {
                        var texto = $('td', row).find('label').text();
                        if(texto=="CONCLUIDO"){
                            $('td', row).find('label').addClass('label bg-success-400');
                            
                        }else{
                             $('td', row).find('label').addClass('label bg-warning-400');
							 
                        }


                    },
                     "columnDefs":[{   "targets": 7, 
                                        "data": null, 
                                        "render": function ( data, type, row, meta ) {
                                        var texto = data[2];
                                        separador = ": ",
                                        textoseparado = texto.split(separador);
                                          
                                          return  '<input class="txt_id" type="hidden" value="'+data[0]+'"/><input class="txt_cuenta" type="hidden" value="'+textoseparado[1]+'"/><input class="txt_identificador" type="hidden" value="'+data[1]+'"/><button class="btn_ver" type="button" title="Gestionar"><i class="icon-eye" style="font-size: 12px;"></i> </button>'
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


function ventana_buscar(id_Registro){	
        opciones = 'width = 800, height = 600, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=yes, left = 50, top = 50';
        url = 'form_buscar.php?id='; 
        url += id_Registro
        window.open(url, 'mp1', opciones); 
}


function abrirNuevaVentana(url) {
    var $w = $('<a style="display: none;"  href="' + url + '"/>');
    $("body").append($w)
    $w[0].click();
    $w.remove();
}

function btn_table(){
   
    $(".btn_ver").unbind();
    $(".btn_ver").click(function (e) {
        var id = $(this).parent().find(".txt_id").val();        
        var identificador = $(this).parent().find(".txt_identificador").val();        
        var id_cuenta = $(this).parent().find(".txt_cuenta").val();        
        console.log(id);
        console.log(id_cuenta);
        bootbox.confirm("&#191;Desea gestionar registro?", function(result) {
            if (result){
                window.location='form_gestion.php?id=' + id+'&cuenta='+id_cuenta+'&identificador='+identificador+'&registro=1';
            }
        }); 
    });
}



</script>

	
</body>
</html>
