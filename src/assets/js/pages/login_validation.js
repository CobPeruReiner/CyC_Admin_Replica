
$(function() {
	$("#valido").find("button").addClass("close").click(function (e) {
		e.preventDefault();
		console.log("x");
		$(this).parent().fadeOut("fast");
	});
	
	// Style checkboxes and radios
	$('.styled').uniform();
	
    // Setup validation
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
        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }
            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }
            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }
            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }
            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Correcto")
        },
        rules: {
            password: {
                minlength: 5
            },
            username: {
                minlength: 6
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
	
	
	$(".form-validate").on("submit",function(e){
		e.preventDefault();
		console.log(e);
		if(e.result===true){
			var username =	jQuery('#username').val();
			var password =	jQuery('#password').val();
			acceso(username,password);	
		}
	});
});

function acceso(username,password) {
	$.ajax({
		data: {username:username,password:password},
		dataType: 'json',
		url: 'ajax/ajax_acceso_user.php',
		success:  function (response) {
			console.log(response);
			if (response.codigo=="1"){
				$("#valido").addClass("alert alert-success").removeClass("alert-danger").fadeIn('fast').find("label").text('Usuario y/o Password Valido');
				setTimeout(function() {
				    if(response.valida_user=="BACKOFFICE" || response.valida_user=="SUPERVISOR"){
				        window.location='datatable_contacto.php';
                    }else{
                        window.location='dashboard.php';
                    }
				}, 2000);
			}else{
				$("#valido").addClass("alert alert-danger").removeClass("alert-success").fadeIn('fast').find("label").text('Usuario y/o Password Incorrecto');
			}
		}
	});
} 