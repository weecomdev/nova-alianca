<?php

class PalavraChaveDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarPalavraChavePorParametros() {
		
		$sql = "select * from rhpalavraschave ";
				
		if ($_SESSION["OrdemPlvChave"]== '1'){
			     $sql .= " Order By PALAVRACHAVE ";
		}
		else{
			     $sql .= " Order By DESCRICAO40 ";
		}
		
		return $this->db->Execute($sql);
	}
	
	private function prepareStatement(PalavraChave $palavrasChave) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($palavrasChave->PalavraChave)){
                $columns[$c++] = "PalavraChave";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($palavrasChave->PalavraChave));
        }
        
        if (!is_null($palavrasChave->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($palavrasChave->Descricao40));
        }
        if (!is_null($palavrasChave->AtivaDesativada)){
                $columns[$c++] = "AtivaDesativada";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($palavrasChave->AtivaDesativada));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;
        
        return $statement;
   }

   function criarPalavrasChave(PalavraChave $palavraschave) {
		$statement = $this->prepareStatement($palavraschave);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhpalavraschave(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
    }
	function excluirPalavrasChave() {
		$sql = "delete from rhpalavraschave ";
		return $this->db->Execute($sql);
	}
}

?>