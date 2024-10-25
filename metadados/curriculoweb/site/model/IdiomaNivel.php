<?php

class IdiomaNivel {

	public $NivelIdioma = null;
	public $Descricao20;
	public $NumeroOrdem;
    
    function validaTamanhoCampos(){
		if (($this->NivelIdioma != null) && (strlen($this->NivelIdioma) > 4))
		    return false;
		if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;       
        if (($this->NumeroOrdem != null) && (!is_numeric($this->NumeroOrdem)))
		    return false;          
        return true;
	} 
	
}

?>