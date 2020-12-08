<!DOCTYPE html>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <script src="../../JS/jquery-3.5.1.min.js"></script>
    <script src="../../JS/Laboratorio/editar.js"></script>
</head>

<body>

    <?php
    include "../functions.php";
    session_start();
    print_r($_SESSION);
    if (count($_SESSION) == 0) {
        //redireciona pro login
    }


    // define variables and set to empty values
    $emailErr = $nomeErr = $cnpjErr = "";
    $email = $senha = $nome = $endereco = $telefone = $cnpj = $tiposExames = "";
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {

        $email = (empty($_POST["email"]) ? "" : test_input($_POST["email"]));
        $senha = (empty($_POST["senha"]) ? "" : test_input($_POST["senha"]));
        $nome = (empty($_POST["nome"]) ? "" : test_input($_POST["nome"]));
        $endereco = (empty($_POST["endereco"]) ? "" : test_input($_POST["endereco"]));
        $telefone = (empty($_POST["telefone"]) ? "" : test_input($_POST["telefone"]));
        $cnpj = (empty($_POST["cnpj"]) ? "" : test_input($_POST["cnpj"]));
        $tiposExames = (empty($_POST["tiposExames"]) ? "" : test_input($_POST["tiposExames"])); //(empty($_POST["tipo_de_exame"]) ? "" : test_input($_POST["tipo_de_exame"]));
        $buscados = busca("laboratorio", array(array("email", $email), array("nome", $nome), array("email", $cnpj)), false);

        foreach ($buscados as $buscado) {
            if ((float)$buscado->registro != (float)$_SESSION["registro"]) {


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
        }
        if (!($nomeErr != "" || $emailErr != "" || $cnpjErr != "")) {
            $xml = simplexml_load_file("../../XMLs/laboratorios.xml");
            foreach ($xml as $lab) {

                //echo $xml[$i]->registro . " = " . $_SESSION["registro"] . "<br>";
                if ((float)$lab->registro == (float)$_SESSION["registro"]) {
                    $lab->nome = $nome;
                    $lab->email = $email;
                    $lab->senha = $senha;
                    $lab->telefone = $telefone;
                    $lab->endereco = $endereco;
                    $lab->cnpj = $cnpj;
                    $lab->tiposExames = $tiposExames;
                    break 1;
                }
            }
            $xml->saveXML("../../XMLs/laboratorios.xml");
            $_SESSION["email"] = $email;
            $_SESSION["senha"] = $senha;
            echo "<br>Dados Alterados<br>";
        }
    } else {
        $laboratorio = checkUser($_SESSION["email"], $_SESSION["senha"], $_SESSION["type"]);

        if ($laboratorio == false) {
            //redireciona pro login
        }
        $email = $laboratorio->email;
        $senha = $laboratorio->senha;
        $nome = $laboratorio->nome;
        $endereco = $laboratorio->endereco;
        $telefone = $laboratorio->telefone;
        $cnpj = $laboratorio->cnpj;
        $tiposExames = $laboratorio->tiposExames;
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>



    <h1>Cadastrar Exame </h1>
    <form method="post" id="editar_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Nome: <input type="text" name="nome" id="nome" required value="<?php echo $nome; ?>"><br>
        <span class="error"><?php echo $nomeErr; ?></span><br><br>
        Email: <input type="text" name="email" id="email" required value="<?php echo $email; ?>"><br>
        <span class="error"><?php echo $emailErr; ?></span><br><br>
        Endereco: <input type="text" name="endereco" id="endereco" required value="<?php echo $endereco; ?>"> <br><br>
        Telefone: <input type="text" name="telefone" id="telefone" required value="<?php echo $telefone; ?>"> <br><br>
        CNPJ: <input type="text" name="cnpj" id="cnpj" required value="<?php echo $cnpj; ?>"><br>
        <span class="error"><?php echo $cnpjErr; ?></span><br><br>
        Tipos de Exame: <input type="text" name="tiposExames" id="tiposExames" required value="<?php echo $tiposExames; ?>"> <br><br>
        Senha: <input type="password" name="senha" id="senha" required value="<?php echo $senha; ?>"> <br><br>

        <input type="submit" name="submit" value="Editar">
    </form>

</body>

</html>