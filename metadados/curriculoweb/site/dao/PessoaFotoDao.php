<?php
class PessoaFotoDao{
	private $db;
	private $ListaQuery;
	function __construct($db) {
		$this->db = $db;
	}
    
	function buscarPessoaFotoParametros(Pessoa $pessoa) {
		$sql = "select * from rhpessoasfotos where ";
		$sql .= " rhpessoasfotos.empresa = ?";
        $sql .= " and rhpessoasfotos.pessoa = ?";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}
			
	function buscarFotoDaPessoa($empresa, $pessoa){
		$sql = "select Foto from rhpessoasfotos 
		where empresa = ? and
		pessoa = ? ";	
		
		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa);
		
		$resultado = $this->db->Execute($query,array($pEmpresa,$pPessoa));
		return $resultado->fields['Foto'];
	}
	function existePessoaFoto($empresa, $pessoa){
		$sql = "select empresa from rhpessoasfotos
				where empresa = ? and
				pessoa = ?";
			
		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa);
		
		$resultado = $this->db->Execute($query,array($pEmpresa,$pPessoa));
		return trim($resultado->fields['empresa']) != "";
	}
	private function prepareStatement(PessoaFoto $pessoaFoto) {
		$statement = array();
		$c = 0;
		$v = 0;

		if (!is_null($pessoaFoto->Empresa)){
			$columns[$c++] = "Empresa";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaFoto->Empresa));
		}

		if (!is_null($pessoaFoto->Pessoa)){
			$columns[$c++] = "Pessoa";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaFoto->Pessoa));
		}

		if (!is_null($pessoaFoto->Foto)){
			$columns[$c++] = "Foto";
			$values[$v++] = "'" . addslashes($pessoaFoto->Foto) . "'";
		}
		$statement[0] = $columns;
		$statement[1] = $values;

		return $statement;
	}
	public function criarPessoaFoto(PessoaFoto $pessoaFoto){
		$statement = $this->prepareStatement($pessoaFoto);

		$columns = $statement[0];
		$values = $statement[1];

		$sql = "INSERT IGNORE INTO rhpessoasfotos (";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";

		return $this->db->Execute($sql);
	}
	function alterarPessoaFoto(PessoaFoto $pessoaFoto) {
		$ListaQuery = array();
		$sql = " update rhpessoasfotos set ";

		if (trim($pessoaFoto->Foto) != "") {
			$sql .= " Foto = '".addslashes($pessoaFoto->Foto)."'";
		}
		else{
			$sql .= " Foto = null ";
		}
	
		$sql .= " where Empresa = ".addslashes($pessoaFoto->Empresa)." ";
		$sql .= " and Pessoa = ".addslashes($pessoaFoto->Pessoa)."";
			
		$query = $this->db->prepare($sql);
		
		return $this->db->Execute($query);	
	}
	function excluirPessoaFoto(PessoaFoto $pessoaFoto) {

		$sql = "DELETE FROM rhpessoasfotos WHERE ";
		$sql .= " Empresa = ? ";
		$sql .= " and Pessoa = ? ";

		$query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaFoto->empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaFoto->pessoa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));	
	}
}
?>