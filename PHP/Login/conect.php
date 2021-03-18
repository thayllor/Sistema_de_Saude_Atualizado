<?php
include_once('../conexao.php');

class User{

	private $email;
	private $senha;
	private $verificado;
	private $conexao;
	
	function __construct(){
		$this->conexao = Conexao::conecta();
		$this->verificado=false;
	}

	function __get($propriedade) {
		return $this->$propriedade;
	}

	function __set($propriedade, $valor) {
		$this->$propriedade = $valor;
	}

    public function verifica_admin(){
		$rs = $this->conexao->prepare("SELECT * FROM admins WHERE email = ?");
		$rs->bindParam(1, $this->email);
		$rs->execute();
		$row = $rs->fetch(PDO::FETCH_OBJ);
		if($row==false){
			return "email não cadastrado";

		}
		else{
			if($this->senha==$row->senha){
				
				$this->senha = $row->senha;
				$this->email = $row->email;
				$this->verificado = true;
				return"senha correta ";
			}
			else{
				return "senha errada ";
			}
		}
		return null;
	}
    public function verifica_paciente(){

		$rs = $this->conexao->prepare("SELECT * FROM pacientes WHERE email = ?");
		$rs->bindParam(1, $this->email);
		$rs->execute();
		$row = $rs->fetch(PDO::FETCH_OBJ);
		if($row==false){
			return "email não cadastrado";

		}
		else{
			if($this->senha==$row->senha){
				
				$this->senha = $row->senha;
				$this->email = $row->email;
				$this->verificado = true;
				return"senha correta ";
			}
			else{
				return "senha errada ";
			}
		}
		return null;

	}
    public function verifica_laboratorios(){

		$rs = $this->conexao->prepare("SELECT * FROM laboratorios WHERE email = ?");
		$rs->bindParam(1, $this->email);
		$rs->execute();
		$row = $rs->fetch(PDO::FETCH_OBJ);
		if($row==false){
			return "email não cadastrado";

		}
		else{
			if($this->senha==$row->senha){
				
				$this->senha = $row->senha;
				$this->email = $row->email;
				$this->verificado = true;
				return"senha correta ";
			}
			else{
				return "senha errada ";
			}
		}
		return null;
	}
    public function verifica_medicos(){

		$rs = $this->conexao->prepare("SELECT * FROM medicos WHERE email = ?");
		$rs->bindParam(1, $this->email);
		$rs->execute();
		$row = $rs->fetch(PDO::FETCH_OBJ);
		if($row==false){
			return "email não cadastrado";

		}
		else{
			if($this->senha==$row->senha){
				
				$this->senha = $row->senha;
				$this->email = $row->email;
				$this->verificado = true;
				return"senha correta ";
			}
			else{
				return "senha errada ";
			}
		}
		return null;
	}
}
