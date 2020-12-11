<!DOCTYPE html>
<html>
    <head>
        <style>
            .error {
                color: #FF0000;
            }
        </style>
         <meta charset="utf-8">
         <script src="../../JS/jquery-3.5.1.min.js"></script>
         <script src="../../JS/funcoes.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">


    </head>
    <body>
        
    <?php
    include "../functions.php";
     $err = "";
     session_start();
    if (count($_SESSION) == 0) {
      redirect("./../Login/login.php");
    }
    if($_SESSION["type"] != "medico"){
      redirect("./../Login/login.php");
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
      <a href="../../" class="btn btn-info float-right" role="button" >Log Out</a>
  </div>
</nav>

<div class="jumbotron"style="background-image: url(http://localhost/CSS/fundo.jpg); background-size: 100%; background-position:center;height:250px">
</div>
  
<div class="container">
  <center>
    
<h2>Menu de Médico</h2>
  </center>
  <div class="row">
    
    <div class="col-sm-4">
      <center>
      <h3>Cadastrar consultas</h3>
        <a href="./cadastro_consulta.php" class="btn btn-info" role="button">Entrar com Dados</a>
      </center>
    </div>
    <div class="col-sm-4">
      <center> 
        <h3>Editar seus dados</h3>
        <a href="./editar.php" class="btn btn-info" role="button">Entrar com Dados</a>
      </center>
    </div>
    <div class="col-sm-4">
      <center>
        <h3>Histórico de consultas</h3>        
        <a href="./historico.php" class="btn btn-info" role="button">Entrar com Dados</a>
      </center>
    </div>
  </div>
</div>


   
       
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
    </body>

</html>

