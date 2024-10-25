<?php

class InformacaoAdicional{
	
	public $Empresa = NULL;
	public $Pessoa = Null;
	//Variavel
	public $Variavel = NULL;
	public $Descricao40 = NULL;
	public $TipoCampo = NULL;
	public $TamanhoCampo = NULL;
	public $NroDecimais = NULL;
	public $TabelaDescricao = NULL;
	public $CampoChave = NULL;
	public $CampoDescricao = NULL;
	public $TabelaOrigemFutura = NULL;
	public $CampoOrigemFutura = NULL;
    public $Descricao = NULL;
	
	//Requisito
	public $Requisito = null;
	public $Descricao80;
	public $TipoRequisito;
	public $ImprimirCurriculo;
	public $SolicitarFicha;
	public $Avaliacao;
	public $Medida;
	public $ClasseRequisito;
    
    function validaTamanhoCampos(){
		if(($this->Empresa != null) &&  (strlen($this->Empresa) > 4))
		    return false;
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false; 
		if (($this->Variavel != null) && (strlen($this->Variavel) > 4))
		    return false;                 
        if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false;                 
        if (($this->TipoCampo != null) && (strlen($this->TipoCampo) > 3))
		    return false;                 
        if (($this->TamanhoCampo != null) && (!is_numeric($this->TamanhoCampo)))
		    return false;                 
        if (($this->NroDecimais != null) && (!is_numeric($this->NroDecimais)))
		    return false;  
        if (($this->TabelaDescricao != null) && (strlen($this->TabelaDescricao) > 30))
		    return false;      
        if (($this->CampoChave != null) && (strlen($this->CampoChave) > 30))
		    return false;                 
        if (($this->CampoDescricao != null) && (strlen($this->CampoDescricao) > 30))
		    return false;                 
        if (($this->TabelaOrigemFutura != null) && (strlen($this->TabelaOrigemFutura) > 30))
		    return false;                 
        if (($this->CampoOrigemFutura != null) && (strlen($this->CampoOrigemFutura) > 30))
		    return false;                 
        if (($this->Descricao != null) && (strlen($this->Descricao) > 80))
		    return false;        
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