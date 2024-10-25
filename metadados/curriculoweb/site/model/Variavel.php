<?php

class Variavel {
	
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
    public $Descricao80 = NULL;    
    
    function validaTamanhoCampos(){
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
        if (($this->Descricao80 != null) && (strlen($this->Descricao80) > 80))
		    return false;
        return true;
	}    
	
}

?>