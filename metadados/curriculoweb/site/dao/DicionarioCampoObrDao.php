<?php
class DicionarioCampoObrDao{
	
	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	public function buscaCamposObrigatorios($where="") {
		$sql = "select rhdicionariocampoobr.IdCampoObr, rhdicionariocampoobr.Tabela, rhdicionariocampoobr.CampoTabela, rhdicionariocampoobr.Descricao60 from rhdicionariocampoobr
		inner join rhcamposwebobr on
		 rhdicionariocampoobr.IdCampoObr = rhcamposwebobr.IdCampoObr ";
		if($where != ""){
			$sql .= " where ".$where;	
		}
		$sql .= " Order by Tabela, CampoTabela ";
		return $this->db->Execute($sql);
	}
	private function prepareStatement(DicionarioCampoObr $campoObr) {
        $statement = array();
        $c = 0;
        $v = 0;
       
        if (!is_null($campoObr->IdCampoObr)){
                $columns[$c++] = "IdCampoObr";
                $values[$v++] =  preg_replace('#[^\pL\pN./\':@_ -]+# ', '', $this->db->qstr($campoObr->IdCampoObr));				
        }
	    if (!is_null($campoObr->Tabela)){
                $columns[$c++] = "Tabela";
				$values[$v++] =  preg_replace('#[^\pL\pN./\':@_ -]+# ', '', $this->db->qstr($campoObr->Tabela));
        }

	    if (!is_null($campoObr->CampoTabela)){
                $columns[$c++] = "CampoTabela";
			    $values[$v++] =  preg_replace('#[^\pL\pN./\':@_ -]+# ', '', $this->db->qstr($campoObr->CampoTabela));    
        }
        
	    if (!is_null($campoObr->Descricao60)){
                $columns[$c++] = "Descricao60";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($campoObr->Descricao60));       
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarDicionarioCampoObr(DicionarioCampoObr $campoObr) {
		$statement = $this->prepareStatement($campoObr);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhdicionariocampoobr(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirDicionarioCampoObr() {
		$sql = "delete from rhdicionariocampoobr ";
		return $this->db->Execute($sql);
	}
	
}
?>