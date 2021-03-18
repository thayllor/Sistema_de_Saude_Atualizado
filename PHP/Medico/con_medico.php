<?php
include_once('../conexao.php');

class Medico{

    private $conexao;
    private $id;

	function __construct($email){
		$this->conexao = Conexao::conecta();
        $rs= $this->conexao->prepare("SELECT id FROM laboratorios WHERE email = ?  ");
        $rs->bindParam(1, $email);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);
        $this->id = $row-> id;
        
	}

	function __get($propriedade) {
		return $this->$propriedade;
	}

	function __set($propriedade, $valor) {
		$this->$propriedade = $valor;
	}

    public function salva_consulta($data,$medicoID,$pacienteID,$receita,$observacao){
		$rs= $this->conexao->prepare("SELECT * FROM consulta WHERE (data = ? OR medicoID = ? OR pacienteID = ? OR receita = ? OR observacao = ?)");
		$rs->bindParam(1, $data);
		$rs->bindParam(2, $medicoID);
        $rs->bindParam(3, $pacienteID);
        $rs->bindParam(4, $receita);
        $rs->bindParam(5, $observacao);
		$rs->execute();
		$row=$rs->fetch(PDO::FETCH_OBJ);

		if(($row->data== $data)&&($row->medicoID== $medicoID)&&($row->pacienteID== $pacienteID)&&($row->receita== $receita)&&($row->observacao== $observacao)){

			return "existente";
		}
		else{
			$stmt = $this->conexao->prepare("INSERT INTO consulta(data,medicoID,pacienteID,receita,observacao) VALUES(?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $this->id);
            $rs->bindParam(1, $data);
            $rs->bindParam(2, $medicoID);
            $rs->bindParam(3, $pacienteID);
            $rs->bindParam(4, $receita);
            $rs->bindParam(5, $observacao);
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
