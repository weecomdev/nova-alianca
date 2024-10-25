<?php

class  DicionarioCampoObr{
	public $IdCampoObr = null;
	public $Tabela = null;
	public $CampoTabela = null;
	public $Deacricao60 = null; 
    
    function validaTamanhoCampos(){
		if (($this->IdCampoObr != null) && (!is_numeric($this->IdCampoObr)))
		    return false;
		if (($this->Tabela != null) && (strlen($this->Tabela) > 30))
		    return false;
		if (($this->CampoTabela != null) && (strlen($this->CampoTabela) > 30))
		    return false;     
        if ((($this->Deacricao60 != null) && strlen($this->Deacricao60) > 60))
		    return false;
        return true;
	}      
}

?>