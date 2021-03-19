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
    <script src="../../JS/Laboratorio/historico.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>

    <?php
    include_once('con_laboratorio.php');
    include "../functions.php";

    session_start();
    if (count($_SESSION) == 0) {
        redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "laboratorio"){
        redirect("./../Login/login.php");
    }
    $lab= new Lab($_SESSION["email"]);
    $method = $_SERVER["REQUEST_METHOD"];
    $lista= $optionsPacientes=$err = "";
    #options com os pacientes
    $pacientes = $lab->pacientes();
    foreach ($pacientes as $paciente) {

        $optionsPacientes .= "<option name='optionsPacientes' value='" . $paciente->id . "'>" . $paciente->nome . "</option>";
    }


    if ($method == "POST") {
        $pacienteID= $_POST["pacienteID"];
        $exames=$lab->historico($pacienteID);
        $lista.= "<br><hr>";
         #faz os exames
        if($exames!=null){
            $lista.= "<p> O paciente escolhido tem um total de ". $lab->countExames .  " exames no seu laboratorio</p> <br><hr>";
            foreach ($exames as $exame) {
                $lista .= "Tipo do Exame: " . $exame->tipo . "<br>";
                $lista .= "Resultado: " . $exame->resultado . "<br>";
                $lista .= "Data: " . $exame->data . "<br><hr><br>";
            }
        }else{
            $lista = "<h4>Sem exames com esse paciente</h4>";
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
<div class="container">
    <center>
        <h1>Historico de Exames</h1>
    </center>
    <div>
   <form method="post" id="historico_lab" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <center>
        <div>
            <label for="pacienteID">Paciente:</label>
            <select name="pacienteID" class="form-control" id="pacienteID" required>
                    <?php echo $optionsPacientes; ?>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary"  nameP="submit" value="Cadastrar">Verificar Historico</button>
        </div>
            
        </center>

    </form>
    </div>
    <?php echo $lista; ?>
</div>
    
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
</body>

</html>