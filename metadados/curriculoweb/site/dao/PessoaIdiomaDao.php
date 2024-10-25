<?php

class PessoaIdiomaDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarPessoaIdiomaPorParametros(Pessoa $pessoa) {
		$sql = " select rhpessoaidiomas.* from rhpessoaidiomas where ";				
        $sql .= " rhpessoaidiomas.empresa = ?";
        $sql .= " and rhpessoaidiomas.pessoa = ?";
		
		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+#', '', $pessoa->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+#' , '', $pessoa->Pessoa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));	
	}
	
	function buscarIdiomasPorPessoa($empresa, $pessoa) {
		
		$sql = "select * from rhpessoaidiomas where Pessoa = ?";
		
	    $query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa);
		
		return $this->db->Execute($query,$pPessoa);	
	}

	private function prepareStatement(PessoaIdioma $pessoaIdioma) {
		
		$statement = array();
		$c = 0;
		$v = 0;
				
		if (!is_null($pessoaIdioma->Empresa)){
			$columns[$c++] = "Empresa";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaIdioma->Empresa));
		}
			
		if (!is_null($pessoaIdioma->Pessoa)){
			$columns[$c++] = "Pessoa";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaIdioma->Pessoa));
		}
			
		if (!is_null($pessoaIdioma->Idioma)){
			$columns[$c++] = "Idioma";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaIdioma->Idioma));
		}
			
		if (!is_null($pessoaIdioma->NivelIdioma)){
			$columns[$c++] = "NivelIdioma";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaIdioma->NivelIdioma));
		}

		if (!is_null($pessoaIdioma->OrigemCurriculo)){
			$columns[$c++] = "OrigemCurriculo";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaIdioma->OrigemCurriculo));
		}
			
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	function criarPessoaIdioma(PessoaIdioma $pessoaIdioma) {
		
		$statement = $this->prepareStatement($pessoaIdioma);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhpessoaidiomas(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	
	function alterarPessoaIdioma(PessoaIdioma $pessoaIdioma) {
		
	}
	
	function excluirPessoaIdioma(PessoaIdioma $pessoaIdioma) {

		$sql = "DELETE FROM rhpessoaidiomas WHERE 1=1 ";
		$sql .= " and Empresa = ?";
		$sql .= " and Pessoa = ?";
		$sql .= " and Idioma = ?";
		
		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaIdioma->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaIdioma->Pessoa);
		$pIdioma =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaIdioma->Idioma);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pIdioma));	
	}
			
}

?>