<?php

class PessoaDadoComplementar {
	
	public $Empresa = NULL;
	public $Pessoa = NULL;
	
	public $Campos = NULL;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;          
   
        return true;
	}      
	
}	
?>