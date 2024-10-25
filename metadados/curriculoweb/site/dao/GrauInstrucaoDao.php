<?php

class GrauInstrucaoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarGrauInstrucaoPorParametros() {
		
		$sql = "select * from rhgrauinstrucao ";
		
		return $this->db->Execute($sql);
	}		
	
	private function prepareStatement(GrauInstrucao $grauInstrucao) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($grauInstrucao->GrauInstrucao)){
                $columns[$c++] = "GrauInstrucao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($grauInstrucao->GrauInstrucao));
        }
        
        if (!is_null($grauInstrucao->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($grauInstrucao->Descricao20));
        }
        if (!is_null($grauInstrucao->GrauInstrucaoRAIS)){
                $columns[$c++] = "GrauInstrucaoRAIS";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($grauInstrucao->GrauInstrucaoRAIS));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
    function criarGrauInstrucao(GrauInstrucao $grauinstrucao) {
		$statement = $this->prepareStatement($grauinstrucao);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhgrauinstrucao(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }

	function excluirGrauInstrucao() {
		$sql = "delete from rhgrauinstrucao ";
		return $this->db->Execute($sql);
	}
	
			
}

?>