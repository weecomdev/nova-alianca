<?php

class GrauInstrucao {

	public $GrauInstrucao = null;
	public $Descricao20;
	public $GrauInstrucaoRAIS;
    
    function validaTamanhoCampos(){
		if  (($this->GrauInstrucao != null) && (strlen($this->GrauInstrucao) > 2))
		    return false;
		if  (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;        
        if  (($this->GrauInstrucaoRAIS != null) && (strlen($this->GrauInstrucaoRAIS) > 2))
		    return false;
        return true;
	} 
	
}

?>