<?php
class OpcaoDicionario {
	public $CampoTabela = null;
	public $Opcao;
	public $TamanhoDescricao;
	public $Descricao60;
    
    function validaTamanhoCampos(){
		if (($this->CampoTabela != null) && (strlen($this->CampoTabela) > 30))
		    return false;
		if (($this->Opcao != null) && (strlen($this->Opcao) > 6))
		    return false;	 
        if (($this->TamanhoDescricao != null) && (!is_numeric($this->TamanhoDescricao)))
		    return false;
        if (($this->Descricao60 != null) && (strlen($this->Descricao60) > 60))
		    return false;         
        return true;
	} 
}
?>