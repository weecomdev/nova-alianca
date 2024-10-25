<?php
class CandidatoWebDir {

	public $Empresa;
	public $DiretrizWeb;
	public $ConteudoData;
	public $ConteudoMemo;
	public $ConteudoNumero;
	public $ConteudoOpcao;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
		if (($this->UsuDiretrizWebario != null) && (strlen($this->DiretrizWeb) > 40))
		    return false;
        if (($this->ConteudoData != null) && (!DataUtil::ValidaData($this->ConteudoData)))
		    return false;   
        if (($this->ConteudoNumero != null) && (!is_numeric($this->ConteudoNumero)))
		    return false;        
        if (($this->ConteudoOpcao != null) && (!is_numeric($this->ConteudoOpcao)))
		    return false;          
        return true;
	}      
	
}
?>