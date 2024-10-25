<?php

class TipoResidenciaDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	private function prepareStatement(TipoResidencia $tiposResidencia) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($tiposResidencia->TipoResidencia)){
                $columns[$c++] = "TipoResidencia";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($tiposResidencia->TipoResidencia)); 
        }
        
        if (!is_null($tiposResidencia->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($tiposResidencia->Descricao20)); 
        }
        if (!is_null($tiposResidencia->ClasseResidencia)){
                $columns[$c++] = "ClasseResidencia";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($tiposResidencia->ClasseResidencia)); 
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
    }
		
	function criarTiposREsidencia(TipoResidencia $tiposresidencia) {
		
		$statement = $this->prepareStatement($tiposresidencia);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhtiposresidencia(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	function excluirTiposResidencia() {
		$sql = "delete from rhtiposresidencia ";
		return $this->db->Execute($sql);
	}
}

?>