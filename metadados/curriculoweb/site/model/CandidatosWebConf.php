<?php

class CandidatosWebConf {

	public $Empresa;
	public $Descricao80;
	public $ExibirPretensaoSal;
	public $ExibirDeficiente;
	public $ExibirEmpAnteriores;
	public $ExibirDadosCompl;
	public $ExibirCursos;
	public $ExibirIdiomas;
	public $ExibirPalavrasChave;
	public $NroMaximoPlvChave;
	public $ExibirRequisitos;
	public $ExibirInteresse;
	public $NroMaximoInteresses;
	public $CargoSel;
	public $FuncaoSel;
	public $AreaAtuacaoSel;
	public $PalavraChaveSel;
	public $RequisitoSel;	
	public $ChaveCriptografia;
	public $DataUltimaImportacao;
	public $UsaProxy;
	public $Servidor;
	public $Porta;
	public $RequerAutenticacao;
	public $UsuarioProxy;
	public $SenhaProxy;
	public $Email;
	public $ServidorEmail;
	public $PortaSMTP;
	public $UsuarioSMTP;
	public $RequerAutenticacaoEmail;
	public $ConexaoSegura;
	public $SenhaSMTP;	
	public $OrdemPlvChave;
	public $OrdemInteresses;	
	public $EmailDe;
	public $ConfigurarEmailPor;
    public $UsaHttps;
    public $TermoHTML;
    public $MinimoCaracteres;
    public $UsaLetrasNumeros;
    public $UsaCaracteresEspeciais;
    public $UsaMaiusculasMinusculas;
    
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
        if (($this->Descricao80 != null) && (strlen($this->Descricao80) > 80))
		    return false;
        if (($this->ExibirPretensaoSal != null) && (strlen($this->ExibirPretensaoSal) > 1))
		    return false; 
        if (($this->ExibirDeficiente != null) && (strlen($this->ExibirDeficiente) > 1))
		    return false;         
        if (($this->ExibirEmpAnteriores != null) && (strlen($this->ExibirEmpAnteriores) > 1))
		    return false;              
        if (($this->ExibirDadosCompl != null) && (strlen($this->ExibirDadosCompl) > 1))
		    return false;              
        if (($this->ExibirCursos != null) && (strlen($this->ExibirCursos) > 1))
		    return false;      
        if (($this->ExibirIdiomas != null) && (strlen($this->ExibirIdiomas) > 1))
		    return false;              
        if (($this->ExibirPalavrasChave != null) && (strlen($this->ExibirPalavrasChave) > 1))
		    return false;              
        if (($this->NroMaximoPlvChave != null) && (!is_numeric($this->NroMaximoPlvChave)))
		    return false;    
        if (($this->CargoSel != null) && (strlen($this->CargoSel) > 1))
		    return false;   
        if (($this->FuncaoSel != null) && (strlen($this->FuncaoSel) > 1))
		    return false;         
        if (($this->AreaAtuacaoSel != null) && (strlen($this->AreaAtuacaoSel) > 1))
		    return false;                 
        if (($this->PalavraChaveSel != null) && (strlen($this->PalavraChaveSel) > 1))
		    return false;                         
        if (($this->RequisitoSel != null) && (strlen($this->RequisitoSel) > 1))
		    return false;                                 
        if (($this->ChaveCriptografia != null) && (strlen($this->ChaveCriptografia) > 40))
		    return false;                                
        if (($this->DataUltimaImportacao != null) && (!DataUtil::ValidaData($this->DataUltimaImportacao)))
		    return false;   
        if (($this->UsaProxy != null) && (strlen($this->UsaProxy) > 1))
		    return false;                                         
        if (($this->Servidor != null) && (strlen($this->Servidor) > 100))
		    return false;                                         
        if (($this->Porta != null) && (!is_numeric($this->Porta)))
		    return false;    
        if (($this->RequerAutenticacao != null) && (strlen($this->RequerAutenticacao) > 1))
		    return false;    
        if (($this->UsuarioProxy != null) && (strlen($this->UsuarioProxy) > 60))
		    return false;            
        if (($this->SenhaProxy != null) && (strlen($this->SenhaProxy) > 60))
		    return false;                                         
        if (($this->Email != null) && (strlen($this->Email) > 40))
		    return false;          
        if (($this->ServidorEmail != null) && (strlen($this->ServidorEmail) > 100))
		    return false;                  
        if (($this->PortaSMTP != null) && (!is_numeric($this->PortaSMTP)))
		    return false; 
        if (($this->UsuarioSMTP != null) && (strlen($this->UsuarioSMTP) > 60))
		    return false;          
        if (($this->RequerAutenticacaoEmail != null) && (strlen($this->RequerAutenticacaoEmail) > 1))
		    return false;          
        if (($this->ConexaoSegura != null) && (strlen($this->ConexaoSegura) > 1))
		    return false;  
        if (($this->SenhaSMTP != null) && (strlen($this->SenhaSMTP) > 200))
		    return false;          
        if (($this->OrdemPlvChave != null) && (strlen($this->OrdemPlvChave) > 1))
		    return false;            
        if (($this->OrdemInteresses != null) && (strlen($this->OrdemInteresses) > 1))
		    return false;           
        if (($this->EmailDe != null) && (strlen($this->EmailDe) > 40))
		    return false;            
        if (($this->ConfigurarEmailPor != null) && (strlen($this->ConfigurarEmailPor) > 1))
		    return false; 
        if (($this->UsaHttps != null) && (strlen($this->UsaHttps) > 1))
		    return false;  
        if (($this->TermoHTML != null) && (strlen($this->TermoHTML) > 8000))
		    return false; 
        if (($this->MinimoCaracteres != null) && (!is_numeric($this->MinimoCaracteres)))
		    return false; 
        if (($this->UsaLetrasNumeros != null) && (strlen($this->UsaLetrasNumeros) > 1))
		    return false;
        if (($this->UsaCaracteresEspeciais != null) && (strlen($this->UsaCaracteresEspeciais) > 1))
		    return false; 
        if (($this->UsaMaiusculasMinusculas != null) && (strlen($this->UsaMaiusculasMinusculas) > 1))
		    return false;                                                          
        return true;
	}    
	
}

?>