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
    <script src="../../JS/Paciente/editar.js"></script>
    
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
    if($_SESSION["type"] != "paciente"){
        redirect("./../Login/login.php");
    }


    // define variables and set to empty values
    $emailErr = $nomeErr = $cpfErr = $telefoneErr = $senhaErr = "";
    $email = $senha = $genero = $nome = $endereco = $telefone = $cpf = $idade = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {

        $email = (empty($_POST["email"]) ? "" : test_input($_POST["email"]));
        $senha = (empty($_POST["senha"]) ? "" : test_input($_POST["senha"]));
        $nome = (empty($_POST["nome"]) ? "" : test_input($_POST["nome"]));
        $endereco = (empty($_POST["endereco"]) ? "" : test_input($_POST["endereco"]));
        $telefone = (empty($_POST["telefone"]) ? "" : test_input($_POST["telefone"]));
        $genero = (empty($_POST["genero"]) ? "" : test_input($_POST["genero"]));
        $cpf = (empty($_POST["cpf"]) ? "" : test_input($_POST["cpf"]));
        $genero = (empty($_POST["genero"]) ? "" : test_input($_POST["genero"]));
        $idade = (empty($_POST["idade"]) ? "" : test_input($_POST["idade"]));
        $buscados = busca("paciente", array(array("email", $email), array("nome", $nome), array("cpf", $cpf)), false);
        $cpf = clearString($cpf);
        $telefone = clearString($telefone);
        foreach ($buscados as $buscado) {
            if ((int)$buscado->registro != (int)$_SESSION["registro"]) {


                if ((string)$buscado->nome == (string)$nome) {
                    $nomeErr = "Nome em Uso";
                }
                if ((string)$buscado->email == (string)$email) {
                    $emailErr = "Email em Uso";
                }
                if ((string)$buscado->cpf == (string)$cpf) {
                    $cpfErr = "CPF em Uso";
                }
            }
        }
        if (!($nomeErr != "" || $emailErr != "" || $cpfErr != "")) {
            $xml = simplexml_load_file("../../XMLs/pacientes.xml");
            foreach ($xml as $pac) {

                //echo $xml[$i]->registro . " = " . $_SESSION["registro"] . "<br>";
                if ((float)$pac->registro == (float)$_SESSION["registro"]) {
                    $pac->nome = $nome;
                    $pac->email = $email;
                    $pac->senha = $senha;
                    $pac->genero = $genero;
                    $pac->telefone = $telefone;
                    $pac->endereco = $endereco;
                    $pac->cpf = $cpf;
                    $pac->idade = $idade;
                    break 1;
                }
            }
            $xml->saveXML("../../XMLs/pacientes.xml");
            $_SESSION["email"] = $email;
            $_SESSION["senha"] = $senha;
            echo "<br>Dados Alterados<br>";
        }
    } else {
        $paciente = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);

        if ($paciente == false) {
            //redireciona pro login
        }
        $email = $paciente->email;
        $senha = $paciente->senha;
        $nome = $paciente->nome;
        $endereco = $paciente->endereco;
        $telefone = $paciente->telefone;
        $cpf = $paciente->cpf;
        $genero = $paciente->genero;
        $idade = $paciente->idade;
        $tiposExames = $paciente->tiposExames;
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    /*<option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outros</option>*/
    $options = "";
    if ($genero == "M") {
        $options = '<option value="M" selected>Masculino</option>
        <option value="F">Feminino</option>
        <option value="O">Outros</option>';
    } else if ($genero == "F") {
        $options = '<option value="M">Masculino</option>
        <option value="F" selected>Feminino</option>
        <option value="O">Outros</option>';
    } else {
        $options = '<option value="M">Masculino</option>
        <option value="F">Feminino</option>
        <option value="O" selected>Outros</option>';
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


<div class="container">
    <center>
    <h1>Atualize seus dados</h1>
    
    <form method="post" id="editar_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <div class="col">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o nome aqui" name="nome" required value="<?php echo $nome ?>"> <br><br>
                <span class="error" id="nomeErr"><?php echo $nomeErr; ?></span><br>
            </div>
            <div class="col">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Digite o email aqui" name="email" required value="<?php echo $email ?>"> <br><br>
                <span class="error" id="emailErr"><?php echo $emailErr; ?></span><br>
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" placeholder="xxx.xxx.xxx-xx" name="cpf" required value="<?php echo $cpf ?>"> <br><br>
                <span class="error" id="cpfErr"><?php echo $cpfErr; ?></span><br>
            </div>
            <div class="col">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" placeholder="Digite o telefone aqui" name="telefone" required value="<?php echo $telefone ?>"> <br><br>
                <span class="error" id="telefoneErr"><?php echo $telefoneErr; ?></span><br>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="genero">Genero:</label>
                <select class="form-control" name="genero" id="genero" >
                    <?php echo $options ?>
                </select>
            </div>
            <div class="col">
                <label for="Idade">Idade:</label>
                <input type="number" class="form-control" id="idade" placeholder="Digite a idade aqui" name="idade" required value="<?php echo $idade ?>"> <br><br>
            </div>
            <div class="col">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" placeholder="Digite o endereço aqui" name="endereco" required value="<?php echo $endereco ?>"> <br><br>
            </div>
            
        </div>

        <div class="form-row">
            <div class="col">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" placeholder="Digite a senha aqui" name="senha" required value="<?php echo $senha ?>"> <br><br>
            </div>
            <div class="col">
                <label for="csenha">Confirmar senha:</label>
                <input type="password" class="form-control" id="csenha" placeholder="Repita a senha aqui" name="csenha" required value="<?php echo $senha ?>"> <br><br>
                <span class="error" id="senhaErr"><?php echo $senhaErr; ?></span><br><br>            
            </div>
        </div>
        
        <button class="btn btn-primary btn-lg btn-block" type="submit" nameP="submit" value="Cadastrar">Cadastrar</button>
        
    </form>
    </center>
</div>
    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>