<?php

class AreaAtuacao {

	public $AreaAtuacao = null;
	public $Descricao60 = null;
	public $AtivaDesativa = null;
              
    function validaTamanhoCampos(){
		if  (($this->AreaAtuacao != null) && (strlen($this->AreaAtuacao) > 4))
		    return false;
        if  (($this->Descricao60 != null) && (strlen($this->Descricao60) > 60))
		    return false;
        if  (($this->AtivaDesativa != null) && (strlen($this->AtivaDesativa) > 1))
		    return false; 
        return true;
	}
	
}

?>