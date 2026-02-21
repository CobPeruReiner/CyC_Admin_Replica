	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="dashboard.php"><img src="assets/images/logo_light.png" alt="SIGESCOB Perú"></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>		
			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-people"></i>
							<span class="badge bg-warning-400" id="contador_online">0</span>
						</a>
						
						<div class="dropdown-menu dropdown-content">
							<div class="dropdown-content-heading">
								Usuarios online
								<ul class="icons-list">
									<li><a href="#"><i class="icon-gear"></i></a></li>
								</ul>
							</div>

							<ul class="media-list dropdown-content-body width-300" id="div_online">
								<li class="media" >
								
								</li>
							</ul>

							<div class="dropdown-content-footer">
								<a href="#" data-popup="tooltip" title="All users"><i class="icon-menu display-block"></i></a>
							
							</div>
						</div>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<p><span class="label bg-success">Online</span></p>
						</a>
						
					</li>

					<li class="dropdown dropdown-user">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="assets/images/placeholder.jpg" alt="<?php echo utf8_encode($_SESSION["nombre_ls"]) ?>">
							<span id="nombre_ls" name="nombre_ls" style="font-size: 11px !important;"><?php echo utf8_encode($_SESSION["nombre_ls"]) ?></span>
							<i class="caret"></i>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="form_m_user.php?id=<?php echo utf8_encode($_SESSION["id_ls"]) ?>"><i class="icon-user-plus"></i> Mi Perfil</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="icon-cog5"></i> Opciones</a></li>
							<li><a  id="cerrar_session" href="#" name="cerrar_session"><i class="icon-switch2"></i> Cerrar</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /main navbar -->


<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold"> <i class="icon-user text-size-small"></i> <?php echo $_SESSION["user_ls"] ?></span>
									<div class="text-size-mini text-muted">
									<?php echo $_SESSION["tipo_ls"] ?>
									</div>
								</div>

								<div class="media-right media-middle">
									<ul class="icons-list">
										<li>
											<a href="#"><i class="icon-cog3"></i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->
					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">
								<!-- Main -->
								<li class="navigation-header"><span>Menu</span> <i class="icon-menu" title="Main pages"></i></li>
								<?php
									require_once("php/clsMenu.php");
									$menu = clsMenu::listar_menu();
									
									//var_dump($menu);
									
									/*activamos segun url*/
									$url= $_SERVER["REQUEST_URI"];
									$porciones = explode("/", $url);
									$active = clsMenu::active_menu($porciones[1]);
									
									/*echo($url);
									echo($active);
									echo($porciones[1]);*/
									
									if (sizeof($active)=='0' AND $porciones[1]=="dashboard.php"){
										$inicio="active";
										$inicio2="";
									}else if (sizeof($active)=='0' AND $porciones[1]=="reportes.php"){
										$inicio2="active";
										$inicio="";
									}else{
										$inicio="";
										$inicio2="";
									}
									echo '<li class="'.$inicio.'"><a href="dashboard.php"><i class="icon-home4"></i> <span>Inicio</span></a></li>';
									
									for ($i=0; $i < sizeof($menu);$i++) {
									   // echo ucfirst(strtolower($menu[$i][1]));
									    //echo utf8_encode(ucfirst(strtolower($active[0][0])));
									    
										if (sizeof($active)=='1' AND ucfirst(strtolower($menu[$i][1]))== utf8_encode(ucfirst(strtolower($active[0][0])))){
											$hola="active";
										}else{
											$hola="";
										}
								?>
								
								<li class="<?php  echo $hola; ?>">
									<a href="#"><i class="<?php echo $menu[$i][2]; ?>"></i> <span><?php echo ucfirst(strtolower($menu[$i][1])); ?></span></a>
									<ul>
										<?php
											
											$submenu = clsMenu::listar_submenu($menu[$i][0]);
											
											//echo $menu[$i][0];
											//var_dump($submenu);
											
											for ($j=0; $j < sizeof($submenu);$j++) {
										
											echo '<li><a href="'.$submenu[$j][1].'">'. utf8_encode(ucfirst(strtolower($submenu[$j][0]))) .'</a></li>';
											
											}
										?>
										
									</ul>
								</li>
								<?php
									}
									echo '<li class="'.$inicio2.'">	<a href="#" class="has-ul"><i class="icon-chart"></i> <span>Reportes</span></a>
									<ul class="hidden-ul" style="display: block;">
										<li><a href="reportes.php">Gestión</a></li>
										<li><a href="report_pago.php">Pago</a></li>
										<li><a href="report_promesa.php">Promesa</a></li>
										<li><a href="report_login.php">Asesores</a></li>
									</ul>
								</li>';
								?>
	                            
	                            
	                            
							<!--	<li >
									<a href="reportes.php"><i class="icon-chart"></i> <span>Reportes</span>  <span class="label label-transparent">Beta</span></a>
									
								</li>-->

								<li><a href="changelog.php"><i class="icon-list-unordered"></i> <span>Changelog <span class="label bg-blue-400"><?php $pizza  = $arr_datos[0][1]; $porciones = explode(" ", $pizza); echo $porciones[1];?></span></span></a></li>
								<li><a href="#"><i class="icon-book"></i> <span>Manual</span></a></li>
								<li><a id="cerrar_session_m" href="#" name="cerrar_session_m"><i class="icon-switch2"></i> <span>Salir</span></a></li>
								<!-- /main -->
								
								<!-- /page kits -->

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->
			
