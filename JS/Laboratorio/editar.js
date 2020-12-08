$(document).ready(function () {
  $("#editar_form").submit(function (event) {
    let err = false;
    if ($("#senha").val() !== $("#csenha").val()) {
      $("#csenhaErr").text("Senhas não conferem");
      err = true;
    } else {
      $("#csenhaErr").text("");
    }
    if (!valida_telefone($("#telefone").val())) {
      $("#telefoneErr").text("Telefone Inválido");
      err = true;
    } else {
      $("#telefoneErr").text("");
    }

    if (!valida_cnpj($("#cnpj").val())) {
      $("#cnpjErr").text("Cnpj Inválido");
      err = true;
    } else {
      $("#cnpjErr").text("");
    }
    if (!valida_email($("#email").val())) {
      $("#emailErr").text("Email Inválido");
      err = true;
    } else {
      $("#emailErr").text("");
    }
    if (err) {
      event.preventDefault();
    }
  });
});
