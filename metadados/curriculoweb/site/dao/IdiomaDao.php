<?php

class IdiomaDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarIdiomaPorParametros() {
		
		$sql = "select * from rhidiomas ";
		
		return $this->db->Execute($sql);
	}
	
	function buscarIdiomasPorPessoa($pessoa) {
		
		$sql = "SELECT * FROM rhpessoaidiomas WHERE Pessoa = ? ";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+#' , '', $pessoa);
		
		return $this->db->Execute($query,$pPessoa);	
		
	}
	

	private function prepareStatement(Idioma $idioma) {
		$statement = array();
		$c = 0;
		$v = 0;
				
		if (!is_null($idioma->Idioma)){
			$columns[$c++] = "Idioma";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($idioma->Idioma));
		}
			
		if (!is_null($idioma->Descricao)){
			$columns[$c++] = "Descricao20";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($idioma->Descricao));
		}
		

		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	function criarIdioma(Idioma $idioma) {
		$statement = $this->prepareStatement($idioma);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhidiomas(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	function excluirIdioma() {
		$sql = "delete from rhidiomas ";
		return $this->db->Execute($sql);
	}
}

?>