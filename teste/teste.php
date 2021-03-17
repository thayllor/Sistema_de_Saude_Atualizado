<?php
class ConectaBanco{
    public static $con;
    public static function conexao(){
        if(!isset(self::$con)){
            $host= 'localhost';
            $user= 'root';
            $pass= '';
            $db= 'planodesaude';

            try{
                self::$con= new PDO("postegre:host=$host:dbname=$db",$user,$pass);
                self::$con->exec("SET CHARSET utf8");
            }
        }
    }


}
?>