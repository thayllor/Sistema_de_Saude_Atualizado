<?php
include_once('../conexao.php');

class Lab{

	private $conexao;
    private $id;
    private $tipos;
	private $email;
	private $senha;
	private $nome;
	private $endereco;
	private $telefone;
	private $cnpj;
	private $countExames;
	
	function __construct($email){
		$this->conexao = Conexao::conecta();
        $rs= $this->conexao->prepare("SELECT * FROM laboratorios WHERE email = ?  ");
        $rs->bindParam(1, $email);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		$this->id = $row-> id;
        $this->tipos = $row-> tipos;
		$this->email = $email;
		$this->senha = $row-> senha;
		$this->nome = $row-> nome;
		$this->endereco = $row-> endereco;
		$this->telefone = $row-> telefone;
		$this->cnpj = $row-> cnpj;
		$rs= $this->conexao->prepare("SELECT COUNT(*) FROM exames WHERE laboratorioID= ?  ");
        $rs->bindParam(1, $this->id);
		$rs->execute();
        $this->countExames= $rs->fetchColumn();
        
	}

	function __get($propriedade) {
		return $this->$propriedade;
	}

	function __set($propriedade, $valor) {
		$this->$propriedade = $valor;
	}

    public function salva_exame($tipo,$resultado,$data,$pacienteID){
		$rs= $this->conexao->prepare("SELECT * FROM exames WHERE (tipo = ? OR resultado = ? OR data = ? OR pacienteID = ?) ");
		$rs->bindParam(1, $tipo);
		$rs->bindParam(2, $resultado);
        $rs->bindParam(3, $data);
        $rs->bindParam(4, $pacienteID);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		if(($row->tipo== $tipo)&&($row->resultado== $resultado)&&($row->data== $data)&&($row->pacienteID== $pacienteID)){

			return "existente";
		}
		else{
			$stmt = $this->conexao->prepare("INSERT INTO exames(laboratorioID,pacienteID,tipo,resultado,data) VALUES(?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $this->id);
			$stmt->bindParam(2, $pacienteID);
			$stmt->bindParam(3, $tipo);
			$stmt->bindParam(4, $resultado);
			$stmt->bindParam(5, $data);
			$stmt->execute();
			return"sucesso";
		}
	}

    public function pacientes(){
		$rs= $this->conexao->prepare("SELECT nome,id FROM pacientes ");
		$rs->execute();
		$row=$rs->fetchAll(PDO::FETCH_OBJ);
		return $row;
	}

	public function editar($email,$senha,$nome,$endereco,$telefone,$cnpj,$tipos){
		
		$rs= $this->conexao->prepare("SELECT * FROM laboratorios WHERE ((email = ? OR nome = ? OR cnpj = ?) AND ( id <> ? )) ");
		$rs->bindParam(1, $email);
		$rs->bindParam(2, $nome);
		$rs->bindParam(3, $cnpj);
		$rs->bindParam(4, $this->id);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
		if($row->email== $email){
			return"email";

		}elseif($row->nome== $nome){
			return"nome";

		}elseif($row->cnpj== $cnpj){
			return"cnpj";

		}else{
			$rs= $this->conexao->prepare("UPDATE laboratorios SET email = ?, senha = ?, nome = ?, endereco = ?, telefone = ?, cnpj = ?, tipos = ? WHERE id = ?");
			$rs->bindParam(1, $email);
			$rs->bindParam(2, $senha);
			$rs->bindParam(3, $nome);
			$rs->bindParam(4, $endereco);
			$rs->bindParam(5, $telefone);
			$rs->bindParam(6, $cnpj);
			$rs->bindParam(7, $tipos);
			$rs->bindParam(8, $this-> id);
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
}

