<?php

class PessoaPalavraChave {
	
	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $PalavraChave = NULL;
	
	public $OrigemCurriculo;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;  
        if (($this->PalavraChave != null) && (strlen($this->PalavraChave) > 4))
		    return false;
        if (($this->OrigemCurriculo != null) && (strlen($this->OrigemCurriculo) > 1))
		    return false;
        return true;
	} 
}

?>