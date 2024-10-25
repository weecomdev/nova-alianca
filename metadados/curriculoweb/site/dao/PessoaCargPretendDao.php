<?php

class PessoaCargPretendDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarPessoaCargPretendPorParametros(Pessoa $pessoa) {
        $sql = "Select * From RHPESSOACARGPRETEND Where ";
        $sql .= " RHPESSOACARGPRETEND.EMPRESA = ?";
        $sql .= " And RHPESSOACARGPRETEND.PESSOA = ?";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '',$pessoa->Empresa);

		return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}
	
}

?>