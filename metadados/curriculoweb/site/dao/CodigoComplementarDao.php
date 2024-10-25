<?php

class CodigoComplementarDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarCodigoComplementarPorVariavel($Variavel, $tabelaDescricao, $campoDescricao) {
		
		$sql = "select * from ".strtolower($tabelaDescricao);
		$sql .= " where Variavel = ?";
		$query = $this->db->prepare($sql);
		$pVariavel =   preg_replace('#[^\pL\pN./\' -]+# ', '', $Variavel);
		return $this->db->Execute($query,$pVariavel);		
	}
	
	
	private function prepareStatement(CodigosCompl $codigosCompl) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($codigosCompl->Variavel)){
                $columns[$c++] = "Variavel";
				$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($codigosCompl->Variavel));
        }
        
        if (!is_null($codigosCompl->CodigoComplementar)){
                $columns[$c++] = "CodigoComplementar";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($codigosCompl->CodigoComplementar));
        }

        if (!is_null($codigosCompl->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($codigosCompl->Descricao40));
        }

        if (!is_null($codigosCompl->Descricao20)){
                $columns[$c++] = "Descricao20";
			    $values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($codigosCompl->Descricao20));
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
    function criarCodigosCompl (CodigosCompl $codigoscompl) {
		$statement = $this->prepareStatement($codigoscompl);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhcodigoscompl(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
	}
	function excluirCodigosCompl() {
		$sql = "delete from rhcodigoscompl ";
		return $this->db->Execute($sql);
	}
}
?>