<?php
	
	session_start();
	if (!isset($_SESSION['user_ls']))
	header("Location: index.php");
	require_once("php/clsUsuario.php");
	require_once("php/clsDashboard.php");
	$obj = new clsUsuario;
	$obj2 = new clsDashboard;
	$arr_datos = $obj->version_system();
	$arr_datos2 = $obj2->gestiones_ctd();
//	 echo date("m/d/Y");
	
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
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>


		<script type="text/javascript"src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
		
<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>

	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>

		
	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	
	
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
							<h4><i class="icon-chart position-left"></i> <span class="text-semibold">Reportes</span></h4>
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
							<li class="active">Reportes</li>
						</ul>

					</div>
				</div>
				<!-- /page header -->
				
				<!-- Content area -->
				<div class="content">

					<!-- Main charts -->
					<div class="row">
					
					
					<div class="col-md-12">
									<h6 class="panel-title">Pagos</h6>
									
									
									<div class="col-md-12">
									    <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
											<i class="icon-calendar3 position-left"></i> <span></span> <b class="caret"></b>
										</button>
									    
				                	</div>
				                	
				                
								<div class="col-md-12">	
								<div class="col-md-6">
									 <select id="cliente" name="cliente" data-placeholder="Seleccione" class="select" required="required">
										<option value="0">Todos los clientes</option>
											<?php
										require_once("php/clsReporte.php");
												$obj = new clsReporte;
												$arr_datos = $obj->clientes2();
												foreach($arr_datos as $datos)
												echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
											?> 
									</select>
								</div>
									
				                <div class="col-md-2">
									<a id="btn_excel2" name="btn_excel2" href="#" class="btn bg-teal-400"><i class="icon-search4"></i></a>
									
									<a id="btn_busca2" name="btn_busca2" href="#" class="btn bg-teal-400"><i class="icon-file-excel"></i> </a>
									
								</div>
							
							</div>
							
							<div class="col-md-12">	
				                	<div class="col-md-6">
									    <select id="cuenta" name="cuenta" data-placeholder="Seleccione" class="select" required="required">
										<option value="0">Todas las cuentas</option>
											<?php
											require_once("php/clsReporte.php");
												$obj = new clsReporte;
												$arr_datos = $obj->cuentas2();
												foreach($arr_datos as $datos)
												echo '<option value="'.$datos['id'].'">'.$datos['nombre'].'</option>';
											?> 
								    	</select>
							    	</div>
								
    								<div class="col-md-2">
    									<a id="btn_excel" name="btn_excel" href="#" class="btn bg-teal-400"><i class="icon-search4"></i></a>
    									
    									<a id="btn_busca" name="btn_busca" href="#" class="btn bg-teal-400"><i class="icon-file-excel"></i> </a>
    									
    								</div>
    							</div>
									
									
					</div>
					
			        <div class="col-lg-1">
			          </div>
					<div class="col-lg-5">
							<div class="panel panel-flat">
								
								<div class="table-responsive">	
            							<table class="datatable-1" style="font-size:11px !important;">
            						<thead style="background: #e8e8e8;">
            							<tr>
            								
            								<th>Fecha Pago</th>
            								<th>Cartera</th>
            								<th>Q</th>
            								<th>Monto</th>
            								
            							</tr>
            						</thead>
            						<tbody>
            						</tbody>
            					</table>
            					</div>
					        </div>
					</div>		
							

						</div>
					
					<!-- /main charts -->




				</div>
				<!-- /content area -->



			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<script>
$(document).ready(function(){
    //Cada 10 segundos (10000 milisegundos) se ejecutará la función refrescar
    //setTimeout(refrescar, 1000);
    
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
    
    
    
     var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                var f=new Date();
                fecha=(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                
                console.log( ('00' + f.getMonth()).slice(-2) ); // "0001"
                var mes=('00' + f.getMonth()).slice(-2);
                var mes2=('00' + (f.getMonth()+1)).slice(-2);
                var dia=('00' + f.getDate()).slice(-2)
                
                fecha2=(f.getFullYear()+ "/" + mes2+ "/" + dia);
                fecha1=(f.getFullYear()+ "/" + mes+ "/" + '01');
                
                console.log(fecha1);
                console.log(fecha2);
                
               /* 01/2/2021
                  2/3/2021
               */

    $('.daterange-ranges').daterangepicker(
        {
            
           // console.log( moment());
            startDate: moment().subtract('days', 29),
            endDate: moment(),
            //minDate: fecha1,
            maxDate: fecha2,
            //dateLimit: { days: 60 },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            opens: 'right',
            applyClass: 'btn-small bg-slate-600 btn-block',
            cancelClass: 'btn-small btn-default btn-block',
            //format: 'DD/MM/YYYY'
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
        },
        function(start, end) {
            $('.daterange-ranges span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        }
    );

    $('.daterange-ranges span').html(moment().subtract('days', 29).format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD'));



      $("#btn_excel").click(function(e) {
		e.preventDefault();
		
		 listar_1(1,$('.daterange-ranges span').text().substring(0, 10),$('.daterange-ranges span').text().substring(13, 23),$('#cuenta').val(),'');
		 
       
    });
    
    $("#btn_busca").click(function(e) {
		e.preventDefault();
		
        bootbox.confirm("\u00bfDesea generar archivo excel?", function(result) {
    		if (result){
    			abrirNuevaVentana('excel_pago.php?fecha_inicio=' +  $('.daterange-ranges span').text().substring(0, 10)+ ' 00:00:00' + '&fecha_fin='+ $('.daterange-ranges span').text().substring(13, 23)+ ' 23:59:59'+ '&cuenta='+$('#cuenta').val());
    		}
    	}); 
    });
    
     $("#btn_busca2").click(function(e) {
		e.preventDefault();
		
        bootbox.confirm("\u00bfDesea generar archivo excel?", function(result) {
    		if (result){
    			abrirNuevaVentana('excel_pago2.php?fecha_inicio=' +  $('.daterange-ranges span').text().substring(0, 10)+ ' 00:00:00' + '&fecha_fin='+ $('.daterange-ranges span').text().substring(13, 23)+ ' 23:59:59'+ '&cliente='+$('#cliente').val());
    		}
    	}); 
    });
    
      $("#btn_excel2").click(function(e) {
		e.preventDefault();
		
		listar_1(1,$('.daterange-ranges span').text().substring(0, 10),$('.daterange-ranges span').text().substring(13, 23),'',$('#cliente').val());
		
       
    });
    
    
    $(".datatable-1").hide();
    
  listar_1(1,fecha1,fecha2,'','');
    
    
  });
  
  
function listar_1(control,fecha_i,fecha_f,cuenta,cliente){
 $.ajax({
        data: {control:control,fecha_i:fecha_i,fecha_f:fecha_f,cuenta:cuenta,cliente:cliente},
        url: 'ajax/ajax_reporte.php',
        dataType: 'json',
    }).done(function(data){
            if (data.codigo==0){
				//swal({   title: "Mensaje del Sistema",   text: data.mensaje,    type: "warning" });
				console.log(data.mensaje);
				$(".datatable-1 tbody").html("");
				$(".datatable-1").hide();
			}else{
			    $(".datatable-1").show();
                var table=$('.datatable-1').dataTable({
                    'data': data.arr_datos,
                    "responsive": true,
                    "destroy": true,
                    "order": [[ 0, "desc" ]],
                    "bProcessing": true
				});  

				$('.dataTables_filter input[type=search]').attr('placeholder','Escribe');

				
                
			}
    });
}

  
function refrescar(){
    location.reload();
}


function abrirNuevaVentana(url) {
    var $w = $('<a style="display: none;"  href="' + url + '"/>');
    $("body").append($w)
    $w[0].click();
    $w.remove();
}

</script>
  
</body>
</html>
