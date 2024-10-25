<?php 
Class PessoaFoto{
	public $Empresa;
	public $Pessoa;
	public $Foto;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;          
        return true;
	}    
}
?>