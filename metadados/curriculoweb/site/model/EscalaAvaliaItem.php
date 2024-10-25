<?php
class EscalaAvaliaItem {
	public $Avaliacao = null;
	public $ItemAvaliacao;
	public $Descricao15;
	public $Peso;
    
    function validaTamanhoCampos(){
		if (($this->Avaliacao != null) && (strlen($this->Avaliacao) > 4))
		    return false;
		if (($this->ItemAvaliacao != null) && (strlen($this->ItemAvaliacao) > 4))
		    return false;
        if (($this->Descricao15 != null) && (strlen($this->Descricao15) > 15))
		    return false;
        if (($this->Peso != null) && (!is_float(floatval($this->Peso))))
		    return false;          
        return true;
        
	}     
}
?>