<?php
class DiagnosticosDao{
	
	private $db;
	private $ListaQuery;
	
	function __construct($db = null){
		$this->db = $db;
	}
	
	private function prepareStatement(Diagnostico $diagnostico){
		$statement = array();
		$c = 0;
		$v = 0;
		
		if (!is_null($diagnostico->Id)) {
			$colums[$c++] = "Id";
            $values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'', $this->db->qstr($diagnostico->Id));
		}
		if (!is_null($diagnostico->Log)) {
			$colums[$c++] = "Log";
			$values[$v++] =  $this->db->qstr($diagnostico->Log);
		
		}
		if (!is_null($diagnostico->Tipo)){
			$colums[$c++] = "Tipo";
			$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($diagnostico->Tipo));
		}
		
		$statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarDiagnostico(Diagnostico $diagnostico) {		
		$statement = $this->prepareStatement($diagnostico);
	
		$columns = $statement[0];
		$values = $statement[1];
	
		$sql = "INSERT IGNORE INTO rhdiagnosticos(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
	
		
		return $this->db->Execute($sql);
	}
	
	
	function ultimoId(){
		
		$sql = "select Max(Id) I from rhdiagnosticos";
		$executar = $this->db->Execute($sql); 
		return $executar->fields['I'];
	}
	
	function buscarCamposDiagnostico() {

		$sql = "Select * from rhdiagnosticos";
	
		return $this->db->Execute($sql);
	}	
	
	function excluiDiagnosticos(){
		
		$sql = "delete from rhdiagnosticos ";
		
		return  $this->db->Execute($sql);
	}
	
	function configuracaoMySqlEspecifica($information){
		$sql = "SHOW VARIABLES LIKE ?";
		$query = $this->db->prepare($sql);
		return $this->db->Execute($query,$information);          
	}
	
	function configuracaoMySql(){
	
		$sql = "SHOW VARIABLES";
	
		return $this->db->Execute($sql);
	}
		
} 
?>
