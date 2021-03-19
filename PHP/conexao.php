<?php 
class Conexao {
	public static $con;
	//Cria um objeto PDO no padrão Singleton 
	public static function conecta(){
		if (!isset(self::$con)) {
			$host = 'localhost';
			$user = 'root';
			$pass = '';
			$db = 'planodesaude';
			try{
				self::$con = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
				self::$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				self::$con->exec('SET CHARSET utf8');
			}
			catch(Exception $e){
			echo $e->getMessage();
			}	
		}
		return self::$con;
	}   
}
?>



