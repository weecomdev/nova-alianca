<?php
class TipoResidencia {
	public $TipoResidencia = null;
	public $Descricao20;
	public $ClasseResidencia;
    
    function validaTamanhoCampos(){
		if (($this->TipoResidencia != null) && (strlen($this->TipoResidencia) > 2))
		    return false;
		if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;
        if (($this->ClasseResidencia != null) && (strlen($this->ClasseResidencia) > 1))
		    return false;
        return true;
	}    
}
?>