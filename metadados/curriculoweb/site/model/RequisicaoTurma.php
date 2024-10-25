<?php
class RequisicaoTurma {
	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $Requisicao = NULL;
    public $DataInscricao = NULL;
    public $CandidatoInscrito = NULL;    
    
    function validaTamanhoCampos(){
		if (($this->Requisicao != null) && (strlen($this->Requisicao) > 8))
		    return false;
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;   
        if (($this->DataInscricao != null) && (!DataUtil::ValidaData($this->DataInscricao)))
		    return false;          
        if (($this->CandidatoInscrito != null) && (strlen($this->CandidatoInscrito) > 1))
		    return false; 
        return true;
	}    
}	
?>