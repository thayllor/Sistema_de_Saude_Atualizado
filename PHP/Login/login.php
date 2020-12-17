<!DOCTYPE HTML>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <script src="../../JS/jquery-3.5.1.min.js"></script>
    <script src="../../JS/Login/login.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">


</head>

<body>

    <?php
    include "../functions.php";
    session_start();

    // define variables and set to empty values
    $err = "";
    $email = $senha = $type = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        $email = (empty($_POST["email"]) ? "" : test_input($_POST["email"]));
        $senha = (empty($_POST["senha"]) ? "" : test_input($_POST["senha"]));
        $type = (empty($_POST["type"]) ? "" : test_input($_POST["type"]));
        $user = checkUser($email, $senha, $type);
        if ($user != false) {
            $_SESSION["email"] = $email;
            $_SESSION["senha"] = $senha;
            $_SESSION["type"] = $type;
            $_SESSION["registro"] = (float)$user->registro;
            if($_SESSION["type"]=="admin") {
                redirect("./../Admin/index.php");
            }
            if($_SESSION["type"]=="laboratorio") {
                redirect("./../Laboratorio/index.php");
            }
            if($_SESSION["type"]=="medico") {
                redirect("./../Medico/index.php");
            }
            if($_SESSION["type"]=="paciente") {
                redirect("./../Paciente/index.php");
            }
        } else {
            session_unset();
        };

        if (count($_SESSION) == 0) {
            $err = "Credenciais Inválidas";
        }
    } else {
        session_unset();
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
      <h1>Login</h1>
</form>

    <form method="post" id="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <span class="error" id="error"><?php echo $err; ?></span><br>

        <div  style= "text-aligment:center; width: 600px;" >
            <div>
                <label for="email">Email:</label>
                <input type="email" class="form-control" placeholder="Digite o email aqui" size="50" id="email" name="email" value="<?php echo $email; ?>">
            </div>
            <br>
            <div >
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" placeholder="Digite a senha aqui" id="senha" name="senha" value="<?php echo $senha; ?>">
            </div>
        </div>


        <div class="form-check-inline">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" id="paciente" name="type" value="paciente">Paciente
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" id="medico" name="type" value="medico">Medico
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" id="admin" name="type" value="admin">Admin
            </label>
        </div>
        
        <div class="form-check-inline">
            <label class="form-check-label">
            <input type="radio" class="form-check-input" id="laboratorio" name="type" value="laboratorio">Laboratorio
            </label>
        </div>
        
        <div>
        <button type="submit" class="btn btn-primary">Logar</button>

        </div>
    </form>
  
    </center>
</div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 
</body>

</html>