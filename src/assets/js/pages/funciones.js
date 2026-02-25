$(function () {
  listar_usuarios_online();

  $("#cerrar_session,#cerrar_session_m").click(function (e) {
    e.preventDefault();
    var user = jQuery("#nombre_ls").text();
    console.log(user);
    bootbox.confirm(
      "<b style='color:#0B610B'>" + user + "</b> ::: ¿Desea salir del sistema?",
      function (result) {
        if (result) {
          cerrarSesion();
        }
      },
    );
  });
});

function listar_usuarios_online() {
  $.ajax({
    data: {},
    dataType: "json",
    url: "ajax/ajax_user_online.php",
    success: function (response) {
      var str_li = "";
      if (response.codigo == 0) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "warning",
        });
        $("#div_online li").html("");
        $("#contador_online").text("");
      } else if (response.codigo == 2) {
        swal({
          title: "Mensaje del Sistema",
          text: response.mensaje,
          type: "info",
        });
        setTimeout(function () {
          window.location = "index.php";
        }, 2000);
      } else {
        //var cols = response.arr_datos[0].length
        for (var i = 0; i < response.arr_datos.length; i++) {
          str_li +=
            '<li class="media" ><div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div><div class="media-body"><a href="#" style="font-size: x-small;" class="media-heading text-semibold">' +
            response.arr_datos[i][0] +
            '</a><span class="display-block text-muted text-size-small" style="font-size: x-small;">' +
            response.arr_datos[i][1] +
            '</span></div><div class="media-right media-middle"><span class="status-mark border-success"></span></div></li>';
        }
        //console.log(str_li);
        $("#div_online li").html(str_li);
        $("#contador_online").text(response.arr_datos.length);
        $("#dash_online").text(response.arr_datos.length);
      }
    },
  });
}

function cerrarSesion() {
  $.ajax({
    async: true,
    url: "ajax/ajax_cerrar_sesion.php",
    type: "post",
    dataType: "json",
    success: function (response) {
      bootbox.alert(response.mensaje);
      window.location = "index.php";
    },
    error: function (dato) {
      bootbox.alert("Ocurrio un error");
    },
  });
}
