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
    print_r($_SESSION);
    if (count($_SESSION) == 0) {
        redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "laboratorio"){
        redirect("./../Login/login.php");
    }

    $laboratorio = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);
    echo "<br>";

    /*
        <Exame>
            <registro>665641</registro>
            <laboratorio>x</laboratorio>
            <paciente>x</paciente>
            <tipoExame>Não Sei</tipoExame>
            <resultado>xxxxxxx</resultado>
            <data>0</data>
        </Exame>
    */
    $err = "";
    $registro = $paciente = $tipoExame = $resultado = $data = $optionsPacientes = $optionsTipoExame = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        //echo "e2";
        $paciente = (empty($_POST["paciente"]) ? "" : test_input($_POST["paciente"]));
        $data = (empty($_POST["data"]) ? "" : test_input($_POST["data"]));
        $resultado = (empty($_POST["resultado"]) ? "" : test_input($_POST["resultado"]));
        $tipoExame = (empty($_POST["tipoExame"]) ? "" : test_input($_POST["tipoExame"]));

        $buscados = busca("consulta", array(array("tipoExame", $tipoExame), array("resultado", $resultado), array("data", $data), array("paciente", $paciente)), true);

        if (empty($buscados)){
            echo "<br>Exame já existe!<br>";
        } else {

            $xml = simplexml_load_file("../../XMLs/exames.xml");
            $xml_exame = $xml->addChild("Exame");
            $xml_exame->addChild('registro', (int)microtime(true));
            $xml_exame->addChild('paciente', $paciente);
            $xml_exame->addChild('tipoExame', $tipoExame);
            $xml_exame->addChild('resultado', $resultado);
            $xml_exame->addChild('data', $data);
            $xml->saveXML("../../XMLs/exames.xml");
            echo "<br>Exame Cadastrado<br>";

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
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="navbar-text">
        Sistema de Plano de Saúde
    </li>
  </ul>
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