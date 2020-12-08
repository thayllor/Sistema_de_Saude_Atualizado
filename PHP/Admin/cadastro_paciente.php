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
    <script src="../../JS/Admin/cadastro_paciente.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>

    <?php
    include "../functions.php";
    session_start();
    print_r($_SESSION);
    if (count($_SESSION) == 0) {
        redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "admin"){
        redirect("./../Login/login.php");
    }

    // define variables and set to empty values
    $nome_atual=
    $err = "";
    $emailErr = $nomeErr = $cpfErr = $telefoneErr = $senhaErr = "";

    $email = $senha = $genero = $nome = $endereco = $telefone = $cpf = $idade = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $genero = $_POST["genero"];
        $nome = $_POST["nome"];
        $endereco = $_POST["endereco"];
        $telefone = $_POST["telefone"];
        $cpf = $_POST["cpf"];
        $idade = $_POST["idade"];
        $buscados = busca("paciente", array(array("email", $email), array("nome", $nome), array("cpf", $cpf)), false);
        $registro = (int)microtime(true);
        foreach ($buscados as $buscado) {

            if ($buscado->nome == $nome) {
                $nomeErr = "Nome em Uso";
            }
            if ($buscado->email == $email) {
                $emailErr = "Email em Uso";
            }
            if ($buscado->cpf == $cpf) {
                $cpfErr = "CPF em Uso";
            }
        }
        if (!($nomeErr != "" || $emailErr != "" || $cpfErr != "")) {
            $xml = simplexml_load_file("../../XMLs/pacientes.xml");
            $xml_novo_lab = $xml->addChild("Paciente");
            $xml_novo_lab->addChild('registro', $registro);
            $xml_novo_lab->addChild('email', $email);
            $xml_novo_lab->addChild('senha', $senha);
            $xml_novo_lab->addChild('nome', $nome);
            $xml_novo_lab->addChild('endereco', $endereco);
            $xml_novo_lab->addChild('telefone', $telefone);
            $xml_novo_lab->addChild('cpf', $cpf);
            $xml_novo_lab->addChild('genero', $genero);
            $xml_novo_lab->addChild('idade', $idade);
            $xml->saveXML("../../XMLs/pacientes.xml");
            redirect("index.php");

        }
    }
    ?>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="navbar-text">
        Nome do sistema
    </li>
  </ul>
</nav>
<div class="jumbotron"style="background-image: url(http://localhost/CSS/fundo.jpg); background-size: 100%; background-position:center;height:250px">
</div>
  

<div class="container">
    <center>
    <h1>Cadastro de Paciente</h1>
    
    <form method="post" id="c_paciente_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <div class="col">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o nome aqui" name="nome" required<?php echo $nome; ?>> <br><br>
                <span class="error" id="nomeErr"><?php echo $nomeErr; ?></span><br>
            </div>
            <div class="col">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Digite o email aqui" name="email" required <?php echo $email; ?>> <br><br>
                <span class="error" id="emailErr"><?php echo $emailErr; ?></span><br>
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" placeholder="Digite o Cpf aqui" name="cpf" required<?php echo $cpf; ?>> <br><br>
                <span class="error" id="cpfErr"><?php echo $cpfErr; ?></span><br>
            </div>
            <div class="col">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" placeholder="Digite o telefone aqui" name="telefone" required <?php echo $telefone; ?>> <br><br>
                <span class="error" id="telefoneErr"><?php echo $telefoneErr; ?></span><br>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="sel1">Genero:</label>
                <select class="form-control" id="sel1" name="genero">
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="O" selected>Outros</option>
                </select>
            </div>
            <div class="col">
                <label for="Idade">Idade:</label>
                <input type="number" class="form-control" id="idade" placeholder="Digite a idade aqui" name="idade" required <?php echo $idade; ?>> <br><br>
            </div>
            <div class="col">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" placeholder="Digite o endereço aqui" name="endereco" required <?php echo $endereco; ?>> <br><br>
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
        
        <button class="btn btn-primary btn-lg btn-block" type="submit" nameP="submit" value="Cadastrar">Cadastrar</button>
        
    </form>
    </center>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 

</body>

</html>