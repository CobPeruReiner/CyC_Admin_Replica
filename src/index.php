<?php
// echo 'PHP version: ' . phpversion();
//echo md5('106152722');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Cobranzas v1.1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="favicon.ico" />

	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="animate.css">
	<link rel="stylesheet" type="text/css" href="hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="select2.min.css">
	<link rel="stylesheet" type="text/css" href="util.css">
	<link rel="stylesheet" type="text/css" href="main.css">



	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>

	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>


	<style>
		.validation-error-label {
			color: #fff !important;
			font-size: 12px !important;
		}
	</style>
</head>

<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('img-01.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">

				<div class="login100-form-avatar">
					<img src="tenor.gif" alt="AVATAR">
				</div>
				<span class="login100-form-title p-t-20 p-b-45">
					Hola Somos Cobranzas
				</span>

				<form class="form-validate">
					<div id="valido" class="no-border" style="display: none;">
						<button type="button"><span>&times;</span></button>
						<label class="text-semibold"></label>
					</div>

					<div class="wrap-input100 validate-input m-b-10">
						<input class="input100" type="text" name="username" id="username" placeholder="Username" required="required" maxlength=15 />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input m-b-10">
						<input class="input100" type="password" name="password" id="password" placeholder="Password" required="required" maxlength=10 />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>
					<div class="container-login100-form-btn p-t-10">


						<button type="submit" class="login100-form-btn" id="btn_ingresar" name="btn_ingresar">Login </button>

					</div>
				</form>
				<div class="text-center w-full p-t-25 p-b-230">
					<a href="#" class="txt1">
						Forgot Username / Password?
					</a>
				</div>
				<div class="text-center w-full">
					<a class="txt1" href="#">
						Create new account
						<i class="fa fa-long-arrow-right"></i>
					</a>
				</div>

			</div>
		</div>
	</div>



	<script>
		$(function() {







			$(document).keydown(function(e) {
				if (e.which == 32) {
					return false;
				}
			});

			const inputs = document.querySelectorAll(".input");

			function addClass() {
				let parent = this.parentNode.parentNode;
				parent.classList.add("focus");
			}

			function removeClass() {
				let parent = this.parentNode.parentNode;
				if (this.value == "") {
					parent.classList.remove("focus");
				}
			}

			inputs.forEach((input) => {
				input.addEventListener("focus", addClass);
				input.addEventListener("blur", removeClass);
			});



			$("#valido").find("button").addClass("close").click(function(e) {
				e.preventDefault();
				$(this).parent().fadeOut("fast");
			});


			$(".form-validate").validate({
				ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
				errorClass: 'validation-error-label',
				successClass: 'validation-valid-label',
				highlight: function(element, errorClass) {
					$(element).removeClass(errorClass);
				},
				unhighlight: function(element, errorClass) {
					$(element).removeClass(errorClass);
				},
				errorPlacement: function(error, element) {
					if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container')) {
						if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
							error.appendTo(element.parent().parent().parent().parent());
						} else {
							error.appendTo(element.parent().parent().parent().parent().parent());
						}
					} else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
						error.appendTo(element.parent().parent().parent());
					} else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
						error.appendTo(element.parent());
					} else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
						error.appendTo(element.parent().parent());
					} else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
						error.appendTo(element.parent().parent());
					} else {
						error.insertAfter(element);
					}
				},
				validClass: "validation-valid-label",
				success: function(label) {
					label.addClass("validation-valid-label").text("Ok")
				},
				rules: {
					password: {
						minlength: 5
					},
					username: {
						minlength: 4
					}
				},
				messages: {
					username: "Ingrese Usuario",
					password: {
						required: "Ingrese Constraseña",
						minlength: jQuery.validator.format("Requiere {0} caracteres")
					}
				}
			});

			$(".form-validate").on("submit", function(e) {
				e.preventDefault();
				if (e.result === true) {
					var username = decodificarEntidadesHTMLNumericas(jQuery('#username').val());
					var password = decodificarEntidadesHTMLNumericas(jQuery('#password').val());
					acceso(username, password);
				}
			});



		});


		function decodificarEntidadesHTMLNumericas(texto) {
			return texto.replace(/&#(\d{1,8});/g, function(m, ascii) {
				return String.fromCharCode(ascii);
			});
		}

		function acceso(username, password) {
			$.ajax({
				data: {
					username: username,
					password: password
				},
				dataType: 'json',
				url: 'ajax/ajax_acceso_user.php',
				success: function(response) {
					console.log(response);
					if (response.codigo == 1) {
						$("#valido").addClass("alert alert-success").removeClass("alert-danger").fadeIn('fast').find("label").text('Usuario y/o Password Correcto');
						setTimeout(function() {
							window.location = 'dashboard.php';
						}, 250);
					} else {
						$("#valido").addClass("alert alert-danger").removeClass("alert-success").fadeIn('fast').find("label").text('Usuario y/o Password Incorrecto');
					}
				}
			});
		}
	</script>
</body>

</html>