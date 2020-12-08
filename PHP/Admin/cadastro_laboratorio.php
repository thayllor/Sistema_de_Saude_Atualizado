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
    <script src="../../JS/Admin/cadastro_laboratorio.js"></script>
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
    $err = "";
    $emailErr = $nomeErr = $cnpjErr = $telefoneErr = $senhaErr = "";
    $email = $senha = $genero = $nome = $endereco = $telefone = $cnpj = $tiposExames = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        //echo "e2";
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $nome = $_POST["nome"];
        $endereco = $_POST["endereco"];
        $telefone = $_POST["telefone"];
        $cnpj = $_POST["cnpj"];
        $tiposExames = $_POST["tiposExames"];
        $buscados = busca("laboratorio", array(array("email", $email), array("nome", $nome), array("cnpj", $cnpj)), false);
        $registro = (int)microtime(true);
        foreach ($buscados as $buscado) {

            if ($buscado->nome == $nome) {
                $nomeErr = "Nome em Uso";
            }
            if ($buscado->email == $email) {
                $emailErr = "Email em Uso";
            }
            if ($buscado->cnpj == $cnpj) {
                $cnpjErr = "Cnpj em Uso";
            }
        }
        if (!($nomeErr != "" || $emailErr != "" || $cnpjErr != "")) {
            $xml = simplexml_load_file("../../XMLs/laboratorios.xml");
            $xml_novo_lab = $xml->addChild("Laboratorio");
            $xml_novo_lab->addChild('registro', $registro);
            $xml_novo_lab->addChild('email', $email);
            $xml_novo_lab->addChild('senha', $senha);
            $xml_novo_lab->addChild('nome', $nome);
            $xml_novo_lab->addChild('endereco', $endereco);
            $xml_novo_lab->addChild('telefone', $telefone);
            $xml_novo_lab->addChild('cnpj', $cnpj);
            $xml_novo_lab->addChild('tiposExames', $tiposExames);
            $xml->saveXML("../../XMLs/laboratorios.xml");
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
    <h1>Cadastro de Laboratorios </h1>
    
    
    <form method="post" id="c_laboratorio_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <div class="col">
                <label for="nome">Nome:</label>
                <span class="error" id="nomeErr"><?php echo $nomeErr; ?></span><br>
                <input type="text" class="form-control" id="nome" placeholder="Digite o nome aqui" name="nome" required value="<?php echo $nome; ?>"> <br><br>
            </div>
            <div class="col">
                <label for="tiposExames">Tipos de exame:</label>
                <input type="text" class="form-control" id="tiposExames" placeholder="Digite os tipos de exame que o laboratorio tem aqui" name="tiposExames" required value="<?php echo $tiposExames; ?>"> <br><br>
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <label for="cnpj">CNPJ:</label>
                <span class="error" id="cnpjErr"><?php echo $cnpjErr; ?></span><br>
                <input type="text" class="form-control" id="cnpj" placeholder="Digite o CNPJ aqui" name="cnpj" required value="<?php echo $cnpj; ?>"> <br><br>
            </div>
            <div class="col">
                <label for="telefone">Telefone:</label>
                <span class="error" id="telefoneErr"><?php echo $telefoneErr; ?></span><br>
                <input type="text" class="form-control" id="telefone" placeholder="Digite o telefone aqui" name="telefone" required value="<?php echo $telefone; ?>"> <br><br>
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <label for="email">Email:</label>
                <span class="error" id="emailErr"><?php echo $emailErr; ?></span><br> 
                <input type="text" class="form-control" id="email" placeholder="Digite o email aqui" name="email" required value="<?php echo $email; ?>"> <br><br>
                
            </div>
            
            <div class="col">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" placeholder="Digite o endereço aqui" name="endereco" required value="<?php echo $endereco; ?>"> <br><br>

            </div>
            
        </div>

        <div class="form-row">
            <div class="col">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" placeholder="Digite a senha aqui" name="senha" required > <br><br>
            </div>
            <div class="col">
                <label for="csenha">Confirmar senha:</label>
                <input type="password" class="form-control" id="csenha" placeholder="Repita a senha aqui" name="csenha" required > <br><br>
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