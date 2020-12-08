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
    include "../functions.php";
    session_start();
    print_r($_SESSION);
    if (count($_SESSION) == 0) {
        redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "medico"){
        redirect("./../Login/login.php");
    }

    // define variables and set to empty values
    $emailErr = $nomeErr = $pacreg = "";
    $nome = $receita = $observacao = $data = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {

        $nome = (empty($_POST["nome"]) ? "" : test_input($_POST["nome"]));

        $buscados = busca("paciente", array(array("nome", $nome)), false);

        foreach ($buscados as $buscado) {
            if ($buscado->nome == $nome) {
                $pacreg = $buscado->registro;
            }
        }

        if ($pacreg == "") {

            echo "<br>Paciente não encontrado!<br>";

        } else {

            $observacao = (empty($_POST["observacao"]) ? "" : test_input($_POST["observacao"]));
            $data = (empty($_POST["data"]) ? "" : test_input($_POST["data"])); 
            $receita = (empty($_POST["receita"]) ? "" : test_input($_POST["receita"]));
            $medico = $_SESSION["registro"];

            $buscados = busca("consulta", array(array("medico", $medico), array("observacao", $observacao), array("receita", $receita), array("data", $data), array("paciente", $pacreg)), true);

            if (empty($buscados)){
                echo "<br>Consulta já existe!<br>";
            } else {


                $registro = (int)microtime(true);

                $xml = simplexml_load_file("../../XMLs/consultas.xml");
                $xml_nova_consulta = $xml->addChild("Consulta");
                $xml_nova_consulta->addChild('registro', $registro);
                $xml_nova_consulta->addChild('data', $data);
                $xml_nova_consulta->addChild('medico', $medico);
                $xml_nova_consulta->addChild('paciente', $pacreg);
                $xml_nova_consulta->addChild('receita', $receita);
                $xml_nova_consulta->addChild('observacao', $observacao);
                $xml->saveXML("../../XMLs/consultas.xml");

                echo "<br>Cadastro da consulta realizado<br>";

            }
        }

    } else {
        $medico = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);

        if ($medico == false) {
            //redireciona pro login
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
<div>

<center>
    <h1>Cadastro de Consulta </h1>
    <br><br><br>
    <form method="post" id="editar_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="container" align="center" >
        <div class="col" align="center">
             
            <label for="nome">Nome do paciente:</label>
            <input type="text" class="form-control" name="nome" id="nome" required value="<?php echo $nome; ?>"><br><br><br>

            
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