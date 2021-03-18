<?php
include_once('../conexao.php');

class Lab{

	private $conexao;
    private $id;
    private $tipos;
	
	function __construct($email){
		$this->conexao = Conexao::conecta();
        $rs= $this->conexao->prepare("SELECT id,tipos FROM laboratorios WHERE email = ?  ");
        $rs->bindParam(1, $email);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
        $this->tipos = $row-> tipos;
        $this->id = $row-> id;
        
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
}
