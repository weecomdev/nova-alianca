<?php

class PessoaIdioma {
	
	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $Idioma = NULL;
	public $NivelIdioma;
	
	public $OrigemCurriculo;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;  
        if (($this->Idioma != null) && (strlen($this->Idioma) > 4))
		    return false;
        if (($this->NivelIdioma != null) && (strlen($this->NivelIdioma) > 4))
		    return false;
        if (($this->OrigemCurriculo != null) && (strlen($this->OrigemCurriculo) > 1))
		    return false;
        return true;
	}   
}

?>