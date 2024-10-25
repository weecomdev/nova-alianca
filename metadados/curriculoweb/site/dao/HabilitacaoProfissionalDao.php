<?php

class HabilitacaoProfissionalDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	private function prepareStatement(HabilitacaoProfissional $habilitacoesProf) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($habilitacoesProf->HabilitacaoProfissional)){
                $columns[$c++] = "HabilitacaoProfissional";
				$values[$v++] = preg_replace('/[^\p{L}\'-9\- ]/u', '', $this->db->qstr($habilitacoesProf->HabilitacaoProfissional));
        }
        
        if (!is_null($habilitacoesProf->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($habilitacoesProf->Descricao20));
        }
        if (!is_null($habilitacoesProf->ConselhoClasse)){
                $columns[$c++] = "ConselhoClasse";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($habilitacoesProf->ConselhoClasse));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
			
	function criarHabilitacaoProfissional(HabilitacaoProfissional $habilitacaoProfissional) {
		
		$statement = $this->prepareStatement($habilitacaoProfissional);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhhabilitacoesprof(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	function excluirHabilitacaoProfissional() {
		$sql = "delete from rhhabilitacoesprof ";
		return $this->db->Execute($sql);
	}
}

?>