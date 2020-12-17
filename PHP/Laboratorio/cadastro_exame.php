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
    <script src="../../JS/Laboratorio/cadastro_exame.js"></script>
    <meta charset="utf-8">
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
    if($_SESSION["type"] != "laboratorio"){
        redirect("./../Login/login.php");
    }
    

    $laboratorio = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);
    $err = "";
    $registro = $paciente = $tipoExame = $resultado = $data = $optionsPacientes = $optionsTipoExame = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        
        $paciente = ($_POST["paciente"]);
        $data = ($_POST["data"]);
        $resultado = ($_POST["resultado"]);
        $tipoExame = ($_POST["tipoExame"]);
        $buscados = busca("exame", array(array("tipoExame", $tipoExame), array("resultado", $resultado), array("data", $data), array("paciente", $paciente)), true);
        print_r($buscados);
        if (empty($buscados)){
            echo "<br>Exame já existe!<br>";
        } else {

            $xml = simplexml_load_file("../../XMLs/exames.xml");
            $xml_exame = $xml->addChild("Exame");
            $xml_exame->addChild('registro', (int)microtime(true));
            $xml_exame->addChild('laboratorio', $laboratorio->registro );
            $xml_exame->addChild('paciente', $paciente);
            $xml_exame->addChild('tipoExame', $tipoExame);
            $xml_exame->addChild('resultado', $resultado);
            $xml_exame->addChild('data', $data);
            $xml->saveXML("../../XMLs/exames.xml");
            redirect("index.php");

        }
    } else {
        $pacientes = simplexml_load_file("../../XMLs/pacientes.xml");

        foreach ($pacientes as $paciente) {

            $optionsPacientes .= "<option name='optionsPacientes' value='" . $paciente->registro . "'>" . $paciente->nome . "</option>";
        }

        $tiposExames = explode(",", $laboratorio->tiposExames);

        foreach ($tiposExames as $tipoExame) {
            $optionsTipoExame .= "<option name='optionsExames' value='" . $tipoExame . "'>" . $tipoExame . "</option>";
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
<center>
    <h1>Cadastro de Exame </h1>
    <form method="post" id="cadastro_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="container" align="center" >
        <div class="col" align="center">
            <label for="paciente">Paciente:</label>
            <select name="paciente" class="form-control" id="paciente" required>
                <?php echo $optionsPacientes; ?>
            </select>
            <label for="tipoExame">Tipo de Exame:</label>
            <select name="tipoExame" class="form-control" id="tipoExame" required>
                <?php echo $optionsTipoExame; ?>
            </select> <br><br>
        </div>
    </div>
        <textarea id="resultado" name="resultado" rows="4" cols="50"  placeholder="Digite aqui um comentario ou descrição do exame" required></textarea> <br><br>
        <span class="error" id="resultadoErr"></span><br><br>
        Data:<input type="date" name="data" id="data" required> <br><br>
        <button type="submit" class="btn btn-primary"  nameP="submit" value="Cadastrar">Cadastrar exame</button>
    </form>
</center>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
</body>

</html>