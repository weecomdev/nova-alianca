<?php

class PessoaFuncPretendDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarPessoaFuncPretendPorParametros(Pessoa $pessoa) { 
        $sql = "Select * From RHPESSOAFUNCPRETEND Where ";
        $sql .= " RHPESSOAFUNCPRETEND.EMPRESA = ?";
        $sql .= " And RHPESSOAFUNCPRETEND.PESSOA = ?";
		
		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));	
	}	
}

?>