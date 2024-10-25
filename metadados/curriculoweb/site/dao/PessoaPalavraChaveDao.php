<?php

class PessoaPalavraChaveDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarPessoaPalavraChavePorPK($pk) {
		
		$sql = "select * from  ";
		
		return $this->db->Execute($sql);
	}
	
	function buscarPessoaPalavraChavePorParametros(Pessoa $pessoa) {
        $sql = "select * from rhpessoapalavrachave where ";
		$sql .= " rhpessoapalavrachave.empresa = ?";
        $sql .= " and rhpessoapalavrachave.pessoa = ?";

		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
 
        return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}
	
	function buscarPalavraChavePorPessoa($empresa, $pessoa) {
		$sql = "select * from rhpessoapalavrachave where Pessoa = ?";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa);
 
        return $this->db->Execute($query,$pPessoa);
	}

	private function prepareStatement(PessoaPalavraChave $pessoaPalavraChave) {
		$statement = array();
		$c = 0;
		$v = 0;
				
		if (!is_null($pessoaPalavraChave->Empresa)){
			$columns[$c++] = "Empresa";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaPalavraChave->Empresa));
		}
			
		if (!is_null($pessoaPalavraChave->Pessoa)){
			$columns[$c++] = "Pessoa";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaPalavraChave->Pessoa));
		}
			
		if (!is_null($pessoaPalavraChave->PalavraChave)){
			$columns[$c++] = "PalavraChave";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaPalavraChave->PalavraChave));
		}

		if (!is_null($pessoaPalavraChave->OrigemCurriculo)){
			$columns[$c++] = "OrigemCurriculo";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaPalavraChave->OrigemCurriculo));
		}
			
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	function criarPessoaPalavraChave(PessoaPalavraChave $pessoaPalavraChave) {
		$statement = $this->prepareStatement($pessoaPalavraChave);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhpessoapalavrachave(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	
	function alterarPessoaPalavraChave(PessoaPalavraChave $pessoaPalavraChave) {
		
	}
	
	function excluirPessoaPalavraChave(PessoaPalavraChave $pessoaPalavraChave) {

		$sql = "DELETE FROM rhpessoapalavrachave WHERE 1=1 ";
		$sql .= " and Empresa = ?";
		$sql .= " and Pessoa = ?";
		$sql .= " and PalavraChave = ?";
		
		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaPalavraChave->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaPalavraChave->Pessoa);
		$pPalavraChave =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaPalavraChave->PalavraChave);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pPalavraChave));		
	}
			
}

?>