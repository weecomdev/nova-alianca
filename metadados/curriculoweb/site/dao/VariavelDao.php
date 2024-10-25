<?php

class VariavelDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarVariaveisPorParametros(Variavel $variavel = NULL) {
		
		$sql = "select * from rhvariaveis ";
		
		return $this->db->Execute($sql);
	}
	
	private function prepareStatement(Variavel $variavel) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($variavel->Variavel)){
                $columns[$c++] = "Variavel";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->Variavel));        
        }

        if (!is_null($variavel->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','='),'',$this->db->qstr($variavel->Descricao40));        
        }

        if (!is_null($variavel->TipoCampo)){
                $columns[$c++] = "TipoCampo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TipoCampo));  
        }

        if (!is_null($variavel->TamanhoCampo)){
                $columns[$c++] = "TamanhoCampo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TamanhoCampo));  
        }

        if (!is_null($variavel->NroDecimais)){
                $columns[$c++] = "NroDecimais";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->NroDecimais));  
        }

        if (!is_null($variavel->TabelaOrigem)){
                $columns[$c++] = "TabelaOrigem";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TabelaOrigem));  
        }

        if (!is_null($variavel->TabelaDescricao)){
                $columns[$c++] = "TabelaDescricao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TabelaDescricao));  
        }

        if (!is_null($variavel->CampoChave)){
                $columns[$c++] = "CampoChave";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoChave));  
        }

        if (!is_null($variavel->CampoDescricao)){
                $columns[$c++] = "CampoDescricao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoDescricao));  
        }

        if (!is_null($variavel->TabelaOrigemFutura)){
                $columns[$c++] = "TabelaOrigemFutura";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TabelaOrigemFutura));  
        }

        if (!is_null($variavel->CampoTabela)){
                $columns[$c++] = "CampoTabela";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoTabela));  
        }


        if (!is_null($variavel->CampoTabelaFutura)){
                $columns[$c++] = "CampoTabelaFutura";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoTabelaFutura));  
        }
        
        if (!is_null($variavel->Descricao80)){
            $columns[$c++] = "Descricao80";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','='),'',$this->db->qstr($variavel->Descricao80));         
        }        


        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	function criarVariavel(Variavel $variavel) {
		$statement = $this->prepareStatement($variavel);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhvariaveis(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
      
        return $this->db->Execute($sql);
    }

	function excluirVariavel() {
		$sql = "delete from rhvariaveis ";
		return $this->db->Execute($sql);
	}

	
	
}
?>