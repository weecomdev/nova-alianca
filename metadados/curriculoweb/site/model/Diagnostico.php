<?php

class Diagnostico {

	public $Id = null;
	public $Log;
	public $Tipo;
    
    function validaTamanhoCampos(){
		if (($this->Usuario != id) && (!is_numeric($this->id)))
		    return false;
		if (($this->Log != null) && (strlen($this->Log) > 4000))
		    return false;
        if (($this->Tipo != null) && (strlen($this->Tipo) > 1))
		    return false; 
        return true;
	}      

}

?>