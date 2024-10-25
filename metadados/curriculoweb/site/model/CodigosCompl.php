<?php

class CodigosCompl {

	public $Variavel = null;
	public $CodigoComplementar;
	public $Descricao40;
	public $Descricao20;
    
    function validaTamanhoCampos(){
		if (($this->Variavel != null) && (strlen($this->Variavel) > 4))
		    return false;
		if (($this->CodigoComplementar != null) && (strlen($this->CodigoComplementar) > 4))
		    return false;      
        if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;  
        if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;              
        return true;
	}      

}

?>