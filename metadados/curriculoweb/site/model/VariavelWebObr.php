<?php

class VariavelWebObr{
	
	public $Empresa = null;
	public $Variavel = null;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
		if (($this->Variavel != null) && (strlen($this->Variavel) > 4))
		    return false;        
        return true;
	}        
	
}

?>