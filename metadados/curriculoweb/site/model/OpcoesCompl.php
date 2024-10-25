<?php

class OpcoesCompl {

	public $Variavel = null;
	public $OpcaoComplementar;
	public $Descricao20;
    
    function validaTamanhoCampos(){
		if (($this->Variavel != null) && (strlen($this->Variavel) > 4))
		    return false;
		if (($this->OpcaoComplementar != null) && (strlen($this->OpcaoComplementar) > 1))
		    return false;
        if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;
        return true;
	}     

}

?>