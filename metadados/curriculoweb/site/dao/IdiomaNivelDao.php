<?php

class IdiomaNivelDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarIdiomaNivelPorParametros() {
		$sql = "select * from rhidiomasniveis ORDER BY NroOrdem";

		return $this->db->Execute($sql);
	}
	
	private function prepareStatement(IdiomaNivel $idiomaNivel) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($idiomaNivel->NivelIdioma)){
                $columns[$c++] = "NivelIdioma";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($idiomaNivel->NivelIdioma));
        }
        
        if (!is_null($idiomaNivel->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($idiomaNivel->Descricao20));
        }
        if (!is_null($idiomaNivel->NumeroOrdem)){
                $columns[$c++] = "NroOrdem";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($idiomaNivel->NumeroOrdem));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;
		
        return $statement;
	}
   function criarIdiomaNivel(IdiomaNivel $idiomaNivel) {
		$statement = $this->prepareStatement($idiomaNivel);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhidiomasniveis(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }
	function excluirIdiomaNivel() {
		$sql = "delete from rhidiomasniveis ";
		return $this->db->Execute($sql);
	}	
}
?>