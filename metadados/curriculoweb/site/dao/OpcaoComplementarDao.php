<?php

class OpcaoComplementarDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarOpcaoComplementarPorVariavel($Variavel) {
		
		$sql = "select * from rhopcoescompl ";
		$sql .= " where Variavel = ?";
		
		$query = $this->db->prepare($sql);
		$pVariavel = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($Variavel));
		
		return $this->db->Execute($query,$pVariavel);   
	}
	
	private function prepareStatement(OpcoesCompl $opcoesCompl) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($opcoesCompl->Variavel)){
                $columns[$c++] = "Variavel";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',($this->db->qstr($opcoesCompl->Variavel)));
        }
        
        if (!is_null($opcoesCompl->OpcaoComplementar)){
                $columns[$c++] = "OpcaoComplementar";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',($this->db->qstr($opcoesCompl->OpcaoComplementar)));
        }

        if (!is_null($opcoesCompl->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($opcoesCompl->Descricao20));
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
   function criarOpcoesCompl(OpcoesCompl $opcoescompl) {
		$statement = $this->prepareStatement($opcoescompl);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhopcoescompl(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
	}
	function excluirOpcoesCompl() {
		$sql = "delete from rhopcoescompl ";
		return $this->db->Execute($sql);
	}
}
?>