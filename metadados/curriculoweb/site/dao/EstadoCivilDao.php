<?php

class EstadoCivilDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarEstadoCivilPorParametros() {
		
		$sql = "select * from rhestadocivil ";

		return $this->db->Execute($sql);
		
	}	
	
	private function prepareStatement(EstadoCivil $estadoCivil) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($estadoCivil->EstadoCivil)){
                $columns[$c++] = "EstadoCivil";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($estadoCivil->EstadoCivil));
        }
        
        if (!is_null($estadoCivil->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($estadoCivil->Descricao20));
        }
        if (!is_null($estadoCivil->ClasseEstadoCivil)){
                $columns[$c++] = "ClasseEstadoCivil";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($estadoCivil->ClasseEstadoCivil));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	
	function criarEstadoCivil(EstadoCivil $estadocivil) {
		
		$statement = $this->prepareStatement($estadocivil);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhestadocivil(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	function excluirEstadoCivil() {
		$sql = "delete from rhestadocivil ";
		return $this->db->Execute($sql);
	}
}

?>