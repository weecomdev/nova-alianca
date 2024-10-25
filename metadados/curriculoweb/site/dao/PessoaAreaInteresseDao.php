<?php

class PessoaAreaInteresseDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarPessoaAreaInteresPorParametros(Pessoa $pessoa) {
        $sql = "select * from rhpessoaareasinteres where ";
        $sql .= " rhpessoaareasinteres.empresa = ?";
        $sql .= " and rhpessoaareasinteres.pessoa = ? ";
		
        $query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));		
	}	
	
	function buscarPessoaAreaInteressePorPK($pk) {
		
		$sql = "select * from  ";
		
		return $this->db->Execute($sql);
	}
	
	function buscarAreaInteressePorPessoa($empresa, $pessoa) {
		$sql = "select * from rhpessoaareasinteres where Pessoa = ?";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  $pessoa;
		return $this->db->Execute($query,$pPessoa);	
	}

	private function prepareStatement(PessoaAreaInteresse $PessoaAreaInteresse) {
		$statement = array();
		$c = 0;
		$v = 0;
				
		if (!is_null($PessoaAreaInteresse->Empresa)){
			$columns[$c++] = "Empresa";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($PessoaAreaInteresse->Empresa));
		}
			
		if (!is_null($PessoaAreaInteresse->Pessoa)){
			$columns[$c++] = "Pessoa";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($PessoaAreaInteresse->Pessoa));
		}
			
		if (!is_null($PessoaAreaInteresse->AreaAtuacao)){
			$columns[$c++] = "AreaAtuacao";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($PessoaAreaInteresse->AreaAtuacao));
		}
		
		if (!is_null($PessoaAreaInteresse->NroOrdem)){
			$columns[$c++] = "NroOrdem";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#', '', $this->db->qstr($PessoaAreaInteresse->NroOrdem));
		}
		

		if (!is_null($PessoaAreaInteresse->OrigemCurriculo)){
			$columns[$c++] = "OrigemCurriculo";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($PessoaAreaInteresse->OrigemCurriculo));
		}
			
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	function criarPessoaAreaInteresse(PessoaAreaInteresse $PessoaAreaInteresse) {
		$statement = $this->prepareStatement($PessoaAreaInteresse);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhpessoaareasinteres(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
				
		return $this->db->Execute($sql);		
	}
	
	function alterarPessoaAreaInteresse(PessoaAreaInteresse $PessoaAreaInteresse) {
		
	}
	
	function excluirPessoaAreaInteresse(PessoaAreaInteresse $PessoaAreaInteresse) {

		$sql = "DELETE FROM rhpessoaareasinteres WHERE 1=1 ";
		$sql .= " and Empresa = ? ";
		$sql .= " and Pessoa =  ? ";
		$sql .= " and AreaAtuacao = ?" ;
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $PessoaAreaInteresse->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $PessoaAreaInteresse->Empresa);
		$pAreaAtuacao =  preg_replace('#[^\pL\pN./\' -]+# ', '', $PessoaAreaInteresse->AreaAtuacao);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pAreaAtuacao));		
	}
			
}

?>