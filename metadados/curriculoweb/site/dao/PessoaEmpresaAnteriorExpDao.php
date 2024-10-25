<?php

class PessoaEmpresaAnteriorExpDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarPessoaEmpresaAnteriorExpPorPK(PessoaEmpresaAnteriorExp $pessoaEmpresaAnteriorExp) {
		
		$sql = "select * from rhpessoaempantexp ";
		$sql .= "where Empresa = ?";
		$sql .= " and Pessoa = ?";
		$sql .= " and NroSequencia = ?";
		$sql .= " and NroOrdem = ?";
		
		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaEmpresaAnteriorExp->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaEmpresaAnteriorExp->Pessoa);
		$pNroSequencia =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaEmpresaAnteriorExp->NroSequencia);
		$pNroOrdem =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaEmpresaAnteriorExp->NroOrdem);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pNroSequencia,$pNroOrdem));
	}
	
	function buscarPessoaEmpresaAnteriorExpPorParametros(Pessoa $pessoa) {
        $sql = "select * from rhpessoaempantexp where ";
        $sql .= " rhpessoaempantexp.empresa = ?";
        $sql .= " and rhpessoaempantexp.pessoa = ?";
		
		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		
       return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}
	
	private function prepareStatement(PessoaEmpresaAnteriorExp $pessoaEmpresaAnteriorExp) {
		
		$statement = array();
		$c = 0;
		$v = 0;
				
		if (!is_null($pessoaEmpresaAnteriorExp->Empresa)) {
			$columns[$c++] = "Empresa";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaEmpresaAnteriorExp->Empresa));
		}
			
		if (!is_null($pessoaEmpresaAnteriorExp->Pessoa)) {
			$columns[$c++] = "Pessoa";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->Pessoa));
		}
			
		if (!is_null($pessoaEmpresaAnteriorExp->NroSequencia)) {
			$columns[$c++] = "NroSequencia";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->NroSequencia));
		}
		
		if (!is_null($pessoaEmpresaAnteriorExp->NroOrdem)) {
			$columns[$c++] = "NroOrdem";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->NroOrdem));
		}
			
		if (!is_null($pessoaEmpresaAnteriorExp->AreaAtuacao)) {
			$columns[$c++] = "AreaAtuacao";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->AreaAtuacao));
		}
			
		if (!is_null($pessoaEmpresaAnteriorExp->Descricao40)) {
			$columns[$c++] = "Descricao40";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->Descricao40));
		}
			
		if (!is_null($pessoaEmpresaAnteriorExp->AnosCasa)) {
			$columns[$c++] = "AnosCasa";
			if ($pessoaEmpresaAnteriorExp->AnosCasa == '')
			{
				$values[$v++] = 0;
			}
			else
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->AnosCasa));
		}
			
		if (!is_null($pessoaEmpresaAnteriorExp->MesesCasa)) {
			$columns[$c++] = "MesesCasa";
			if ($pessoaEmpresaAnteriorExp->MesesCasa == '')
			{
				$values[$v++] = 0;
			}
			else
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->MesesCasa));
		}
			
		$columns[$c++] = "OrigemCurriculo";
		$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->OrigemCurriculo));

		$columns[$c++] = "ExibirExperiencia";
		$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaEmpresaAnteriorExp->ExibirExperiencia));
			
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	function criarPessoaEmpresaAnteriorExp(PessoaEmpresaAnteriorExp $pessoaEmpresaAnteriorExp) {
		
		$statement = $this->prepareStatement($pessoaEmpresaAnteriorExp);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhpessoaempantexp(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
				
		
		return $this->db->Execute($sql);		
	}
	
	function excluirPessoaEmpresaAnteriorExp(EmpresaAnterior $empresaAnterior) {

		$sql = "DELETE FROM rhpessoaempantexp WHERE 1=1 ";
		$sql .= " and empresa = ?";
		$sql .= " and pessoa = ?";
		$sql .= " and nrosequencia = ?";	

		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Pessoa);
		$pNroSequencia =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->NroSequencia);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pNroSequencia));	
	}
			
}

?>