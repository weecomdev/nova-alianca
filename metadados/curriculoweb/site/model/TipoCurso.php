<?php

class TipoCurso {

	public $TipoCurso = null;
	public $Descricao40 = null;
    
    function validaTamanhoCampos(){
		if (($this->TipoCurso != null) && (strlen($this->TipoCurso) > 2))
		    return false;
		if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;         
        return true;
	}    
	
}

?>