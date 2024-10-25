<?php
class TipoCursoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	
	function buscaTipoCursoPorParametros() {
		
		$sql = "select TipoCurso, Descricao40 from rhtiposcurso ORDER BY Descricao40";
		
		return $this->db->Execute($sql);
	}
	
	
	private function prepareStatement(TipoCurso $tipoCurso) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($tipoCurso->TipoCurso)){
                $columns[$c++] = "TipoCurso";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($tipoCurso->TipoCurso)); 
        }
        
        if (!is_null($tipoCurso->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($tipoCurso->Descricao40)); 
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
    }
		
	function criarTipoCurso(TipoCurso $tipoCurso) {
		
		$statement = $this->prepareStatement($tipoCurso);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhtiposcurso(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	function excluirTipoCurso() {
		$sql = "delete from rhtiposcurso ";
		return $this->db->Execute($sql);
	}
	
}
?>