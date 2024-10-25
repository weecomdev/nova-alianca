<?php

class Requisicao {
	
	public $Empresa = NULL;
	public $Requisicao = NULL;
	public $DataRequisicao = NULL;
	public $SituacaoRequisicao = NULL;
	public $QuantidadeVagas = NULL;
	public $Observacoes = NULL;
	public $SalarioMaximo = NULL;
	public $VinculoEmpregaticio = NULL;
	public $Funcao = NULL;	
	public $Cargo = NULL;
	public $AreaAtuacao = NULL;
	public $DescricaoAtividades = NULL;
	public $AbrirInscricao = NULL;
	public $DivulgarVagaExt = NULL;
	public $InicioSelecao = NULL;
	public $PrazoEncerramento = NULL;
	public $Dt_Encerra = NULL;
	
	// Search
	public $SalarioInicio;
	public $SalarioFim;
    
    function validaTamanhoCampos(){
		if (($this->Requisicao != null) && (strlen($this->Requisicao) > 8))
		    return false;
        if (($this->DataRequisicao != null) && (!DataUtil::ValidaData($this->DataRequisicao)))
		    return false;   
        if (($this->SituacaoRequisicao != null) && (strlen($this->SituacaoRequisicao) > 1))
		    return false;
        if (($this->QuantidadeVagas != null) && (!is_numeric($this->QuantidadeVagas)))
		    return false;        
        if (($this->SalarioMaximo != null) && (!is_float(floatval($this->SalarioMaximo))))
		    return false; 
        if (($this->VinculoEmpregaticio != null) && (strlen($this->VinculoEmpregaticio) > 2))
		    return false;      
        if (($this->Funcao != null) && (strlen($this->Funcao) > 8))
		    return false;
        if (($this->Cargo != null) && (strlen($this->Cargo) > 8))
		    return false;
        if (($this->AreaAtuacao != null) && (strlen($this->AreaAtuacao) > 4))
		    return false;
        if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
        if (($this->AbrirInscricao != null) && (strlen($this->AbrirInscricao) > 1))
		    return false;
        if (($this->DivulgarVagaExt != null) && (strlen($this->DivulgarVagaExt) > 1))
		    return false;
        if (($this->InicioSelecao != null) && (!DataUtil::ValidaData($this->InicioSelecao)))
		    return false;
        if (($this->PrazoEncerramento != null) && (!DataUtil::ValidaData($this->PrazoEncerramento)))
		    return false;
        if (($this->Dt_Encerra != null) && (!DataUtil::ValidaData($this->Dt_Encerra)))
		    return false;
        return true;
	}    
}

?>