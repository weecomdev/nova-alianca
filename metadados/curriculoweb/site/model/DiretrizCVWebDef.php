<?php
class DiretrizCVWebDef{
	public $DiretrizWeb; 
	public $Descricao80;
	public $TipoDiretrizWeb;
    
    function validaTamanhoCampos(){
		if (($this->DiretrizWeb != null) && (strlen($this->DiretrizWeb) > 40))
		    return false;
		if (($this->Descricao80 != null) && (strlen($this->Descricao80) > 80))
		    return false;
        if (($this->TipoDiretrizWeb != null) && (strlen($this->TipoDiretrizWeb) > 1))
		    return false;
        return true;
	}      
}
?>