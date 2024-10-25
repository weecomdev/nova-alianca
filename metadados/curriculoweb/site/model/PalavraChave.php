<?php
class PalavraChave {
	public $PalavraChave = null;
	public $Descricao40;
	public $AtivaDesativada;
    
    function validaTamanhoCampos(){
		if (($this->PalavraChave != null) && (strlen($this->PalavraChave) > 4))        
		    return false;
		if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;
        if (($this->AtivaDesativada != null) && (strlen($this->AtivaDesativada) > 1))
		    return false;
        return true;
	} 
}
?>