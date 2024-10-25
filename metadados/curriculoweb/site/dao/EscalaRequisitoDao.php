<?php

class EscalaRequisitoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarItensEscalaRequisitoPorPk($Avaliacao) {
		$sql = "SELECT  rhescalarequisitos.Avaliacao, rhescalareqitens.Item_Avaliacao, rhescalareqitens.Descricao15  ";
		$sql .= " FROM rhescalarequisitos ";
		$sql .= " INNER JOIN rhescalareqitens ON (rhescalarequisitos.Avaliacao = rhescalareqitens.Avaliacao) ";
		$sql .= " WHERE rhescalarequisitos.Avaliacao = ?";
		
		$query = $this->db->prepare($sql);
		
		$pAvaliacao =  preg_replace('#[^\pL\pN./\' -]+# ', '', $Avaliacao);
		
		return $this->db->Execute($query,$pAvaliacao);
	}
	
	private function prepareStatement(EscalaRequisito $escalasAvaliacao) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($escalasAvaliacao->Avaliacao)){
                $columns[$c++] = "Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($escalasAvaliacao->Avaliacao));
        }
        
        if (!is_null($escalasAvaliacao->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($escalasAvaliacao->Descricao40));
        }
        if (!is_null($escalasAvaliacao->ItemAvaliacao)){
                $columns[$c++] = "Item_Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($escalasAvaliacao->ItemAvaliacao));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;
        
        return $statement;
	}
	
    function criarEscalaRequisito(EscalaRequisito $escalasavaliacao) {
		$statement = $this->prepareStatement($escalasavaliacao);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhescalarequisitos(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }
	function excluirEscalaRequisito() {
		$sql = "delete from rhescalarequisitos ";
		return $this->db->Execute($sql);
	}
	
	
}
?>