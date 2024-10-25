<?php
global $deParaValoresConfig;

$deParaValoresConfig['cor']['1'] = 'laranja';
$deParaValoresConfig['cor']['2'] = 'verde';
$deParaValoresConfig['cor']['3'] = 'azul';
$deParaValoresConfig['cor']['4'] = 'vermelho';
$deParaValoresConfig['cor']['5'] = 'preto';

$deParaValoresConfig['indicadorEmailConcluido']['1'] = 'S';
$deParaValoresConfig['indicadorEmailConcluido']['2'] = 'N';

$deParaValoresConfig['primeiroEmpregoObrigatorio']['1'] = 'S';
$deParaValoresConfig['primeiroEmpregoObrigatorio']['2'] = 'N';

$deParaValoresConfig['localPessoaFoto']['1'] = '1';
$deParaValoresConfig['localPessoaFoto']['2'] = '2';

$deParaValoresConfig['interesseProfissionalObrigatorio']['1'] = '1';
$deParaValoresConfig['interesseProfissionalObrigatorio']['2'] = '2';

$deParaValoresConfig['ObrigarPreenchimentoCamposObrParaVagas']['1'] = '1';
$deParaValoresConfig['ObrigarPreenchimentoCamposObrParaVagas']['2'] = '2';

$deParaValoresConfig['filtrarVagasPorAreaOuRegiao']['1'] = '1';
$deParaValoresConfig['filtrarVagasPorAreaOuRegiao']['2'] = '2';

$deParaValoresConfig['exibirSalarioOferecido']['1'] = '1';
$deParaValoresConfig['exibirSalarioOferecido']['2'] = '2';

class Config{
	
	private $db;
	private $empresa;
	private $configuracoes=array();
	function __construct($db, $empresa){
		$this->db = $db;
		$this->empresa = $empresa;
		$this->carregaConfiguracoes($empresa);
	}
	private function carregaConfiguracoes($empresa){
		$candidatosWebDirDao = new CandidatoWebDirDao($this->db);
		$resultadoDirEmpresa = $candidatosWebDirDao->buscaDiretrizesEmpresa($empresa);
		$this->configuracoes = array();
		while(!$resultadoDirEmpresa->EOF){
			$this->configuracoes[$resultadoDirEmpresa->fields['DiretrizWeb']]['valor'] = $this->trataValorDiretriz($resultadoDirEmpresa);
			$resultadoDirEmpresa->MoveNext();
		}
	}
	private function trataValorDiretriz($diretriz){
		global $deParaValoresConfig;
		if($diretriz->fields['TipoDiretrizWeb'] == 'T'){
			return $diretriz->fields['ConteudoMemo']; 
		}
		else if($diretriz->fields['TipoDiretrizWeb'] == 'D'){
			return $diretriz->fields['ConteudoData']; 
		}
		else if($diretriz->fields['TipoDiretrizWeb'] == 'N'){
			return $diretriz->fields['ConteudoNumero']; 
		}
		else if($diretriz->fields['TipoDiretrizWeb'] == 'O'){
			return $deParaValoresConfig[$diretriz->fields['DiretrizWeb']][$diretriz->fields['ConteudoOpcao']]; 
		}
		return "";
	}
	public function getValorDiretriz($nomeDiretriz){
		return $this->configuracoes[$nomeDiretriz]['valor'];
	}
	public function teste(){
		return $this->configuracoes;
	}
}
?>