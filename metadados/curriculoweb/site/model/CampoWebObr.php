<?php

class CampoWebObr{
	
	public $Empresa = null;
	public $IdCampoObr = null;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
        if (($this->IdCampoObr != null) && (!is_numeric($this->IdCampoObr)))
		    return false;
        return true;
	}    
	
}

?>