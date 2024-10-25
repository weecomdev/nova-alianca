<?php

class MeuCurriculoController {

	private $db;
	private $entidade;
	private $acao;
	
	public function __construct($db, $entidade, $acao = null) {
		$this->db = $db;
		$this->entidade = $entidade;
		$this->acao = $acao;
		
		if ($acao)
			$this->$acao();
		else 
			$this->webpage();
	}

	public function webpage(){
		switch($this->entidade){
			case "informacoesPessoais":
				$this->executeInformacoesPessoais();
			break;
			case "informacoesProfissionais":
				//$this->salvarInformacoesPessoais();
				$this->executeInformacoesProfissionais();
			break;
			case "informacoesAcademicas":
				$this->executeInformacoesAcademicas();
			break;
			case "historicoProfissional":
				$this->executeHistoricoProfissional();	
			break;
			case "enviarconcluido":
				$this->enviarConcluido();	
			break;	
			case "palavrasChaves":
				$this->executePalavrasChave();
			break;
			case "idiomas":
				$this->executeIdiomas();
			break;
			case "interessesProfissionais":
				include '';	
			break;
				
		}
	
	}
	
	function executeInformacoesAcademicas() {
		
		$giDao = new GrauInstrucaoDao($this->db);
		
		$result = $giDao->buscarGrauInstrucaoPorParametros();
		
		include 'site/web/MeuCurriculo/informacoesAcademicas.php';
				
	}
	
	function executeHistoricoProfissional() {
		
		$atDao = new AreaAtuacaoDao($this->db);
		
		$result = $atDao->buscarAreaAtuacaoPorParametros();
		
		include 'site/web/MeuCurriculo/historicoProfissional.php';		
	}
	
	
	
	private function executeInformacoesPessoais(){
		$pessoaDao = new PessoaDao($this->db); 
	
		include 'site/web/MeuCurriculo/informacoesPessoais.php';
	}
	
	private function executeInformacoesProfissionais(){
		$pessoaDao = new PessoaDao($this->db); 
		$pessoa = new Pessoa();
		
		$pessoa->Nome = $_REQUEST['nome'];
		$pessoa->Pai = $_REQUEST['pai'];
		$pessoa->Mae = $_REQUEST['mae'];
		$pessoa->DataNascimento = $_REQUEST['dataNascimento'];
		$pessoa->Cpf = $_REQUEST['cpf'];
		$pessoa->Rg = $_REQUEST['rg'];
		$pessoa->Sexo = $_REQUEST['sexo'];
		
        if ($pessoa->validaTamanhoCampos())
		    $pessoaDao->salvar($pessoa);	
	
		include 'site/web/MeuCurriculo/informacoesProfissionais.php';
	}
	
	function executePalavrasChave() {
		
		$pcDao = new PalavraChaveDao($this->db);
		
		$listaPalavrasChave = $pcDao->buscarPalavraChavePorParametros();
		
		
		include 'site/web/MeuCurriculo/palavrasChaves.php';		
	}
	
	function executeIdiomas() {
		$iDao = new IdiomaDao($this->db);
		$piDao = new PessoaIdiomaDao($this->db);
		
		switch($this->acao){
			case "salvar":
				print_r($_POST);
			break;

			default:
				$listaIdiomas = $iDao->buscarIdiomaPorParametros();
				$listaIdiomasPessoa =  $piDao->buscarIdiomaPorPessoa($pessoa);
				include 'site/web/MeuCurriculo/idiomas.php';		
			break;
		}
	}
	
	function enviarConcluido() {
		$concluido = new ConcluidoModel($this->db);
		echo $concluido->enviarConcluido();
	}
	
}
?>