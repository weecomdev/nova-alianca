<?php
class EscalaRequisitoItem {
	public $Avaliacao = null;
	public $ItemAvaliacao;
	public $Descricao15;
    
    function validaTamanhoCampos(){
		if (($this->Avaliacao != null) && (strlen($this->Avaliacao) > 4))
		    return false;
		if (($this->ItemAvaliacao != null) && (strlen($this->ItemAvaliacao) > 4))
		    return false;
        if (($this->Descricao15 != null) && (strlen($this->Descricao15) > 15))
		    return false;        
        return true;
	}       
}
?>