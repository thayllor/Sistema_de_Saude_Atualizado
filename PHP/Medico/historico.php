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
    <script src="../../JS/funcoes.js"></script>
    <script src="../../JS/Medico/historico.js"></script>
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
    $medico = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);
    $err = "";
    $lista = "";
    $nome = $nomeErr = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        $nome = $_POST["nome"];
        $buscados = busca("paciente", array(array("nome", $nome)), false);
        $pacreg = "";
        foreach ($buscados as $buscado) {
            if ($buscado->nome == $nome) {
                $pacreg = $buscado->registro;
            }
        }
        if ($pacreg == "") {
            echo "<br>Paciente não encontrado!<br>";
        } else {
            $consultas = simplexml_load_file("../../XMLs/consultas.xml");
            foreach ($consultas as $consulta) {
                if ((int)$consulta->medico == $_SESSION["registro"] && (int)$consulta->paciente == $pacreg) {
                    $lista .= "Data da Consulta: " . $consulta->data . "<br>";
                    $lista .= "Receita: " . $consulta->receita . "<br>";
                    $lista .= "Observacao: " . $consulta->observacao . "<br><hr><br>";
                }
            }
            if ($lista == "") {
                $lista = "<h4>Lista Vazia</h4>";
            }
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

<form method="post" id="consulta_medica_form">

    <div class="container" align="center">
    
        <h1>Historico de Consultas</h1>

        <label for="nome">Nome do paciente:</label>
        <input type="text" class="form-control" name="nome" id="nome" required value="<?php echo $nome; ?>"><br><br><br>
        <span class="error"><?php echo $nomeErr; ?></span><br><br>

        <button type="submit" class="btn btn-primary"  nameP="submit" value="Procurar">Procurar paciente</button>


    </div>
</form>

<?php echo $lista; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>