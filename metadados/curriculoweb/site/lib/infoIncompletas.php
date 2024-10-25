<?php
class InfoIncompletas {

	private $db;
	private $arrCamposObrVazios=array();
	private $arrCamposObr=array();
	private $camposVaziosDao=null;

	function __construct($db = null) {
		$this->db = $db;
		$this->camposVaziosDao = new CamposVaziosDao($db);
	}

	function carregaCamposObrigatorios($empresa, $pessoa){
		$pessoaDao = new PessoaDao($this->db);
		$brasileiro = $pessoaDao->pessoaEhBrasileira($empresa, $pessoa);
		$dicionario 		= new DicionarioCampoObrDao($this->db);
		$listaDicionario    = $dicionario->buscaCamposObrigatorios("Tabela='RHPESSOAS'");
		$this->arrCamposObr = array();
		$tabAntiga 			= "";
		global $configObj;
		while(!$listaDicionario->EOF) {
			if($brasileiro &&
			(strtolower($listaDicionario->fields['CampoTabela']) == "validadevisto" ||
			strtolower($listaDicionario->fields['CampoTabela']) == "anochegadabrasil" ||
			strtolower($listaDicionario->fields['CampoTabela']) == "tipovisto")){
				$listaDicionario->MoveNext();
				continue;
			}
			if($tabAntiga != $listaDicionario->fields['Tabela']){
				$i = 0;
				$tabAntiga = $listaDicionario->fields['Tabela'];
			}
			$this->arrCamposObr[strtolower($listaDicionario->fields['Tabela'])][$i]["CampoTabela"] = strtolower($listaDicionario->fields['CampoTabela']);
			$this->arrCamposObr[strtolower($listaDicionario->fields['Tabela'])][$i]["Descricao"] = $listaDicionario->fields['Descricao60'];
			$i++;

			$listaDicionario->MoveNext();
		}


		$valorDiretrizInteresse = $configObj->getValorDiretriz('interesseProfissionalObrigatorio');
		if($valorDiretrizInteresse == 2){
			$this->arrCamposObr['rhpessoaareasinteres'][$i]["CampoTabela"] = 'pessoa';
			$this->arrCamposObr['rhpessoaareasinteres'][$i]["Descricao"] = 'Interesses Profissionais';
		}

		$this->arrCamposObr['rhpessoas'][$i]["CampoTabela"] = 'nome';
		$this->arrCamposObr['rhpessoas'][$i]["Descricao"] = 'Nome';
		$i++;

		$this->arrCamposObr['rhpessoas'][$i]["CampoTabela"] = 'nascimento';
		$this->arrCamposObr['rhpessoas'][$i]["Descricao"] = 'Data de Nascimento';
		$i++;

		$this->arrCamposObr['rhpessoas'][$i]["CampoTabela"] = 'sexo';
		$this->arrCamposObr['rhpessoas'][$i]["Descricao"] = 'Sexo';
		$i++;

		$this->arrCamposObr['rhpessoas'][$i]["CampoTabela"] = 'email';
		$this->arrCamposObr['rhpessoas'][$i]["Descricao"] = 'Email';
		$i++;

		$variavel = new VariavelWebObrDao($this->db);
		$resultado = $variavel->buscarVariavelObr();
		$i = 0;
		while(!$resultado->EOF) {
			$this->arrCamposObr[strtolower('rhpessoasdadoscompl')][$i]["CampoTabela"] = strtolower($resultado->fields['CampoTabelaFutura']);
			$this->arrCamposObr[strtolower('rhpessoasdadoscompl')][$i]["Descricao"] = $resultado->fields['Descricao40'];
			$i++;
			$resultado->MoveNext();
		}

		$requisito = new RequisitoWebObrDao($this->db);
		$resultado = $requisito->buscarRequisitoObr();
		$i = 0;
		while(!$resultado->EOF) {
			$this->arrCamposObr[strtolower('rhpessoarequisitos')][$i]["CampoTabela"] = strtolower($resultado->fields['Requisito']);
			$this->arrCamposObr[strtolower('rhpessoarequisitos')][$i]["Descricao"] = $resultado->fields['Descricao80'];
			$i++;
			$resultado->MoveNext();
		}
	}

	function carregaCamposVazios($empresa, $pessoa){
        $pessoaDao = new PessoaDao($this->db);
        $pess = $pessoaDao->buscarPessoaPorPk($pessoa);
		$this->arrCamposObrVazios=array();
        $possuiPIS = $pess->fields['PossuiPIS'];
		foreach($this->arrCamposObr as $tabela=>$campo){

            $pis = $this->campoExiste($campo, "pis");
            $datapis = $this->campoExiste($campo[0], "datapis");
            if  ((!$pis && !$datapis) || ($possuiPIS == "S" && ($pis || $datapis))){
			    $this->arrCamposObrVazios[$tabela] = $this->ConfereCamposVazios($empresa, $pessoa, $tabela, $this->arrCamposObr[$tabela]);
            }
		}
	}

    function campoExiste($campos, $campo){
		if (is_array($campos) || is_object($campos))
		{
			foreach ($campos as $campotabela)
			{
				if ($campotabela["CampoTabela"] == $campo)
				return true;
			}
		}
        return false;
    }

	private function ConfereCamposVazios($empresa, $pessoa, $tabela, $camposTabela){
		if($tabela=="rhpessoarequisitos"){
			return $this->camposVaziosDao->ConfereCamposVaziosRequisitos($empresa, $pessoa, $camposTabela);
		}
		else{
		    if($tabela=="rhpessoaareasinteres"){
			    return $this->camposVaziosDao->ConfereCamposVaziosInteresse($empresa, $pessoa, $tabela, $camposTabela);
		    }
		    else{
			    return $this->camposVaziosDao->ConfereCamposVaziosPadrao($empresa, $pessoa, $tabela, $camposTabela);
		    }
		}
	}

	function existeCampoVazio(){
        $this->carregaCamposObrigatorios(LoginModel::getEmpresaLogada(), LoginModel::getPessoaLogada());
        $this->carregaCamposVazios(LoginModel::getEmpresaLogada(), LoginModel::getPessoaLogada());

		if(!is_array($this->arrCamposObrVazios)){
			return false;
		}
		foreach($this->arrCamposObrVazios as $tabela=>$campos){
			if (is_array($campos) && count($campos) > 0) {
				return true;
			}
		}
		return false;
	}

	function getCamposObr(){
		return $this->arrCamposObr;
	}

	function getCamposVazios(){
		return $this->arrCamposObrVazios;
	}

	function getCamposVaziosHTML(){
		$retorno = "";
		if($this->existeCampoVazio(LoginModel::getEmpresaLogada(), LoginModel::getPessoaLogada())){
			global $traducaoTabelas;
			$retorno .= "Os seguintes campos precisam ser preenchidos:</br>";
			foreach ($this->arrCamposObrVazios as $tabela=>$campos){
				foreach($campos as $campo){
					$retorno .= '- '. $traducaoTabelas[$tabela].'/'.$campo['Descricao'].';</br>';
				}
			}
		}
		return $retorno;
	}
}
?>