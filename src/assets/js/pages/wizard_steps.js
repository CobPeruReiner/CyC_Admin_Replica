
$(function() {


    // Wizard examples
    // ------------------------------

    // Basic wizard setup
    $(".steps-basic").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="number">#index#</span> #title#',
        labels: {
            finish: 'Submit'
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
                console.log('demo');
                console.log(event);
                console.log(currentIndex);
                var lista = new Array();
                $('.table tr').each(function(i,item){
                    if($(item).attr('data-item') != undefined){
                        var norma = new Object();
                        norma.id = $(item).attr('data-item');
                        var td1 =$(item).find('td')[0];
                        norma.fecha = $(td1).find('input').val();
                        var td2 =$(item).find('td')[1];
                        
                        $(td2).find('div.radio').each(function(j,item2){
                            if($(item2).find('input[type=radio]').is(':checked')) {
                                norma.estado = $(item2).find('label').text().trim();
                                return false;
                            } else norma.estado = null;
                        });
                        
                        lista.push(norma)
                    }
                });

                //console.log(lista)
                var id_project=$('#id_project').val();
                for(var i = 0;i < lista.length;i++){
                    //console.log('modificar('+id_project+','+lista[i].id+','+lista[i].fecha.substr(13)+')')
                   //modificar(id_project,lista[i].id,lista[i].fecha.substr(0, 10),lista[i].fecha.substr(13),lista[i].estado)
                }
            
           
        },
    });


    // Async content loading
    $(".steps-async").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="number">#index#</span> #title#',
        labels: {
            finish: 'Submit'
        },
        onContentLoaded: function (event, currentIndex) {
            $(this).find('select.select').select2();

            $(this).find('select.select-simple').select2({
                minimumResultsForSearch: Infinity
            });

            $(this).find('.styled').uniform({
                radioClass: 'choice'
            });

            $(this).find('.file-styled').uniform({
                fileButtonClass: 'action btn bg-warning'
            });
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    // Saving wizard state
    $(".steps-state-saving").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        saveState: true,
        titleTemplate: '<span class="number">#index#</span> #title#',
        autoFocus: true,
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    // Specify custom starting step
    $(".steps-starting-step").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        startIndex: 2,
        titleTemplate: '<span class="number">#index#</span> #title#',
        autoFocus: true,
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    //
    // Wizard with validation
    //

    // Show form
    var form = $(".steps-validation").show();


    // Initialize wizard
    $(".steps-validation").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="number">#index#</span> #title#',
        autoFocus: true,
        onStepChanging: function (event, currentIndex, newIndex) {

            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex) {
                return true;
            }
            
            //console.log(newIndex);
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && $(".multiselect").val()===null) {
                bootbox.alert("Seleccione Otras Áreas Comunes");
                return false;
            }

            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex) {

                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }

            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },

    
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },

        onFinished: function (event, currentIndex) {
            //alert("Submitted!");
			var id=$('#id_contacto').val();
            var nombre=$('#nombre').val();
            var movil=$('#telefono').val();
            var direccion=$('#direccion').val();
            var correo=$('#email').val();
            var edificio=$('#edificio').val();
            var distrito=$('#distrito').val();
            var razon_cambio=$('#razon_cambio').val();
            var tipo_inmueble=$('#tipo_inmueble').val();
            var mpromedio=$('#mpromedio').val();
            var es_peatonal=$('#es_peatonal').val();
            var es_vehicular=$('#es_vehicular').val();
            var local_comercial=$('#local_comercial').val();
            var depa_ofi=$('#depa_ofi').val();
            var torres=$('#torres').val();
            var pisos=$('#pisos').val();
            var sotano=$('#sotano').val();
            var antiguedad=$('#antiguedad').val();
            var recibo_agua=$('#recibo_agua').val();
            var recibo_luz=$('#recibo_luz').val();
            var conserjes=$('#conserjes').val();
            var ronderos=$('#ronderos').val();
            var operarios=$('#operarios').val();
            var tipo_admin=$('#tipo_admin').val();
            var ascensor=$('#ascensor').val();
            var ascensor_dis=$('#ascensor_dis').val();
            var camaras=$('#camaras').val();
            var piscinas=$('#piscinas').val();
            var areas_verde=$('#areas_verde').val();
            var maq_gym=$('#maq_gym').val();
            var constructura=$('#constructura').val();
            var junta=$('#junta').val();
            var pago_mant=$('#pago_mant').val();
            var administrador_actual=$('#administrador_actual').val();
            var junta_dir=$('#junta_dir').val();
            var presupuesto_mensual=$('#presupuesto_mensual').val();
            var observacion=$('#observacion').val();
            var entero=$('#entero').val();
            var sectorista=$('#sectorista').val();
            var contrato_ser=$('#contrato_ser').val();
            var nombre=$('#nombre').val();
            var edificio=$('#edificio').val();
            var correo=$('#email').val();
            var movil=$('#telefono').val();
            var distrito=$('#distrito').val();
            var arr_items = $(".multiselect").val();
			var valida=2;
			 
			modificar_contacto(valida,observacion,id,direccion,razon_cambio,tipo_inmueble,mpromedio,es_peatonal,es_vehicular,local_comercial,depa_ofi,torres,pisos,sotano,antiguedad,recibo_agua,recibo_luz,conserjes,ronderos,operarios,tipo_admin,ascensor,ascensor_dis,camaras,piscinas,areas_verde,maq_gym,constructura,junta,pago_mant,administrador_actual,junta_dir,presupuesto_mensual,entero,sectorista,contrato_ser,nombre,edificio,correo,movil,distrito,arr_items)
        }
    });


    // Initialize validation
    $(".steps-validation").validate({
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
        rules: {
            email: {
                email: true
            }
        }
    });



    // Initialize plugins
    // ----------

    // Simple select without search
    $('.select-simple').select2({
        minimumResultsForSearch: Infinity
    });


    // Styled checkboxes and radios
    $('.styled').uniform({
        radioClass: 'choice'
    });


    // Styled file input
    $('.file-styled').uniform({
        fileButtonClass: 'action btn bg-blue'
    });
    
});


function modificar_contacto(valida,observacion,id,direccion,razon_cambio,tipo_inmueble,mpromedio,es_peatonal,es_vehicular,local_comercial,depa_ofi,torres,pisos,sotano,antiguedad,recibo_agua,recibo_luz,conserjes,ronderos,operarios,tipo_admin,ascensor,ascensor_dis,camaras,piscinas,areas_verde,maq_gym,constructura,junta,pago_mant,administrador_actual,junta_dir,presupuesto_mensual,entero,sectorista,contrato_ser,nombre,edificio,correo,movil,distrito,arr_items) {
    $.ajax({
        data: {valida:valida,observacion:observacion,id:id,direccion:direccion,razon_cambio:razon_cambio,tipo_inmueble:tipo_inmueble,mpromedio:mpromedio,es_peatonal:es_peatonal,es_vehicular:es_vehicular,local_comercial:local_comercial,depa_ofi:depa_ofi,torres:torres,pisos:pisos,sotano:sotano,antiguedad:antiguedad,recibo_agua:recibo_agua,recibo_luz:recibo_luz,conserjes:conserjes,ronderos:ronderos,operarios:operarios,tipo_admin:tipo_admin,ascensor:ascensor,ascensor_dis:ascensor_dis,camaras:camaras,piscinas:piscinas,areas_verde:areas_verde,maq_gym:maq_gym,constructura:constructura,junta:junta,pago_mant:pago_mant,administrador_actual:administrador_actual,junta_dir:junta_dir,presupuesto_mensual:presupuesto_mensual,entero:entero,sectorista:sectorista,contrato_ser:contrato_ser,nombre:nombre,edificio:edificio,correo:correo,movil:movil,distrito:distrito,arr_items:arr_items},
        dataType: 'json',
        url: 'ajax/ajax_contacto.php',
        success:  function (response) {           
        console.log(response);
            if(response.codigo==1){
                window.location='datatable_contacto.php';  
               //console.log("exito");
            }else if(response.codigo>1){
                swal({   title: "Mensaje del Sistema", text: response.mensaje, type: "error" });
            }else{
                bootbox.dialog({
                closeButton: false,
                message: 'ERROR',
                    buttons: {
                                danger: {
                                    label: "Cerrar",
                                    className: "btn-danger",
                                    callback: function () {
                                        window.location='dashboard.php';
                                        }
                                    }
                            }
                });
            }
        }
    });
}