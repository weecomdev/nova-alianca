<?php

class Idioma {

	public $Idioma = NULL;
	public $Descricao = NULL;
    
    function validaTamanhoCampos(){
		if (($this->Idioma != null) && (strlen($this->Idioma) > 4))
		    return false;
		if (($this->Descricao != null) && (strlen($this->Descricao) > 20))
		    return false;         
        return true;
	} 
	
}

?>