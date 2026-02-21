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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf8">
	
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
	<script type="text/javascript" src="assets/js/plugins/ui/prism.min.js"></script>
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/sidebar_detached_sticky_native.js"></script>
	<script type="text/javascript" src="assets/js/pages/funciones.js"></script>
	<!-- /theme JS files -->

</head>

<body data-spy="scroll" data-target=".sidebar-detached" class="has-detached-right">

<?php include 'cabecera.php'; ?>
			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold"><?php echo($arr_datos[0][1]); ?></span> - Changelog</h4>
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
							<li class="active">Changelog</li>
						</ul>

						<ul class="breadcrumb-elements">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Opciones
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="#"><i class="icon-accessibility"></i> Acceso</a></li>
									<li class="divider"></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->
				

				<!-- Content area -->
				<div class="content">

					<!-- Detached content -->
					<div class="container-detached">
						<div class="content-detached">
                            <?php
                            $var = clsUsuario::changelog();
                            for ($i=0; $i < sizeof($var);$i++) {
                            echo '	
                            	<div class="panel panel-flat" id="'.$var[$i][5].'">
                            								<div class="panel-heading">
                            									<h5 class="panel-title">Version '.$var[$i][0].'</h5>
                            									<div class="heading-elements">
                            										<span class="text-muted heading-text">'.$var[$i][3].'</span>
                            										<span class="label bg-blue heading-text">'.$var[$i][4].'</span>
                            					            	</div>
                            								</div>
                            
                            								<div class="panel-body">
                            								<p class="content-group"></p><pre class="language-php"><code>'.htmlentities($var[$i][2]).'</code></pre>
                            								</div>
                            							</div>' ;
                            }
                            ?>

							<!-- Initial release -->
							<div class="panel panel-flat" id="release">
								<div class="panel-heading">
									<h5 class="panel-title">Initial release</h5>
									<div class="heading-elements">
										<span class="text-muted heading-text">2020-08-01</span>
										<span class="label bg-blue heading-text">0.9</span>
					            	</div>
								</div>

								<div class="panel-body">
									System is in active development. All updates will be properly documented and explained, to make your upgrade process as easy as possible. In all new updates will be included: bug fixing, new functionality, plugins version control and code improvement. Feel free to contact we if you have any suggestions or requests!
								</div>

								<div class="table-responsive">
									<table class="table table-bordered table-striped table-xs">
										<thead>
											<tr>
												<th class="col-xs-3">Type</th>
												<th>Files</th>
												<th>Description</th>
											</tr>
										</thead>
										<tbody>
											<tr>
                                                <?php
                                                    $path = ".";
                                                    $total_ficheros = php_contador($path);
                                                    $total_css = css_contador($path);
                                                    $total_less = less_contador($path);
                                                    $total_img = img_contador($path);
                                                    $total_js = js_contador($path);
                                                    //echo "Hay $total_ficheros ficheros en el directorio $path<br>";
                                                ?>
                                            <th colspan="3" class="active">Core files</th>
											</tr>
											<tr>
												<td>PHP & HTML files</td>
												<td><?php echo $total_ficheros; ?></td>
												<td>Depending on layout, around <?php echo $total_ficheros; ?> main PHP/HTML files in each layout</td>
											</tr>
											<tr>
												<td>LESS & CSS files</td>
												<td><?php echo ($total_less+$total_css); ?></td>
												<td><?php echo $total_less; ?> main LESS files, <?php echo ($total_css-1); ?> CSS for icon fonts and 1 <code>animate.min.css</code> animation library</td>
											</tr>
								
											<tr>
												<th colspan="3" class="active">Other files</th>
											</tr>
											<tr>
												<td>JSON|JS|AJAX files</td>
												<td><?php echo $total_js; ?></td>
												<td>Different demo data sources. For demo purposes</td>
											</tr>
											<tr>
												<td>Image files</td>
												<td><?php echo $total_img; ?></td>
												<td>Logos, flag icons and notification icons</td>
											</tr>
											
										</tbody>
									</table>
								</div>
							</div>
							<!-- /initial release -->

						</div>
					</div>
					<!-- /detached content -->
<?php
 //------------------------------------------------------------- 
 function php_contador($path){
     $total_ficheros = 0;
     $dir = opendir($path);
     while ($elemento = readdir($dir)){
        // echo (substr($elemento,-4) .'</br>');
         if( $elemento != "." && $elemento != ".."){
                 if( is_dir($path."/".$elemento) ){
                        //echo("Procesando subdirectorio: ". $elemento . "<br>");
                        $total_ficheros += php_contador($path."/".$elemento);
                 }else{
                     if (substr($elemento,-4)=='.php' || substr($elemento,-5)=='.html'){
                         $total_ficheros++;
                     }
                 }
         }
     }
     return $total_ficheros;
 }

 function css_contador($path) {
     $total_estilo = 0;
     $dir = opendir($path);
     while ($elemento = readdir($dir)){
         if( $elemento != "." && $elemento != ".."){
                 if( is_dir($path."/".$elemento) ){
                        $total_estilo += css_contador($path."/".$elemento);
                 } else {
                     if (substr($elemento,-4)=='.css' || substr($elemento,-4)=='.eot'  || substr($elemento,-4)=='.svg' || substr($elemento,-4)=='.ttf'  || substr($elemento,-4)=='.woff'  || substr($elemento,-4)=='.woff2'){
                         $total_estilo++;
                     }
                 }
         }
     }
     return $total_estilo;
 }
 
function less_contador($path) {
     $total_estilo2 = 0;
     $dir = opendir($path);
     while ($elemento = readdir($dir)){
         if( $elemento != "." && $elemento != ".."){
                 if( is_dir($path."/".$elemento) ){
                        $total_estilo2 += less_contador($path."/".$elemento);
                 } else {
                     if (substr($elemento,-5)=='.less' ){
                         $total_estilo2++;
                     }
                 }
         }
     }
     return $total_estilo2;
 }

  function img_contador($path) {
     $total_img= 0;
     $dir = opendir($path);
     while ($elemento = readdir($dir)){
         if( $elemento != "." && $elemento != ".."){
                 if( is_dir($path."/".$elemento) ){
                        $total_img += img_contador($path."/".$elemento);
                 } else {
                     if (substr($elemento,-4)=='.jpg' || substr($elemento,-4)=='.png' || substr($elemento,-5)=='.jpeg' || substr($elemento,-4)=='.bmp' || substr($elemento,-4)=='.gif' || substr($elemento,-4)=='.swf'){
                         $total_img++;
                     }
                 }
         }
     }
     return $total_img;
 }
 
 function js_contador($path) {
     $total_js= 0;
     $dir = opendir($path);
     while ($elemento = readdir($dir)){
         if( $elemento != "." && $elemento != ".."){
                 if( is_dir($path."/".$elemento) ){
                        $total_js += img_contador($path."/".$elemento);
                 } else {
                     if (substr($elemento,-3)=='.js' || substr($elemento,-5)=='.json' ){
                         $total_js++;
                     }
                 }
         }
     }
     return $total_js;
 }
 
 
?>

					<!-- Detached sidebar -->
					<div class="sidebar-detached">
			        	<div class="sidebar sidebar-default">
							<div class="sidebar-content">

				        		<!-- Support -->
								<div class="sidebar-category no-margin">
									<div class="category-title">
										<span>Changelog</span>
										<i class="icon-menu7 pull-right"></i>
									</div>

									<div class="category-content">
										<a href="http://amvsolucionesti.com/" class="btn bg-danger-400 btn-block" target="_blank"><i class="icon-lifebuoy position-left"></i> Item support</a>
									</div>
								</div>
								<!-- /support -->

			        			
			        			<!-- Navigation -->
								<div class="sidebar-category">
									<div class="category-content no-padding">
										<ul class="nav navigation">
											<li class="navigation-divider no-margin-top"></li>
											<li class="navigation-header"><i class="icon-history pull-right"></i> Version history</li>
											
											<!--<li><a href="#1_2">Version 1.2 <span class="text-muted text-regular pull-right">08.07.2019</span></a></li>
											<li>
												<a href="#1_1_1">Version 1.1 <span class="text-muted text-regular pull-right">30.02.2019</span></a>
												<ul>
													<li><a href="#1_1_1">Version 1.1.1 <span class="text-muted text-regular pull-right">02.02.2019</span></a></li>
													<li><a href="#1_1_2">Version 1.1.2 <span class="text-muted text-regular pull-right">15.02.2019</span></a></li>
												</ul>
											</li>
											<li><a href="#1_0">Version 1.0 <span class="text-muted text-regular pull-right">21.01.2019</span></a></li>
										    -->
											<?php
                                            $var = clsUsuario::changelog();
                                              for ($i=0; $i < sizeof($var);$i++) {
                                                if(strlen($var[$i][4])>=5){
                                                      echo '<li><a href="#'.$var[$i][5].'">Version '.$var[$i][4].' <span class="text-muted text-regular pull-right"></span></a>';
                                                      echo '<ul>';
                                                      echo '<li><a href="#'.$var[$i][5].'">Version '.$var[$i][4].'<span class="text-muted text-regular pull-right">'.$var[$i][3].'</span></a></li>' ;
                                                      echo '</ul>';
                                                      echo '</li>';
                                                }else{
                                                     echo '<li><a href="#'.$var[$i][5].'">Version '.$var[$i][4].'<span class="text-muted text-regular pull-right">'.$var[$i][3].'</span></a></li>' ;
                                                }
                                              }
                                                  
                                              
                                            ?>

											<li><a href="#release">Initial release <span class="text-muted text-regular pull-right">2019-01-01</span></a></li>
											<li class="navigation-divider"></li>
											<li class="navigation-header"><i class="icon-gear pull-right"></i> Extras</li>
											<li><a href="http://infortec.com.pe/" target="_blank"><i class="icon-bubbles4 text-slate-400"></i>Contacto</a></li>
											<li><a href="http://amvsolucionesti.com/" target="_blank"><i class="icon-lifebuoy text-slate-400"></i> Soporte</a></li>
											<li><a href="http://amvsolucionesti.com/#portafolio" target="_blank"><i class="icon-rocket text-slate-400"></i> Portafolio</a></li>
			
							            </ul>
						            </div>
					            </div>
					            <!-- /navigation -->

				            </div>
			            </div>
		            </div>
		            <!-- /detached sidebar -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
