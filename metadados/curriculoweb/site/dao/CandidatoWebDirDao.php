<?php
class CandidatoWebDirDao{
	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	private function prepareStatement(CandidatoWebDir $candidatoWebDir) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($candidatoWebDir->Empresa)){
                $columns[$c++] = "Empresa";
				$values[$v++] =  preg_replace('#[^\pL\pN./\':_. -]+# ', '', $this->db->qstr($candidatoWebDir->Empresa));      
        }
        
        if (!is_null($candidatoWebDir->DiretrizWeb)){
                $columns[$c++] = "DiretrizWeb";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatoWebDir->DiretrizWeb));  
        }
        
		if (!is_null($candidatoWebDir->ConteudoData)){
                $columns[$c++] = "ConteudoData";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatoWebDir->ConteudoData));      
        }
		if (!is_null($candidatoWebDir->ConteudoMemo)){
                $columns[$c++] = "ConteudoMemo";
				$values[$v++] =  $this->db->qstr($candidatoWebDir->ConteudoMemo);     
        }
		if (!is_null($candidatoWebDir->ConteudoNumero)){
                $columns[$c++] = "ConteudoNumero";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatoWebDir->ConteudoNumero));        
        }
		if (!is_null($candidatoWebDir->ConteudoOpcao)){
                $columns[$c++] = "ConteudoOpcao";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatoWebDir->ConteudoOpcao));       
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarCandidatoWebDir(CandidatoWebDir $candidatoWebDir) {
		$statement = $this->prepareStatement($candidatoWebDir);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhcandidatoswebdir(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirCandidatoWebDir() {
		$sql = "delete from rhcandidatoswebdir ";
		return $this->db->Execute($sql);
	}	
	
	function buscaDiretrizesEmpresa($empresa){
		$sql = "SELECT rhcandidatoswebdir.Empresa, rhcandidatoswebdir.DiretrizWeb, 
					rhcandidatoswebdir.ConteudoData, rhcandidatoswebdir.ConteudoMemo, rhcandidatoswebdir.ConteudoNumero,
					rhcandidatoswebdir.ConteudoOpcao, rhdiretrizescvwebdef.TipoDiretrizWeb 
				from rhcandidatoswebdir
				inner join rhdiretrizescvwebdef on
					rhcandidatoswebdir.DiretrizWeb = rhdiretrizescvwebdef.DiretrizWeb 
				where empresa = '$empresa' ";

        return $this->db->Execute($sql);        
	}
}
?>