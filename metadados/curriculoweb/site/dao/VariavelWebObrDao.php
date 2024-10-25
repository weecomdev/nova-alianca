<?php
class VariavelWebObrDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarVariavelObr() {		
		$sql = "SELECT  rhvariaveiswebobr.Variavel, rhvariaveis.Descricao80, rhvariaveis.CampoTabelaFutura FROM rhvariaveiswebobr ";
		$sql .= " inner join rhvariaveis on rhvariaveiswebobr.variavel = rhvariaveis.variavel ";
	    return $this->db->Execute($sql);		
	}
	
	
	private function prepareStatement(VariavelWebObr $variavelObr) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($variavelObr->Empresa)){
                $columns[$c++] = "Empresa";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($variavelObr->Empresa));     
        }
        
        if (!is_null($variavelObr->Variavel)){
                $columns[$c++] = "Variavel";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavelObr->Variavel));     
        }    

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarVariavelObr(VariavelWebObr $variavelObr) {
		$statement = $this->prepareStatement($variavelObr);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhvariaveiswebobr(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirVariavelObr() {
		$sql = "delete from rhvariaveiswebobr ";
		return $this->db->Execute($sql);
	}
	
}
?>