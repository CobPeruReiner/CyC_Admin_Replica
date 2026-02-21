$(function () {
  // Basic
  $(".select").select2();

  // Format icon
  function iconFormat(icon) {
    var originalOption = icon.element;
    if (!icon.id) {
      return icon.text;
    }
    var $icon =
      "<i class='icon-" + $(icon.element).data("icon") + "'></i>" + icon.text;

    return $icon;
  }

  // Initialize with options
  $(".select-icons").select2({
    templateResult: iconFormat,
    minimumResultsForSearch: Infinity,
    templateSelection: iconFormat,
    escapeMarkup: function (m) {
      return m;
    },
  });

  // Checkboxes, radios
  $(".styled").uniform({ radioClass: "choice" });

  // File input
  $(".file-styled").uniform({
    fileButtonClass: "action btn bg-pink-400",
  });

  // Bootstrap switch
  // ------------------------------
  $(".switch").bootstrapSwitch();

  var validator = $(
    ".form-user,.form-m-user,.form-a-horario,.form-m-horario,.form-a-sucursal,.form-m-sucursal,.form-a-cliente,.form-m-cliente,.form-a-cartera,.form-m-cartera,.form-a-menu,.form-m-menu,.form-a-accion,.form-m-accion,.form-a-categoria,.form-m-categoria,.form-a-efecto,.form-m-efecto,.form-a-motivo,.form-m-motivo,.form-a-contacto,.form-m-contacto,.form-a-campana,.form-m-campana,.form-a-pago,.form-m-pago,.form-a-cuota,.form-m-cuota,.form-a-telefono,.form-m-telefono,.form-a-direccion,.form-m-direccion,.form-a-infoadc,.form-m-infoadc,.form-a-table,.form-m-gui,.form-gestion"
  ).validate({
    ignore: "input[type=hidden], .select2-search__field, .ignorar", // ignore hidden fields
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
      password: {
        minlength: 5,
      },
      minimum_characters: {
        minlength: 10,
      },
      maximum_characters: {
        maxlength: 10,
      },
      minimum_number: {
        min: 1,
      },
      maximum_number: {
        max: 10,
      },
      number_range: {
        range: [1, 20],
      },
    },
    messages: {
      custom: {
        required: "This is a custom error message",
      },
      agree: "Please accept our policy",
    },
  });

  $(".form-project").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var dark = $(this).parent();
      var cliente = jQuery("#cliente").val();
      var normas = jQuery(".select2-selection__choice").text();
      var fecha_inicio = jQuery(".daterange-weeknumbers")
        .val()
        .replace("/", "-")
        .replace("/", "-")
        .substr(0, 10);
      var fecha_fin = jQuery(".daterange-weeknumbers")
        .val()
        .substr(13)
        .replace("/", "-")
        .replace("/", "-");
      var plazo = jQuery("#plazo").val();
      var consulting = jQuery("#consultor").text();
      var auditor = jQuery("#auditor").val();

      bootbox.confirm("¿Desea registrar proyecto?", function (result) {
        if (result) {
          loader(dark);
          registrar_project(
            consulting,
            cliente,
            fecha_inicio,
            fecha_fin,
            normas,
            plazo,
            auditor
          );
        }
      });
    }
  });

  $(".form-file").on("submit", function (e) {
    e.preventDefault();
    console.log(e);

    if (e.result === true) {
      var id_norma = jQuery("#alpaca-norma_text").val();
      var id_version = jQuery("#alpaca-version_text").val();
      var id_language = jQuery("#language").val();
      var fecha_caducidad = jQuery(".pickadate").val();
      var estado = $("input:checked").length;
      var peso = jQuery(".file-footer-caption samp").text();

      bootbox.confirm("¿Desea registrar?", function (result) {
        if (result) {
          registrar_file(
            id_norma,
            id_version,
            id_language,
            fecha_caducidad,
            estado,
            peso
          );
        }
      });
    }
  });

  $(".form-user").on("submit", function (e) {
    e.preventDefault();

    if (e.result === true) {
      var apellidos = jQuery("#apellidos").val();
      var nombre = jQuery("#nombre").val();
      var dni = jQuery("#dni").val();
      var sexo = jQuery("#sexo").val();
      var fechanac = jQuery("#fechanac").val();
      var ec = jQuery("#ec").val();
      var cargo = jQuery("#cargo").val();
      var direccion = jQuery("#direccion").val();

      var distrito = jQuery("#select2-distrito-container").text();
      var departamento = jQuery("#select2-departamento-container").text();

      var referencia = jQuery("#referencia").val();
      var fam = jQuery("#fam").val();
      var hijos = jQuery("#hijos").val();
      var telefono = jQuery("#telefono").val();
      var movil = jQuery("#movil").val();

      var fechaing = jQuery("#fechaing").val();

      var email = jQuery("#email").val();
      var suc = jQuery("#suc").val();
      var user = jQuery("#user").val();
      var gi = jQuery("#gi").val();
      var cartera = jQuery("#cartera").val();
      var password = jQuery("#password").val();
      var arr_items = $(".multiselect").val();

      bootbox.confirm("¿Desea registrar usuario?", function (result) {
        if (result) {
          registrar(
            apellidos,
            nombre,
            dni,
            sexo,
            fechanac,
            ec,
            cargo,
            direccion,
            departamento,
            distrito,
            referencia,
            fam,
            hijos,
            telefono,
            movil,
            email,
            suc,
            arr_items,
            user,
            password,
            gi,
            cartera,
            fechaing
          );
        }
      });
    }
  });

  $(".form-a-pago").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var fecha_pago = jQuery("#fechapago").val() + " " + jQuery("#hora").val();
      var tipo = jQuery("#tipo").val();
      var monto = jQuery("#monto").val();
      var homologo = jQuery("#homolo").val();

      bootbox.confirm("¿Desea registrar pago?", function (result) {
        if (result) {
          registrar_pago(
            nombre,
            cartera,
            identificador,
            fecha_pago,
            tipo,
            monto,
            homologo,
            1
          );
        }
      });
    }
  });

  $(".form-a-telefono").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var documento = jQuery("#documento").val();
      var fuente = jQuery("#fuente").val();
      var numero = jQuery("#numero").val();
      var tipo = jQuery("#tipo").val();
      var operador = jQuery("#operador").val();
      var personal = jQuery("#personal").val();

      bootbox.confirm("¿Desea registrar teléfono?", function (result) {
        if (result) {
          registrar_telefono(
            documento,
            fuente,
            numero,
            tipo,
            operador,
            personal,
            1
          );
        }
      });
    }
  });

  $(".form-a-infoadc").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var dato1 = jQuery("#dato1").val();
      var dato2 = jQuery("#dato2").val();
      var dato3 = jQuery("#dato3").val();
      var dato4 = jQuery("#dato4").val();
      var dato5 = jQuery("#dato5").val();
      var dato6 = jQuery("#dato6").val();
      var dato7 = jQuery("#dato7").val();
      var dato8 = jQuery("#dato8").val();
      var dato9 = jQuery("#dato9").val();
      var dato10 = jQuery("#dato10").val();

      bootbox.confirm("¿Desea registrar información adc?", function (result) {
        if (result) {
          registrar_infoadc(
            cartera,
            identificador,
            dato1,
            dato2,
            dato3,
            dato4,
            dato5,
            dato6,
            dato7,
            dato8,
            dato9,
            dato10,
            1
          );
        }
      });
    }
  });

  $(".form-a-direccion").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var documento = jQuery("#documento").val();
      var fuente = jQuery("#fuente").val();
      var direccion = jQuery("#direccion").val();
      var tipo = jQuery("#tipo").val();
      var referencia = jQuery("#referencia").val();

      var distrito = jQuery("#select2-distrito-container").text();
      var provincia = jQuery("#select2-provincia-container").text();
      var departamento = jQuery("#select2-departamento-container").text();

      var personal = jQuery("#personal").val();

      bootbox.confirm("¿Desea registrar dirección?", function (result) {
        if (result) {
          registrar_direccion(
            documento,
            fuente,
            direccion,
            departamento,
            provincia,
            distrito,
            referencia,
            tipo,
            personal,
            1
          );
        }
      });
    }
  });

  $(".form-a-cuota").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var fecha_cuota =
        jQuery("#fechacuota").val() + " " + jQuery("#hora").val();
      var tipo = jQuery("#tipo").val();
      var monto = jQuery("#monto").val();
      var homologo = jQuery("#homolo").val();

      bootbox.confirm("¿Desea registrar cuota?", function (result) {
        if (result) {
          registrar_cuota(
            nombre,
            cartera,
            identificador,
            fecha_cuota,
            tipo,
            monto,
            homologo,
            1
          );
        }
      });
    }
  });

  $(".form-a-campana").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var fecha_campana =
        jQuery("#fechacam").val() + " " + jQuery("#hora").val();
      var tipo = jQuery("#tipo").val();
      var monto = jQuery("#monto").val();
      var porcentaje = jQuery("#desc").val();
      var homologo = jQuery("#homolo").val();

      bootbox.confirm("¿Desea registrar campaña?", function (result) {
        if (result) {
          registrar_campana(
            nombre,
            cartera,
            identificador,
            fecha_campana,
            tipo,
            monto,
            porcentaje,
            homologo,
            1
          );
        }
      });
    }
  });

  $(".form-a-horario").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var tipo = jQuery("#tipo").val();
      var inicio = jQuery("#anytime-time").val();
      var fin = jQuery("#anytime-time2").val();
      var break1 = jQuery("#anytime-time3").val();
      var refri = jQuery("#anytime-time4").val();
      var break2 = jQuery("#anytime-time5").val();
      var refri2 = jQuery("#anytime-time6").val();

      bootbox.confirm("¿Desea registrar horario?", function (result) {
        if (result) {
          registrar_horario(
            nombre,
            tipo,
            inicio,
            fin,
            break1,
            refri,
            break2,
            refri2,
            1
          );
        }
      });
    }
  });

  $(".form-a-sucursal").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var distrito = jQuery("#select2-distrito-container").text();
      var departamento = jQuery("#select2-departamento-container").text();
      var direccion = jQuery("#direccion").val();
      var telefono = jQuery("#telefono").val();

      bootbox.confirm("¿Desea registrar surcursal?", function (result) {
        if (result) {
          registrar_sucursal(
            nombre,
            distrito,
            departamento,
            direccion,
            telefono,
            1
          );
        }
      });
    }
  });

  $(".form-a-efecto").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var accion = jQuery("#accion").val();
      var categoria = jQuery("#categoria").val();
      var homologo = jQuery("#homologo").val();
      var descripcion = jQuery("#descripcion").val();
      var peso = jQuery("#peso").val();
      var promesa = jQuery("#promesa").val();

      bootbox.confirm("¿Desea registrar efecto?", function (result) {
        if (result) {
          registrar_efecto(
            nombre,
            accion,
            categoria,
            homologo,
            descripcion,
            peso,
            1,
            promesa
          );
        }
      });
    }
  });

  $(".form-a-motivo").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var efecto = jQuery("#efecto").val();
      var homologo = jQuery("#homologo").val();
      var descripcion = jQuery("#descripcion").val();

      bootbox.confirm("¿Desea registrar motivo?", function (result) {
        if (result) {
          registrar_motivo(nombre, efecto, homologo, descripcion, 1);
        }
      });
    }
  });

  $(".form-a-contacto").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var efecto = jQuery("#efecto").val();
      var homologo = jQuery("#homologo").val();
      var descripcion = jQuery("#descripcion").val();

      bootbox.confirm("¿Desea registrar contacto?", function (result) {
        if (result) {
          registrar_contacto(nombre, efecto, homologo, descripcion, 1);
        }
      });
    }
  });

  $(".form-m-direccion").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var documento = jQuery("#documento").val();
      var fuente = jQuery("#fuente").val();
      var direccion = jQuery("#direccion").val();
      var tipo = jQuery("#tipo").val();
      var referencia = jQuery("#referencia").val();
      var distrito = jQuery("#select2-distrito-container").text();
      var provincia = jQuery("#select2-provincia-container").text();
      var departamento = jQuery("#select2-departamento-container").text();
      var personal = jQuery("#personal").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar dirección?", function (result) {
        if (result) {
          modificar_direccion(
            id,
            documento,
            fuente,
            direccion,
            departamento,
            provincia,
            distrito,
            referencia,
            tipo,
            personal,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-infoadc").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var dato1 = jQuery("#dato1").val();
      var dato2 = jQuery("#dato2").val();
      var dato3 = jQuery("#dato3").val();
      var dato4 = jQuery("#dato4").val();
      var dato5 = jQuery("#dato5").val();
      var dato6 = jQuery("#dato6").val();
      var dato7 = jQuery("#dato7").val();
      var dato8 = jQuery("#dato8").val();
      var dato9 = jQuery("#dato9").val();
      var dato10 = jQuery("#dato10").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar información adc?", function (result) {
        if (result) {
          modificar_infoadc(
            id,
            cartera,
            identificador,
            dato1,
            dato2,
            dato3,
            dato4,
            dato5,
            dato6,
            dato7,
            dato8,
            dato9,
            dato10,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-telefono").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var documento = jQuery("#documento").val();
      var fuente = jQuery("#fuente").val();
      var numero = jQuery("#numero").val();
      var tipo = jQuery("#tipo").val();
      var operador = jQuery("#operador").val();
      var personal = jQuery("#personal").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar teléfono?", function (result) {
        if (result) {
          modificar_telefono(
            id,
            documento,
            fuente,
            numero,
            tipo,
            operador,
            personal,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-cuota").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var fecha_cuota =
        jQuery("#fechacuota").val() + " " + jQuery("#hora").val();
      var tipo = jQuery("#tipo").val();
      var monto = jQuery("#monto").val();
      var homologo = jQuery("#homolo").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar cuota?", function (result) {
        if (result) {
          modificar_cuota(
            id,
            nombre,
            cartera,
            identificador,
            fecha_cuota,
            tipo,
            monto,
            homologo,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-pago").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var fecha_pago = jQuery("#fechapago").val() + " " + jQuery("#hora").val();
      var tipo = jQuery("#tipo").val();
      var monto = jQuery("#monto").val();
      var homologo = jQuery("#homolo").val();

      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar pago?", function (result) {
        if (result) {
          modificar_pago(
            id,
            nombre,
            cartera,
            identificador,
            fecha_pago,
            tipo,
            monto,
            homologo,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-campana").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var cartera = jQuery("#cartera").val();
      var identificador = jQuery("#identificador").val();
      var fecha_campana =
        jQuery("#fechacam").val() + " " + jQuery("#hora").val();
      var tipo = jQuery("#tipo").val();
      var monto = jQuery("#monto").val();
      var porcentaje = jQuery("#desc").val();
      var homologo = jQuery("#homolo").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar campaña?", function (result) {
        if (result) {
          modificar_campana(
            id,
            nombre,
            cartera,
            identificador,
            fecha_campana,
            tipo,
            monto,
            porcentaje,
            homologo,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-motivo").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var efecto = jQuery("#efecto").val();
      var homologo = jQuery("#homologo").val();
      var descripcion = jQuery("#descripcion").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar motivo?", function (result) {
        if (result) {
          modificar_motivo(
            id,
            nombre,
            efecto,
            homologo,
            descripcion,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-sucursal").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var distrito = jQuery("#select2-distrito-container").text();
      var departamento = jQuery("#select2-departamento-container").text();

      var direccion = jQuery("#direccion").val();
      var telefono = jQuery("#telefono").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar surcursal?", function (result) {
        if (result) {
          modificar_sucursal(
            id,
            nombre,
            distrito,
            departamento,
            direccion,
            telefono,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-cartera").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var tipo = jQuery("#tipo").val();
      var tramo = jQuery("#tramo").val();
      var central = jQuery("#central").val();
      var idcliente = jQuery("#idcliente").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar cartera?", function (result) {
        if (result) {
          modificar_cartera(
            id,
            nombre,
            tipo,
            tramo,
            central,
            idcliente,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-contacto").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var efecto = jQuery("#efecto").val();
      var homologo = jQuery("#homologo").val();
      var descripcion = jQuery("#descripcion").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar contacto?", function (result) {
        if (result) {
          modificar_contacto(
            id,
            nombre,
            efecto,
            homologo,
            descripcion,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-a-accion").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var tipo = jQuery("#tipo").val();
      var cartera = jQuery("#cartera").val();

      bootbox.confirm("¿Desea registrar acción?", function (result) {
        if (result) {
          registrar_accion(nombre, tipo, cartera, 1);
        }
      });
    }
  });

  $(".form-a-categoria").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var descripcion = jQuery("#descripcion").val();

      bootbox.confirm("¿Desea registrar categoría?", function (result) {
        if (result) {
          registrar_categoria(nombre, descripcion, 1);
        }
      });
    }
  });

  $(".form-m-accion").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var tipo = jQuery("#tipo").val();
      var cartera = jQuery("#cartera").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar acción?", function (result) {
        if (result) {
          modificar_accion(id, nombre, tipo, cartera, estado, 3);
        }
      });
    }
  });

  $(".form-m-categoria").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var descripcion = jQuery("#descripcion").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar acción?", function (result) {
        if (result) {
          modificar_categoria(id, nombre, descripcion, estado, 3);
        }
      });
    }
  });

  $(".form-a-cliente").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var identificador = jQuery("#identificador").val();
      var idpersonal = jQuery("#personal").val();

      bootbox.confirm("¿Desea registrar cliente?", function (result) {
        if (result) {
          registrar_cliente(nombre, identificador, idpersonal, 1);
        }
      });
    }
  });

  $(".form-m-cliente").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var identificador = jQuery("#identificador").val();
      var idpersonal = jQuery("#personal").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar cliente?", function (result) {
        if (result) {
          modificar_cliente(id, nombre, identificador, idpersonal, estado, 3);
        }
      });
    }
  });

  $(".form-a-cartera").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var tipo = jQuery("#tipo").val();
      var tramo = jQuery("#tramo").val();
      var central = jQuery("#central").val();
      var idcliente = jQuery("#idcliente").val();

      bootbox.confirm("¿Desea registrar cartera?", function (result) {
        if (result) {
          registrar_cartera(nombre, tipo, tramo, central, idcliente, 1);
        }
      });
    }
  });

  $(".form-a-menu").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var nombre = jQuery("#nombre").val();
      var icono = jQuery("#icono").val();

      bootbox.confirm("¿Desea registrar menu?", function (result) {
        if (result) {
          registrar_menu(nombre, icono, 1);
        }
      });
    }
  });

  $(".form-m-horario").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id_horario").val();
      var nombre = jQuery("#nombre").val();
      var dia = jQuery("#tipo").val();
      var horainicio = jQuery("#anytime-time").val();
      var horafin = jQuery("#anytime-time2").val();
      var break1 = jQuery("#anytime-time3").val();
      var refri = jQuery("#anytime-time4").val();
      var break2 = jQuery("#anytime-time5").val();
      var refri2 = jQuery("#anytime-time6").val();
      var estado = $("input:checked").length;

      bootbox.confirm("¿Desea modificar horario?", function (result) {
        if (result) {
          modificar_horario(
            id,
            nombre,
            dia,
            horainicio,
            horafin,
            break1,
            refri,
            break2,
            refri2,
            estado,
            3
          );
        }
      });
    }
  });

  $(".form-m-efecto").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#id").val();
      var nombre = jQuery("#nombre").val();
      var accion = jQuery("#accion").val();
      var categoria = jQuery("#categoria").val();
      var homologo = jQuery("#homologo").val();
      var descripcion = jQuery("#descripcion").val();
      var peso = jQuery("#peso").val();
      var estado = $("input:checked").length;
      var promesa = jQuery("#promesa").val();

      bootbox.confirm("¿Desea modificar efecto?", function (result) {
        if (result) {
          modificar_efecto(
            id,
            nombre,
            accion,
            categoria,
            homologo,
            descripcion,
            peso,
            estado,
            3,
            promesa
          );
        }
      });
    }
  });

  $(".form-m-menu").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      var id = jQuery("#idmenu").val();
      var nombre = jQuery("#nombre").val();
      var icono = jQuery("#icono").val();
      var estado = $("#estado").is(":checked");

      if (estado === true || estado == true) {
        estado = "1";
      } else {
        estado = "0";
      }

      var arr_check = new Array();
      $("#item_table")
        .find("input[type=checkbox]")
        .each(function (i, e) {
          if ($(this).is(":checked")) arr_check.push([i, $(this).val()]);
        });
      console.log(arr_check);

      var arr_items = new Array();
      for (var i = 1; i <= 100; i++) {
        var $control = $("#item_table").find("#nombre_sm_" + i);
        var $control2 = $("#item_table").find("#url_sm_" + i);
        //console.log($control.length);
        if ($control.length == 1) {
          arr_items.push([i, $control.val(), $control2.val()]);
        }
      }

      console.log(arr_items);

      bootbox.confirm("¿Desea modificar módulo?", function (result) {
        if (result) {
          modificar_menu(id, nombre, icono, estado, arr_check, arr_items, 3);
        }
      });
    }
  });

  $(".form-m-user").on("submit", function (e) {
    e.preventDefault();
    console.log(e);

    var fechabaja2 = jQuery("#fechabaja").val();
    console.log(fechabaja2);

    if (e.result === true) {
      var apellidos = jQuery("#apellidos").val();
      var nombre = jQuery("#nombre").val();
      var dni = jQuery("#dni").val();
      var sexo = jQuery("#sexo").val();
      var fechanac = jQuery("#fechanac").val();
      var ec = jQuery("#ec").val();
      var cargo = jQuery("#cargo").val();
      var direccion = jQuery("#direccion").val();

      var distrito = jQuery("#select2-distrito-container").text();
      var departamento = jQuery("#select2-departamento-container").text();

      var referencia = jQuery("#referencia").val();
      var fam = jQuery("#fam").val();
      var hijos = jQuery("#hijos").val();
      var telefono = jQuery("#telefono").val();
      var movil = jQuery("#movil").val();
      var email = jQuery("#email").val();
      var suc = jQuery("#suc").val();

      var user = jQuery("#user").val();
      var gi = jQuery("#gi").val();
      var password = jQuery("#password").val();
      var arr_items = $(".multiselect").val();

      var fechaing = jQuery("#fechaing").val();
      var fechabaja = jQuery("#fechabaja").val();

      var estado = $("#estado").is(":checked");
      var cartera = jQuery("#cartera").val();

      if (estado === true || estado == true) {
        estado = "1";
      } else {
        estado = "0";
      }

      var id = jQuery("#id_user").val();
      console.log(id);

      bootbox.confirm("¿Desea modificar usuario?", function (result) {
        if (result) {
          modificar(
            id,
            estado,
            apellidos,
            nombre,
            dni,
            sexo,
            fechanac,
            ec,
            cargo,
            direccion,
            departamento,
            distrito,
            referencia,
            fam,
            hijos,
            telefono,
            movil,
            email,
            suc,
            arr_items,
            user,
            password,
            gi,
            cartera,
            fechaing,
            fechabaja
          );
        }
      });
    }
  });

  $(".form-norma").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      if (jQuery("#nombre3").val() == "") {
        var nombre3 = "";
      } else {
        var nombre3 = ":" + jQuery("#nombre3").val();
      }
      var nombre =
        jQuery("#nombre1").val() + " " + jQuery("#nombre2").val() + nombre3;
      var descripcion = jQuery("#descripcion").val();
      var sector = jQuery("#sector").val();
      //console.log(nombre);
      bootbox.confirm("¿Desea registrar norma?", function (result) {
        if (result) {
          registrar_norma(nombre, descripcion, sector, 1, 0);
        }
      });
    }
  });

  $(".form-m-norma").on("submit", function (e) {
    e.preventDefault();
    console.log(e);
    if (e.result === true) {
      if (jQuery("#nombre3").val() == "") {
        var nombre3 = "";
      } else {
        var nombre3 = ":" + jQuery("#nombre3").val();
      }
      var nombre =
        jQuery("#nombre1").val() + " " + jQuery("#nombre2").val() + nombre3;
      var descripcion = jQuery("#descripcion").val();
      var sector = jQuery("#sector").val();
      var id = jQuery("#id_norma").val();
      //console.log(nombre);
      bootbox.confirm("¿Desea modificar norma?", function (result) {
        if (result) {
          registrar_norma(nombre, descripcion, sector, 2, id);
        }
      });
    }
  });
});

function registrar_contacto(nombre, efecto, homologo, descripcion, control) {
  $.ajax({
    data: {
      nombre: nombre,
      efecto: efecto,
      homologo: homologo,
      descripcion: descripcion,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_contacto.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_contacto.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_contacto.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_motivo(nombre, efecto, homologo, descripcion, control) {
  $.ajax({
    data: {
      nombre: nombre,
      efecto: efecto,
      homologo: homologo,
      descripcion: descripcion,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_motivo.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_motivo.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_motivo.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_efecto(
  nombre,
  accion,
  categoria,
  homologo,
  descripcion,
  peso,
  control,
  promesa
) {
  $.ajax({
    data: {
      nombre: nombre,
      accion: accion,
      categoria: categoria,
      homologo: homologo,
      descripcion: descripcion,
      peso: peso,
      control: control,
      promesa: promesa,
    },
    dataType: "json",
    url: "ajax/ajax_efecto.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_efecto.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_efecto.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_cuota(
  nombre,
  cartera,
  identificador,
  fecha_cuota,
  tipo,
  monto,
  homologo,
  control
) {
  $.ajax({
    data: {
      nombre: nombre,
      cartera: cartera,
      identificador: identificador,
      fecha_cuota: fecha_cuota,
      tipo: tipo,
      monto: monto,
      homologo: homologo,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_cuota.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_cuota.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_cuota.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_direccion(
  documento,
  fuente,
  direccion,
  departamento,
  provincia,
  distrito,
  referencia,
  tipo,
  personal,
  control
) {
  $.ajax({
    data: {
      documento: documento,
      fuente: fuente,
      direccion: direccion,
      departamento: departamento,
      provincia: provincia,
      distrito: distrito,
      referencia: referencia,
      tipo: tipo,
      personal: personal,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_direccion.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_direccion.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_direccion.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_infoadc(
  cartera,
  identificador,
  dato1,
  dato2,
  dato3,
  dato4,
  dato5,
  dato6,
  dato7,
  dato8,
  dato9,
  dato10,
  control
) {
  $.ajax({
    data: {
      cartera: cartera,
      identificador: identificador,
      dato1: dato1,
      dato2: dato2,
      dato3: dato3,
      dato4: dato4,
      dato5: dato5,
      dato6: dato6,
      dato7: dato7,
      dato8: dato8,
      dato9: dato9,
      dato10: dato10,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_infoadc.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_infoadc.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_infoadc.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_telefono(
  documento,
  fuente,
  numero,
  tipo,
  operador,
  personal,
  control
) {
  $.ajax({
    data: {
      documento: documento,
      fuente: fuente,
      numero: numero,
      tipo: tipo,
      operador: operador,
      personal: personal,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_telefono.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_telefono.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_telefono.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_pago(
  nombre,
  cartera,
  identificador,
  fecha_pago,
  tipo,
  monto,
  homologo,
  control
) {
  $.ajax({
    data: {
      nombre: nombre,
      cartera: cartera,
      identificador: identificador,
      fecha_pago: fecha_pago,
      tipo: tipo,
      monto: monto,
      homologo: homologo,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_pago.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_pago.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_pago.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_campana(
  nombre,
  cartera,
  identificador,
  fecha_campana,
  tipo,
  monto,
  porcentaje,
  homologo,
  control
) {
  $.ajax({
    data: {
      nombre: nombre,
      cartera: cartera,
      identificador: identificador,
      fecha_campana: fecha_campana,
      tipo: tipo,
      monto: monto,
      porcentaje: porcentaje,
      homologo: homologo,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_campana.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_campana.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_campana.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_categoria(nombre, descripcion, control) {
  $.ajax({
    data: { nombre: nombre, descripcion: descripcion, control: control },
    dataType: "json",
    url: "ajax/ajax_categoria.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_categoria.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_categoria.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_accion(nombre, tipo, cartera, control) {
  $.ajax({
    data: { nombre: nombre, tipo: tipo, cartera: cartera, control: control },
    dataType: "json",
    url: "ajax/ajax_accion.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_accion.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_accion.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_cartera(nombre, tipo, tramo, central, idcliente, control) {
  $.ajax({
    data: {
      nombre: nombre,
      tipo: tipo,
      tramo: tramo,
      central: central,
      idcliente: idcliente,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_cartera.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_cartera.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_cartera.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_menu(nombre, icono, control) {
  $.ajax({
    data: { nombre: nombre, icono: icono, control: control },
    dataType: "json",
    url: "ajax/ajax_menu.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_menu.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_menu.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_cliente(nombre, identificador, idpersonal, control) {
  $.ajax({
    data: {
      nombre: nombre,
      identificador: identificador,
      idpersonal: idpersonal,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_cliente.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_cliente.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_cliente.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_sucursal(
  nombre,
  distrito,
  departamento,
  direccion,
  telefono,
  control
) {
  $.ajax({
    data: {
      nombre: nombre,
      distrito: distrito,
      departamento: departamento,
      direccion: direccion,
      telefono: telefono,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_sucursal.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_sucursal.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_sucursal.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_horario(
  nombre,
  tipo,
  inicio,
  fin,
  break1,
  refri,
  break2,
  refri2,
  control
) {
  $.ajax({
    data: {
      nombre: nombre,
      tipo: tipo,
      inicio: inicio,
      fin: fin,
      break1: break1,
      refri: refri,
      break2: break2,
      refri2: refri2,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_horario.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_horario.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_horario.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_file(
  id_norma,
  id_version,
  id_language,
  fecha_caducidad,
  estado,
  peso
) {
  $.ajaxFileUpload({
    async: false,
    url: "ajax/ajax_registrar_file.php",
    type: "post",
    secureuri: false,
    fileElementId: "file-es",
    dataType: "json",
    data: {
      campo_archivo: "file-es",
      descripcion: "File",
      id_norma: id_norma,
      id_version: id_version,
      id_language: id_language,
      fecha_caducidad: fecha_caducidad,
      estado: estado,
      peso: peso,
    },
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "form_file.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: response.mensaje,
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "dashboard.php";
              },
            },
          },
        });
      }
    },
    error: function (dato) {
      console.log("ERROR");
      console.log(dato);
    },
  });
}

function registrar(
  apellidos,
  nombre,
  dni,
  sexo,
  fechanac,
  ec,
  cargo,
  direccion,
  departamento,
  distrito,
  referencia,
  fam,
  hijos,
  telefono,
  movil,
  email,
  suc,
  arr_items,
  user,
  password,
  gi,
  cartera,
  fechaing
) {
  $.ajax({
    data: {
      apellidos: apellidos,
      nombre: nombre,
      dni: dni,
      sexo: sexo,
      fechanac: fechanac,
      ec: ec,
      cargo: cargo,
      direccion: direccion,
      departamento: departamento,
      distrito: distrito,
      referencia: referencia,
      fam: fam,
      hijos: hijos,
      telefono: telefono,
      movil: movil,
      email: email,
      suc: suc,
      arr_items: arr_items,
      user: user,
      password: password,
      gi: gi,
      cartera: cartera,
      fechaing: fechaing,
    },
    dataType: "json",
    url: "ajax/ajax_registrar_user.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_basic.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_basic.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_menu(
  id,
  nombre,
  icono,
  estado,
  arr_check,
  arr_items,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      icono: icono,
      estado: estado,
      arr_check: arr_check,
      arr_items: arr_items,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_menu.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_menu.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_menu.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_categoria(id, nombre, descripcion, estado, control) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      descripcion: descripcion,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_categoria.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_categoria.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_categoria.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_contacto(
  id,
  nombre,
  efecto,
  homologo,
  descripcion,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      efecto: efecto,
      homologo: homologo,
      descripcion: descripcion,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_contacto.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_contacto.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_contacto.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_cliente(
  id,
  nombre,
  identificador,
  idpersonal,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      identificador: identificador,
      idpersonal: idpersonal,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_cliente.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_cliente.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_cliente.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_sucursal(
  id,
  nombre,
  distrito,
  departamento,
  direccion,
  telefono,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      distrito: distrito,
      departamento: departamento,
      direccion: direccion,
      telefono: telefono,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_sucursal.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_sucursal.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_sucursal.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_cartera(
  id,
  nombre,
  tipo,
  tramo,
  central,
  idcliente,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      tipo: tipo,
      tramo: tramo,
      central: central,
      idcliente: idcliente,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_cartera.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_cartera.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_cartera.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_direccion(
  id,
  documento,
  fuente,
  direccion,
  departamento,
  provincia,
  distrito,
  referencia,
  tipo,
  personal,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      documento: documento,
      fuente: fuente,
      direccion: direccion,
      departamento: departamento,
      provincia: provincia,
      distrito: distrito,
      referencia: referencia,
      tipo: tipo,
      personal: personal,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_direccion.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_direccion.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_direccion.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_infoadc(
  id,
  cartera,
  identificador,
  dato1,
  dato2,
  dato3,
  dato4,
  dato5,
  dato6,
  dato7,
  dato8,
  dato9,
  dato10,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      cartera: cartera,
      identificador: identificador,
      dato1: dato1,
      dato2: dato2,
      dato3: dato3,
      dato4: dato4,
      dato5: dato5,
      dato6: dato6,
      dato7: dato7,
      dato8: dato8,
      dato9: dato9,
      dato10: dato10,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_infoadc.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_infoadc.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_infoadc.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_telefono(
  id,
  documento,
  fuente,
  numero,
  tipo,
  operador,
  personal,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      documento: documento,
      fuente: fuente,
      numero: numero,
      tipo: tipo,
      operador: operador,
      personal: personal,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_telefono.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_telefono.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_telefono.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_cuota(
  id,
  nombre,
  cartera,
  identificador,
  fecha_cuota,
  tipo,
  monto,
  homologo,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      cartera: cartera,
      identificador: identificador,
      fecha_cuota: fecha_cuota,
      tipo: tipo,
      monto: monto,
      homologo: homologo,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_cuota.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_cuota.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_cuota.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_pago(
  id,
  nombre,
  cartera,
  identificador,
  fecha_pago,
  tipo,
  monto,
  homologo,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      cartera: cartera,
      identificador: identificador,
      fecha_pago: fecha_pago,
      tipo: tipo,
      monto: monto,
      homologo: homologo,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_pago.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_pago.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_pago.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_campana(
  id,
  nombre,
  cartera,
  identificador,
  fecha_campana,
  tipo,
  monto,
  porcentaje,
  homologo,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      cartera: cartera,
      identificador: identificador,
      fecha_campana: fecha_campana,
      tipo: tipo,
      monto: monto,
      porcentaje: porcentaje,
      homologo: homologo,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_campana.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_campana.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_campana.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_motivo(
  id,
  nombre,
  efecto,
  homologo,
  descripcion,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      efecto: efecto,
      homologo: homologo,
      descripcion: descripcion,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_motivo.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_motivo.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_motivo.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_efecto(
  id,
  nombre,
  accion,
  categoria,
  homologo,
  descripcion,
  peso,
  estado,
  control,
  promesa
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      accion: accion,
      categoria: categoria,
      homologo: homologo,
      descripcion: descripcion,
      peso: peso,
      estado: estado,
      control: control,
      promesa: promesa,
    },
    dataType: "json",
    url: "ajax/ajax_efecto.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_efecto.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_efecto.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_accion(id, nombre, tipo, cartera, estado, control) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      tipo: tipo,
      cartera: cartera,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_accion.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_accion.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_accion.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar_horario(
  id,
  nombre,
  dia,
  horainicio,
  horafin,
  break1,
  refri,
  break2,
  refri2,
  estado,
  control
) {
  $.ajax({
    data: {
      id: id,
      nombre: nombre,
      dia: dia,
      horainicio: horainicio,
      horafin: horafin,
      break1: break1,
      refri: refri,
      break2: break2,
      refri2: refri2,
      estado: estado,
      control: control,
    },
    dataType: "json",
    url: "ajax/ajax_horario.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_horario.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_horario.php";
              },
            },
          },
        });
      }
    },
  });
}

function modificar(
  id,
  estado,
  apellidos,
  nombre,
  dni,
  sexo,
  fechanac,
  ec,
  cargo,
  direccion,
  departamento,
  distrito,
  referencia,
  fam,
  hijos,
  telefono,
  movil,
  email,
  suc,
  arr_items,
  user,
  password,
  gi,
  cartera,
  fechaing,
  fechabaja
) {
  console.log({
    id: id,
    estado: estado,
    apellidos: apellidos,
    nombre: nombre,
    dni: dni,
    sexo: sexo,
    fechanac: fechanac,
    ec: ec,
    cargo: cargo,
    direccion: direccion,
    departamento: departamento,
    distrito: distrito,
    referencia: referencia,
    fam: fam,
    hijos: hijos,
    telefono: telefono,
    movil: movil,
    email: email,
    suc: suc,
    arr_items: arr_items,
    user: user,
    password: password,
    gi: gi,
    cartera: cartera,
    fechaing: fechaing,
    fechabaja: fechabaja,
  });
  $.ajax({
    data: {
      id: id,
      estado: estado,
      apellidos: apellidos,
      nombre: nombre,
      dni: dni,
      sexo: sexo,
      fechanac: fechanac,
      ec: ec,
      cargo: cargo,
      direccion: direccion,
      departamento: departamento,
      distrito: distrito,
      referencia: referencia,
      fam: fam,
      hijos: hijos,
      telefono: telefono,
      movil: movil,
      email: email,
      suc: suc,
      arr_items: arr_items,
      user: user,
      password: password,
      gi: gi,
      cartera: cartera,
      fechaing: fechaing,
      fechabaja: fechabaja,
    },
    dataType: "json",
    url: "ajax/ajax_modificar_user.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_basic.php";
      } else if (response.codigo > 1) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "Error",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "datatable_basic.php";
              },
            },
          },
        });
      }
    },
  });
}

function registrar_norma(nombre, descripcion, sector, valida, id) {
  $.ajax({
    data: {
      nombre: nombre,
      descripcion: descripcion,
      sector: sector,
      valida: valida,
      id: id,
    },
    dataType: "json",
    url: "ajax/ajax_registrar_norma.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_norma.php";
      } else if (response.codigo >= 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "error",
        });
      } else {
        bootbox.dialog({
          closeButton: false,
          message: "ERROR",
          buttons: {
            danger: {
              label: "Cerrar",
              className: "btn-danger",
              callback: function () {
                window.location = "dashboard.php";
              },
            },
          },
        });
      }
    },
  });
}

//Permite digitar solo numeros
function jsf_SoloNumero(event) {
  var codigo = jsf_RetornarCodigoKey(event);
  var caracter = "";
  if (!(typeof event.key == undefined || typeof event.key == "undefined"))
    caracter = event.key;
  if (
    ((codigo < 48 || codigo > 57) &&
      codigo != 8 &&
      codigo != 9 &&
      codigo != 37 &&
      codigo != 39 &&
      codigo != 46) ||
    caracter == "'"
  ) {
    // 8 back, 9 tab, 37 left, 39 right, 46 supr
    event.returnValue = false;
    return false;
  }
}

function jsf_RetornarCodigoKey(event) {
  var codigo;
  if (event.keyCode == undefined || event.keyCode == 0)
    codigo = parseInt(event.charCode);
  else codigo = parseInt(event.keyCode);
  return codigo;
}

function loader(dark) {
  $(dark).block({
    message: '<i class="icon-spinner spinner"></i>',
    overlayCSS: {
      backgroundColor: "#1B2024",
      opacity: 0.85,
      cursor: "wait",
    },
    css: {
      border: 0,
      padding: 0,
      backgroundColor: "none",
      color: "#fff",
    },
  });
}

function remover_loader(dark) {
  $(dark).unblock();
}
