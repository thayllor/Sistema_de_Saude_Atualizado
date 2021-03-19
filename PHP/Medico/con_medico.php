<?php
include_once('../conexao.php');

class Medico{

    private $conexao;
    private $id;
	private $email;
	private $senha;
	private $nome; 
	private $endereco;
	private $telefone;
	private $especialidade;
	private $crm;
	private $idade; 
	private $countConsultas;

	function __construct($email){
		$this->conexao = Conexao::conecta();
        $rs= $this->conexao->prepare("SELECT * FROM medicos WHERE email = ?  ");
        $rs->bindParam(1, $email);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		$this->id = $row-> id;
		$this->email = $email;
		$this->senha = $row-> senha;
		$this->nome = $row-> nome;
		$this->endereco = $row-> endereco;
		$this->telefone = $row-> telefone;
		$this->especialidade = $row-> especialidade;
		$this->crm = $row-> crm;
        $this->idade = $row-> idade;
        $rs= $this->conexao->prepare("SELECT COUNT(*) FROM consultas WHERE medicoID= ?  ");
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

    public function salva_consulta($data,$pacienteID,$receita,$observacao){
		$rs= $this->conexao->prepare("SELECT * FROM consultas WHERE (data = ? OR medicoID = ? OR pacienteID = ? OR receita = ? OR observação = ?)");
		$rs->bindParam(1, $data);
		$rs->bindParam(2, $this->id);
        $rs->bindParam(3, $pacienteID);
        $rs->bindParam(4, $receita);
        $rs->bindParam(5, $observacao);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		if(($row->data== $data)&&($row->medicoID== $this->id)&&($row->pacienteID== $pacienteID)&&($row->receita== $receita)&&($row->observação== $observacao)){
			return "existente";
		}
		else{
			$rs = $this->conexao->prepare("INSERT INTO consultas(data,medicoID,pacienteID,receita,observação) VALUES(?, ?, ?, ?, ?)");
            $rs->bindParam(1, $data);
            $rs->bindParam(2, $this->id);
            $rs->bindParam(3, $pacienteID);
            $rs->bindParam(4, $receita);
            $rs->bindParam(5, $observacao);
			$rs->execute();
			return"sucesso";
		}
	}

	public function editar($email,$senha,$nome,$endereco,$especialidade,$telefone,$crm,$idade ){
		$rs= $this->conexao->prepare("SELECT * FROM medicos WHERE ((email = ? OR nome = ? OR crm = ?) AND ( id <> ? ))  ");
		$rs->bindParam(1, $email);
		$rs->bindParam(2, $nome);
		$rs->bindParam(3, $crm);
		$rs->bindParam(4, $this->id);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		if($row->email== $email){
			return"email";
		

		}elseif($row->nome== $nome){
			return"nome";

		}elseif($row->crm== $crm){
			return"crm";

		}else{

			$rs= $this->conexao->prepare("UPDATE medicos SET email = ?, senha = ?, nome = ?, endereco = ?, especialidade =?, telefone = ?, crm = ?, idade = ? WHERE id = ?");
			$rs->bindParam(1, $email);
			$rs->bindParam(2, $senha);
			$rs->bindParam(3, $nome);
			$rs->bindParam(4, $endereco);
			$rs->bindParam(5, $especialidade);
			$rs->bindParam(6, $telefone);
			$rs->bindParam(7, $crm);
			$rs->bindParam(8, $idade);
			$rs->bindParam(9, $this-> id);
			$rs->execute();
			return"sucesso";
		}
		
	}

    public function pacientes(){
		$rs= $this->conexao->prepare("SELECT nome,id FROM pacientes ");
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;
	}

	public function historico($pacienteID){
		$rs= $this->conexao->prepare("SELECT * FROM consultas WHERE (pacienteID = ? AND medicoID = ?) ");
		$rs->bindParam(1, $pacienteID);
		$rs->bindParam(2, $this->id);
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;
	}
}
