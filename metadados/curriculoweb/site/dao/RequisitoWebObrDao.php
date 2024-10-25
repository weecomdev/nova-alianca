<?php
class RequisitoWebObrDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	
	function buscarRequisitoObr() {		
		$sql = "SELECT  rhrequisitoswebobr.Requisito, rhrequisitos.Descricao80 FROM rhrequisitoswebobr "; 
		$sql .= " inner join rhrequisitos on rhrequisitoswebobr.Requisito = rhrequisitos.Requisito ";
				
	    return $this->db->Execute($sql);		
	}
		
	
	private function prepareStatement(RequisitoWebObr $requisitoObr) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($requisitoObr->Empresa)){
                $columns[$c++] = "Empresa";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($requisitoObr->Empresa)); 
        }       
        
        if (!is_null($requisitoObr->Requisito)){
                $columns[$c++] = "Requisito";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisitoObr->Requisito)); 
        }

        $statement[0] = $columns;
        $statement[1] = $values;
        
        return $statement;
   }
   
   function criarRequisitoWebObr(RequisitoWebObr $requisitoObr) {
		$statement = $this->prepareStatement($requisitoObr);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhrequisitoswebobr(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
	}
	
	function excluirRequisitoWebObr() {
		$sql = "delete from rhrequisitoswebobr ";
		return $this->db->Execute($sql);
	}
	
}
?>