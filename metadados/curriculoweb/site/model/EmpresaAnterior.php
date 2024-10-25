<?php

class EmpresaAnterior {
	
	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $NroSequencia = NULL;	
	
	public $EmpresaAnterior;
	public $EstaTrabalhando;
	public $PrimeiroEmprego;
	
	public $DataAdminissao;
	public $DataRescisao;
	public $SalarioFinal;
	public $Observacoes;
	
	public $OrigemCurriculo = '2';

    function validaTamanhoCampos(){
        
        $teste = 500.50;
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false; 
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;        
        if (($this->NroSequencia != null) && (!is_numeric($this->NroSequencia)))
		    return false;  
        if (($this->DataAdminissao != null) && (!DataUtil::ValidaData($this->DataAdminissao)))
		    return false; 
        if (($this->DataRescisao != null) && (!DataUtil::ValidaData($this->DataRescisao)))
		    return false; 
        if (($this->EmpresaAnterior != null) && (strlen($this->EmpresaAnterior) > 40))
		    return false; 
        if (($this->SalarioFinal != null) && (!is_float(floatval($this->SalarioFinal))))
		    return false;
        if (($this->EstaTrabalhando != null) && (strlen($this->EstaTrabalhando) > 1))
		    return false;  
        if (($this->OrigemCurriculo != null) && (strlen($this->OrigemCurriculo) > 1))
		    return false;  
        if (($this->PrimeiroEmprego != null) && (strlen($this->PrimeiroEmprego) > 1))
		    return false; 
        return true;
	}  
	
}

?>