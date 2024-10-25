<?php

class Nacionalidade {

	public $Nacionalidade = null;
	public $Descricao20;
	public $NacionalidadeRAIS;
    
    function validaTamanhoCampos(){
		if (($this->Nacionalidade != null) && (strlen($this->Nacionalidade) > 2))
		    return false;
		if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;         
        if (($this->NacionalidadeRAIS != null) && (strlen($this->NacionalidadeRAIS) > 2))
		    return false;
        return true;
	} 
	
}

?>