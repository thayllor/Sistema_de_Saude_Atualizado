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
    include_once("./con_paciente.php");
    include "../functions.php";

    session_start();
    if (count($_SESSION) == 0) {
        redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "paciente"){
        redirect("./../Login/login.php");
    }

    $pac = new Pac($_SESSION["email"]);
    $lista =$optionsMedicos= "";
    $method = $_SERVER["REQUEST_METHOD"];
    $medicos = $pac->medicos();
    foreach ($medicos as $medico) {

        $optionsMedicos .= "<option name='optionsMedicos' value='" . $medico->id . "'>" . $medico->nome . "</option>";
    }

    if($method == "POST"){

        $medicoID = $_POST["Medico"];

        $consultas=$pac->consultas($medicoID);
        $lista.= "<br><hr>";
         #faz os exames
        if($consultas!=null){
            $lista.= "<p> Você tem um total de ". $pac->countConsultas .  " consultas com o medico escolhido</p> <br><hr>";
                foreach ($consultas as $consulta) {
                    $lista .= "Observação: " . $consulta->observação . "<br>";
                    $lista .= "Receita: " . $consulta->receita . "<br>";
                    $lista .= "Data: " . $consulta->data . "<br><hr><br>";
                }
            
        }else{
            $lista = "<h4>Sem consultas com esse medico</h4>";
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
<div class="container" align="center" >


    <h1>Historico de Consultas</h1>
<form method="post" id="cadastro_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="col" align="center">
        <label for="Medico">Medico:</label>
        <select name="Medico" class="form-control" id="Medico" required>
            <?php echo $optionsMedicos; ?>
        </select>
    </div>
    <div class="col" align="center">
        <button type="submit" class="btn btn-primary"  nameP="submit" value="Verificar">Verificar Historico</button>
    </div>
</form>


    <?php echo $lista; ?>
    
</div>
    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>