<?php

class PessoaCargPretend {

	public $Empresa = null;
	public $Pessoa;
	public $Cargo;
	public $PretencaoSalarial;
	public $SituacaoCandidato;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;      
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;  
        if (($this->Cargo != null) && (strlen($this->Cargo) > 8))
		    return false;
        if (($this->PretencaoSalarial != null) && (!is_float(floatval($this->PretencaoSalarial))))
		    return false;  
        if (($this->SituacaoCandidato != null) && (strlen($this->SituacaoCandidato) > 1))
		    return false;        
        return true;
	}  
	
}

?>