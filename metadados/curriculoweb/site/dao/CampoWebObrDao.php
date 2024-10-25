<?php
class CampoWebObrDao{
	
	private $db;
	private $ListaQuery;
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	
	function buscarCamposObr( $tabela = null, $where="") {		
		$sql = "Select rhdicionariocampoobr.CampoTabela, rhdicionariocampoobr.Descricao60 From rhdicionariocampoobr ";
		$sql .= " Inner Join rhcamposwebobr On  rhdicionariocampoobr.IDCAMPOOBR = rhcamposwebobr.IDCAMPOOBR "; 
		$sql .= " Where 1 = 1 ";
		
		if (!is_null($tabela)){
			$sql .= " AND  rhdicionariocampoobr.Tabela = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($tabela)); 	
		}			
		if($where != "")
			$sql .= " And ".$where;
		$query = $this->db->prepare($sql);
					
	    return $this->db->Execute($query);		
	}
	
	private function prepareStatement( CampoWebObr $campoObr) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($campoObr->Empresa)){
                $columns[$c++] = "Empresa";		
                $values[$v++]  =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($campoObr->Empresa));     
        }
        
        if (!is_null($campoObr->IdCampoObr)){
			
                $columns[$c++] = "IdCampoObr";
                $values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($campoObr->IdCampoObr));
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarCampoWebObr(CampoWebObr $campoObr) {
		$statement = $this->prepareStatement($campoObr);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhcamposwebobr(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirCampoWebObr() {
		$sql = "delete from rhcamposwebobr ";
		return $this->db->Execute($sql);
	}
	
}
?>