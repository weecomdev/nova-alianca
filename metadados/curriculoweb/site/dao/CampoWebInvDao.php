<?php
class CampoWebInvDao{
	
	private $db;
	private $ListaQuery;
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	
	function buscarCamposInv( $tabela = null, $where="") {		
		$sql = "Select rhdicionariocampoobr.CampoTabela, rhdicionariocampoobr.Descricao60 From rhdicionariocampoobr ";
		$sql .= " Inner Join rhcamposwebinv On  rhdicionariocampoobr.IDCAMPOOBR = rhcamposwebinv.IDCAMPOINV "; 
		$sql .= " Where 1 = 1 ";
		
		if (!is_null($tabela)){
			$sql .= " AND  rhdicionariocampoobr.Tabela =".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($tabela)); 	
		}			
		if($where != "")
			$sql .= " And ".$where;
		$query = $this->db->prepare($sql);

					
	    return $this->db->Execute($query);		
	}
	
	private function prepareStatement(CampoWebInv $campoInv) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($campoInv->Empresa)){
                $columns[$c++] = "Empresa";		
                $values[$v++]  =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($campoInv->Empresa));     
        }
        
        if (!is_null($campoInv->IdCampoInv)){
			
                $columns[$c++] = "IdCampoInv";
                $values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($campoInv->IdCampoInv));
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarCampoWebInv(CampoWebInv $campoInv) {
		$statement = $this->prepareStatement($campoInv);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhcamposwebinv(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirCampoWebInv() {
		$sql = "delete from rhcamposwebinv ";
		return $this->db->Execute($sql);
	}
	
}
?>