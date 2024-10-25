<?php 
Class PessoaAnexo{
	public $Empresa;
	public $Pessoa;
	public $ArquivoBlob;
    public $NomeArquivo;
    public $TipoArquivo;   
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;       
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;          
        if (($this->NomeArquivo != null) && (strlen($this->NomeArquivo) > 250))
		    return false;       
        if (($this->TipoArquivo != null) && (strlen($this->TipoArquivo) > 10))
		    return false;               
        return true;
	}    
}
?>
