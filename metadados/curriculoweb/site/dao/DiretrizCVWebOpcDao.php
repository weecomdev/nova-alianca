<?php
class DiretrizCVWebOpcDao{
	
	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	private function prepareStatement(DiretrizCVWebOpc $diretrizCVWebOpc) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($diretrizCVWebOpc->DiretrizWeb)){
                $columns[$c++] = "DiretrizWeb";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($diretrizCVWebOpc->DiretrizWeb)); 	
        }
        
		if (!is_null($diretrizCVWebOpc->NroOrdem)){
                $columns[$c++] = "NroOrdem";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($diretrizCVWebOpc->NroOrdem)); 	
        }
        
		if (!is_null($diretrizCVWebOpc->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($diretrizCVWebOpc->Descricao40));
        }
        	        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarDiretrizCVWebOpc(DiretrizCVWebOpc $diretrizCVWebOpc) {
		$statement = $this->prepareStatement($diretrizCVWebOpc);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhdiretrizescvwebopc(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirDiretrizCVWebOpc() {
		$sql = "delete from rhdiretrizescvwebopc ";
		return $this->db->Execute($sql);
	}	
}
?>