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
    <script src="../../JS/Paciente/historico.js"></script>
    
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
    if($_SESSION["type"] != "paciente"){
        redirect("./../Login/login.php");
    }

    $paciente = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);
    echo "<br>";

    /*
        <Exame>
            <registro>665641</registro>
            <paciente>x</paciente>
            <paciente>234432432</paciente>
            <tipoExame>Não Sei</tipoExame>
            <resultado>xxxxxxx</resultado>
            <data>0</data>
        </Exame>
    */
    $err = "";

    $method = $_SERVER["REQUEST_METHOD"];

    $laboratorios = simplexml_load_file("../../XMLs/laboratorios.xml");
    $exames = simplexml_load_file("../../XMLs/exames.xml");

    $lista = "";
    foreach ($laboratorios as $lab) {
        $found = false;
        foreach ($exames as $exame) {
            if ((int)$exame->paciente == (int)$paciente->registro && (int)$exame->laboratorio == (int)$lab->registro) {
                if (!$found) {
                    $lista .= "<div id = '" . $lab->registro . "'><button onclick='mostrarHistorico(" . $lab->registro . ")'>
                    " . $lab->nome . "
                    </button><br><br><div id='" . $lab->registro . "-historico' style='display: none;'>";
                    $found = true;
                }
                $lista .= "Tipo do Exame: " . $exame->tipoExame . "<br>";
                $lista .= "Resultado: " . $exame->resultado . "<br>";
                $lista .= "Data: " . $exame->data . "<br><hr><br>";
            }
        }
        if ($found) {
            $lista .= "</div></div>";
        }
    }
    if ($lista == "") {
        $lista = "<h4>Lista Vazia</h4>";
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
<div class="container" align="center" >


    <h1>Historico de Exames</h1>
    <?php echo $lista; ?>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>