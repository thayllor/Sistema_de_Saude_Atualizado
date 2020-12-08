<?php
function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}

function clearString($string)
{
    $string = join("", explode(".", $string));
    $string = join("", explode(",", $string));
    $string = join("", explode("/", $string));
    $string = join("", explode("-", $string));
    $string = join("", explode(" ", $string));
    $string = join("", explode("(", $string));
    $string = join("", explode(")", $string));
    return $string;
}

function checkUser($email, $senha, $type, $distanciaRaiz = "../../")
{
    $xml = simplexml_load_file($distanciaRaiz . "XMLs/" . $type . "s.xml");
    foreach ($xml->children() as $data) {
        if ($data->email == $email && $data->senha == $senha) {
            return $data;
        }
    }
    return false;
}

function busca($type, $filtros, $and = true, $distanciaRaiz = "../../")
{
    //pega os dados do xml
    $xml = simplexml_load_file($distanciaRaiz . "XMLs/" . $type . "s.xml");
    //variavel que contem o resultado da busca
    $found = array();
    //percorre os dados do xml
    foreach ($xml->children() as $data) {
        $count = 0;
        foreach ($data->children() as $field) {


            foreach ($filtros as $filtro) {
                if ($field->getName() == $filtro[0] && $field == $filtro[1]) {
                    $count++;
                }
            }
        }
        if ($count == count($filtros) && $and) {
            array_push($found, $data);
        } elseif ($count > 0) {
            array_push($found, $data);
        }
    }
    return $found;
}
