$(document).ready(function () {
  $("#editar_form").submit(function (event) {
    let err = false;
    if ($("#senha").val() !== $("#csenha").val()) {
      $("#senhaErr").text("Senhas não conferem");
      err = true;
    } else {
      $("#senhaErr").text("");
    }

    if (!valida_cpf($("#cpf").val())) {
      $("#cpfErr").text("CPF Inválido");
      err = true;
    } else {
      $("#cpfErr").text("");
    }

    if (!valida_telefone($("#telefone").val())) {
      $("#telefoneErr").text("Telefone Inválido");
      err = true;
    } else {
      $("#telefoneErr").text("");
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
