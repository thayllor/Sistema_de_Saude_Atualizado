<!DOCTYPE html>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
        .container {
         max-width: 960px;
        }

    </style>
    <script src="../../JS/jquery-3.5.1.min.js"></script>
    <script src="../../JS/Medico/editar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
 
<body>

    <?php
    include_once('./con_medico.php');
    include "../functions.php";
    
    session_start();
    if (count($_SESSION) == 0) {
        redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "medico"){
        redirect("./../Login/login.php");
    }
    $medico= new Medico($_SESSION["email"]);
    $emailErr = $nomeErr = $optionsPacientes= "";
    $nome = $receita = $observacao = $data = "" ;
    $method = $_SERVER["REQUEST_METHOD"];
    $pacientes = $medico->pacientes();
    foreach ($pacientes as $paciente) {

        $optionsPacientes .= "<option name='optionsPacientes' value='" . $paciente->id . "'>" . $paciente->nome . "</option>";
    }

    if ($method == "POST") {

        $nome = ($_POST["nome"]);
        $paciente = ($_POST["paciente"]);
        $observacao = ($_POST["observacao"]);
        $data = ($_POST["data"]); 
        $receita = ($_POST["receita"]);
        $err=$medico->salva_consulta($data,$paciente,$receita,$observacao,$nome);
        if($err=="existente"){
            $consistenciaERR="A consulta ja existe";
        } else {
            $nome = $receita = $observacao = $paciente = $medico = $optionsPacientes = $err = $consistenciaERR="";
            redirect("index.php");
        }
    }
    

    ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="#">Sistema de Plano de Saúde</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active"></li>
    </ul>
      <a href="index.php" class="btn btn-info float-right" role="button" >Voltar para o menu</a>
  </div>
</nav>

<div class="jumbotron"style="background-image: url(http://localhost/CSS/fundo.jpg); background-size: 100%; background-position:center;height:250px">
</div>
<div>

<center>
    <h1>Cadastro de Consulta </h1>
    <br><br><br>
    <form method="post" id="editar_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="container" align="center" >
        <div class="col" align="center">
            <label for="paciente">Paciente:</label>
            <br>
            <select name="paciente" class="form-control" id="paciente" required>
                <?php echo $optionsPacientes; ?>
            </select>
            <br>
           
            
            <div class="form-row">
                <div class="col">
                    <label for="observacao">Observação:</label>
                    <textarea id="observacao" name="observacao" rows="4" cols="50"  placeholder="Digite aqui um comentario ou descrição da consulta" required value="<?php echo $observacao; ?>"></textarea><br>
                </div>
                <div class="col">
                    <label for="receita">Receita:</label>
                    <textarea id="receita" name="receita" rows="4" cols="50"  placeholder="Digite aqui a receita medica da consulta" required value="<?php echo $receita; ?>"></textarea><br>
                </div>
            </div>
           
            <label for="data ">Data:</label>
            <input type="date" name="data" id="data" required> <br><br><br><br><br>

            
            
        </div>
    </div>
        <button type="submit" class="btn btn-primary"  nameP="submit" value="Cadastrar">Cadastrar consulta</button>
    </form>
</center>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
</body>

</html>