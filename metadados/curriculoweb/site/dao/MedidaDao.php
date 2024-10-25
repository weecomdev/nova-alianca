<?php

class MedidaDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	private function prepareStatement(Medida $medida) {
		$statement = array();
		$c = 0;
		$v = 0;
		
		if (!is_null($medida->Medida)){
		        $columns[$c++] = "Medida";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($medida->Medida));
		}
		
		if (!is_null($medida->Descricao40)){
		        $columns[$c++] = "Descricao40";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($medida->Descricao40));
		}
		if (!is_null($medida->NroDecimais)){
		        $columns[$c++] = "NroDecimais";
		        if($medida->NroDecimais==""){
		        	$values[$v++] = "null";
		        }else{
					$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($medida->NroDecimais));
		        }
		}
		
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	
	function criarMedida(Medida $medida) {
		
		$statement = $this->prepareStatement($medida);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhmedidas(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}


	function excluirMedida() {
		$sql = "delete from rhmedidas ";
		return $this->db->Execute($sql);
	}
}

?>