<?php

class Cargo {

	public $Cargo = null;
	public $Descricao40;
	public $Descricao20;
	public $DescricaoOficial;
	public $CBO;
	public $CBONovo;
	public $CodigoOcupacaoIR;
	public $PlanoCargo;
	public $FaixaSalarial;
	public $ClasseSalarial;
	public $TextoOLE;
	public $NivelCargo;
	public $GrauInstrucao;
	public $FatorRequisito;
	public $FatorDescricao;
	public $AtivaDesativada;
	public $GrauInstrucaoMaximo;
	public $MaodeObra;
	public $CargoDeProfessor;
    
    function validaTamanhoCampos(){
		if (($this->Cargo != null) && (strlen($this->Cargo) > 8))
		    return false;
		if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;
        if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;   
        if (($this->DescricaoOficial != null) && (strlen($this->DescricaoOficial) > 40))
		    return false;           
        if (($this->CBO != null) && (strlen($this->CBO) > 6))
		    return false;
        if (($this->CodigoOcupacaoIR != null) && (strlen($this->CodigoOcupacaoIR) > 3))
		    return false;
        if (($this->PlanoCargo != null) && (strlen($this->PlanoCargo) > 4))
		    return false;
        if (($this->FaixaSalarial != null) && (strlen($this->FaixaSalarial) > 4))
		    return false;
        if (($this->ClasseSalarial != null) && (strlen($this->ClasseSalarial) > 4))
		    return false;    
        if (($this->NivelCargo != null) && (!is_numeric($this->NivelCargo)))
		    return false;       
        if (($this->GrauInstrucao != null) && (strlen($this->GrauInstrucao) > 2))
		    return false;        
        if (($this->FatorRequisito != null) && (strlen($this->FatorRequisito) > 4))
		    return false; 
        if (($this->FatorDescricao != null) && (strlen($this->FatorDescricao) > 4))
		    return false;     
        if (($this->AtivaDesativada != null) && (strlen($this->AtivaDesativada) > 1))
		    return false;   
        if (($this->GrauInstrucaoMaximo != null) && (strlen($this->GrauInstrucaoMaximo) > 2))
		    return false;       
        if (($this->MaodeObra != null) && (strlen($this->MaodeObra) > 1))
		    return false;     
        if (($this->CargoDeProfessor != null) && (strlen($this->CargoDeProfessor) > 1))
		    return false;        
        return true;
	}      

}

?>