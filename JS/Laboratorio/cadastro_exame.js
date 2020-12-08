$(document).ready(function () {
  $("#cadastro_form").submit(function (event) {
    if (
      $("#resultado").val() == null ||
      $("#resultado").val() == undefined ||
      $("#resultado").val().trim() == ""
    ) {
      $("#resultadoErr").text("Preenchimento obrigatório");
      event.preventDefault();
    } else {
      $("#resultadoErr").text("");
    }
  });
});
