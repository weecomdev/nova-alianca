<?php

class CandidatosWebConfDao {

	private $db;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarCandidatosWebConfPorParametros() {
		
		$sql = "select * from rhcandidatoswebconf ";

		return $this->db->Execute($sql);
		
	}
    
    function buscarPoliticaDeSenhas() {
		
		$sql = "select * from rhcandidatoswebconf ";

		$retorno = $this->db->Execute($sql);

        if ($retorno->fields['Empresa'] != "")
        {
            $candidato = new CandidatosWebConf();
			$candidato->MinimoCaracteres = $retorno->fields['MinimoCaracteres'];
            $candidato->UsaLetrasNumeros  = $retorno->fields['UsaLetrasNumeros'];
            $candidato->UsaCaracteresEspeciais = $retorno->fields['UsaCaracteresEspeciais'];
            $candidato->UsaMaiusculasMinusculas = $retorno->fields['UsaMaiusculasMinusculas'];
			return $candidato;

        }
		
	}

	function buscarCandidatosWebConfPorParametrosEmpresa($empresa) {
		
		$sql = "select * from rhcandidatoswebconf Where Empresa =? ";

        $query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);

		return  $this->db->Execute($query,$pEmpresa);
		
	}		
    function buscarTermoHtmlCandidatosWebConf() {
		
		$sql = "select TermoHTML from rhcandidatoswebconf ";

        return $this->db->Execute($sql)->fields['TermoHTML']; 
		
	}	
	
	function buscaEmpresaPrincipal(){
		$sql = "select Empresa from rhcandidatoswebconf ";
        return $this->db->Execute($sql)->fields['Empresa'];	}
	
	private function prepareStatement(CandidatosWebConf $candidatosWebConf) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($candidatosWebConf->Empresa)){
                $columns[$c++] = "Empresa";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($candidatosWebConf->Empresa));
        }

        if (!is_null($candidatosWebConf->Descricao80)){
                $columns[$c++] = "Descricao80";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'', $this->db->qstr($candidatosWebConf->Descricao80));
        }

        if (!is_null($candidatosWebConf->ExibirPretensaoSal)){
                $columns[$c++] = "ExibirPretensaoSal";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirPretensaoSal));
        }

        if (!is_null($candidatosWebConf->ExibirDeficiente)){
                $columns[$c++] = "ExibirDeficiente";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirDeficiente));
        }

        if (!is_null($candidatosWebConf->ExibirEmpAnteriores)){
                $columns[$c++] = "ExibirEmpAnteriores";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirEmpAnteriores));
        }

        if (!is_null($candidatosWebConf->ExibirDadosCompl)){
                $columns[$c++] = "ExibirDadosCompl";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirDadosCompl)) ;
        }
        if (!is_null($candidatosWebConf->ExibirCursos)){
                $columns[$c++] = "ExibirCursos";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirCursos)) ;
        }

        if (!is_null($candidatosWebConf->ExibirIdiomas)){
                $columns[$c++] = "ExibirIdiomas";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirIdiomas)) ;
        }
        if (!is_null($candidatosWebConf->ExibirPalavrasChave)){
                $columns[$c++] = "ExibirPalavrasChave";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirPalavrasChave)) ;
        }

        if (!is_null($candidatosWebConf->NroMaximoPlvChave)){
                $columns[$c++] = "NroMaximoPlvChave";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->NroMaximoPlvChave)) ;
        }

        if (!is_null($candidatosWebConf->ExibirRequisitos)){
                $columns[$c++] = "ExibirRequisitos";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirRequisitos)) ;
        }

        if (!is_null($candidatosWebConf->ExibirInteresse)){
                $columns[$c++] = "ExibirInteresse";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ExibirInteresse)) ;
        }
        if (!is_null($candidatosWebConf->NroMaximoInteresses)){
                $columns[$c++] = "NroMaximoInteresses";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->NroMaximoInteresses)) ;
        }

        if (!is_null($candidatosWebConf->CargoSel)){
                $columns[$c++] = "CargoSel";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->CargoSel)) ;
        }
        if (!is_null($candidatosWebConf->FuncaoSel)){
                $columns[$c++] = "FuncaoSel";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->FuncaoSel)) ;
        }

        if (!is_null($candidatosWebConf->AreaAtuacaoSel)){
                $columns[$c++] = "AreaAtuacaoSel";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->AreaAtuacaoSel)) ;
        }
        if (!is_null($candidatosWebConf->PalavraChaveSel)){
                $columns[$c++] = "PalavraChaveSel";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->PalavraChaveSel ));
        }

        if (!is_null($candidatosWebConf->RequisitoSel)){
                $columns[$c++] = "RequisitoSel";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->RequisitoSel)) ;
        }

        if (!is_null($candidatosWebConf->ChaveCriptografia)){
                $columns[$c++] = "ChaveCriptografia";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($candidatosWebConf->ChaveCriptografia)) ;
        }

        if (!is_null($candidatosWebConf->DataUltimaImportacao)){
                $columns[$c++] = "DataUltimaImportacao";
                $values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($candidatosWebConf->DataUltimaImportacao)) ;
        }
        
        if (!is_null($candidatosWebConf->UsaProxy)){
                $columns[$c++] = "UsaProxy";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->UsaProxy)) ;
        }
        
        if (!is_null($candidatosWebConf->Servidor)){
                $columns[$c++] = "Servidor";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($candidatosWebConf->Servidor)) ;
        }
        
        if (!is_null($candidatosWebConf->Porta) && ($candidatosWebConf->Porta != "")){
                $columns[$c++] = "Porta";
                $values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($candidatosWebConf->Porta));
        }
        
		if (!is_null($candidatosWebConf->RequerAutenticacao)){
                $columns[$c++] = "RequerAutenticacao";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->RequerAutenticacao)) ;
        }
        
        if (!is_null($candidatosWebConf->UsuarioProxy)){
                $columns[$c++] = "UsuarioProxy";
                $values[$v++] = preg_replace('#[^\pL\pN./\':_@. -]+# ', '', $this->db->qstr($candidatosWebConf->UsuarioProxy)) ;
        }

        if (!is_null($candidatosWebConf->SenhaProxy)){
                $columns[$c++] = "SenhaProxy";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'', $this->db->qstr($candidatosWebConf->SenhaProxy)) ;
        }

        if (!is_null($candidatosWebConf->Email)){
                $columns[$c++] = "Email";
                $values[$v++] = preg_replace('#[^\pL\pN./\':_@. -]+# ', '', $this->db->qstr($candidatosWebConf->Email)) ;
        }

        if (!is_null($candidatosWebConf->ServidorEmail)){
                $columns[$c++] = "ServidorEmail";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($candidatosWebConf->ServidorEmail)) ;
        }

        if (!is_null($candidatosWebConf->PortaSMTP) && ($candidatosWebConf->PortaSMTP != "")){
                $columns[$c++] = "PortaSMTP";
                $values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($candidatosWebConf->PortaSMTP));
        }

        if (!is_null($candidatosWebConf->UsuarioSMTP)){
                $columns[$c++] = "UsuarioSMTP";
                $values[$v++] = preg_replace('#[^\pL\pN./\'@_: -]+# ', '', $this->db->qstr($candidatosWebConf->UsuarioSMTP)) ;
        }

        if (!is_null($candidatosWebConf->RequerAutenticacaoEmail)){
                $columns[$c++] = "RequerAutenticacaoEmail";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->RequerAutenticacaoEmail)) ;
        }

        if (!is_null($candidatosWebConf->ConexaoSegura)){
                $columns[$c++] = "ConexaoSegura";
                $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->ConexaoSegura)) ;
        }

        if (!is_null($candidatosWebConf->SenhaSMTP)){
                $columns[$c++] = "SenhaSMTP";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'', $this->db->qstr($candidatosWebConf->SenhaSMTP)) ;
        }
        
        if (!is_null($candidatosWebConf->OrdemPlvChave)){
        	    $columns[$c++] = "OrdemPlvChave";
        	    $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->OrdemPlvChave)) ;
        }
        
        if (!is_null($candidatosWebConf->OrdemInteresses)){
        	    $columns[$c++] = "OrdemInteresses";
        	    $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->OrdemInteresses)) ;
        }
        
	    if (!is_null($candidatosWebConf->EmailDe)){
        	    $columns[$c++] = "EmailDe";
        	    $values[$v++] = preg_replace('#[^\pL\pN./\'@_: -]+# ', '', $this->db->qstr($candidatosWebConf->EmailDe)) ;
        }
        
	    if (!is_null($candidatosWebConf->ConfigurarEmailPor)){
        	    $columns[$c++] = "ConfigurarEmailPor";
        	    $values[$v++] = preg_replace('#[^\pL\pN./\'_@ -]+# ', '', $this->db->qstr($candidatosWebConf->ConfigurarEmailPor)) ;
        }    
        
        if (!is_null($candidatosWebConf->UsaHttps)){
            $columns[$c++] = "UsaHttps";
            $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->UsaHttps));
        }  

        if (!is_null($candidatosWebConf->TermoHTML)){
           $columns[$c++] = "TermoHTML";
           $values[$v++] = $this->db->qstr($candidatosWebConf->TermoHTML);
        } 

        if (!is_null($candidatosWebConf->MinimoCaracteres)){
            $columns[$c++] = "MinimoCaracteres";
            $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->MinimoCaracteres));
        } 

       if (!is_null($candidatosWebConf->UsaLetrasNumeros)){
            $columns[$c++] = "UsaLetrasNumeros";
            $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->UsaLetrasNumeros));
        }
 
       if (!is_null($candidatosWebConf->UsaCaracteresEspeciais)){
            $columns[$c++] = "UsaCaracteresEspeciais";
            $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->UsaCaracteresEspeciais));
        }   

       if (!is_null($candidatosWebConf->UsaMaiusculasMinusculas)){
            $columns[$c++] = "UsaMaiusculasMinusculas";
            $values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($candidatosWebConf->UsaMaiusculasMinusculas));
        }                             
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarCandidatosWebConf(CandidatosWebConf $candidatosWebConf) {
		$statement = $this->prepareStatement($candidatosWebConf);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhcandidatoswebconf(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);	
	}

	function excluirCandidatosWebConf() {
		$sql = "delete from rhcandidatoswebconf ";

		return $this->db->Execute($sql);
	}	
}
?>