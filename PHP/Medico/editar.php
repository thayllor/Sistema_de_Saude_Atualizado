<!DOCTYPE html>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <script src="../../JS/jquery-3.5.1.min.js"></script>
    <script src="../../JS/funcoes.js"></script>
    <script src="../../JS/Medico/editar.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>

    <?php
    include "../functions.php";
    session_start();
    if (count($_SESSION) == 0) {
        redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "medico"){
        redirect("./../Login/login.php");
    }


    // define variables and set to empty values
    $emailErr = $nomeErr = $crmErr = $senhaErr= $telefoneErr= "";
    $email = $senha = $nome = $endereco = $telefone = $crm = $especialidade = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $nome = $_POST["nome"];
        $endereco = $_POST["endereco"];
        $telefone = $_POST["telefone"];
        $crm = $_POST["crm"];
        $especialidade = $_POST["especialidade"];
        $crm = clearString($crm);
        $telefone = clearString($telefone);
        $buscados = busca("medico", array(array("email", $email), array("nome", $nome), array("crm", $crm)), false);

        foreach ($buscados as $buscado) {
            if ((int)$buscado->registro != (int)$_SESSION["registro"]) {


                if ((string)$buscado->nome == (string)$nome) {
                    $nomeErr = "Nome em Uso";
                }
                if ((string)$buscado->email == (string)$email) {
                    $emailErr = "Email em Uso";
                }
                if ((string)$buscado->crm == (string)$crm) {
                    $crmErr = "Crm em Uso";
                }
            }
        }
        if (!($nomeErr != "" || $emailErr != "" || $crmErr != "")) {
            $xml = simplexml_load_file("../../XMLs/medicos.xml");
            foreach ($xml as $med) {

                //echo $xml[$i]->registro . " = " . $_SESSION["registro"] . "<br>";
                if ((int)$med->registro == (int)$_SESSION["registro"]) {
                    $med->nome = $nome;
                    $med->email = $email;
                    $med->senha = $senha;
                    $med->telefone = $telefone;
                    $med->endereco = $endereco;
                    $med->crm = $crm;
                    $med->especialidade = $especialidade;
                    break 1;
                }
            }
            $xml->saveXML("../../XMLs/medicos.xml");
            $_SESSION["email"] = $email;
            $_SESSION["senha"] = $senha;
            echo "<br>Dados Alterados<br>";
        }
    } else {
        $medico = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);

        if ($medico == false) {
            //redireciona pro login
        }
        $email = $medico->email;
        $senha = $medico->senha;
        $nome = $medico->nome;
        $endereco = $medico->endereco;
        $telefone = $medico->telefone;
        $crm = $medico->crm;
        $especialidade = $medico->especialidade;
        $idade= $medico->idade;
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


<div class="container">
    <center>
    <h1>Atualize seus dados</h1>
    <form method="post" id="editar_medico_form">
    <div class="form-row">
        <div class="col">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" placeholder="Digite o nome aqui" name="nome" required value="<?php echo $nome; ?>"> <br><br>
        </div>
        <div class="col">
            <label for="Idade">Idade:</label>
            <input type="number" class="form-control" id="idade" placeholder="Digite a idade aqui" name="idade" required value="<?php echo $idade; ?>"> <br><br>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <label for="crm">CRM:</label>
            <input type="text" class="form-control" id="crm" placeholder="Digite o CRM aqui" name="crm" required value="<?php echo $crm; ?>"> <br><br>
            <span class="error" id="crmErr"><?php echo $crmErr; ?></span><br><br>
        </div>
        <div class="col">
            <label for="telefone">Telefone:</label>
            <input type="text" class="form-control" id="telefone" placeholder="Digite o telefone aqui" name="telefone" required value="<?php echo $telefone; ?>"> <br><br>
            <span class="error" id="telefoneErr"><?php echo $telefoneErr; ?></span>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Digite o email aqui" name="email" required value="<?php echo $email; ?>"> <br><br>
        </div>
        <div class="col">
            <label for="especialidade">Especialidade:</label>
            <input type="text" class="form-control" id="especialidade" placeholder="Digite a especialidade do medico aqui" name="especialidade" required value="<?php echo $especialidade; ?>"> <br><br>
        </div>
        <div class="col">
            <label for="endereco">Endereço:</label>
            <input type="text" class="form-control" id="endereco" placeholder="Digite o endereço aqui" name="endereco" required value="<?php echo $endereco; ?>"> <br><br>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control" id="senha" placeholder="Digite a senha aqui" name="senha" required> <br><br>
        </div>
        <div class="col">
            <label for="csenha">Confirmar senha:</label>
            <input type="password" class="form-control" id="csenha" placeholder="Repita a senha aqui" name="csenha" required> <br><br>
        </div>
    </div>
    <span class="error" id="senhaErr" name="senhaErr"></span><br>
        
        <button class="btn btn-primary btn-lg btn-block" type="submit" nameP="submit" value="Cadastrar">Cadastrar</button>
    </form>
    </center>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
</body>

</html>