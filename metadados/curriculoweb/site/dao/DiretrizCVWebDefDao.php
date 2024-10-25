<?php
class DiretrizCVWebDefDao{
	
	private $db;
	private $ListaQuery;
	function __construct($db = NULL) {
		$this->db = $db;
	}
	private function prepareStatement(DiretrizCVWebDef $diretrizCVWebDef) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($diretrizCVWebDef->DiretrizWeb)){
                $columns[$c++] = "DiretrizWeb";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($diretrizCVWebDef->DiretrizWeb));  				
        }
		
        if (!is_null($diretrizCVWebDef->Descricao80)){
                $columns[$c++] = "Descricao80";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($diretrizCVWebDef->Descricao80)); 				
        }
        
		if (!is_null($diretrizCVWebDef->TipoDiretrizWeb)){
                $columns[$c++] = "TipoDiretrizWeb";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($diretrizCVWebDef->TipoDiretrizWeb)); 
        }        
	        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarDiretrizCVWebDef(DiretrizCVWebDef $diretrizCVWebDef) {
		$statement = $this->prepareStatement($diretrizCVWebDef);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhdiretrizescvwebdef(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirDiretrizCVWebDef() {
		$sql = "delete from rhdiretrizescvwebdef ";
		return $this->db->Execute($sql);
	}
}
?>