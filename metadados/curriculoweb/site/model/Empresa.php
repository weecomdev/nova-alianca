<?php
class Empresa {
	public $Empresa = null;
	public $RazaoSocial;
	public $Descricao20;
	public $TipoEmpresa;
	public $UsaFolha;
	public $UsaPonto;
	public $UsaRecrutamento;
	public $UsaTreinamento;
	public $UsaCargosSalarios;
	public $UsaGestaoSalarial;
	public $UsaSeguranca;
	public $UsaPCMSO;
	public $UsaValeTransp;
	public $UsaModulo01;
	public $UsaModulo02;
	public $UsaModulo03;
	public $UsaModulo04;
	public $UsaModulo05;
	public $UsaModulo06;
	public $UsaModulo07;
	public $UsaModulo08;
	public $UsaModulo09;
	public $UsaModulo10;
	public $UsaModulo11;
	public $UsaModulo12;
	public $UsaModulo13;
	public $UsaModulo14;
	public $UsaModulo15;
	public $UsaModulo16;
	public $UsaModulo17;
	public $UsaModulo18;
	public $UsaModulo19;
	public $UsaModulo20;
	public $GrupoEmpresa;
	public $Usuario;
	public $AtivaDesativada;
    
    function validaTamanhoCampos(){
		if (($this->Empresa != null) && (strlen($this->Empresa) > 4))
		    return false;
		if (($this->RazaoSocial != null) && (strlen($this->RazaoSocial) > 40))
		    return false;       
        if (($this->Descricao20 != null) && (strlen($this->Descricao20) > 20))
		    return false; 
        if (($this->TipoEmpresa != null) && (strlen($this->TipoEmpresa) > 1))
		    return false; 
        if (($this->UsaFolha != null) && (strlen($this->UsaFolha) > 1))
		    return false; 
        if (($this->UsaPonto != null) && (strlen($this->UsaPonto) > 1))
		    return false; 
        if (($this->UsaRecrutamento != null) && (strlen($this->UsaRecrutamento) > 1))
		    return false; 
        if (($this->UsaTreinamento != null) && (strlen($this->UsaTreinamento) > 1))
		    return false; 
        if (($this->UsaCargosSalarios != null) && (strlen($this->UsaCargosSalarios) > 1))
		    return false; 
        if (($this->UsaGestaoSalarial != null) && (strlen($this->UsaGestaoSalarial) > 1))
		    return false; 
        if (($this->UsaSeguranca != null) && (strlen($this->UsaSeguranca) > 1))
		    return false; 
        if (($this->UsaPCMSO != null) && (strlen($this->UsaPCMSO) > 1))
		    return false; 
        if (($this->UsaValeTransp != null) && (strlen($this->UsaValeTransp) > 1))
		    return false; 
        if (($this->UsaModulo01 != null) && (strlen($this->UsaModulo01) > 1))
		    return false;        
        if (($this->UsaModulo02 != null) && (strlen($this->UsaModulo02) > 1))
		    return false; 
        if (($this->UsaModulo03 != null) && (strlen($this->UsaModulo03) > 1))
		    return false; 
        if (($this->UsaModulo04 != null) && (strlen($this->UsaModulo04) > 1))
		    return false; 
        if (($this->UsaModulo05 != null) && (strlen($this->UsaModulo05) > 1))
		    return false; 
        if (($this->UsaModulo06 != null) && (strlen($this->UsaModulo06) > 1))
		    return false; 
        if (($this->UsaModulo07 != null) && (strlen($this->UsaModulo07) > 1))
		    return false; 
        if (($this->UsaModulo08 != null) && (strlen($this->UsaModulo08) > 1))
		    return false; 
        if (($this->UsaModulo09 != null) && (strlen($this->UsaModulo09) > 1))
		    return false;
        if (($this->UsaModulo10 != null) && (strlen($this->UsaModulo10) > 1))
		    return false; 
        if (($this->UsaModulo11 != null) && (strlen($this->UsaModulo11) > 1))
		    return false; 
        if (($this->UsaModulo12 != null) && (strlen($this->UsaModulo12) > 1))
		    return false; 
        if (($this->UsaModulo13 != null) && (strlen($this->UsaModulo13) > 1))
		    return false; 
        if (($this->UsaModulo14 != null) && (strlen($this->UsaModulo14) > 1))
		    return false; 
        if (($this->UsaModulo15 != null) && (strlen($this->UsaModulo15) > 1))
		    return false; 
        if (($this->UsaModulo16 != null) && (strlen($this->UsaModulo16) > 1))
		    return false; 
        if (($this->UsaModulo17 != null) && (strlen($this->UsaModulo17) > 1))
		    return false; 
        if (($this->UsaModulo18 != null) && (strlen($this->UsaModulo18) > 1))
		    return false; 
        if (($this->UsaModulo19 != null) && (strlen($this->UsaModulo19) > 1))
		    return false;
        if (($this->UsaModulo20 != null) && (strlen($this->UsaModulo20) > 1))
		    return false; 
        if (($this->GrupoEmpresa != null) && (strlen($this->GrupoEmpresa) > 4))
		    return false; 
        if (($this->Usuario != null) && (strlen($this->Usuario) > 4))
		    return false; 
        if (($this->AtivaDesativada != null) && (strlen($this->AtivaDesativada) > 1))
		    return false; 
        return true;
	}  
}
?>