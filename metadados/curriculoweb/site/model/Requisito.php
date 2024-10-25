<?php

class Requisito {

	public $Requisito = null;
	public $Descricao80;
	public $TipoRequisito;
	public $ImprimirCurriculo;
	public $SolicitarFicha;
	public $Avaliacao;
	public $Medida;
	public $ClasseRequisito;
    
    function validaTamanhoCampos(){
		if (($this->Requisito != null) && (strlen($this->Requisito) > 4))
		    return false;
		if (($this->Descricao80 != null) && (strlen($this->Descricao80) > 80))
		    return false;        
        if (($this->TipoRequisito != null) && (strlen($this->TipoRequisito) > 2))
		    return false;
        if (($this->ImprimirCurriculo != null) && (strlen($this->ImprimirCurriculo) > 1))
		    return false;
        if (($this->SolicitarFicha != null) && (strlen($this->SolicitarFicha) > 1))
		    return false;
        if (($this->Avaliacao != null) && (strlen($this->Avaliacao) > 4))
		    return false;
        if (($this->Medida != null) && (strlen($this->Medida) > 4))
		    return false;
        if (($this->ClasseRequisito != null) && (strlen($this->ClasseRequisito) > 4))
		    return false;
        return true;
	}    

}

?>