<?php

class Pessoa {

	public $Empresa = NULL;
	public $Pessoa = NULL;
	public $Nome = NULL;
	public $NomeCompleto = NULL;
	public $Apelido = NULL;
	public $DataCadastramento = NULL;
	public $NomeArquivoFoto = NULL;
	public $Foto = NULL;
	public $Pai = NULL;
	public $Mae = NULL;
	public $Nascimento = NULL;
	public $LocalNascimento = NULL;
	public $UFNascimento = NULL;
	public $Sexo = NULL;
	public $RacaCor = NULL;
	public $GrauInstrucao = NULL;
	public $PretensaoSalarial = NULL;
	public $DeficienteFisico = NULL;
	public $BenefReabilitado = NULL;
	public $Estudando = NULL;
	public $EstaTrabalhando = NULL;
	public $Nacionalidade = NULL;
	public $ValidadeVisto = NULL;
	public $AnoChegadaBrasil = NULL;
	public $TipoVisto = NULL;
	public $Identidade = NULL;
	public $TipoIdentidade = NULL;	
	public $ConselhoClasse = NULL;
	public $RegistroConselho = NULL;
	public $DataRegistro = NULL;
	public $InscricaoSindicato = NULL;
	public $Rua = NULL;
	public $NroRua = NULL;
	public $Complemento = NULL;
	public $Bairro = NULL;
	public $Cidade = NULL;
	public $Cep = NULL;
	public $UF = NULL;
	public $DDD = NULL;
	public $Telefone = NULL;
	public $Ramal = NULL;
	public $TelefoneRecados = NULL;
	public $DDDCelular = NULL;
	public $TelefoneCelular = NULL;
	public $Email = NULL;
	public $InicioResidencia = NULL;
	public $CPF = NULL;
	public $UltAlteracao;
	public $RegistroHabilitacao = NULL;
	public $CategoriaHabilitacao = NULL;
	public $ValidadeHabilitacao = NULL;
    public $PIS = NULL;
    public $DataPIS = NULL;
    public $PossuiPIS = NULL;  
    public $AceiteTermo = NULL;
    public $Excluir = NULL;    
	
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4)) 
		    return false;	      
        if (($this->Pessoa != null) && (!is_numeric($this->Pessoa)))
		    return false;
        if (($this->Nome != null) && (strlen($this->Nome) > 40))
		    return false;        
        if (($this->NomeCompleto != null) && (strlen($this->NomeCompleto) > 70))
		    return false;        
        if (($this->Apelido != null) && (strlen($this->Apelido) > 20))
		    return false;        
        if (($this->DataCadastramento != null) && (!DataUtil::ValidaData($this->DataCadastramento)))
		    return false;  
        if (($this->NomeArquivoFoto != null) && (strlen($this->NomeArquivoFoto) > 44))
		    return false;        
        if (($this->Pai != null) && (strlen($this->Pai) > 40))
		    return false;        
        if (($this->Mae != null) && (strlen($this->Mae) > 40))
		    return false;   
        if (($this->Nascimento != null) && (!DataUtil::ValidaData($this->Nascimento)))
		    return false;  
        if (($this->LocalNascimento != null) && (strlen($this->LocalNascimento) > 20))
		    return false;  
        if (($this->UFNascimento != null) && (strlen($this->UFNascimento) > 2))
		    return false; 
        if (($this->Sexo != null) && (strlen($this->Sexo) > 1))
		    return false; 
        if (($this->RacaCor != null) && (strlen($this->RacaCor) > 1))
		    return false;  
        if (($this->DeficienteFisico != null) && (strlen($this->DeficienteFisico) > 1))
		    return false;         
        if (($this->BenefReabilitado != null) && (strlen($this->BenefReabilitado) > 1))
		    return false;   
        if (($this->Estudando != null) && (strlen($this->Estudando) > 1))
		    return false;   
        if (($this->ConselhoClasse != null) && (strlen($this->ConselhoClasse) > 8))
		    return false;   
        if (($this->RegistroConselho != null) && (strlen($this->RegistroConselho) > 12))
		    return false;   
        if (($this->DataRegistro != null) && (!DataUtil::ValidaData($this->DataRegistro)))
		    return false; 
        if (($this->InscricaoSindicato != null) && (strlen($this->InscricaoSindicato) > 16))
		    return false;   
        if (($this->Rua != null) && (strlen($this->Rua) > 40))
		    return false;   
        if (($this->NroRua != null) && (strlen($this->NroRua) > 8))
		    return false;   
        if (($this->Complemento != null) && (strlen($this->Complemento) > 20))
		    return false; 
        if (($this->Bairro != null) && (strlen($this->Bairro) > 20))
		    return false; 
        if (($this->Cidade != null) && (strlen($this->Cidade) > 20))
		    return false;   
        if (($this->Cep != null) && (strlen($this->Cep) > 10))
		    return false;   
        if (($this->UF != null) && (strlen($this->UF) > 2))
		    return false;   
        if (($this->DDD != null) && (strlen($this->DDD) > 4))
		    return false;   
        if (($this->Telefone != null) && (strlen($this->Telefone) > 15))
		    return false;   
        if (($this->Ramal != null) && (strlen($this->Ramal) > 4))
		    return false;   
        if (($this->TelefoneRecados != null) && (strlen($this->TelefoneRecados) > 1))
		    return false;   
        if (($this->DDDCelular != null) && (strlen($this->DDDCelular) > 4))
		    return false;   
        if (($this->TelefoneCelular != null) && (strlen($this->TelefoneCelular) > 15))
		    return false;   
        if (($this->Email != null) && (strlen($this->Email) > 80))
		    return false; 
        if (($this->InicioResidencia != null) && (!DataUtil::ValidaData($this->InicioResidencia)))
		    return false;         
        if (($this->CPF != null) && (strlen($this->CPF) > 11))
		    return false; 
        if (($this->TipoIdentidade != null) && (strlen($this->TipoIdentidade) > 2))
		    return false; 
        if (($this->Identidade != null) && (strlen($this->Identidade) > 15))
		    return false; 
        if (($this->AnoChegadaBrasil != null) && (!is_numeric($this->AnoChegadaBrasil)))
		    return false; 
        if (($this->TipoVisto != null) && (strlen($this->TipoVisto) > 1))
		    return false; 
        if (($this->ValidadeVisto != null) && (!DataUtil::ValidaData($this->ValidadeVisto)))
		    return false; 
        if (($this->UltAlteracao != null) && (!DataUtil::ValidaData($this->UltAlteracao)))
		    return false; 
        if (($this->EstaTrabalhando != null) && (strlen($this->EstaTrabalhando) > 1))
		    return false;       
        if (($this->PretensaoSalarial != null) && (!is_float(floatval($this->PretensaoSalarial))))
		    return false;  
        if (($this->GrauInstrucao != null) && (strlen($this->GrauInstrucao) > 2))
		    return false; 
        if (($this->Nacionalidade != null) && (strlen($this->Nacionalidade) > 2))
		    return false; 
        if (($this->RegistroHabilitacao != null) && (strlen($this->RegistroHabilitacao) > 15))
		    return false; 
        if (($this->ValidadeHabilitacao != null) && (!DataUtil::ValidaData($this->ValidadeHabilitacao)))
		    return false; 
        if (($this->CategoriaHabilitacao != null) && (strlen($this->CategoriaHabilitacao) > 3))
		    return false;    
        if (($this->PIS != null) && (strlen($this->PIS) > 11))
		    return false; 
        if (($this->DataPIS != null) && (!DataUtil::ValidaData($this->DataPIS)))
		    return false; 
        if (($this->PossuiPIS != null) && (strlen($this->PossuiPIS) > 1))
		    return false;
        if (($this->AceiteTermo != null) && (strlen($this->AceiteTermo) > 1))
		    return false; 
        if (($this->Excluir != null) && (strlen($this->Excluir) > 1))
		    return false;   
        return true;
	} 	
}

?>