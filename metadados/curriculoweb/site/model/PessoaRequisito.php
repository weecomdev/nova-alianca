<?php

class PessoaRequisito {
	
	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $Requisito = NULL;
	public $QuantidadeRequisito = NULL;
	public $TextoRequisito = NULL;
	public $Item_Avaliacao = NULL;
	
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;  
        if (($this->Requisito != null) && (strlen($this->Requisito) > 4))
		    return false;
        if (($this->QuantidadeRequisito != null) && (!is_float(floatval($this->QuantidadeRequisito))))
		    return false;
        if (($this->TextoRequisito != null) && (strlen($this->TextoRequisito) > 80))
		    return false;
        if (($this->Item_Avaliacao != null) && (strlen($this->Item_Avaliacao) > 4))
		    return false;
        return true;
	} 
}	
?>