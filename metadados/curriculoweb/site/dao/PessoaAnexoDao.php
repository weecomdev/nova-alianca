<?php
class PessoaAnexoDao{
	private $db;
	private $ListaQuery;
	function __construct($db) {
		$this->db = $db;

	}

	function buscarAnexoDaPessoa($empresa, $pessoa){
		$sql = "select Empresa, Pessoa, NomeArquivo, TipoArquivo, ArquivoBlob from rhpessoasanexos
		where empresa = ? and
		pessoa = ?"	;

		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa);


		return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}


	function existePessoaAnexo($empresa, $pessoa){
		$sql = "select empresa from rhpessoasanexos
				where empresa = ? and
				pessoa = ?";

		$query = $this->db->prepare($sql);
		$pEmpresa = preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa);

		$resultado = $this->db->Execute($query,array($pEmpresa,$pPessoa));

		return trim($resultado->fields['empresa']) != "";
	}

	private function prepareStatement(PessoaAnexo $pessoaAnexo) {
		$statement = array();
		$c = 0;
		$v = 0;

		if (!is_null($pessoaAnexo->Empresa)){
			$columns[$c++] = "Empresa";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaAnexo->Empresa));
		}

		if (!is_null($pessoaAnexo->Pessoa)){
			$columns[$c++] = "Pessoa";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaAnexo->Pessoa));
		}

		if (!is_null($pessoaAnexo->ArquivoBlob)){
			$columns[$c++] = "ArquivoBlob";
			$values[$v++] = "'" . addslashes($pessoaAnexo->ArquivoBlob) . "'";

		}

        if (!is_null($pessoaAnexo->NomeArquivo)){
			$columns[$c++] = "NomeArquivo";
			$values[$v++] = "'" . addslashes(preg_replace('#[^\pL\pN./\' -]+#' , '',$pessoaAnexo->NomeArquivo)) . "'";
		}

        if (!is_null($pessoaAnexo->TipoArquivo)){
			$columns[$c++] = "TipoArquivo";
			$values[$v++] = "'" . addslashes($pessoaAnexo->TipoArquivo) . "'";
		}

		$statement[0] = $columns;
		$statement[1] = $values;

		return $statement;
	}

	public function criarPessoaAnexo(PessoaAnexo $pessoaAnexo){
		$statement = $this->prepareStatement($pessoaAnexo);

		$columns = $statement[0];
		$values = $statement[1];

		$sql = "INSERT IGNORE INTO rhpessoasanexos (";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";




		return $this->db->Execute($sql);
	}

	function alterarPessoaAnexo(PessoaAnexo $pessoaAnexo) {
		$sql = " update rhpessoasanexos set ";

		if (trim($pessoaAnexo->ArquivoBlob) != "") {
			$sql .= " ArquivoBlob = '" . addslashes($pessoaAnexo->ArquivoBlob) . "' ";
		}
		else{
			$sql .= " ArquivoBlob = null ";
		}

		if (trim($pessoaAnexo->NomeArquivo) != "") {
			$sql .= " NomeArquivo = '" . addslashes($pessoaAnexo->NomeArquivo) . "' ";
		}
		else{
			$sql .= " NomeArquivo = null ";
		}

		if (trim($pessoaAnexo->TipoArquivo) != "") {
			$sql .= " TipoArquivo = " . addslashes($pessoaAnexo->TipoArquivo) . " ";
		}
		else{
			$sql .= " TipoArquivo = null ";
		}

		$sql .= " where Empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);
		$sql .= " and Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa);

		$query = $this->db->prepare($sql);

		return $this->db->Execute($query);

	}

	function excluirPessoaAnexo(PessoaAnexo $pessoaAnexo) {

		$sql = "DELETE FROM rhpessoasanexos WHERE ";
		$sql .= " Empresa = ?";
		$sql .= " and Pessoa = ?";

		$query = $this->db->prepare($sql);
		$pEmpresa = preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaAnexo->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaAnexo->Pessoa);

		return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}
}
?>
