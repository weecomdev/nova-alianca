<?php

class VinculoEmpregaticio {

	public $VinculoEmpregaticio = null;
	public $Descricao40;
	public $Descricao20;
	public $VinculoEmpregaticioRAIS;
	public $CategoriaSEFIP;
	public $OpcaoPrevidencia;
	public $VinculoPrevidencia;
	public $RecolheFGTS;
	public $VinculoSindicato;
	public $RecebeFerias;
	public $RegimeTempoParcial;
	public $Recebe13Salario;
	public $CodigoRetencao;
    
    function validaTamanhoCampos(){
		if (($this->VinculoEmpregaticio != null) && (strlen($this->VinculoEmpregaticio) > 2))
		    return false;
		if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;       
        if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;       
        if (($this->VinculoEmpregaticioRAIS != null) && (strlen($this->VinculoEmpregaticioRAIS) > 2))
		    return false;       
        if (($this->CategoriaSEFIP != null) && (strlen($this->CategoriaSEFIP) > 2))
		    return false;       
        if (($this->OpcaoPrevidencia != null) && (strlen($this->OpcaoPrevidencia) > 1))
		    return false;       
        if (($this->VinculoPrevidencia != null) && (strlen($this->VinculoPrevidencia) > 1))
		    return false;       
        if (($this->RecolheFGTS != null) && (strlen($this->RecolheFGTS) > 1))
		    return false;         
        if (($this->VinculoSindicato != null) && (strlen($this->VinculoSindicato) > 1))
		    return false; 
        if (($this->RecebeFerias != null) && (strlen($this->RecebeFerias) > 1))
		    return false; 
        if (($this->RegimeTempoParcial != null) && (strlen($this->RegimeTempoParcial) > 1))
		    return false;       
        if (($this->Recebe13Salario != null) && (strlen($this->Recebe13Salario) > 1))
		    return false;
        if (($this->CodigoRetencao != null) && (strlen($this->CodigoRetencao) > 4))
		    return false;       
        return true;
	}    

}

?>