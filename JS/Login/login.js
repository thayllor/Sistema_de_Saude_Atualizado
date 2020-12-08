$(document).ready(function () {
  $("#login_form").submit(function (event) {
    if (
      $("#email").val() == "" ||
      $("#senha").val() == "" ||
      $("input[name='type']:checked").val() == "" ||
      $("input[name='type']:checked").val() == null
    ) {
      $("#error").text("Preencha todos os campos");
      event.preventDefault();
    } else {
      $("#error").text("");
    }
  });
});
