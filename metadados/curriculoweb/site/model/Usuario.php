<?php

class Usuario {
	
	public $Usuario = null;
	public $Cpf = null;
	public $Senha = null;
	public $Pessoa = null;
    
    function validaTamanhoCampos(){
		if (($this->Usuario != null) && (!is_numeric($this->Usuario)))
		    return false;
        if (($this->Cpf != null) && (strlen($this->Cpf) > 11))
		    return false;
        if (($this->Senha != null) && (strlen($this->Senha) > 120))
		    return false; 
		if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;        
        return true;
	}    
}
?>