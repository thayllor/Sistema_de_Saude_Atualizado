<?php
include_once('../conexao.php');

class Pac{

	private $conexao;
    private $id;
	private $email;
	private $senha;
	private $nome;
	private $endereco;
	private $telefone;
	private $cpf;
    private $genero;
    private $idade;
    private $countExames;
    private $countConsultas;
	function __construct($email){
		$this->conexao = Conexao::conecta();
        $rs= $this->conexao->prepare("SELECT * FROM pacientes WHERE email = ?  ");
        $rs->bindParam(1, $email);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		$this->id = $row-> id;
		$this->email = $email;
		$this->senha = $row-> senha;
		$this->nome = $row-> nome;
		$this->endereco = $row-> endereco;
		$this->telefone = $row-> telefone;
		$this->cpf = $row-> cpf;
        $this->genero = $row-> genero;
        $this->idade = $row-> idade;
        $rs= $this->conexao->prepare("SELECT COUNT(*) FROM exames WHERE pacienteID= ?  ");
        $rs->bindParam(1, $this->id);
		$rs->execute();
        $this->countExames= $rs->fetchColumn();
        $rs= $this->conexao->prepare("SELECT COUNT(*) FROM consultas WHERE pacienteID= ?  ");
        $rs->bindParam(1, $this->id);
		$rs->execute();
        $this->countConsultas= $rs->fetchColumn();
	}

	function __get($propriedade) {
		return $this->$propriedade;
	}

	function __set($propriedade, $valor) {
		$this->$propriedade = $valor;
	}

	public function editar($email,$senha,$nome,$endereco,$telefone,$cpf,$genero,$idade){
		
		$rs= $this->conexao->prepare("SELECT * FROM pacientes WHERE ((email = ? OR nome = ? OR cpf = ?) AND ( id <> ? )); ");
		$rs->bindParam(1, $email);
		$rs->bindParam(2, $nome);
		$rs->bindParam(3, $cpf);
		$rs->bindParam(4, $this->id);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		if($row->email== $email){
			return"email";

		}elseif($row->nome== $nome){
			return"nome";

		}elseif($row->cpf== $cpf){
			return"cpf";

		}else{
			$rs= $this->conexao->prepare("UPDATE pacientes SET email = ?, senha = ?, nome = ?, endereco = ?, telefone = ?, cpf = ?, genero = ?, idade = ? WHERE id = ?");
			$rs->bindParam(1, $email);
			$rs->bindParam(2, $senha);
			$rs->bindParam(3, $nome);
			$rs->bindParam(4, $endereco);
			$rs->bindParam(5, $telefone);
			$rs->bindParam(6, $cpf);
			$rs->bindParam(7, $genero);
            $rs->bindParam(8, $idade);
			$rs->bindParam(9, $this-> id);
			$rs->execute();
			return"sucesso";
		}
		
	}

	public function historico($pacienteID){
		$rs= $this->conexao->prepare("SELECT * FROM exames WHERE (pacienteID = ? AND laboratorioID = ?) ");
		$rs->bindParam(1, $pacienteID);
		$rs->bindParam(2, $this->id);
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;
	}

    public function exames($laboratorioID){
        $rs= $this->conexao->prepare("SELECT * FROM exames WHERE (pacienteID = ? AND laboratorioID = ?) ");
		$rs->bindParam(1, $this->id);
		$rs->bindParam(2, $laboratorioID);
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;

    }

    public function consultas($medicoID){
        $rs= $this->conexao->prepare("SELECT * FROM consultas WHERE (pacienteID = ? AND medicoID = ?) ");
		$rs->bindParam(1, $this->id);
		$rs->bindParam(2, $medicoID);
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;

    }

    public function medicos(){
        $rs= $this->conexao->prepare("SELECT nome,id FROM medicos ");
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;

    }
    public function laboratorios(){
        $rs= $this->conexao->prepare("SELECT nome,id FROM laboratorios ");
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;
    }
}

