<?php
class DiretrizCVWebOpc{
	public $DiretrizWeb;
	public $NroOrdem;
	public $Descricao40;
    
    function validaTamanhoCampos(){
		if (($this->DiretrizWeb != null) && (strlen($this->DiretrizWeb) > 40))        
		    return false;       
        if (($this->NroOrdem != null) && (!is_numeric($this->NroOrdem)))
		    return false;  
        if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;   
        return true;
	}      
}
?>