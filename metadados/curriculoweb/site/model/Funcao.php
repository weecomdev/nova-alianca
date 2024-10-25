<?php
class Funcao {
	public $Funcao = null;
	public $Descricao40;
	public $Descricao20;
	public $Cargo;
	public $CBO;
	public $CBONovo;
	public $PlanoCargo;
	public $FaixaSalarial;
	public $ClasseSalarial;
	public $RequisitosFuncaoPPP;
	public $DescAtividadesPPP;
	public $ConstarPPP;
	public $FatorRequisito;
	public $FatorDescricao;
	public $TextoOLE;
	public $GrauInstrucao;
	public $AtivaDesativada;
	public $GrauInstrucaoMaximo;
	public $MaodeObra;
    
    function validaTamanhoCampos(){
		if (($this->Funcao != null) && (strlen($this->Funcao) > 8))
		    return false;
		if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;   
        if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false;          
        if (($this->Cargo != null) && (strlen($this->Cargo) > 8))
		    return false; 
        if (($this->CBO != null) && (strlen($this->CBO) > 6))
		    return false;       
        if (($this->CBONovo != null) && (strlen($this->CBONovo) > 6))
		    return false;          
        if (($this->PlanoCargo != null) && (strlen($this->PlanoCargo) > 4))
		    return false;          
        if (($this->FaixaSalarial != null) && (strlen($this->FaixaSalarial) > 4))
		    return false;  
        if (($this->ClasseSalarial != null) && (strlen($this->ClasseSalarial) > 4))
		    return false;          
        if (($this->ConstarPPP != null) && (strlen($this->ConstarPPP) > 1))
		    return false;          
        if (($this->FatorRequisito != null) && (strlen($this->FatorRequisito) > 4))
		    return false;          
        if (($this->FatorDescricao != null) && (strlen($this->FatorDescricao) > 4))
		    return false;          
        if (($this->GrauInstrucao != null) && (strlen($this->GrauInstrucao) > 2))
		    return false;  
        if (($this->AtivaDesativada != null) && (strlen($this->AtivaDesativada) > 1))
		    return false;          
        if (($this->GrauInstrucaoMaximo != null) && (strlen($this->GrauInstrucaoMaximo) > 2))
		    return false;          
        if (($this->MaodeObra != null) && (strlen($this->MaodeObra) > 1))
		    return false;          
        return true;
	}     
}
?>