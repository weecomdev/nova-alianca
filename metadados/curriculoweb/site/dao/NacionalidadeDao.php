<?php

class NacionalidadeDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarNacionalidadesPorParametros() {
		
		$sql = "select * from rhnacionalidades ";
		
		return $this->db->Execute($sql);
	}
	private function prepareStatement(Nacionalidade $nacionalidade) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($nacionalidade->Nacionalidade)){
                $columns[$c++] = "Nacionalidade";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($nacionalidade->Nacionalidade));
        }
        
        if (!is_null($nacionalidade->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($nacionalidade->Descricao20));
        }
        if (!is_null($nacionalidade->NacionalidadeRAIS)){
                $columns[$c++] = "NacionalidadeRAIS";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($nacionalidade->NacionalidadeRAIS));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;
		
        return $statement;
	}
   function criarNacionalidade(Nacionalidade $nacionalidade) {
		$statement = $this->prepareStatement($nacionalidade);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhnacionalidades(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }
	function excluirNacionalidade() {
		$sql = "delete from rhnacionalidades ";
		return $this->db->Execute($sql);
	}	
}
?>