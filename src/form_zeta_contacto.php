<?php
	require_once("php/clsUsuario.php");
	require_once("php/clsGestion.php");
	session_start();
	if (!isset($_SESSION['user_ls'])){
		header("Location: index.php");
	}elseif ($_REQUEST['id']==""   ){
		header("Location: datatable_contacto.php");
	}else{
        $objTable = clsGestion::select_cuenta($_REQUEST['cuenta']);
         
		$objDescribe = clsGestion::gui_tbl($objTable['id'],1);
		$objDescribeg2 = clsGestion::gui_tbl($objTable['id'],2);
		$objDescribeg3 = clsGestion::gui_tbl($objTable['id'],3);
		$objDescribe2 = clsGestion::gui_tbl2($_REQUEST['cuenta'],$_REQUEST['identificador']);
		
		//print_r($_REQUEST['cuenta']);
		//print_r($_REQUEST['id']);
		
		//var_dump($objTable['id']);

	}
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

	<!-- Theme JS files -->
	
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
						<h4><a href="datatable_mi_bandeja.php"><i class="icon-arrow-left52 position-left"></i></a> <span class="text-semibold">Seguimiento</span> Contacto</h4>
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
						GESTIÓN TMK
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>

	                	<form class="steps-validation" action="#">
							<h6>Cliente</h6>
							<fieldset>
								<div class="row">
									<div class="col-md-10">
									
									<legend class="text-semibold"><i class="icon-user position-left"></i> Datos Cliente</legend>
													
										<div class="col-md-4">
										    
								    <?php
									/*echo is_float(sizeof($objDescribe)/3);
								    echo  is_float(24.5);*/
								    
								    if (is_float(sizeof($objDescribe)/3)==1){
								        $par=round(sizeof($objDescribe)/3                )-2;
										$par3=$par;   
										$par2=($par3*2)+2;
										$par4=$par2+1;
								    }else{
										 $par=(sizeof($objDescribe)/3             );
										 $par3=(sizeof($objDescribe)/3             ); 
										 $par2=($par*2)-1;
										 $par4=($par*2);
									}
									
									//echo ('0-'.$par.','.$par3.','.$par2.','.$par4);
										    	
								    
										
								        for ($i=0; $i < $par+1;$i++){
								    
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribe[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribe[$i]['campo']] ?>" readonly />
									
									    	</div>
												
												<?php } ?>
												
										</div>
										<div class="col-md-4">
												<?php
												
												for ($i=$par3+1; $i < $par2+1 ;$i++) {
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribe[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribe[$i]['campo']] ?>" readonly>
									
									    	</div>
												
												<?php } ?>	
													
									    </div>
									    
									    	<div class="col-md-4">
												<?php
									
										
												for ($i= $par4 ; $i < sizeof($objDescribe);$i++) {
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribe[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribe[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribe[$i]['campo']] ?>" readonly>
									
									    	</div>
												
												<?php } ?>	
													
									    </div>
									
									</div>

								
								</div>

							</fieldset>

						<h6>Cuenta</h6>
							<fieldset>
								<div class="row">
    								<div class="col-md-10">
    								    	<legend class="text-semibold"><i class="icon-home5 position-left"></i> Datos Cuenta</legend>
    									
    											
										<div class="col-md-4">
										    
								    <?php
							
								    
								        for ($i=0; $i < $par+1;$i++){
								    
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribeg2[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribeg2[$i]['campo']] ?>" readonly />
									
									    	</div>
												
												<?php } ?>
												
										</div>
										<div class="col-md-4">
												<?php
												
												for ($i=$par3+1; $i < $par2+1 ;$i++) {
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribeg2[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribeg2[$i]['campo']] ?>" readonly>
									
									    	</div>
												
												<?php } ?>	
													
									    </div>
									    
									    	<div class="col-md-4">
												<?php
									
										
												for ($i= $par4 ; $i < sizeof($objDescribeg2);$i++) {
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribeg2[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribeg2[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribeg2[$i]['campo']] ?>" readonly>
									
									    	</div>
												
												<?php } ?>	
                                    
								</div>

							</fieldset>

							<h6>Deuda</h6>
							<fieldset>
								<div class="row">
									
										<div class="col-md-10">
    								    	<legend class="text-semibold"><i class="icon-home5 position-left"></i> Datos Deuda</legend>
    									
    											
										<div class="col-md-4">
										    
								    <?php
							
								    
								        for ($i=0; $i < $par+1;$i++){
								    
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribeg3[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribeg3[$i]['campo']] ?>" readonly />
									
									    	</div>
												
												<?php } ?>
												
										</div>
										<div class="col-md-4">
												<?php
												
												for ($i=$par3+1; $i < $par2+1 ;$i++) {
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribeg3[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribeg3[$i]['campo']] ?>" readonly>
									
									    	</div>
												
												<?php } ?>	
													
									    </div>
									    
									    	<div class="col-md-4">
												<?php
									
										
												for ($i= $par4 ; $i < sizeof($objDescribeg3);$i++) {
												?>
												<div class="form-group" >
													
													<span><?php echo ($objDescribeg3[$i]['campo']); ?></span> 
										<input type="text" id="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" name="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" class="form-control" placeholder="<?php $objDescribe2[$objDescribeg3[$i]['campo']] ?>" value="<?php echo $objDescribe2[$objDescribeg3[$i]['campo']] ?>" readonly>
									
									    	</div>
												
												<?php } ?>	
									
								    
								    

								</div>
							</fieldset>
							
							<h6>Gestión</h6>
							<fieldset>
								<div class="row">
								    
								</div>
							</fieldset>

						</form>
		            </div>
		            <!-- /wizard with validation -->



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
   
 
    
})

</script>
</body>
</html>
