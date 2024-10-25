<?php

class Medida {

	public $Medida = null;
	public $Descricao40;
	public $NroDecimais;
    
    function validaTamanhoCampos(){
		if (($this->Medida != null) && (strlen($this->Medida) > 4))
		    return false;
		if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;         
        if (($this->NroDecimais != null) && (!is_numeric($this->NroDecimais)))
		    return false;          
        return true;
	} 
	
}

?>