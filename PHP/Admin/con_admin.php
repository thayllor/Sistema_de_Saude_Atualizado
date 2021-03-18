<?php
include_once('../conexao.php');

class Admin{

	private $conexao;
	
	function __construct(){
		$this->conexao = Conexao::conecta();
		
	}

	function __get($propriedade) {
		return $this->$propriedade;
	}

	function __set($propriedade, $valor) {
		$this->$propriedade = $valor;
	}

    public function salva_paciente($email,$senha,$nome,$endereco,$telefone,$cpf,$genero,$idade ){
		$rs= $this->conexao->prepare("SELECT * FROM pacientes WHERE (email = ? OR cpf = ? OR nome= ? ) ");
		$rs->bindParam(1, $email);
		$rs->bindParam(2, $cpf);
		$rs->bindParam(3, $nome);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		
		if($row->email== $email){
			return "email";
		}
		elseif($row->cpf== $cpf){
			return"cpf";
		}elseif($row->nome== $nome){
			return"nome";
		}
		else{
			$stmt = $this->conexao->prepare("INSERT INTO pacientes(email,senha,nome,endereco,telefone,cpf,genero,idade) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $email);
			$stmt->bindParam(2, $senha);
			$stmt->bindParam(3, $nome);
			$stmt->bindParam(4, $endereco);
			$stmt->bindParam(5, $telefone);
			$stmt->bindParam(6, $cpf);
			$stmt->bindParam(7, $genero);
			$stmt->bindParam(8, $idade);
			$stmt->execute();
			return"sucesso";
		}


	}

    public function salva_medico($email,$senha,$nome,$endereco,$especialidade,$telefone,$crm,$idade ){

		$rs= $this->conexao->prepare("SELECT * FROM medicos WHERE (email = ? OR crm = ? OR nome = ?) ");
		$rs->bindParam(1, $email);
		$rs->bindParam(2, $crm);
		$rs->bindParam(3, $nome);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		
		if($row->email== $email){
			return "email";
		}
		elseif($row->crm== $crm){
			return"crm";
		}elseif($row->nome== $nome){
			return"nome";
		}
		else{
			$stmt = $this->conexao->prepare("INSERT INTO medicos(email,senha,nome,endereco,especialidade,telefone,crm,idade) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $email);
			$stmt->bindParam(2, $senha);
			$stmt->bindParam(3, $nome);
			$stmt->bindParam(4, $endereco);
			$stmt->bindParam(5, $especialidade);
			$stmt->bindParam(6, $telefone);
			$stmt->bindParam(7, $crm);
			$stmt->bindParam(8, $idade);
			$stmt->execute();
			return"sucesso";
		}


	}

    public function salva_laboratorio($email,$senha,$nome,$endereco,$telefone,$cnpj,$tipos){

		
		$rs= $this->conexao->prepare("SELECT * FROM laboratorios WHERE (email = ? OR cnpj = ? OR nome= ?) ");
		$rs->bindParam(1, $email);
		$rs->bindParam(2, $cnpj);
		$rs->bindParam(3, $nome);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		
		if($row->email== $email){
			return "email";
		}
		elseif($row->cnpj== $cnpj){
			return"cnpj";
		}elseif($row->nome== $nome){
			return"nome";
		}
		else{
			$stmt = $this->conexao->prepare("INSERT INTO medicos(email,senha,nome,endereco,telefone,cnpj,tipos) VALUES(?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $email);
			$stmt->bindParam(2, $senha);
			$stmt->bindParam(3, $nome);
			$stmt->bindParam(4, $endereco);
			$stmt->bindParam(5, $telefone);
			$stmt->bindParam(6, $cnpj);
			$stmt->bindParam(7, $tipos);
			$stmt->execute();
			return"sucesso";
		}


	}
}
