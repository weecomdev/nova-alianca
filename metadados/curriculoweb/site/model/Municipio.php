<?php

class Municipio {

	public $Cidade = null;
	public $UF;
	public $CodigoMunicipioRAIS;
    public $Descricao80;
	
    function validaTamanhoCampos(){
		if (($this->Cidade != null) && (strlen($this->Cidade) > 20))
		    return false;
		if (($this->UF != null) && (strlen($this->UF) > 2))
		    return false;        
        if (($this->CodigoMunicipioRAIS != null) && (strlen($this->CodigoMunicipioRAIS > 8)))
		    return false;  
        if (($this->Descricao80 != null) && (strlen($this->Descricao80 > 80)))
		    return false;          
        return true;
	}     
}

?>