<?php

class PessoaFuncPretend {

	public $Empresa = null;
	public $Pessoa;
	public $Funcao;
	public $SituacaoCandidato;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;          
        if (($this->Funcao != null) && (strlen($this->Funcao) > 8))
		    return false;  
        if (($this->SituacaoCandidato != null) && (strlen($this->SituacaoCandidato) > 1))
		    return false;  
        return true;
	}    
	
}

?>