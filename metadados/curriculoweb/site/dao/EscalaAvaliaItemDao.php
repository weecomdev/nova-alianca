<?php

class EscalaAvaliaItemDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	private function prepareStatement(EscalaAvaliaItem $escalaavaliaitem) {
		$statement = array();
		$c = 0;
		$v = 0;
		
		if (!is_null($escalaavaliaitem->Avaliacao)){ 
		
                $columns[$c++] = "Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($escalaavaliaitem->Avaliacao));
        }
        
		if (!is_null($escalaavaliaitem->ItemAvaliacao)){
		        $columns[$c++] = "Item_Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($escalaavaliaitem->ItemAvaliacao));
		}
		
		if (!is_null($escalaavaliaitem->Descricao15)){
		        $columns[$c++] = "Descricao15";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($escalaavaliaitem->Descricao15));
		}
		if (!is_null($escalaavaliaitem->Peso)){
		        $columns[$c++] = "Peso";
				$values[$v++] = preg_replace('/[^\p{L}\'0-9\-., ]/u', '', $this->db->qstr($escalaavaliaitem->Peso));
		}
		
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	
	function criarEscalasAvaliaItem(EscalaAvaliaItem $escalaavaliaitem) {
		
		$statement = $this->prepareStatement($escalaavaliaitem);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhescalasavaliaitens(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}

function excluirEscalasAvaliaItens() {
		$sql = "delete from rhescalasavaliaitens ";
		return $this->db->Execute($sql);
	}
}

?>