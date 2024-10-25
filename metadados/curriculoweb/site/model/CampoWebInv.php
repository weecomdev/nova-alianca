<?php

class CampoWebInv{
	
	public $Empresa = null;
	public $IdCampoInv = null;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
        if (($this->IdCampoInv != null) && (!is_numeric($this->IdCampoInv)))
		    return false;
        return true;
	}    
	
}

?>