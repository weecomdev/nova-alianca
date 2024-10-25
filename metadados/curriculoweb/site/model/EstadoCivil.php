<?php

class EstadoCivil {

	public $EstadoCivil = null;
	public $Descricao20;
	public $ClasseEstadoCivil;
    
    function validaTamanhoCampos(){
		if (($this->EstadoCivil != null) && (strlen($this->EstadoCivil) > 2))
		    return false;
		if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;    
        if (($this->ClasseEstadoCivil != null) && (strlen($this->ClasseEstadoCivil) > 1))
		    return false;  
        return true;
	} 
	
}

?>