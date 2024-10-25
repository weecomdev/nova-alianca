<?php
class PessoaAreaInteresse {
	
	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $NroOrdem = NULL;
	public $AreaAtuacao = NULL;
	
	public $ExibirExperiencia = "01";
	public $OrigemCurriculo = 2;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;	   
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;        
        if (($this->NroOrdem != null) && (!is_numeric($this->NroOrdem)))
		    return false;
        if(($this->ExibirExperiencia != null) &&  (strlen($this->ExibirExperiencia) > 2))
		    return false;
        if (($this->AreaAtuacao != null) && (strlen($this->AreaAtuacao) > 4))
		    return false;
        if (($this->OrigemCurriculo != null) && (strlen($this->OrigemCurriculo) > 1))
		    return false;
        return true;
	}  
}

?>