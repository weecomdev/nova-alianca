<?php

class PessoaCurso {
	
	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $NroOrdem = NULL;
	
	// chave da tabela rhcursos
	public $Curso = NULL;
	public $Descricao50 = NULL;
	
	// campo com a descricao do curso
	public $Nm_Curso = NULL;
	
	// Entidade
	public $Descricao40 = NULL;
	public $Car_Horaria = NULL;
	public $Dt_Inicio = NULL;
	public $Dt_Encerra = NULL;	
	
	public $OrigemCurriculo = '2';

	//Descricao do tipo de curso
	public $TipoCurso = null;
	public $DescTpCurso = null;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;  
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;
        if (($this->NroOrdem != null) && (!is_numeric($this->NroOrdem)))
		    return false;               
        if (($this->Curso != null) && (strlen($this->Curso) > 15))
		    return false;
        if (($this->Descricao50 != null) && (strlen($this->Descricao50) > 50))
		    return false; 
        if (($this->Car_Horaria != null) && (!is_float(floatval($this->Car_Horaria))))
		    return false; 
        if (($this->Dt_Inicio != null) && (!DataUtil::ValidaData($this->Dt_Inicio)))
		    return false;        
        if (($this->Dt_Encerra != null) && (!DataUtil::ValidaData($this->Dt_Encerra)))
		    return false; 
        if (($this->Descricao40 != null) && (strlen($this->Descricao40) > 40))
		    return false; 
        if (($this->OrigemCurriculo != null) && (strlen($this->OrigemCurriculo) > 1))
		    return false; 
        return true;
	}      
	
}

?>