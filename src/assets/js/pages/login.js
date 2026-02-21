/* ------------------------------------------------------------------------------
 *
 *  # Login page
 *
 *  Specific JS code additions for login and registration pages
 *
 *  Version: 1.0
 *  Latest update: Aug 1, 2015
 *
 * ---------------------------------------------------------------------------- */

$(function () {
  $(".select").select2();
  // Style checkboxes and radios
  $(".styled").uniform();

  // Setup validation
  // ------------------------------

  // Initialize
  var validator = $("#form-login").validate({
    ignore: "input[type=hidden], .select2-search__field", // ignore hidden fields
    errorClass: "validation-error-label",
    successClass: "validation-valid-label",
    highlight: function (element, errorClass) {
      $(element).removeClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
      $(element).removeClass(errorClass);
    },

    // Different components require proper error label placement
    errorPlacement: function (error, element) {
      // Styled checkboxes, radios, bootstrap switch
      if (
        element.parents("div").hasClass("checker") ||
        element.parents("div").hasClass("choice") ||
        element.parent().hasClass("bootstrap-switch-container")
      ) {
        if (
          element.parents("label").hasClass("checkbox-inline") ||
          element.parents("label").hasClass("radio-inline")
        ) {
          error.appendTo(element.parent().parent().parent().parent());
        } else {
          error.appendTo(element.parent().parent().parent().parent().parent());
        }
      }
      // Input with icons and Select2
      else if (
        element.parents("div").hasClass("has-feedback") ||
        element.hasClass("select2-hidden-accessible")
      ) {
        error.appendTo(element.parent());
      } else {
        error.insertAfter(element);
      }
    },
    validClass: "validation-valid-label",
    success: function (label) {
      label.addClass("validation-valid-label").text("Correcto");
    },
    rules: {
      dni: {
        minlength: 8,
      },
      repeat_password: {
        equalTo: "#dni",
      },
      minimum_characters: {
        minlength: 10,
      },
      maximum_characters: {
        maxlength: 10,
      },
      minimum_number: {
        min: 10,
      },
      maximum_number: {
        max: 10,
      },
      number_range: {
        range: [10, 20],
      },
    },
    messages: {
      custom: {
        required: "This is a custom error message",
      },
      agree: "Please accept our policy",
    },
    settings: {
      success: {
        caller: validate_form,
      },
    },
  });

  $("#form-login").on("submit", function (e) {
    e.preventDefault();
    console.log(validator);
    console.log(e);

    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var dni = jQuery("#dni").val();
      var usuario = jQuery("#usuario").val();
      var tipo = jQuery("#tipo").val();
      var centro = jQuery("#centro").val();

      bootbox.confirm("¿Desea registrar usuario?", function (result) {
        if (result) {
          registrar(nombre, dni, usuario, tipo, centro);
        }
      });
    }
  });
});

function registrar(nombre, dni, usuario, tipo, centro) {
  $.ajax({
    data: {
      nombre: nombre,
      dni: dni,
      usuario: usuario,
      tipo: tipo,
      centro: centro,
    },
    dataType: "json",
    url: "ajax/ajax_registrar_user.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "index.php";
      }
    },
  });
}

function validate_form() {
  console.log("settings");
}

function jsf_RetornarCodigoKey(event) {
  var codigo;
  if (event.keyCode == undefined || event.keyCode == 0)
    codigo = parseInt(event.charCode);
  else codigo = parseInt(event.keyCode);
  return codigo;
}

function jsf_SoloNumero(event) {
  var codigo = jsf_RetornarCodigoKey(event);
  if ((codigo < 48 || codigo > 57) && codigo != 8 && codigo != 9) {
    // 8 back, 9 tab
    event.returnValue = false;
    return false;
  }
}
