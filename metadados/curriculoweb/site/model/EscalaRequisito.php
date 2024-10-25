<?php
class EscalaRequisito {
	public $Avaliacao = null;
	public $Descricao40;
	public $ItemAvaliacao;
    
    function validaTamanhoCampos(){
		if (($this->Avaliacao != null) && (strlen($this->Avaliacao) > 4))
		    return false;
		if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;         
        return true;
	}     
}
?>