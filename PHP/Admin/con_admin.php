<?php
include_once('conexao.php');

class Admin{

	private $nome;
	private $email;
	private $senha;
	private $conexao;
	
	function __construct(){
		$this->conexao = Conexao::conexao();
	}

	function __get($propriedade) {
		return $this->$propriedade;
	}

	function __set($propriedade, $valor) {
		$this->$propriedade = $valor;
	}

	public function salvar(){

		$stmt = $this->conexao->prepare("INSERT INTO admin(email, senha, nome) VALUES(?, ?, ?)");

		$stmt->bindParam(1, $this->email);
		$stmt->bindParam(2, $this->senha);
		$stmt->bindParam(3, $this->nome);

		$stmt->execute();
		$this->id = $this->conexao->lastInsertId();

	}

    public function salva_paciente($email,$senha,$nome,$endereco,$telefone,$cpf,$genero,$idade ){

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
		$this->id = $this->conexao->lastInsertId();

	}

    public function salva_medico($email,$senha,$nome,$endereco,$especialidade,$telefone,$crm,$idade ){

		$stmt = $this->conexao->prepare("INSERT INTO medicos(email,senha,nome,endereco,telefone,crm,idade,especialidade) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");

		$stmt->bindParam(1, $email);
		$stmt->bindParam(2, $senha);
		$stmt->bindParam(3, $nome);
        $stmt->bindParam(4, $endereco);
		$stmt->bindParam(5, $telefone);
		$stmt->bindParam(6, $crm);
        $stmt->bindParam(7, $idade);
		$stmt->bindParam(8, $especialidade);

		$stmt->execute();
		$this->id = $this->conexao->lastInsertId();

	}

    public function salva_laboratorio($email,$senha,$nome,$endereco,$telefone,$cnpj,$tipos){

		$stmt = $this->conexao->prepare("INSERT INTO laboratorios(email,senha,nome,endereco,telefone,cnpj,tipos) VALUES(?, ?, ?, ?, ?, ?, ?)");

		$stmt->bindParam(1, $email);
		$stmt->bindParam(2, $senha);
		$stmt->bindParam(3, $nome);
        $stmt->bindParam(4, $endereco);
		$stmt->bindParam(5, $telefone);
		$stmt->bindParam(6, $cnpj);
		$stmt->bindParam(7, $tipos);

		$stmt->execute();
		$this->id = $this->conexao->lastInsertId();

	}
}
