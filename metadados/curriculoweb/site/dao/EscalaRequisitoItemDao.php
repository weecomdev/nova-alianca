<?php

class EscalaRequisitoItemDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	private function prepareStatement(EscalaRequisitoItem $escalarequisitoitem) {
		$statement = array();
		$c = 0;
		$v = 0;
		
		if (!is_null($escalarequisitoitem->Avaliacao)){
                $columns[$c++] = "Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($escalarequisitoitem->Avaliacao));
        }
        
		if (!is_null($escalarequisitoitem->ItemAvaliacao)){
		        $columns[$c++] = "Item_Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($escalarequisitoitem->ItemAvaliacao));
		}
		
		if (!is_null($escalarequisitoitem->Descricao15)){
		        $columns[$c++] = "Descricao15";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($escalarequisitoitem->Descricao15));
		}
				
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	
	function criarEscalaRequisitoItem(EscalaRequisitoItem $escalarequisitoitem) {
		
		$statement = $this->prepareStatement($escalarequisitoitem);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhescalareqitens(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	function excluirEscalaRequisitoItem() {
		$sql = "delete from rhescalareqitens ";
		return $this->db->Execute($sql);
	}
}

?>