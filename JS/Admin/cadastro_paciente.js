$(document).ready(function () {
      $("#c_paciente_form").submit(function (event) {
      let err = false;
      if (!valida_telefone($("#telefone").val())) {
        $("#telefoneErr").text("telefone invalido");
        err = true;
      } else {
        $("#telefoneErr").text("");
      }
      if (!valida_email($("#email").val())) {
        $("#emailErr").text("email invalido");
        err = true;
      } else {
        $("#emailErr").text("");
      }
      if ($("#senha").val() != $("#csenha").val()) {
        $("#senhaErr").text("As senhas digitadas são diferentes");
        err = true;
      } else{
        $("#senhaErr").text("");
      }
      if ( !valida_cpf($("#cpf").val() ) ){
        $("#cpfErr").text("Cpf Invalido");
        err=true;
      }else{
        $("#cpfErr").text("");
      }
      if(err){
        event.preventDefault();
      }
    });
  });