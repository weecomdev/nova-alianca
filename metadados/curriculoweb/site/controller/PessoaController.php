<?php
class PessoaController {

	private $db;
	private $entidade;
	private $acao;

	public function __construct($db, $entidade, $acao) {
		$this->db = $db;
		$this->entidade = $entidade;
		$this->acao = $acao;

		if ($acao)
			$this->$acao();
		else
			$this->abrir();
	}

	public function abrir() {
        $_SESSION["GUIA"] = "Pessoais";
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();


		$pDao = new PessoaDao($this->db);
        $teste = new MunicipioDao($this->db);
        $mDao = new MunicipioDao($this->db);
		$odDao = new OpcaoDicionarioDao($this->db);
		$nDao = new NacionalidadeDao($this->db);
		$giDao = new GrauInstrucaoDao($this->db);
		$ecDao = new EstadoCivilDao($this->db);
        $paDao = new PessoaAnexoDao($this->db);



		$listaOpcaoDeficienteFisico = $odDao->buscarOpcoesPorCampo("DEFICIENTEFISICO");
		$listaOpcaoTipoIdentidade = $odDao->buscarOpcoesPorCampo("TIPOIDENTIDADE");
		$listaOpcaoUF = $odDao->buscarOpcoesPorCampo("UF");
		$listaOpcaoUFNascimento = $odDao->buscarOpcoesPorCampo("UFNASCIMENTO");
		$listaOpcaoTipoVisto = $odDao->buscarOpcoesPorCampo("TIPOVISTO");
		$listaNacionalidade = $nDao->buscarNacionalidadesPorParametros();
		$listaGrauInstrucao = $giDao->buscarGrauInstrucaoPorParametros();
		$listaEstadoCivil = $ecDao->buscarEstadoCivilPorParametros();

		//Campos obrigatorios
		$camposObr = new CampoWebObrDao($this->db);
		$listaCamposObr = $camposObr->buscarCamposObr("RHPESSOAS");
        $listaCamposObrFoto = $camposObr->buscarCamposObr("RHPESSOASFOTOS");
        $listaCamposObrAnexo =  $camposObr->buscarCamposObr("RHPESSOASANEXOS");

        //Campos Invisíveis
        
        $camposInv = new CampoWebInvDao($this->db);
		$listaCamposInv = $camposInv->buscarCamposInv("RHPESSOAS");
        $listaCamposFotoInv = $camposInv->buscarCamposInv("RHPESSOASFOTOS");
        $listaCamposAnexoInv = $camposInv->buscarCamposInv("RHPESSOASANEXOS");

		$pessoa = $pDao->buscarPessoaPorPk($_SESSION["PessoaLogada"]);



        // Carrega municípios conforme UF

        $listaOpcaoLocalNascimento = $mDao->buscarCidadesPorUF($pessoa->fields['UFNascimento']);
        $listaOpcaoCidade = $mDao->buscarCidadesPorUF($pessoa->fields['UF']);
        $pessoaAnexo = $paDao->buscarAnexoDaPessoa($pessoa->fields['Empresa'], $pessoa->fields['Pessoa']);

		include 'site/web/MeuCurriculo/informacoesPessoais.php';
	}

    private function toJSON($result) {
		$json = array();
		$json['Cidade'] = utf8_encode($result->fields['Cidade']);
		$json['Descricao80'] = utf8_encode($result->fields['Descricao80']);

		return $json;
	}

     function MostrarSolicitarExclusao() {
		include 'site/web/MeuCurriculo/excluirCurriculo.php';	
		exit;
	}   
	

    public function buscarCidadesPorUF()
    {
        $uf = $_POST['UF'];

        $mDao = new MunicipioDao($this->db);
        $cidades = $mDao->buscarCidadesPorUF($uf);

        $cont = 0;
        while (!$cidades->EOF) {
            $json = $this->toJSON($cidades);

            $dados[$cont++] = $json;
            $cidades->MoveNext();
        }
        echo json_encode($dados);
        exit;
    }

	public function webpage(){
		switch($this->entidade){
			case "informacoesPessoais":
				$this->executeInformacoesPessoais();
			break;
			case "informacoesProfissionais":
				$this->executeInformacoesProfissionais();
			break;
			case "informacoesAcademicas":
				$this->executeInformacoesAcademicas();
			break;
			case "historicoProfissional":
				$this->executeHistoricoProfissional();
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
		$this->salvar();
		include 'site/web/MeuCurriculo/informacoesProfissionais.php';
	}

	private function salvar(){
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();
		$pessoaDao = new PessoaDao($this->db);
		$pessoa = new Pessoa();
		$pessoa->Pessoa = $_SESSION['PessoaLogada'];

		if (isset($_REQUEST['Nome'])) $pessoa->Nome = utf8_decode($_REQUEST['Nome']);
		if (isset($_REQUEST['Pai'])) $pessoa->Pai = utf8_decode($_REQUEST['Pai']);
		if (isset($_REQUEST['Mae'])) $pessoa->Mae = utf8_decode($_REQUEST['Mae']);
		if (isset($_REQUEST['Nascimento'])) $pessoa->Nascimento = $dateUtil->toTimestamp($_REQUEST['Nascimento']);
		if (isset($_REQUEST['LocalNascimento'])) $pessoa->LocalNascimento = utf8_decode($_REQUEST['LocalNascimento']);
		if (isset($_REQUEST['UFNascimento'])) $pessoa->UFNascimento = utf8_decode($_REQUEST['UFNascimento']);
		if (isset($_REQUEST['Sexo'])) $pessoa->Sexo = utf8_decode($_REQUEST['Sexo']);
		if (isset($_REQUEST['GrauInstrucao'])) $pessoa->GrauInstrucao = utf8_decode($_REQUEST['GrauInstrucao']);
		if (isset($_REQUEST['EstadoCivil'])) $pessoa->EstadoCivil = utf8_decode($_REQUEST['EstadoCivil']);
		if (isset($_REQUEST['PretensaoSalarial'])) $pessoa->PretensaoSalarial = $numberUtil->formatarSql($_REQUEST['PretensaoSalarial']);
		if (isset($_REQUEST['DeficienteFisico'])) $pessoa->DeficienteFisico = utf8_decode($_REQUEST['DeficienteFisico']);
		if (isset($_REQUEST['BenefReabilitado'])) $pessoa->BenefReabilitado = utf8_decode($_REQUEST['BenefReabilitado']);
		if (isset($_REQUEST['Estudando'])) $pessoa->Estudando = utf8_decode($_REQUEST['Estudando']);
		if (isset($_REQUEST['EstaTrabalhando'])) $pessoa->EstaTrabalhando = utf8_decode($_REQUEST['EstaTrabalhando']);
		if (isset($_REQUEST['Nacionalidade'])) $pessoa->Nacionalidade = utf8_decode($_REQUEST['Nacionalidade']);
		if (isset($_REQUEST['ValidadeVisto'])) $pessoa->ValidadeVisto = $dateUtil->toTimestamp($_REQUEST['ValidadeVisto']);
		if (isset($_REQUEST['AnoChegadaBrasil'])) $pessoa->AnoChegadaBrasil = $_REQUEST['AnoChegadaBrasil'];
		if (isset($_REQUEST['TipoVisto'])) $pessoa->TipoVisto = $_REQUEST['TipoVisto'];
		if (isset($_REQUEST['TipoIdentidade'])) $pessoa->TipoIdentidade = utf8_decode($_REQUEST['TipoIdentidade']);
		if (isset($_REQUEST['Identidade'])) $pessoa->Identidade = utf8_decode($_REQUEST['Identidade']);
		if (isset($_REQUEST['ConselhoClasse'])) $pessoa->ConselhoClasse = utf8_decode($_REQUEST['ConselhoClasse']);
		if (isset($_REQUEST['RegistroConselho'])) $pessoa->RegistroConselho = utf8_decode($_REQUEST['RegistroConselho']);
		if (isset($_REQUEST['DataRegistro'])) $pessoa->DataRegistro = $dateUtil->toTimestamp($_REQUEST['DataRegistro']);
		if (isset($_REQUEST['Cep'])) $pessoa->Cep = utf8_decode($_REQUEST['Cep']);
		if (isset($_REQUEST['Rua'])) $pessoa->Rua = utf8_decode($_REQUEST['Rua']);
		if (isset($_REQUEST['NroRua'])) $pessoa->NroRua = utf8_decode($_REQUEST['NroRua']);
		if (isset($_REQUEST['Complemento'])) $pessoa->Complemento = utf8_decode($_REQUEST['Complemento']);
		if (isset($_REQUEST['Cidade'])) $pessoa->Cidade = utf8_decode($_REQUEST['Cidade']);
		if (isset($_REQUEST['UF'])) $pessoa->UF = utf8_decode($_REQUEST['UF']);
		if (isset($_REQUEST['DDD'])) $pessoa->DDD = utf8_decode($_REQUEST['DDD']);
		if (isset($_REQUEST['Telefone'])) $pessoa->Telefone = utf8_decode($_REQUEST['Telefone']);
		if (isset($_REQUEST['DDDCelular'])) $pessoa->DDDCelular = utf8_decode($_REQUEST['DDDCelular']);
		if (isset($_REQUEST['TelefoneCelular'])) $pessoa->TelefoneCelular = utf8_decode($_REQUEST['TelefoneCelular']);
		if (isset($_REQUEST['Email'])) $pessoa->Email = utf8_decode($_REQUEST['Email']);
		if (isset($_REQUEST['Bairro'])) $pessoa->Bairro = utf8_decode($_REQUEST['Bairro']);
		if (isset($_REQUEST['RegistroHabilitacao'])) $pessoa->RegistroHabilitacao = utf8_decode($_REQUEST['RegistroHabilitacao']);
		if (isset($_REQUEST['CategoriaHabilitacao'])) $pessoa->CategoriaHabilitacao = utf8_decode($_REQUEST['CategoriaHabilitacao']);
		if (isset($_REQUEST['ValidadeHabilitacao'])) $pessoa->ValidadeHabilitacao =  $dateUtil->toTimestamp($_REQUEST['ValidadeHabilitacao']);
        if (isset($_REQUEST['PIS'])) $pessoa->PIS = utf8_decode($_REQUEST['PIS']);
        if (isset($_REQUEST['DataPIS'])) $pessoa->DataPIS =  $dateUtil->toTimestamp($_REQUEST['DataPIS']);
        if (isset($_REQUEST['PossuiPIS'])) $pessoa->PossuiPIS =  utf8_decode($_REQUEST['PossuiPIS']);
		echo $pessoa->Nome;
		$pessoa->UltAlteracao = date("Y-m-d H:i:s");
        if ($pessoa->validaTamanhoCampos())
		    $pessoaDao->salvar($pessoa);
	}

	function executePalavrasChave() {

		$pcDao = new PalavraChaveDao($this->db);

		$listaPalavrasChave = $pcDao->buscarPalavraChavePorParametros();


		include 'site/web/MeuCurriculo/palavrasChaves.php';
	}

     public function setExcluir()
    {     
        $cpf = $_POST['CPF'];
        $cpf = str_replace(".","",$cpf);
		$cpf = str_replace("-","",$cpf);


        $login = new LoginModel($this->db);
		$msg = $login->solicitarExclusao($cpf);	
        echo utf8_encode($msg);
  
        exit;
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

}
?>