$(function () {
  /*probando*/
  $.extend($.fn.dataTable.defaults, {
    autoWidth: false,
    columnDefs: [
      {
        orderable: false,
        width: "100px",
        targets: [5],
      },
    ],
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    language: {
      search: "<span>Buscar:</span> _INPUT_",
      lengthMenu: "<span>Show:</span> _MENU_",
      paginate: {
        first: "First",
        last: "Last",
        next: "&rarr;",
        previous: "&larr;",
      },
    },
    drawCallback: function () {
      $(this)
        .find("tbody tr")
        .slice(-3)
        .find(".dropdown, .btn-group")
        .addClass("dropup");
    },
    preDrawCallback: function () {
      $(this)
        .find("tbody tr")
        .slice(-3)
        .find(".dropdown, .btn-group")
        .removeClass("dropup");
    },
  });

  // Basic datatable
  $(".datatable-basic").DataTable();

  // Alternative pagination
  $(".datatable-pagination").DataTable({
    pagingType: "simple",
    language: {
      paginate: { next: "Next &rarr;", previous: "&larr; Prev" },
    },
  });

  $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

  // Enable Select2 select for the length option
  $(".dataTables_length select").select2({
    minimumResultsForSearch: Infinity,
    width: "auto",
  });

  var LocationActual = window.location.pathname.split("/");
  console.log(LocationActual);

  if (LocationActual[1] == "datatable_basic.php") {
    listar_usuarios();
  }

  if (LocationActual[1] == "datatable_horario.php") {
    listar_horarios(2);
  }

  if (LocationActual[1] == "datatable_sucursal.php") {
    listar_surcusal(2);
  }

  if (LocationActual[1] == "datatable_menu.php") {
    listar_menu(2);
  }

  if (LocationActual[1] == "datatable_cliente.php") {
    listar_cliente(2);
  }

  if (LocationActual[1] == "datatable_cartera.php") {
    listar_cartera(2);
  }

  if (LocationActual[1] == "datatable_accion.php") {
    listar_accion(2);
  }

  if (LocationActual[1] == "datatable_categoria.php") {
    listar_categoria(2);
  }

  if (LocationActual[1] == "datatable_efecto.php") {
    listar_efecto(2);
  }

  if (LocationActual[1] == "datatable_motivo.php") {
    listar_motivo(2);
  }

  if (LocationActual[1] == "datatable_contacto.php") {
    listar_contacto(2);
  }

  if (LocationActual[1] == "datatable_campana.php") {
    listar_campana(2);
  }

  if (LocationActual[1] == "datatable_pago.php") {
    listar_pago(2);
  }

  if (LocationActual[1] == "datatable_cuota.php") {
    listar_cuota(2);
  }

  if (LocationActual[1] == "datatable_telefono.php") {
    listar_telefono(2);
  }

  if (LocationActual[1] == "datatable_direccion.php") {
    listar_direccion(2);
  }

  if (LocationActual[1] == "datatable_infoadc.php") {
    listar_infoadc(2);
  }

  if (LocationActual[1] == "datatable_mapa.php") {
    listar_mapa(2);
  }
});

function listar_mapa(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_mapa.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-mapa tbody").html("");
    } else {
      var table = $(".datatable-mapa").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_mapa();

      $("input[type=search]").keyup(function (e) {
        btn_mapa();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_mapa();
      });

      $(".dataTables_length select").change(function (e) {
        btn_mapa();
      });
    }
  });
}

function listar_infoadc(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_infoadc.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-infoadc tbody").html("");
    } else {
      var table = $(".datatable-infoadc").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 5,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_infoadc();

      $("input[type=search]").keyup(function (e) {
        btn_infoadc();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_infoadc();
      });

      $(".dataTables_length select").change(function (e) {
        btn_infoadc();
      });

      $(".datatable-infoadc")
        .on("order.dt", function () {
          btn_infoadc();
        })
        .on("search.dt", function () {
          btn_infoadc();
        })
        .on("page.dt", function () {
          btn_infoadc();
        })
        .DataTable();
    }
  });
}

function listar_direccion(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_direccion.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-direccion tbody").html("");
    } else {
      var table = $(".datatable-direccion").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 8,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_direccion();

      $("input[type=search]").keyup(function (e) {
        btn_direccion();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_direccion();
      });

      $(".dataTables_length select").change(function (e) {
        btn_direccion();
      });

      $(".datatable-direccion")
        .on("order.dt", function () {
          btn_direccion();
        })
        .on("search.dt", function () {
          btn_direccion();
        })
        .on("page.dt", function () {
          btn_direccion();
        })
        .DataTable();
    }
  });
}

function listar_telefono(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_telefono.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-telefono tbody").html("");
    } else {
      var table = $(".datatable-telefono").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_telefono();

      $("input[type=search]").keyup(function (e) {
        btn_telefono();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_telefono();
      });

      $(".dataTables_length select").change(function (e) {
        btn_telefono();
      });

      $(".datatable-telefono")
        .on("order.dt", function () {
          btn_telefono();
        })
        .on("search.dt", function () {
          btn_telefono();
        })
        .on("page.dt", function () {
          btn_telefono();
        })
        .DataTable();
    }
  });
}

function listar_cuota(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_cuota.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-cuota tbody").html("");
    } else {
      var table = $(".datatable-cuota").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_cuota();

      $("input[type=search]").keyup(function (e) {
        btn_cuota();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_cuota();
      });

      $(".dataTables_length select").change(function (e) {
        btn_cuota();
      });

      $(".datatable-cuota")
        .on("order.dt", function () {
          btn_cuota();
        })
        .on("search.dt", function () {
          btn_cuota();
        })
        .on("page.dt", function () {
          btn_cuota();
        })
        .DataTable();
    }
  });
}

function listar_pago(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_pago.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-pago tbody").html("");
    } else {
      var table = $(".datatable-pago").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_pago();

      $("input[type=search]").keyup(function (e) {
        btn_pago();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_pago();
      });

      $(".dataTables_length select").change(function (e) {
        btn_pago();
      });

      $(".datatable-campana")
        .on("order.dt", function () {
          btn_pago();
        })
        .on("search.dt", function () {
          btn_pago();
        })
        .on("page.dt", function () {
          btn_pago();
        })
        .DataTable();
    }
  });
}

function listar_campana(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_campana.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-campana tbody").html("");
    } else {
      var table = $(".datatable-campana").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_campana();

      $("input[type=search]").keyup(function (e) {
        btn_campana();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_campana();
      });

      $(".dataTables_length select").change(function (e) {
        btn_campana();
      });

      $(".datatable-campana")
        .on("order.dt", function () {
          btn_campana();
        })
        .on("search.dt", function () {
          btn_campana();
        })
        .on("page.dt", function () {
          btn_campana();
        })
        .DataTable();
    }
  });
}

function listar_contacto(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_contacto.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-contacto tbody").html("");
    } else {
      var table = $(".datatable-contacto").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_contacto();

      $("input[type=search]").keyup(function (e) {
        btn_contacto();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_contacto();
      });

      $(".dataTables_length select").change(function (e) {
        btn_contacto();
      });

      $(".datatable-contacto")
        .on("order.dt", function () {
          btn_contacto();
        })
        .on("search.dt", function () {
          btn_contacto();
        })
        .on("page.dt", function () {
          btn_contacto();
        })
        .DataTable();
    }
  });
}

function listar_motivo(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_motivo.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-motivo tbody").html("");
    } else {
      var table = $(".datatable-motivo").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_motivo();

      $("input[type=search]").keyup(function (e) {
        btn_motivo();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_motivo();
      });

      $(".dataTables_length select").change(function (e) {
        btn_motivo();
      });

      $(".datatable-motivo")
        .on("order.dt", function () {
          btn_motivo();
        })
        .on("search.dt", function () {
          btn_motivo();
        })
        .on("page.dt", function () {
          btn_motivo();
        })
        .DataTable();
    }
  });
}

function listar_efecto(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_efecto.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-efecto tbody").html("");
    } else {
      var table = $(".datatable-efecto").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_efecto();

      $("input[type=search]").keyup(function (e) {
        btn_efecto();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_efecto();
      });

      $(".dataTables_length select").change(function (e) {
        btn_efecto();
      });

      $(".datatable-efecto")
        .on("order.dt", function () {
          btn_efecto();
        })
        .on("search.dt", function () {
          btn_efecto();
        })
        .on("page.dt", function () {
          btn_efecto();
        })
        .DataTable();
    }
  });
}

function listar_categoria(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_categoria.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-categoria tbody").html("");
    } else {
      var table = $(".datatable-categoria").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 4,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_categoria();

      $("input[type=search]").keyup(function (e) {
        btn_categoria();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_categoria();
      });

      $(".dataTables_length select").change(function (e) {
        btn_categoria();
      });

      $(".datatable-categoria")
        .on("order.dt", function () {
          btn_categoria();
        })
        .on("search.dt", function () {
          btn_categoria();
        })
        .on("page.dt", function () {
          btn_categoria();
        })
        .DataTable();
    }
  });
}

function listar_surcusal(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_sucursal.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-sucursal tbody").html("");
    } else {
      var table = $(".datatable-sucursal").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_sucursal();

      $("input[type=search]").keyup(function (e) {
        btn_sucursal();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_sucursal();
      });

      $(".dataTables_length select").change(function (e) {
        btn_sucursal();
      });

      $(".datatable-sucursal")
        .on("order.dt", function () {
          btn_sucursal();
        })
        .on("search.dt", function () {
          btn_sucursal();
        })
        .on("page.dt", function () {
          btn_sucursal();
        })
        .DataTable();
    }
  });
}

function listar_cartera(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_cartera.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-cartera tbody").html("");
    } else {
      var table = $(".datatable-cartera").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 7,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_cartera();

      $("input[type=search]").keyup(function (e) {
        btn_cartera();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_cartera();
      });

      $(".dataTables_length select").change(function (e) {
        btn_cartera();
      });

      $(".datatable-cartera")
        .on("order.dt", function () {
          btn_cartera();
        })
        .on("search.dt", function () {
          btn_cartera();
        })
        .on("page.dt", function () {
          btn_cartera();
        })
        .DataTable();
    }
  });
}

function listar_cliente(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_cliente.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-cliente tbody").html("");
    } else {
      var table = $(".datatable-cliente").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 5,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_cliente();

      $("input[type=search]").keyup(function (e) {
        btn_cliente();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_cliente();
      });

      $(".dataTables_length select").change(function (e) {
        btn_cliente();
      });

      $(".datatable-cliente")
        .on("order.dt", function () {
          btn_cliente();
        })
        .on("search.dt", function () {
          btn_cliente();
        })
        .on("page.dt", function () {
          btn_cliente();
        })
        .DataTable();
    }
  });
}

function listar_menu(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_menu.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-menu tbody").html("");
    } else {
      var table = $(".datatable-menu").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 5,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="new_submenu" type="button"><i class="icon-add" style="font-size: 12px;"></i> </button><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_menu();

      $("input[type=search]").keyup(function (e) {
        btn_menu();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_menu();
      });

      $(".dataTables_length select").change(function (e) {
        btn_menu();
      });

      $(".datatable-menu")
        .on("order.dt", function () {
          btn_menu();
        })
        .on("search.dt", function () {
          btn_menu();
        })
        .on("page.dt", function () {
          btn_menu();
        })
        .DataTable();
    }
  });
}

function listar_horarios(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_horario.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-horario tbody").html("");
    } else {
      var table = $(".datatable-horario").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_horario();

      $("input[type=search]").keyup(function (e) {
        btn_horario();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_horario();
      });

      $(".dataTables_length select").change(function (e) {
        btn_horario();
      });

      $(".datatable-horario")
        .on("order.dt", function () {
          btn_horario();
        })
        .on("search.dt", function () {
          btn_horario();
        })
        .on("page.dt", function () {
          btn_horario();
        })
        .DataTable();
    }
  });
}

function listar_accion(control) {
  $.ajax({
    data: { control: control },
    url: "ajax/ajax_accion.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-accion tbody").html("");
    } else {
      var table = $(".datatable-accion").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 6,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn_accion();

      $("input[type=search]").keyup(function (e) {
        btn_accion();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn_accion();
      });

      $(".dataTables_length select").change(function (e) {
        btn_accion();
      });

      $(".datatable-accion")
        .on("order.dt", function () {
          btn_accion();
        })
        .on("search.dt", function () {
          btn_accion();
        })
        .on("page.dt", function () {
          btn_accion();
        })
        .DataTable();
    }
  });
}

function listar_usuarios() {
  $.ajax({
    data: {},
    url: "ajax/ajax_listar_user.php",
    dataType: "json",
  }).done(function (data) {
    if (data.codigo == 0) {
      swal({
        title: "Mensaje del Sistema",
        text: data.mensaje,
        type: "warning",
      });
      $(".datatable-basic tbody").html("");
    } else {
      //console.log(data.arr_datos);

      var table = $(".datatable-basic").dataTable({
        data: data.arr_datos,
        responsive: true,
        destroy: true,
        order: [[0, "desc"]],
        bProcessing: true,
        createdRow: function (row, data, index) {
          var texto = $("td", row).find("label").text();
          if (texto == "SUSPENDED") {
            $("td", row).find("label").addClass("label bg-danger-400");
            $("td", row)
              .find(".btn_delete")
              .removeClass("btn_delete")
              .addClass("not-active");
          } else {
            $("td", row).find("label").addClass("label bg-success-400");
          }
        },
        columnDefs: [
          {
            targets: 8,
            data: null,
            render: function (data, type, row, meta) {
              return (
                '<input class="txt_id" type="hidden" value="' +
                data[0].split("-")[1] +
                '"/><button class="btn_update" type="button"><i class="icon-reload-alt" style="font-size: 12px;"></i> </button><button class="btn_delete" type="button"><i class="icon-trash-alt" style="font-size: 12px;"></i> </button>'
              );
            },
          },
        ],
      });

      $(".dataTables_filter input[type=search]").attr("placeholder", "Escribe");

      // Enable Select2 select for the length option
      $(".dataTables_length select").select2({
        minimumResultsForSearch: Infinity,
        width: "auto",
      });

      btn();

      $("input[type=search]").keyup(function (e) {
        btn();
      });

      $(document).on("click", ".paginate_button", function (e) {
        btn();
      });

      $(".dataTables_length select").change(function (e) {
        btn();
      });

      $(".datatable-basic")
        .on("order.dt", function () {
          btn();
        })
        .on("search.dt", function () {
          btn();
        })
        .on("page.dt", function () {
          btn();
        })
        .DataTable();
    }
  });
}

function btn_efecto() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja efecto?", function (result) {
      if (result) {
        baja_efecto(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar efecto?", function (result) {
      if (result) {
        window.location = "form_m_efecto.php?id=" + id;
      }
    });
  });
}

function btn_contacto() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja contacto?", function (result) {
      if (result) {
        baja_contacto(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar contacto?", function (result) {
      if (result) {
        window.location = "form_m_contacto.php?id=" + id;
      }
    });
  });
}

function btn_accion() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja acción?", function (result) {
      if (result) {
        baja_accion(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar acción?", function (result) {
      if (result) {
        window.location = "form_m_accion.php?id=" + id;
      }
    });
  });
}

function btn_motivo() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja motivo?", function (result) {
      if (result) {
        baja_motivo(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar motivo?", function (result) {
      if (result) {
        window.location = "form_m_motivo.php?id=" + id;
      }
    });
  });
}

function btn_horario() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja horario?", function (result) {
      if (result) {
        // baja_horario(id);
        window.baja_horario(id);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar horario?", function (result) {
      if (result) {
        window.location = "form_m_horario.php?id=" + id;
      }
    });
  });
}

function btn_sucursal() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja sucursal?", function (result) {
      if (result) {
        baja_sucursal(id);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar sucursal?", function (result) {
      if (result) {
        window.location = "form_m_sucursal.php?id=" + id;
      }
    });
  });
}

function btn_cartera() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja cartera?", function (result) {
      if (result) {
        baja_cartera(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar cartera?", function (result) {
      if (result) {
        window.location = "form_m_cartera.php?id=" + id;
      }
    });
  });
}

function btn_cliente() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja cliente?", function (result) {
      if (result) {
        baja_cliente(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar cliente?", function (result) {
      if (result) {
        window.location = "form_m_cliente.php?id=" + id;
      }
    });
  });
}

function btn_pago() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja pago?", function (result) {
      if (result) {
        baja_pago(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar pago?", function (result) {
      if (result) {
        window.location = "form_m_pago.php?id=" + id;
      }
    });
  });
}

function btn_campana() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja campaña?", function (result) {
      if (result) {
        baja_campana(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar campaña?", function (result) {
      if (result) {
        window.location = "form_m_campana.php?id=" + id;
      }
    });
  });
}

function btn_cuota() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja cuota?", function (result) {
      if (result) {
        baja_cuota(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar cuota?", function (result) {
      if (result) {
        window.location = "form_m_cuota.php?id=" + id;
      }
    });
  });
}

function btn_telefono() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja teléfono?", function (result) {
      if (result) {
        baja_telefono(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar teléfono?", function (result) {
      if (result) {
        window.location = "form_m_telefono.php?id=" + id;
      }
    });
  });
}

function btn_infoadc() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja infoadc?", function (result) {
      if (result) {
        baja_infoadc(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar infoadc?", function (result) {
      if (result) {
        window.location = "form_m_infoadc.php?id=" + id;
      }
    });
  });
}

function btn_direccion() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja dirección?", function (result) {
      if (result) {
        baja_direccion(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar dirección?", function (result) {
      if (result) {
        window.location = "form_m_direccion.php?id=" + id;
      }
    });
  });
}

function btn_categoria() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja categoría?", function (result) {
      if (result) {
        baja_categoria(id, 4);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar categoría?", function (result) {
      if (result) {
        window.location = "form_m_categoria.php?id=" + id;
      }
    });
  });
}

function btn() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja a usuario?", function (result) {
      if (result) {
        baja_user(id);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar usuario?", function (result) {
      if (result) {
        window.location = "form_m_user.php?id=" + id;
      }
    });
  });
}

function btn_menu() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja a módulo?", function (result) {
      if (result) {
        baja_menu(id);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar módulo?", function (result) {
      if (result) {
        window.location = "form_m_menu.php?id=" + id;
      }
    });
  });

  $(".new_submenu").click(function (e) {
    bootbox.prompt("Ingrese Submenu", function (result) {
      if (result == null) {
        console.log("nulo");
      } else if (result == "") {
        swal({
          title: "Mensaje del Sistema",
          text: "Ingrese nombre de submenu",
          type: "warning",
        });
        return false;
      } else {
        var id = $(this).parent().find(".txt_id").val();
        new_submenu(result, id, 4);
      }
    });
  });
}

function btn_mapa() {
  $(".btn_delete").unbind();
  $(".btn_delete").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea dar de baja a punto?", function (result) {
      if (result) {
        baja_menu(id);
      }
    });
  });

  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    console.log(id);
    bootbox.confirm("&#191;Desea modificar punto?", function (result) {
      if (result) {
        window.location = "form_m_coordenada.php?id=" + id;
      }
    });
  });

  $(".new_submenu").click(function (e) {
    bootbox.prompt("Ingrese Submenu", function (result) {
      if (result == null) {
        console.log("nulo");
      } else if (result == "") {
        swal({
          title: "Mensaje del Sistema",
          text: "Ingrese nombre de submenu",
          type: "warning",
        });
        return false;
      } else {
        var id = $(this).parent().find(".txt_id").val();
        new_submenu(result, id, 4);
      }
    });
  });
}

function btn_ver() {
  $(".btn_ver").unbind();
  $(".btn_ver").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    var mensaje = $(this).parent().find(".txt_mensaje").val();
    swal({ title: "Mensaje del Sistema", text: mensaje, type: "info" });
  });
}

function btn_descarga() {
  $(".btn_descarga").unbind();
  $(".btn_descarga").click(function (e) {
    var fichero = $(this).parent().find(".txt_fichero").val();
    window.location.href = "https://adminio.pe/archivos/" + fichero;
  });
}

function btn_sector() {
  $(".btn_update").unbind();
  $(".btn_update").click(function (e) {
    var id = $(this).parent().find(".txt_id").val();
    var nombre = $(this).parent().find(".txt_nombre").val();
    //console.log(id);
    bootbox.confirm({
      title: "Modificar Sector: " + id,
      message:
        "<input id='nombre_sector' class='form-control' type='text' name='nombre_sector' value='" +
        nombre +
        "'></input>",
      buttons: {
        cancel: {
          label: "Cancel",
        },
        confirm: {
          label: '<i class="icon-check" style="font-size: 12px;"></i> Ok',
        },
      },
      callback: function (result) {
        // console.log('This was logged in the callback: ' + id);
        var nombre_f = $("#nombre_sector").val();
        console.log(result);
        if (result == false || result == "false") {
          console.log("nulo");
        } else if ($("#nombre_sector").val() == "") {
          swal({
            title: "Mensaje del Sistema",
            text: "Ingrese nombre de sector",
            type: "warning",
          });
          return false;
        } else {
          update_sector(nombre_f, id, 2);
        }
      },
    });
  });
}

function baja_user(id) {
  $.ajax({
    data: { id: id },
    dataType: "json",
    url: "ajax/ajax_baja_user.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_usuarios();
      }
    },
  });
}

function baja_contacto(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_contacto.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_contacto(2);
      }
    },
  });
}

function baja_pago(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_pago.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_pago(2);
      }
    },
  });
}

function baja_campana(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_campana.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_campana(2);
      }
    },
  });
}

function baja_cuota(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_cuota.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_cuota(2);
      }
    },
  });
}

function baja_telefono(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_telefono.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_telefono(2);
      }
    },
  });
}

function baja_infoadc(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_infoadc.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_infoadc(2);
      }
    },
  });
}

function baja_direccion(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_direccion.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_direccion(2);
      }
    },
  });
}

function baja_motivo(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_motivo.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_motivo(2);
      }
    },
  });
}

function baja_sucursal(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_sucursal.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_surcusal(2);
      }
    },
  });
}

function baja_efecto(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_efecto.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_efecto(2);
      }
    },
  });
}

function baja_categoria(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_categoria.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_categoria(2);
      }
    },
  });
}

function baja_accion(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_accion.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_accion(2);
      }
    },
  });
}

function baja_cartera(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_cartera.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_cartera(2);
      }
    },
  });
}

function baja_cliente(id, control) {
  $.ajax({
    data: { id: id, control: control },
    dataType: "json",
    url: "ajax/ajax_cliente.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        listar_cliente(2);
      }
    },
  });
}

function baja_horario(id) {
  $.ajax({
    data: { id: id, control: 4 },
    dataType: "json",
    url: "ajax/ajax_horario.php",
    success: function (response) {
      if (response.codigo == 1) {
        listar_horarios(2);
      } else {
        bootbox.alert(response.mensaje || "No se pudo dar de baja el horario");
      }
    },
    error: function () {
      bootbox.alert("Error de comunicación con el servidor.");
    },
  });
}

if (typeof window !== "undefined") {
  window.baja_horario = baja_horario;
}

function new_submenu(nombre, id, control) {
  $.ajax({
    data: { nombre: nombre, id: id, control: control },
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

function update_sector(nombre, id, valida) {
  $.ajax({
    data: { nombre: nombre, id: id, valida: valida },
    dataType: "json",
    url: "ajax/ajax_registrar_sector.php",
    success: function (response) {
      console.log(response);
      if (response.codigo == 1) {
        window.location = "datatable_sector.php";
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
