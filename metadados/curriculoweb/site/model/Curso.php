<?php
class Curso {
	public $Curso = null;
	public $Descricao50;
	public $ProgramaCurso;
	public $DataCriacao;
	public $DataDesativacao;
	public $Validade;
	public $CarHoraria;
	public $TipoLocal;
	public $TipoCurso;
	public $UltimaRevisaoExigida;
	public $UltDtRevisaoExigida;
	public $ClassificacaoCurso;
	public $TextoOLE;
	public $UsaModulo10;
	public $AvaliarReacao;
	public $AvaliarPreTeste;
	public $AvaliarEficacia;
	public $AvaliarPosTeste;
	public $QuestionarioPre;
	public $QuestionarioPos;
	public $ObjetivoCurso;
	public $GrauInstrucaoAndamento;
	public $GrauInstrucaoConcluido;
	public $Fornecedor;
    
    function validaTamanhoCampos(){
		if (($this->Curso != null) && (strlen($this->Curso) > 15))
		    return false;
		if (($this->Descricao50 != null) && (strlen($this->Descricao50) > 50))
		    return false;             
        if (($this->DataCriacao != null) && (!DataUtil::ValidaData($this->DataCriacao)))
		    return false;          
        if (($this->DataDesativacao != null) && (!DataUtil::ValidaData($this->DataDesativacao)))
		    return false;  
		if (($this->Validade != null) && (!is_numeric($this->Validade)))
		    return false;         
		if (($this->CarHoraria != null) && (!is_float(floatval($this->CarHoraria))))
		    return false;     
		if (($this->TipoLocal != null) && (strlen($this->TipoLocal) > 1))
		    return false;  
		if (($this->TipoCurso != null) && (strlen($this->TipoCurso) > 2))
		    return false;    
		if (($this->UltimaRevisaoExigida != null) && (!is_numeric($this->UltimaRevisaoExigida)))
		    return false;  
        if (($this->UltDtRevisaoExigida != null) && (!DataUtil::ValidaData($this->UltDtRevisaoExigida)))
		    return false; 
        if (($this->ClassificacaoCurso != null) && (strlen($this->ClassificacaoCurso) > 4))
		    return false;   
        if (($this->UsaModulo10 != null) && (strlen($this->UsaModulo10) > 1))
		    return false;          
        if (($this->AvaliarReacao != null) && (strlen($this->AvaliarReacao) > 1))
		    return false;  
        if (($this->AvaliarPreTeste != null) && (strlen($this->AvaliarPreTeste) > 1))
		    return false;          
        if (($this->AvaliarEficacia != null) && (strlen($this->AvaliarEficacia) > 1))
		    return false;          
        if (($this->AvaliarPosTeste != null) && (strlen($this->AvaliarPosTeste) > 1))
		    return false;          
        if (($this->QuestionarioPre != null) && (strlen($this->QuestionarioPre) > 4))
		    return false;  
        if (($this->QuestionarioPos != null) && (strlen($this->QuestionarioPos) > 4))
		    return false;           
        if (($this->GrauInstrucaoAndamento != null) && (strlen($this->GrauInstrucaoAndamento) > 2))
		    return false;        
        if (($this->GrauInstrucaoConcluido != null) && (strlen($this->GrauInstrucaoConcluido) > 2))
		    return false;  
        if (($this->Fornecedor != null) && (strlen($this->Fornecedor) > 4))
		    return false;      
        return true;
	}          
}
?>