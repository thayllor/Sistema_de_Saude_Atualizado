<!DOCTYPE HTML>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>

    <?php
    include "../PHP/functions.php";
    print_r(busca("paciente", array(array('email', "x"), array('senha', "y"))));
    ?>

</body>

</html>