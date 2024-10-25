<?php

class HabilitacaoProfissional {

	public $HabilitacaoProfissional = null;
	public $Descricao20;
	public $ConselhoClasse;
    
    function validaTamanhoCampos(){
		if (($this->HabilitacaoProfissional != null) && (strlen($this->HabilitacaoProfissional) > 4))
		    return false;
		if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;         
        if (($this->ConselhoClasse != null) && (strlen($this->ConselhoClasse) > 8))
		    return false;
        return true;
	} 
	
}

?>