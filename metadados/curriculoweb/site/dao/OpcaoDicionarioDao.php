<?php
class OpcaoDicionarioDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarOpcoesPorCampo($campo) {
		
		$sql = "SELECT * FROM rhopcoesdicionario WHERE CampoTabela = ?";
		
		$query = $this->db->prepare($sql);
		$pCampo = preg_replace('#[^\pL\pN./\' -]+# ', '', $campo);	
		
		return $this->db->Execute($query,$pCampo);
	}
	
	private function prepareStatement(OpcaoDicionario $opcoesDicionario) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($opcoesDicionario->CampoTabela)){
                $columns[$c++] = "CampoTabela";
                $values[$v++] = "'" . $opcoesDicionario->CampoTabela . "'";
        }
        
        if (!is_null($opcoesDicionario->Opcao)){
                $columns[$c++] = "Opcao";
                $values[$v++] = "'" . $opcoesDicionario->Opcao . "'";
        }

        if (!is_null($opcoesDicionario->TamanhoDescricao)){
                $columns[$c++] = "TamanhoDescricao";
                $values[$v++] = "'" . $opcoesDicionario->TamanhoDescricao . "'";
        }

        if (!is_null($opcoesDicionario->Descricao60)){
                $columns[$c++] = "Descricao60";
                $values[$v++] = "'" . $opcoesDicionario->Descricao60 . "'";
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
   function criarOpcoesDicionario(OpcaoDicionario $opcoesdicionario) {
		$statement = $this->prepareStatement($opcoesdicionario);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhopcoesdicionario(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        
        return $this->db->Execute($sql);
	}
	
	function excluirOpcoesDicionario() {
		$sql = "delete from rhopcoesdicionario ";
		return $this->db->Execute($sql);
	}

	
}

?>