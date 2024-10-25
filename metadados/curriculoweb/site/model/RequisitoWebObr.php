<?php

class RequisitoWebObr {

	public $Empresa = null;
	public $Requisito = null;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
		if (($this->Requisito != null) && (strlen($this->Requisito) > 4))
		    return false;        
        return true;
	}    

}

?>