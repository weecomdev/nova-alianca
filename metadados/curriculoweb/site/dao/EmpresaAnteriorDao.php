<?php

class EmpresaAnteriorDao {

	private $db;
	private $ListaQuery;

	function __construct($db = null) {
		$this->db = $db;
	}

	function buscarProximaSequencia(EmpresaAnterior $empresaAnterior) {

		$sql = "select nrosequencia + 1 as proxima from rhempresasanteriores  ";
		$sql .= "where empresa = ?";
		$sql .= " and pessoa = ?";
                $sql .= " and nrosequencia = ("
                        . "Select MAX(a.nrosequencia) "
                        . "from rhempresasanteriores a "
                        . "where rhempresasanteriores.empresa = a.empresa and "
                        . "rhempresasanteriores.pessoa = a.pessoa)";

		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Pessoa);
		$result = $this->db->Execute($query,array($pEmpresa,$pPessoa));

                if(!is_null($result->fields['proxima'])){
                    return $result->fields['proxima'];
                }
                else{
                    return 1;
                }
	}

	function buscarEmpresaAnteriorPorPK(EmpresaAnterior $empresaAnterior) {

		$sql = "select * from rhempresasanteriores ";
		$sql .= "where empresa = ?";
		$sql .= " and pessoa = ?";
		$sql .= " and nrosequencia = ?";

		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Pessoa);
		$pSequencia =  preg_replace('#[^\pL\pN./\' -]+# ', '',$empresaAnterior->NroSequencia);

		return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pSequencia));

	}

	function buscarEmpresaAnteriorPorParametros(EmpresaAnterior $empresaAnterior) {
		$sql = "select * from rhempresasanteriores ";
		$sql .= " where empresa = ?";
		$sql .= " and pessoa = ?";

        $pPrimeiroEmprego = null;
		if (!is_null($empresaAnterior->PrimeiroEmprego)){
			$sql .= " AND rhempresasanteriores.primeiroemprego = ?";
            $pPrimeiroEmprego =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->PrimeiroEmprego);
		}

		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Pessoa);

        if (!is_null($pPrimeiroEmprego))
		    return $this->db->Execute($query,array($pEmpresa,$pPessoa, $pPrimeiroEmprego));
        else
            return $this->db->Execute($query,array($pEmpresa,$pPessoa));

	}

	function buscarEmpresasAnterioresPorParametros(Pessoa $pessoa) {
        $sql = "select rhempresasanteriores.* from rhempresasanteriores where ";
        $sql .= " rhempresasanteriores.empresa = ?";
        $sql .= " and rhempresasanteriores.pessoa = ?";

		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);

        return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}


	private function prepareStatement(EmpresaAnterior $empresaAnterior) {

		$statement = array();
		$c = 0;
		$v = 0;

		if (!is_null($empresaAnterior->Empresa)) {
			$columns[$c++] = "Empresa";
			$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($empresaAnterior->Empresa));
		}


		if (!is_null($empresaAnterior->Pessoa)) {
			$columns[$c++] = "Pessoa";
			$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresaAnterior->Pessoa));
		}

		if (!is_null($empresaAnterior->NroSequencia)) {
			$columns[$c++] = "NroSequencia";
			$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresaAnterior->NroSequencia));
		}

		if (!is_null($empresaAnterior->EmpresaAnterior)) {
			$columns[$c++] = "EmpresaAnterior";
			$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($empresaAnterior->EmpresaAnterior));
		}

		if (!is_null($empresaAnterior->EstaTrabalhando)) {
			$columns[$c++] = "EstaTrabalhando";
			$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresaAnterior->EstaTrabalhando));
		}

		if (!is_null($empresaAnterior->PrimeiroEmprego)) {
			$columns[$c++] = "PrimeiroEmprego";
			$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresaAnterior->PrimeiroEmprego));
		}

		if (!is_null($empresaAnterior->DataAdmissao)) {
			$columns[$c++] = "DataAdmissao";
			$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($empresaAnterior->DataAdmissao));
		}

		if (!is_null($empresaAnterior->DataRescisao)) {
			$columns[$c++] = "DataRescisao";
			$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($empresaAnterior->DataRescisao));
		}

		if (!is_null($empresaAnterior->SalarioFinal)) {
			$columns[$c++] = "SalarioFinal";
			$values[$v++] =  preg_replace('#[^\pL\pN./\'. -]+#', '', $this->db->qstr($empresaAnterior->SalarioFinal));
		}

		if (!is_null($empresaAnterior->Observacoes)) {
			$columns[$c++] = "Observacoes";
			$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($empresaAnterior->Observacoes));
		}

		$columns[$c++] = "OrigemCurriculo";
		$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresaAnterior->OrigemCurriculo));

		$statement[0] = $columns;
		$statement[1] = $values;

		return $statement;
	}

	function criarEmpresaAnterior(EmpresaAnterior $empresaAnterior) {

		$statement = $this->prepareStatement($empresaAnterior);

		$columns = $statement[0];
		$values = $statement[1];

		$sql = "INSERT INTO rhempresasanteriores(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";

		return $this->db->Execute($sql);
	}

	function alterarEmpresaAnterior(EmpresaAnterior $empresaAnterior) {

		$sql = " update rhempresasanteriores set ";
		$sql .= " empresaanterior = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->EmpresaAnterior));
		$sql .= " ,estatrabalhando = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->EstaTrabalhando));
		$sql .= " ,primeiroemprego = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->PrimeiroEmprego));

		if (trim($empresaAnterior->DataAdmissao) != "") {
			$sql .= " ,dataadmissao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->DataAdmissao));
		}
		else{
			$sql .= " ,dataadmissao = null ";
		}
		if (trim($empresaAnterior->DataRescisao) != "") {
			$sql .= " ,datarescisao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->DataRescisao));
		}
		else{
			$sql .= " ,datarescisao = null ";
		}
		$sql .= " ,salariofinal = " . preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->SalarioFinal));
		$sql .= " ,observacoes = " . preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->Observacoes)). " ";
		$sql .= " where empresa = " . preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->Empresa)) . "";
		$sql .= " and pessoa = " . preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->Pessoa));
		$sql .= " and nrosequencia = " . preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresaAnterior->NroSequencia));

		$query = $this->db->prepare($sql);
        return $this->db->Execute($query);
	}

	function excluirEmpresaAnterior(EmpresaAnterior $empresaAnterior) {

		$sql = "DELETE FROM rhempresasanteriores WHERE 1=1 ";
		$sql .= " and empresa = ?";
		$sql .= " and pessoa = ?";
		$sql .= " and nrosequencia = ?";

		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->Pessoa);
		$pNumeroSequencia =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresaAnterior->NroSequencia);

        return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pNumeroSequencia));
	}

}

?>