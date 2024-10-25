<?php
// Report simple running errors
ini_set('error_reporting', E_ALL ^ E_NOTICE);
// Set the display_errors directive to Off
ini_set('display_errors', 1);
// Log errors to the web server's error log
ini_set('log_errors', 1);

$globalEmpresa = "0";
$ticket = "";

require_once('padraoServicos.php');
require_once('lib/nusoap.php');

$server = new soap_server(); 							// Create the server instance
$server->configureWSDL('wsdlServerBF2Receber', 'urn:wsdlServerBF2Receber');	// Initialize WSDL support

// Registra o metdodo receber
$server->register(
	'receber',								// method name:
array("empresa" => "xsd:string",
          "name"=>"xsd:string",
          "ticketLogin"=>"xsd:string"),			// parameter list:
array('return'=>'xsd:string'),			// retorno = string contendo XML
	'urn:wsdlServerBF2Receber',				// namespace
	'urn:wsdlServerBF2Receber#receber',		// soapaction
	'rpc',									// style: rpc or document
	'encoded',								// use: encoded or literal
	'Receber informações do sistema Metadados');			// description: documentation for the method

// Registra o metdodo Excluir Curriculos
$server->register(
	'ExcluirCurriculos',								// method name:
array("empresa" => "xsd:string",
      "cpf"=>"xsd:string",
      "nomecompleto"=>"xsd:string",          
      "ticketLogin"=>"xsd:string"),			// parameter list:
array('return' => 'tns:RetornoAtualizar'),			// retorno = 
	'urn:wsdlServerBF2Receber',				// namespace
	'urn:wsdlServerBF2Receber#ExcluirCurriculos',		// soapaction
	'rpc',									// style: rpc or document
	'encoded',								// use: encoded or literal
	'Excluir Currículos');			// description: documentation for the method

// Registra o metdodo atualizarEmail
$server->register(
	'atualizarEmail',								// method name:
array("empresa" => "xsd:string",
          "cpf"=>"xsd:string",
          "email"=>"xsd:string",          
          "ticketLogin"=>"xsd:string"),			// parameter list:
array('return'=>'xsd:string'),			// retorno = string contendo XML
	'urn:wsdlServerBF2Receber',				// namespace
	'urn:wsdlServerBF2Receber#atualizarEmail',		// soapaction
	'rpc',									// style: rpc or document
	'encoded',								// use: encoded or literal
	'Atualizar e-mail de candidato pelo CPF do sistema Metadados');			// description: documentation for the method

class RetornoAtualizar {
	var $AconteceuErro;
	var $Script;
	var $Data;
	var $Observacoes;
	var $DescErro;
}

$server->wsdl->addComplexType(
    'RetornoAtualizar',
    'complexType',
    'struct',
    'all',
    '',
	array(
		'AconteceuErro' => array('name' => 'erro', 'type' => 'xsd:boolean'),
		'DescErro' => array('name' => 'descerro', 'type' => 'xsd:string'),
        'Script' => array('name' => 'script', 'type' => 'xsd:string'),
        'Data' => array('name' => 'age', 'type' => 'xsd:string'),
        'Observacoes' => array('name' => 'observacoes', 'type' => 'xsd:string')
	)
);
//Registra o método atualizar
$server->register(
	"atualizar",
array("ticketLogin"=>"xsd:string"),
array("return" => "tns:RetornoAtualizar"),
	'urn:wsdlServerBF2Receber',				// namespace
	'urn:wsdlServerBF2Receber#atualizar',		// soapaction
	"rpc",
	"encoded");

function atualizar($ticketLogin){
	global $db;
	$arquivo = "../curriculoweb.xml";
	$ret = new RetornoAtualizar();
	$ret->AconteceuErro = false;
	if(!tentaExcluirTicket($ticketLogin)){
		$ret->AconteceuErro = true;
		$ret->DescErro = "Login inválido!";
		return $ret;
	}
	if (file_exists($arquivo)) {
		include_once "../site/dao/VersaoCVWebDao.php";
		$versaoDao = new VersaoCVWebDao($db);
		$ultimaData = $versaoDao->buscarUltimoScript();
		$xml = simplexml_load_file($arquivo);
		foreach($xml->Registro as $reg){
			try {
				if($ultimaData < $reg->Data){
					$db->Execute(utf8_decode($reg->Script));
					$versaoDao->atualizaUltimoScript($reg->Data);
				}
			} catch (exception $e) {
				$ret->AconteceuErro = true;
				$ret->DescErro = $e->msg;
				$ret->Script = utf8_decode($reg->Script);
				$ret->Data = $reg->Data;
				$ret->Observacoes = utf8_decode($reg->Observacoes);
				return $ret;
			}
		}
	} else {
		$ret->AconteceuErro = true;
		$ret->DescErro = "O arquivo $arquivo não existe.";
		return $ret;
	}
	return $ret;
}

function atualizarEmail($empresa,$cpf,$email,$ticketLogin) {
    if(!tentaExcluirTicket($ticketLogin)){
        return "Login inválido!";
    }
    try{
        atualizarEmailCandidato($empresa,$cpf,$email);
    }
    catch (exception $e) {
        return $e->msg;
    }   
    return "";
}

function ExcluirCurriculos($empresa,$cpf,$nomecompleto,$ticketLogin) {
    global $db;

	include "../site/dao/PessoaDao.php";
	include "../site/model/Pessoa.php";
    include "../site/model/LoginModel.php";
    include "../site/dao/CandidatosWebConfDao.php";
    include "../site/dao/CandidatoWebDirDao.php";
    include "../site/lib/phpmailer/PHPMailerAutoload.php";
	include "../site/model/MetaMail.php";
	include "../services/lib/class.simetric.php";
    include "../site/lib/config.php";


    $ret = new RetornoAtualizar();
	$ret->AconteceuErro = false;

    if(!tentaExcluirTicket($ticketLogin)){
		$ret->AconteceuErro = true;
		$ret->DescErro = "Login inválido!";
		return $ret;
	}

    $login = new LoginModel($db);
	$iDao = new PessoaDao($db);
	$iModel = new Pessoa();
    $iModel = $iDao->buscarPessoaPorCPFEmpresa($cpf,$empresa);

    if ($iModel != null)
    {  
        try
        {
		    $result = $iDao->DeletarCurriculo($iModel->CPF,$iModel->Empresa,$iModel->Pessoa);
        }
        catch(exception $e)
        {
	        $ret->AconteceuErro = true;
		    $ret->DescErro = 'Não foi possível excluir a pessoa'.$nomecompleto.' com CPF '.$cpf.' da empresa '.$empresa.'.';
            return $ret; 
        }

        if ($result == False)
        {
            $ret->AconteceuErro = true;
		    $ret->DescErro = 'Não foi possível excluir a pessoa'.$nomecompleto.' com CPF '.$cpf.' da empresa '.$empresa.'.';
            return $ret;
        }
        else
        { 
            try
            {
                 $login->MandaEmailExclusao($cpf,$empresa,$iModel->Email);
            }
            catch(Exception $e)
            {
            }
            return $ret;
        }
    }
    else
    {        
        $ret->AconteceuErro = true;
		$ret->DescErro = 'A pessoa '.$nomecompleto.' com '.'CPF '.$cpf.' da empresa '.$empresa.' não pode ser removida pois a mesma não está cadastrada no Currículo Web.';
 	    return $ret;
    }
 }

function receber($empresa,$msg,$ticketLogin) {
	global $server;
	global $db;
	global $ticket;

    if(!tentaExcluirTicket($ticketLogin)){
        return "Login inválido!";
    }

    $simetricKey = pegarChave($empresa);

    $result = decrypt($msg,$simetricKey);

    $lAux = $result;
    $caracterInicial = strlen(substr($lAux,0, strpos($lAux,'<?xml')));
    $lAux = substr($lAux,$caracterInicial, strpos($lAux,'</Inicio>'));
    $caracterFinal = (strlen($lAux) - strpos($lAux,'</Inicio>'))-9;

    $result = substr($result,$caracterInicial, strpos($result,'</Inicio>')-$caracterFinal);

	$doc = new DOMDocument("1.0");
    $doc->loadXML($result);

    $tabela = $doc->firstChild->firstChild->nodeName;

    $nomeArquivo = "tmp/" . $tabela . ".xml";

    if (($tabela == "AberturaDaExportacao") || ($tabela == "FechamentoDaExportacao")){
        $arquivos = glob('tmp/*');
        foreach($arquivos as $arquivo){
            if(is_file($arquivo))
                unlink($arquivo);
        }
    }
    else {
        $limparTabela = false;
        $doc_temp = obterArquivoTemporario($tabela);
        if ($doc_temp == null){
            $doc->save($nomeArquivo);
            $limparTabela = true;
        }

        try {
            $lista = $doc->getElementsByTagName($tabela);


            //IDIOMAS
            if (($tabela == 'RHIDIOMAS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaIdiomas($lista, $limparTabela);
            }

            //NÍVEIS DE IDIOMAS
            if (($tabela == 'RHIDIOMASNIVEIS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaIdiomasNiveis($lista, $limparTabela);
            }

            //FUNÇÕES
            if (($tabela == 'RHFUNCOES') && ($lista != null) && ($lista->length > 0)) {
                inserirListaFuncoes($lista, $limparTabela);
            }

            //CANDIDATOS
            if (($tabela == 'RHCANDIDATOSWEBCONF') && ($lista != null) && ($lista->length > 0)) {
                inserirListaCandidatosWebConf($lista, $limparTabela);
            }

            //REQUISIÇÕES
            if (($tabela == 'RHREQUISICOES') && ($lista != null) && ($lista->length > 0)) {
                inserirListaRequisicoes($lista, $limparTabela);
            }

            //ÁREAS DE ATUAÇÃO
            if (($tabela == 'RHAREASATUACAO') && ($lista != null) && ($lista->length > 0)) {
                inserirListaAreasAtuacao($lista, $limparTabela);
            }

            //REGIÕES
            if (($tabela == 'RHREGIOES') && ($lista != null) && ($lista->length > 0)) {
                inserirListaRegioes($lista, $limparTabela);
            }

            //CURSOS
            if (($tabela == 'RHCURSOS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaCursos($lista, $limparTabela);
            }

            //CARGOS
            if (($tabela == 'RHCARGOS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaCargos($lista, $limparTabela);
            }

            //REQUISITOS
            if (($tabela == 'RHREQUISITOS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaRequisitos($lista, $limparTabela);
            }

            //PALAVRAS-CHAVE
            if (($tabela == 'RHPALAVRASCHAVES') && ($lista != null) && ($lista->length > 0)) {
                inserirListaPalavrasChave($lista, $limparTabela);
            }

            //EMPRESAS
            if (($tabela == 'RHEMPRESAS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaEmpresas($lista, $limparTabela);
            }

            //VARIÁVEIS
            if (($tabela == 'RHVARIAVEIS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaVariaveis($lista, $limparTabela);
            }

            //VÍNCULOS EMPREGATÍCIOS
            if (($tabela == 'RHVINCEMPREGATICIOS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaVincEmpregaticios($lista, $limparTabela);
            }

            //HABILITAÇÕES PROFISSIONAIS
            if (($tabela == 'RHHABILITACOESPROF') && ($lista != null) && ($lista->length > 0)) {
                inserirListaHabilitacoesProf($lista, $limparTabela);
            }

            //MEDIDAS
            if (($tabela == 'RHMEDIDAS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaMedidas($lista, $limparTabela);
            }

            //ESCALAS DE AVALIAÇÃO
            if (($tabela == 'RHESCALASAVALIACAO') && ($lista != null) && ($lista->length > 0)) {
                inserirListaEscalasAvaliacao($lista, $limparTabela);
            }

            //ITENS DA ESCALA DE AVALIAÇÃO
            if (($tabela == 'RHESCALASAVALIAITENS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaEscalasAvaliaItens($lista, $limparTabela);
            }

            //REQUISITOS DA ESCALA
            if (($tabela == 'RHESCALAREQUISITOS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaEscalaRequisitos($lista, $limparTabela);
            }

            //ITENS DOS REQUISITOS DA ESCALA
            if (($tabela == 'RHESCALAREQITENS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaEscalaReqItens($lista, $limparTabela);
            }

            //ESTADO CIVIL
            if (($tabela == 'RHESTADOCIVIL') && ($lista != null) && ($lista->length > 0)) {
                inserirListaEstadoCivil($lista, $limparTabela);
            }

            //GRAU DE INSTRUÇÃO
            if (($tabela == 'RHGRAUINSTRUCAO') && ($lista != null) && ($lista->length > 0)) {
                inserirListaGrauInstrucao($lista, $limparTabela);
            }

            //MUNICÍPIOS
            if (($tabela == 'RHMUNICIPIOS') && ($lista != null) && ($lista->length > 0)) {
                inserirListaMunicipios($lista, $limparTabela);
            }

            //NACIONALIDADES
            if (($tabela == 'RHNACIONALIDADES') && ($lista != null) && ($lista->length > 0)) {
                inserirListaNacionalidades($lista, $limparTabela);
            }

            //TIPOS DE RESIDÊNCIA
            if (($tabela == 'RHTIPOSRESIDENCIA') && ($lista != null) && ($lista->length > 0)) {
                inserirListaTiposResidencia($lista, $limparTabela);
            }

            //OPÇÕES DO DICIONÁRIO
            if (($tabela == 'RHOPCOESDICIONARIO') && ($lista != null) && ($lista->length > 0)) {
                inserirListaOpcoesDicionario($lista, $limparTabela);
            }

            //CÓDIGOS COMPLEMENTARES
            if (($tabela == 'RHCODIGOSCOMPL') && ($lista != null) && ($lista->length > 0)) {
                inserirListaCodigosCompl($lista, $limparTabela);
            }

            //OPÇÕES COMPLEMENTARES
            if (($tabela == 'RHOPCOESCOMPL') && ($lista != null) && ($lista->length > 0)) {
                inserirListaOpcoesCompl($lista, $limparTabela);
            }

            //REQUISITOS DO CURRÍCULO WEB
            if (($tabela == 'RHREQUISITOSWEBOBR') && ($lista != null) && ($lista->length > 0)) {
                inserirListaRequisitosObr($lista, $limparTabela);
            }

            //VARIÁVEIS OBRIGATÓRIAS
            if (($tabela == 'RHVARIAVEISWEBOBR') && ($lista != null) && ($lista->length > 0)) {
                inserirListaVariaveisObr($lista, $limparTabela);
            }

            //CAMPOS OBRIGATÓRIOS
            if (($tabela == 'RHCAMPOSWEBOBR') && ($lista != null) && ($lista->length > 0)) {
                inserirListaCamposWebObr($lista, true);
            }

            //CAMPOS NÃO VISÍVEIS
            if (($tabela == 'RHCAMPOSWEBINV') && ($lista != null) && ($lista->length > 0)) {
                inserirListaCamposWebInv($lista, true);
            }

            //DICIONÁRIO DE CAMPOS OBRIGATÓRIOS
            if (($tabela == 'RHDICIONARIOCAMPOOBR') && ($lista != null) && ($lista->length > 0)) {
                inserirListaDicionarioCampoObr($lista, $limparTabela);
            }

            //TIPOS DE CURSO
            if (($tabela == 'RHTIPOSCURSO') && ($lista != null) && ($lista->length > 0)) {
                inserirListaTiposCurso($lista, $limparTabela);
            }
			
            //DIRETRIZES DO CW
            if (($tabela == 'RHDIRETRIZESCVWEBDEF') && ($lista != null) && ($lista->length > 0)) {
                inserirListaDiretrizCVWebDef($lista, $limparTabela);
            }

            //OPÇÕES DAS DIRETRIZES DO CW
            if (($tabela == 'RHDIRETRIZESCVWEBOPC') && ($lista != null) && ($lista->length > 0)) {
                inserirListaDiretrizCVWebOpc($lista, $limparTabela);
            }

            //CANDIDATOS CW
            if (($tabela == 'RHCANDIDATOSWEBDIR') && ($lista != null) && ($lista->length > 0)) {
                inserirListaCandidatoWebDir($lista, $limparTabela);
            }

           
        }
        catch (exception $e) {
            return $e->msg;
        }
    }

    return "";
}

function obterArquivoTemporario($tabela){
    if (file_exists("tmp/" . $tabela . ".xml")){
        $retorno = new DOMDocument("1.0");
        $retorno->load("tmp/" . $tabela . ".xml");
        return $retorno;
    }
    return null;
}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);
$server->service(file_get_contents("php://input"));

function inserirListaIdiomas($listaIdiomas, $limparTabela){
	global $db;
	include "../site/dao/IdiomaDao.php";
	include "../site/model/Idioma.php";

	$iDao = new IdiomaDao($db);
	$iModel = new Idioma();
    if ($limparTabela)
	    $iDao->excluirIdioma();
	foreach ($listaIdiomas as $elem) {
		$iModel->Idioma = utf8_decode($elem->getAttribute('IDIOMA'));
		$iModel->Descricao = utf8_decode($elem->getAttribute('DESCRICAO20'));

		$iDao->criarIdioma($iModel);
	}
}

function inserirListaIdiomasNiveis($listaIdiomasNiveis, $limparTabela){
	global $db;
	include "../site/dao/IdiomaNivelDao.php";
	include "../site/model/IdiomaNivel.php";

	$iDao = new IdiomaNivelDao($db);
	$iModel = new IdiomaNivel();
    if ($limparTabela)
	    $iDao->excluirIdiomaNivel();
	foreach ($listaIdiomasNiveis as $elem) {
		$iModel->NivelIdioma = utf8_decode($elem->getAttribute('NIVELIDIOMA'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->NumeroOrdem = utf8_decode($elem->getAttribute('NROORDEM'));

		$iDao->criarIdiomaNivel($iModel);
	}
}

function inserirListaRequisicoes($listaRequisicoes, $limparTabela){
	global $db;
	include "../site/dao/RequisicaoDao.php";
	include "../site/model/Requisicao.php";
	include_once "../site/util/DataUtil.php";
    include_once "../site/util/NumberUtil.php";

	$iDao = new RequisicaoDao($db);
	$iModel = new Requisicao();
	$dateUtil = new DataUtil();
    $numberUtil = new NumberUtil();

    
    if ($limparTabela)
	    $iDao->excluirRequisicao();
	foreach ($listaRequisicoes as $elem) {
		$iModel->Requisicao = utf8_decode($elem->getAttribute('REQUISICAO'));

		$iModel->DataRequisicao = $dateUtil->toTimestamp(utf8_decode($elem->getAttribute('DATAREQUISICAO')));
		$iModel->SituacaoRequisicao = utf8_decode($elem->getAttribute('SITUACAOREQUISICAO'));
		$iModel->QuantidadeVagas = utf8_decode($elem->getAttribute('QUANTIDADEVAGAS'));
		$iModel->Observacoes = utf8_decode($elem->getAttribute('OBSERVACOES'));
		$iModel->SalarioMaximo = $numberUtil->formatarSql(utf8_decode($elem->getAttribute('SALARIOMAXIMO')));
		$iModel->VinculoEmpregaticio = utf8_decode($elem->getAttribute('VINCULOEMPREGATICIO'));
		$iModel->Funcao = utf8_decode($elem->getAttribute('FUNCAO'));
		$iModel->Cargo = utf8_decode($elem->getAttribute('CARGO'));
		$iModel->AreaAtuacao = utf8_decode($elem->getAttribute('AREAATUACAO'));
		$iModel->Regiao = utf8_decode($elem->getAttribute('REGIAO'));
		$iModel->Empresa = utf8_decode($elem->getAttribute('EMPRESA'));
		$iModel->DescricaoAtividades = utf8_decode($elem->getAttribute('DESCRICAOATIVIDADES'));
		$iModel->AbrirInscricao = utf8_decode($elem->getAttribute('ABRIRINSCRICAO'));
		$iModel->DivulgarVagaExt = utf8_decode($elem->getAttribute('DIVULGARVAGAEXT'));
		$iModel->InicioSelecao =  $dateUtil->toTimestamp(utf8_decode($elem->getAttribute('INICIOSELECAO')));
		$iModel->PrazoEncerramento =  $dateUtil->toTimestamp(utf8_decode($elem->getAttribute('PRAZOENCERRAMENTO')));
		$iModel->Dt_Encerra =  $dateUtil->toTimestamp(utf8_decode($elem->getAttribute('DT_ENCERRA')));

		$iDao->criarRequisicao($iModel);
	}
}

function inserirListaCandidatosWebConf($listaCandidatosWebConf, $limparTabela){
	global $db;
	include "../site/dao/CandidatosWebConfDao.php";
	include "../site/model/CandidatosWebConf.php";

	$iDao = new CandidatosWebConfDao($db);
	$iModel = new CandidatosWebConf();
    if ($limparTabela)
	    $iDao->excluirCandidatosWebConf();
	foreach ($listaCandidatosWebConf as $elem) {
		$iModel->Empresa = utf8_decode($elem->getAttribute('EMPRESA'));
		$iModel->Descricao80 = utf8_decode($elem->getAttribute('DESCRICAO80'));
		$iModel->ExibirPretensaoSal= utf8_decode($elem->getAttribute('EXIBIRPRETENSAOSAL'));
		$iModel->ExibirDeficiente = utf8_decode($elem->getAttribute('EXIBIRDEFICIENTE'));
		$iModel->ExibirEmpAnteriores = utf8_decode($elem->getAttribute('EXIBIREMPANTERIORES'));
		$iModel->ExibirDadosCompl = utf8_decode($elem->getAttribute('EXIBIRDADOSCOMPL'));
		$iModel->ExibirCursos = utf8_decode($elem->getAttribute('EXIBIRCURSOS'));
		$iModel->ExibirIdiomas = utf8_decode($elem->getAttribute('EXIBIRIDIOMAS'));
		$iModel->ExibirPalavrasChave = utf8_decode($elem->getAttribute('EXIBIRPALAVRASCHAVE'));
		$iModel->NroMaximoPlvChave = utf8_decode($elem->getAttribute('NROMAXIMOPLVCHAVE'));
		$iModel->ExibirRequisitos = utf8_decode($elem->getAttribute('EXIBIRREQUISITOS'));
		$iModel->ExibirInteresse = utf8_decode($elem->getAttribute('EXIBIRINTERESSE'));
		$iModel->NroMaximoInteresses = utf8_decode($elem->getAttribute('NROMAXIMOINTERESSES'));
		$iModel->CargoSel = utf8_decode($elem->getAttribute('CARGOSEL'));
		$iModel->FuncaoSel = utf8_decode($elem->getAttribute('FUNCAOSEL'));
		$iModel->AreaAtuacaoSel = utf8_decode($elem->getAttribute('AREAATUACAOSEL'));
		$iModel->PalavraChaveSel = utf8_decode($elem->getAttribute('PALAVRACHAVESEL'));
		$iModel->RequisitoSel = utf8_decode($elem->getAttribute('REQUISITOSEL'));
		$iModel->ChaveCriptografia = utf8_decode($elem->getAttribute('CHAVECRIPTOGRAFIA'));
		$iModel->DataUltimaImportacao = utf8_decode($elem->getAttribute('DATAULTIMPORTACAO'));
		$iModel->UsaProxy = utf8_decode($elem->getAttribute('USAPROXY'));
		$iModel->Servidor = utf8_decode($elem->getAttribute('SERVIDOR'));
		$iModel->Porta = utf8_decode($elem->getAttribute('PORTA'));
		$iModel->RequerAutenticacao = utf8_decode($elem->getAttribute('REQUERAUTENTICACAO'));
		$iModel->UsuarioProxy = utf8_decode($elem->getAttribute('USUARIOPROXY'));
		$iModel->SenhaProxy = utf8_decode($elem->getAttribute('SENHAPROXY'));
		$iModel->Email = utf8_decode($elem->getAttribute('EMAIL'));
		$iModel->ServidorEmail = utf8_decode($elem->getAttribute('SERVIDOREMAIL'));
		$iModel->PortaSMTP = utf8_decode($elem->getAttribute('PORTASMTP'));
		$iModel->UsuarioSMTP = utf8_decode($elem->getAttribute('USUARIOSMTP'));
		$iModel->RequerAutenticacaoEmail = utf8_decode($elem->getAttribute('REQUERAUTENTICACAOEMAIL'));
		$iModel->ConexaoSegura = utf8_decode($elem->getAttribute('CONEXAOSEGURA'));
		$iModel->SenhaSMTP = utf8_decode($elem->getAttribute('SENHASMTP'));
		$iModel->OrdemPlvChave = utf8_decode($elem->getAttribute('ORDEMPLVCHAVE'));
		$iModel->OrdemInteresses = utf8_decode($elem->getAttribute('ORDEMINTERESSES'));
		$iModel->ConfigurarEmailPor = utf8_decode($elem->getAttribute('CONFIGURAREMAILPOR'));
		$iModel->EmailDe = utf8_decode($elem->getAttribute('EMAILDE'));
        $iModel->UsaHttps = utf8_decode($elem->getAttribute('USAHTTPS')); 
        $iModel->TermoHTML = utf8_decode($elem->getAttribute('TERMOHTML'));
        $iModel->MinimoCaracteres = utf8_decode($elem->getAttribute('MINIMOCARACTERES'));
        $iModel->UsaLetrasNumeros = utf8_decode($elem->getAttribute('USALETRASNUMEROS'));
        $iModel->UsaCaracteresEspeciais = utf8_decode($elem->getAttribute('USACARACTERESESPECIAIS'));
        $iModel->UsaMaiusculasMinusculas = utf8_decode($elem->getAttribute('USAMAIUSCULASMINUSCULAS'));
        $iDao->criarCandidatosWebConf($iModel);

	}
}

function inserirListaFuncoes($listaFuncoes, $limparTabela){
	global $db;
	include "../site/dao/FuncaoDao.php";
	include "../site/model/Funcao.php";

	$iDao = new FuncaoDao($db);
	$iModel = new Funcao();
    if ($limparTabela)
	    $iDao->excluirFuncao();
	foreach ($listaFuncoes as $elem) {
		$iModel->Funcao = utf8_decode($elem->getAttribute('FUNCAO'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->Cargo = utf8_decode($elem->getAttribute('CARGO'));
		$iModel->CBO = utf8_decode($elem->getAttribute('CBO'));
		$iModel->CBONovo = utf8_decode($elem->getAttribute('CBONOVO'));
		$iModel->PlanoCargo = utf8_decode($elem->getAttribute('PLANOCARGO'));
		$iModel->FaixaSalarial = utf8_decode($elem->getAttribute('FAIXASALARIAL'));
		$iModel->ClasseSalarial = utf8_decode($elem->getAttribute('CLASSESALARIAL'));
		$iModel->RequisitosFuncaoPPP = utf8_decode($elem->getAttribute('REQUISITOSFUNCAOPPP'));
		$iModel->DescAtividadesPPP = utf8_decode($elem->getAttribute('DESCATIVIDADESPPP'));
		$iModel->ConstarPPP = utf8_decode($elem->getAttribute('CONSTARPPP'));
		$iModel->FatorRequisito = utf8_decode($elem->getAttribute('FATORREQUISITO'));
		$iModel->FatorDescricao = utf8_decode($elem->getAttribute('FATORDESCRICAO'));
		$iModel->TextoOLE = utf8_decode($elem->getAttribute('TEXTOOLE'));
		$iModel->GrauInstrucao = utf8_decode($elem->getAttribute('GRAUINSTRUCAO'));
		$iModel->AtivaDesativada = utf8_decode($elem->getAttribute('ATIVADESATIVADA'));
		$iModel->GrauInstrucaoMaximo = utf8_decode($elem->getAttribute('GRAUINSTRUCAOMAXIMO'));
		$iModel->MaoDeObra = utf8_decode($elem->getAttribute('MAODEOBRA'));
		$iModel->Descricao = utf8_decode($elem->getAttribute('DESCRICAO'));

		$iDao->criarFuncao($iModel);
	}
}

function inserirListaCargos($listaCargos, $limparTabela){
	global $db;
	include "../site/dao/CargoDao.php";
	include "../site/model/Cargo.php";

	$iDao = new CargoDao($db);
	$iModel = new Cargo();
    if ($limparTabela)
	    $iDao->excluirCargo();
	foreach ($listaCargos as $elem) {
		$iModel->Cargo = utf8_decode($elem->getAttribute('CARGO'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->DescricaoOficial = utf8_decode($elem->getAttribute('DESCRICAOOFICIAL'));
		$iModel->CBO = utf8_decode($elem->getAttribute('CBO'));
		$iModel->CBONovo = utf8_decode($elem->getAttribute('CBONOVO'));
		$iModel->CodigoOcupacaoIR = utf8_decode($elem->getAttribute('CODIGOOCUPACAOIR'));
		$iModel->PlanoCargo = utf8_decode($elem->getAttribute('PLANOCARGO'));
		$iModel->FaixaSalarial = utf8_decode($elem->getAttribute('FAIXASALARIAL'));
		$iModel->ClasseSalarial = utf8_decode($elem->getAttribute('CLASSESALARIAL'));
		$iModel->TextoOLE = utf8_decode($elem->getAttribute('TEXTOOLE'));
		$iModel->NivelCargo = utf8_decode($elem->getAttribute('NIVELCARGO'));
		$iModel->GrauInstrucao = utf8_decode($elem->getAttribute('GRAUINSTRUCAO'));
		$iModel->FatorRequisito = utf8_decode($elem->getAttribute('FATORREQUISITO'));
		$iModel->FatorDescricao = utf8_decode($elem->getAttribute('FATORDESCRICAO'));
		$iModel->AtivaDesativada = utf8_decode($elem->getAttribute('ATIVADESATIVADA'));
		$iModel->GrauInstrucaoMaximo = utf8_decode($elem->getAttribute('GRAUINSTRUCAOMAXIMO'));
		$iModel->MaoDeObra = utf8_decode($elem->getAttribute('MAODEOBRA'));
		$iModel->CargoDeProfessor = utf8_decode($elem->getAttribute('DESCRICAO'));

		$iDao->criarCargo($iModel);
	}
}

function inserirListaVincEmpregaticios($listaVincEmpregaticios, $limparTabela){
	global $db;
	include "../site/dao/VinculoEmpregaticioDao.php";
	include "../site/model/VinculoEmpregaticio.php";

	$iDao = new VinculoEmpregaticioDao($db);
	$iModel = new VinculoEmpregaticio();
    if ($limparTabela)
	    $iDao->excluirVincEmpregaticio();
	foreach ($listaVincEmpregaticios as $elem) {
		$iModel->VinculoEmpregaticio = utf8_decode($elem->getAttribute('VINCULOEMPREGATICIO'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->VinculoEmpregaticioRAIS = utf8_decode($elem->getAttribute('VINCULOEMPREGATICIORAIS'));
		$iModel->CategoriaSEPIF = utf8_decode($elem->getAttribute('CATEGORIASEPIF'));
		$iModel->OpcaoPrevidencia = utf8_decode($elem->getAttribute('OPCAOPREVIDENCIA'));
		$iModel->VinculoPrevidencia = utf8_decode($elem->getAttribute('VINCULOPREVIDENCIA'));
		$iModel->RecolheFGTS = utf8_decode($elem->getAttribute('RECOLHEFGTS'));
		$iModel->VinculoSindicato = utf8_decode($elem->getAttribute('VINCULOSINDICATO'));
		$iModel->RecebeFerias = utf8_decode($elem->getAttribute('RECEBEFERIAS'));
		$iModel->RegimeTempoParcial = utf8_decode($elem->getAttribute('REGIMETEMPOPARCIAL'));
		$iModel->Recebe13Salario = utf8_decode($elem->getAttribute('RECEBE13SALARIO'));
		$iModel->CodigoRetencao = utf8_decode($elem->getAttribute('CODIGORETENCAO'));

		$iDao->criarVincEmpregaticio($iModel);
	}
}

function inserirListaAreasAtuacao($listaAreasAtuacao, $limparTabela){
	global $db;
	include "../site/dao/AreaAtuacaoDao.php";
	include "../site/model/AreaAtuacao.php";

	$iDao = new AreaAtuacaoDao($db);
	$iModel = new AreaAtuacao();
    if ($limparTabela)
	    $iDao->excluirAreaAtuacao();
	foreach ($listaAreasAtuacao as $elem) {
		$iModel->AreaAtuacao = utf8_decode($elem->getAttribute('AREAATUACAO'));
		$iModel->Descricao60 = utf8_decode($elem->getAttribute('DESCRICAO60'));
		$iModel->AtivaDesativa = utf8_decode($elem->getAttribute('ATIVADESATIVADA'));

		$iDao->criarAreaAtuacao($iModel);
	}
}

function inserirListaRegioes($listaRegioes, $limparTabela){
	global $db;
	include "../site/dao/RegiaoDao.php";
	include "../site/model/Regiao.php";

	$iDao = new RegiaoDao($db);
	$iModel = new Regiao();
    if ($limparTabela)
	    $iDao->excluirRegiao();
	foreach ($listaRegioes as $elem) {
		$iModel->Regiao = utf8_decode($elem->getAttribute('REGIAO'));
		$iModel->Descricao60 = utf8_decode($elem->getAttribute('DESCRICAO60'));
		$iModel->AtivaDesativada = utf8_decode($elem->getAttribute('ATIVADESATIVADA'));

		$iDao->criarRegiao($iModel);
	}
}

function inserirListaEmpresas($listaEmpresas, $limparTabela){
	global $db;
	include "../site/dao/EmpresaDao.php";
	include "../site/model/Empresa.php";

	$iDao = new EmpresaDao($db);
	$iModel = new Empresa();
    if ($limparTabela)
	    $iDao->excluirEmpresa();
	foreach ($listaEmpresas as $elem) {
		$iModel->Empresa = utf8_decode($elem->getAttribute('EMPRESA'));
		$iModel->RazaoSocial = utf8_decode($elem->getAttribute('RAZAOSOCIAL'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->TipoEmpresa = utf8_decode($elem->getAttribute('TIPOEMPRESA'));
		$iModel->UsaFolha = utf8_decode($elem->getAttribute('USAFOLHA'));
		$iModel->UsaPonto = utf8_decode($elem->getAttribute('USAPONTO'));
		$iModel->UsaRecrutamento = utf8_decode($elem->getAttribute('USARECRUTAMENTO'));
		$iModel->UsaTreinamento = utf8_decode($elem->getAttribute('USATREINAMENTO'));
		$iModel->UsaCargosSalarios = utf8_decode($elem->getAttribute('USACARGOSSALARIOS'));
		$iModel->UsaGestaoSalarial = utf8_decode($elem->getAttribute('USAGESTAOSALARIAL'));
		$iModel->UsaSeguranca = utf8_decode($elem->getAttribute('USASEGURANCA'));
		$iModel->UsaPCMSO = utf8_decode($elem->getAttribute('USAPCMSO'));
		$iModel->UsaValeTransp = utf8_decode($elem->getAttribute('USAVALETRANSP'));
		$iModel->UsaModulo01 = utf8_decode($elem->getAttribute('USAMODULO01'));
		$iModel->UsaModulo02 = utf8_decode($elem->getAttribute('USAMODULO02'));
		$iModel->UsaModulo03 = utf8_decode($elem->getAttribute('USAMODULO03'));
		$iModel->UsaModulo04 = utf8_decode($elem->getAttribute('USAMODULO04'));
		$iModel->UsaModulo05 = utf8_decode($elem->getAttribute('USAMODULO05'));
		$iModel->UsaModulo06 = utf8_decode($elem->getAttribute('USAMODULO06'));
		$iModel->UsaModulo07 = utf8_decode($elem->getAttribute('USAMODULO07'));
		$iModel->UsaModulo08 = utf8_decode($elem->getAttribute('USAMODULO08'));
		$iModel->UsaModulo09 = utf8_decode($elem->getAttribute('USAMODULO09'));
		$iModel->UsaModulo10 = utf8_decode($elem->getAttribute('USAMODULO10'));
		$iModel->UsaModulo11 = utf8_decode($elem->getAttribute('USAMODULO11'));
		$iModel->UsaModulo12 = utf8_decode($elem->getAttribute('USAMODULO12'));
		$iModel->UsaModulo13 = utf8_decode($elem->getAttribute('USAMODULO13'));
		$iModel->UsaModulo14 = utf8_decode($elem->getAttribute('USAMODULO14'));
		$iModel->UsaModulo15 = utf8_decode($elem->getAttribute('USAMODULO15'));
		$iModel->UsaModulo16 = utf8_decode($elem->getAttribute('USAMODULO16'));
		$iModel->UsaModulo17 = utf8_decode($elem->getAttribute('USAMODULO17'));
		$iModel->UsaModulo18 = utf8_decode($elem->getAttribute('USAMODULO18'));
		$iModel->UsaModulo19 = utf8_decode($elem->getAttribute('USAMODULO19'));
		$iModel->UsaModulo20 = utf8_decode($elem->getAttribute('USAMODULO20'));
		$iModel->GrupoEmpresa = utf8_decode($elem->getAttribute('GRUPOEMPRESA'));
		$iModel->Usuario = utf8_decode($elem->getAttribute('USUARIO'));
		$iModel->AtivaDesativada = utf8_decode($elem->getAttribute('ATIVADESATIVADA'));

		$iDao->criarEmpresa($iModel);
	}
}

function inserirListaVariaveis($listaVariaveis, $limparTabela){
	global $db;
	include "../site/dao/VariavelDao.php";
	include "../site/model/Variavel.php";

	$iDao = new VariavelDao($db);
	$iModel = new Variavel();
    if ($limparTabela)
	    $iDao->excluirVariavel();
	foreach ($listaVariaveis as $elem) {
		$iModel->Variavel = utf8_decode($elem->getAttribute('VARIAVEL'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->TipoCampo = utf8_decode($elem->getAttribute('TIPOCAMPO'));
		$iModel->TamanhoCampo = utf8_decode($elem->getAttribute('TAMANHOCAMPO'));
		$iModel->NroDecimais = utf8_decode($elem->getAttribute('NRODECIMAIS'));
		$iModel->TabelaOrigem = utf8_decode($elem->getAttribute('TABELAORIGEM'));
		$iModel->TabelaDescricao = utf8_decode($elem->getAttribute('TABELADESCRICAO'));
		$iModel->CampoChave = utf8_decode($elem->getAttribute('CAMPOCHAVE'));
		$iModel->CampoDescricao = utf8_decode($elem->getAttribute('CAMPODESCRICAO'));
		$iModel->TabelaOrigemFutura = utf8_decode($elem->getAttribute('TABELAORIGEMFUTURA'));
		$iModel->CampoTabela = utf8_decode($elem->getAttribute('CAMPOTABELA'));
		$iModel->CampoTabelaFutura = utf8_decode($elem->getAttribute('CAMPOTABELAFUTURA'));
        $iModel->Descricao80 = utf8_decode($elem->getAttribute('DESCRICAO80'));        

		$iDao->criarVariavel($iModel);
	}
}

function inserirListaVariaveisObr($listaVariaveisObr, $limparTabela){
	global $db;
	include "../site/dao/VariavelWebObrDao.php";
	include "../site/model/VariavelWebObr.php";

	$iDao = new VariavelWebObrDao($db);
	$iModel = new VariavelWebObr();
    if ($limparTabela)
	    $iDao->excluirVariavelObr();
	foreach ($listaVariaveisObr as $elem) {
		$iModel->Empresa = utf8_decode($elem->getAttribute('EMPRESA'));
		$iModel->Variavel = utf8_decode($elem->getAttribute('VARIAVEL'));

		$iDao->criarVariavelObr($iModel);
	}
}

function inserirListaCodigosCompl($listaCodigosCompl, $limparTabela){
	global $db;
	include "../site/dao/CodigoComplementarDao.php";
	include "../site/model/CodigosCompl.php";

	$iDao = new CodigoComplementarDao($db);
	$iModel = new CodigosCompl();
    if ($limparTabela)
	    $iDao->excluirCodigosCompl();
	foreach ($listaCodigosCompl as $elem) {
		$iModel->Variavel = utf8_decode($elem->getAttribute('VARIAVEL'));
		$iModel->CodigoComplementar = utf8_decode($elem->getAttribute('CODIGOCOMPLEMENTAR'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));

		$iDao->criarCodigosCompl($iModel);
	}
}

function inserirListaOpcoesCompl($listaOpcoesCompl, $limparTabela){
	global $db;
	include "../site/dao/OpcaoComplementarDao.php";
	include "../site/model/OpcoesCompl.php";

	$iDao = new OpcaoComplementarDao($db);
	$iModel = new OpcoesCompl();
    if ($limparTabela)
	    $iDao->excluirOpcoesCompl();
	foreach ($listaOpcoesCompl as $elem) {
		$iModel->Variavel = utf8_decode($elem->getAttribute('VARIAVEL'));
		$iModel->OpcaoComplementar = utf8_decode($elem->getAttribute('OPCAOCOMPLEMENTAR'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));

		$iDao->criarOpcoesCompl($iModel);
	}
}

function inserirListaOpcoesDicionario($listaOpcoesDicionario, $limparTabela){
	global $db;
	include "../site/dao/OpcaoDicionarioDao.php";
	include "../site/model/OpcaoDicionario.php";

	$iDao = new OpcaoDicionarioDao($db);
	$iModel = new OpcaoDicionario();
    if ($limparTabela)
	    $iDao->excluirOpcoesDicionario();
	foreach ($listaOpcoesDicionario as $elem) {
		$iModel->CampoTabela = utf8_decode($elem->getAttribute('CAMPOTABELA'));
		$iModel->Opcao = utf8_decode($elem->getAttribute('OPCAO'));
		$iModel->TamanhoDescricao = utf8_decode($elem->getAttribute('TAMANHODESCRICAO'));
		$iModel->Descricao60 = utf8_decode($elem->getAttribute('DESCRICAO60'));

		$iDao->criarOpcoesDicionario($iModel);
	}
}

function inserirListaHabilitacoesProf($listaHabilitacoesProf, $limparTabela){
	global $db;
	include "../site/dao/HabilitacaoProfissionalDao.php";
	include "../site/model/HabilitacaoProfissional.php";

	$iDao = new HabilitacaoProfissionalDao($db);
	$iModel = new HabilitacaoProfissional();
    if ($limparTabela)
	    $iDao->excluirHabilitacaoProfissional();
	foreach ($listaHabilitacoesProf as $elem) {
		$iModel->HabilitacaoProfissional = utf8_decode($elem->getAttribute('HABILITACAOPROFISSIONAL'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->ConselhoClasse = utf8_decode($elem->getAttribute('CONSELHOCLASSE'));

		$iDao->criarHabilitacaoProfissional($iModel);
	}
}

function inserirListaRequisitos($listaRequisitos, $limparTabela){
	global $db;
	include "../site/dao/RequisitoDao.php";
	include "../site/model/Requisito.php";

	$iDao = new RequisitoDao($db);
	$iModel = new Requisito();
    if ($limparTabela)
	    $iDao->excluirRequisito();
	foreach ($listaRequisitos as $elem) {
		$iModel->Requisito = utf8_decode($elem->getAttribute('REQUISITO'));
		$iModel->Descricao80 = utf8_decode($elem->getAttribute('DESCRICAO80'));
		$iModel->TipoRequisito = utf8_decode($elem->getAttribute('TIPOREQUISITO'));
		$iModel->ImprimirCurriculo = utf8_decode($elem->getAttribute('IMPRIMIRCURRICULO'));
		$iModel->SolicitarFicha = utf8_decode($elem->getAttribute('SOLICITARFICHA'));
		$iModel->Avaliacao = utf8_decode($elem->getAttribute('AVALIACAO'));
		$iModel->Medida = utf8_decode($elem->getAttribute('MEDIDA'));
		$iModel->ClasseRequisito = utf8_decode($elem->getAttribute('CLASSEREQUISITO'));

		$iDao->criarRequisito($iModel);
	}
}

function inserirListaRequisitosObr($listaRequisitosObr, $limparTabela){
	global $db;
	include "../site/dao/RequisitoWebObrDao.php";
	include "../site/model/RequisitoWebObr.php";

	$iDao = new RequisitoWebObrDao($db);
	$iModel = new RequisitoWebObr();
    if ($limparTabela)
	    $iDao->excluirRequisitoWebObr();
	foreach ($listaRequisitosObr as $elem) {
		$iModel->Empresa =  utf8_decode($elem->getAttribute('EMPRESA'));
		$iModel->Requisito = utf8_decode($elem->getAttribute('REQUISITO'));

		$iDao->criarRequisitoWebObr($iModel);
	}

}

function inserirListaMedidas($listaMedidas, $limparTabela){
	global $db;
	include "../site/dao/MedidaDao.php";
	include "../site/model/Medida.php";

	$iDao = new MedidaDao($db);
	$iModel = new Medida();
    if ($limparTabela)
	    $iDao->excluirMedida();
	foreach ($listaMedidas as $elem) {
		$iModel->Medida = utf8_decode($elem->getAttribute('MEDIDA'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->NroDecimais = utf8_decode($elem->getAttribute('NRODECIMAIS'));

		$iDao->criarMedida($iModel);
	}
}

function inserirListaEscalasAvaliacao($listaEscalasAvaliacao, $limparTabela){
	global $db;
	include "../site/dao/EscalaAvaliacaoDao.php";
	include "../site/model/EscalaAvaliacao.php";

	$iDao = new EscalaAvaliacaoDao($db);
	$iModel = new EscalaAvaliacao();
    if ($limparTabela)
	    $iDao->excluirEscalasAvaliacao();
	foreach ($listaEscalasAvaliacao as $elem) {
		$iModel->Avaliacao = utf8_decode($elem->getAttribute('AVALIACAO'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->ItemAvaliacao = utf8_decode($elem->getAttribute('ITEM_AVALIACAO'));

		$iDao->criarEscalasAvaliacao($iModel);
	}
}

function inserirListaEscalasAvaliaItens($listaEscalasAvaliaItens, $limparTabela){
	global $db;
	include "../site/dao/EscalaAvaliaItemDao.php";
	include "../site/model/EscalaAvaliaItem.php";

	$iDao = new EscalaAvaliaItemDao($db);
	$iModel = new EscalaAvaliaItem();
    if ($limparTabela)
	    $iDao->excluirEscalasAvaliaItens();
	foreach ($listaEscalasAvaliaItens as $elem) {
		$iModel->Avaliacao = utf8_decode($elem->getAttribute('AVALIACAO'));
		$iModel->ItemAvaliacao = utf8_decode($elem->getAttribute('ITEM_AVALIACAO'));
		$iModel->Descricao15 = utf8_decode($elem->getAttribute('DESCRICAO15'));
		$iModel->Peso = utf8_decode($elem->getAttribute('PESO'));

		$iDao->criarEscalasAvaliaItem($iModel);
	}
}

function inserirListaEscalaRequisitos($listaEscalaRequisitos, $limparTabela){
	global $db;
	include "../site/dao/EscalaRequisitoDao.php";
	include "../site/model/EscalaRequisito.php";

	$iDao = new EscalaRequisitoDao($db);
	$iModel = new EscalaRequisito();
    if ($limparTabela)
	    $iDao->excluirEscalaRequisito();
	foreach ($listaEscalaRequisitos as $elem) {
		$iModel->Avaliacao = utf8_decode($elem->getAttribute('AVALIACAO'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));

		$iDao->criarEscalaRequisito($iModel);
	}
}

function inserirListaEscalaReqItens($listaEscalaReqItens, $limparTabela){
	global $db;
	include "../site/dao/EscalaRequisitoItemDao.php";
	include "../site/model/EscalaRequisitoItem.php";

	$iDao = new EscalaRequisitoItemDao($db);
	$iModel = new EscalaRequisitoItem();
    if ($limparTabela)
	    $iDao->excluirEscalaRequisitoItem();
	foreach ($listaEscalaReqItens as $elem) {
		$iModel->Avaliacao = utf8_decode($elem->getAttribute('AVALIACAO'));
		$iModel->ItemAvaliacao = utf8_decode($elem->getAttribute('ITEM_AVALIACAO'));
		$iModel->Descricao15 = utf8_decode($elem->getAttribute('DESCRICAO15'));

		$iDao->criarEscalaRequisitoItem($iModel);
	}
}

function inserirListaCursos($listaCursos, $limparTabela){
	global $db;
	include "../site/dao/CursoDao.php";
	include "../site/model/Curso.php";
	include_once "../site/util/DataUtil.php";
	include_once "../site/util/NumberUtil.php";


	$iDao = new CursoDao($db);
	$iModel = new Curso();
	$dateUtil = new DataUtil();
	$numberUtil = new NumberUtil();

    if ($limparTabela)
	    $iDao->excluirCurso();

	foreach ($listaCursos as $elem) {
		$iModel->Curso = utf8_decode($elem->getAttribute('CURSO'));
		$iModel->Descricao50 = utf8_decode($elem->getAttribute('DESCRICAO50'));
		$iModel->ProgramaCurso = utf8_decode($elem->getAttribute('PROGRAMACURSO'));
		$iModel->DataCriacao = $dateUtil->toTimestamp(utf8_decode($elem->getAttribute('DATACRIACAO')));
		$iModel->DataDesativacao = $dateUtil->toTimestamp(utf8_decode($elem->getAttribute('DATADESATIVACAO')));
		$iModel->Validade = utf8_decode($elem->getAttribute('VALIDADE'));


		$iModel->TipoLocal = utf8_decode($elem->getAttribute('TIPO_LOCAL'));
		$iModel->TipoCurso = utf8_decode($elem->getAttribute('TIPOCURSO'));

		$iModel->UltimaRevisaoExigida = utf8_decode($elem->getAttribute('ULTIMAREVISAOEXIGIDA'));
		$iModel->UltDtRevisaoExigida = $dateUtil->toTimestamp(utf8_decode($elem->getAttribute('ULTDT_REVISAOEXIGIDA')));


		$iModel->CarHoraria = $numberUtil->formatarSql(utf8_decode($elem->getAttribute('CAR_HORARIA')));
		$iModel->ClassificacaoCurso = utf8_decode($elem->getAttribute('CLASSIFICACAOCURSO'));
		$iModel->TextoOLE = utf8_decode($elem->getAttribute('TEXTOOLE'));
		$iModel->UsaModulo10 = utf8_decode($elem->getAttribute('USAMODULO10'));
		$iModel->AvaliarReacao = utf8_decode($elem->getAttribute('AVALIARREACAO'));
		$iModel->AvaliarEficacia = utf8_decode($elem->getAttribute('AVALIAREFICACIA'));
		$iModel->ObjetivoCurso = utf8_decode($elem->getAttribute('OBJETIVOCURSO'));


		$iModel->AvaliarPreTeste = utf8_decode($elem->getAttribute('AVALIARPRETESTE'));
		$iModel->AvaliarPosTeste = utf8_decode($elem->getAttribute('AVALIARPOSTESTE'));
		$iModel->QuestionarioPre = utf8_decode($elem->getAttribute('QUESTIONARIOPRE'));
		$iModel->QuestionarioPos = utf8_decode($elem->getAttribute('QUESTIONARIOPOS'));

		$iModel->GrauInstrucaoAndamento = utf8_decode($elem->getAttribute('GRAUINSTRUCAOANDAMENTO'));
		$iModel->GrauInstrucaoConcluido = utf8_decode($elem->getAttribute('GRAUINSTRUCAOCONCLUIDO'));
		$iModel->Fornecedor = utf8_decode($elem->getAttribute('FORNECEDOR'));

		$iDao->criarCurso($iModel);
	}
}

function inserirListaEstadoCivil($listaEstadoCivil, $limparTabela){
	global $db;
	include "../site/dao/EstadoCivilDao.php";
	include "../site/model/EstadoCivil.php";

	$iDao = new EstadoCivilDao($db);
	$iModel = new EstadoCivil();
    if ($limparTabela)
	    $iDao->excluirEstadoCivil();
	foreach ($listaEstadoCivil as $elem) {
		$iModel->EstadoCivil = utf8_decode($elem->getAttribute('ESTADOCIVIL'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->ClasseEstadoCivil = utf8_decode($elem->getAttribute('CLASSEESTADOCIVIL'));

		$iDao->criarEstadoCivil($iModel);
	}
}

function inserirListaGrauInstrucao($listaGrauInstrucao, $limparTabela){
	global $db;
	include "../site/dao/GrauInstrucaoDao.php";
	include "../site/model/GrauInstrucao.php";

	$iDao = new GrauInstrucaoDao($db);
	$iModel = new GrauInstrucao();
    if ($limparTabela)
	    $iDao->excluirGrauInstrucao();
	foreach ($listaGrauInstrucao as $elem) {
		$iModel->GrauInstrucao = utf8_decode($elem->getAttribute('GRAUINSTRUCAO'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->GrauInstrucaoRAIS = utf8_decode($elem->getAttribute('GRAUINSTRUCAORAIS'));

		$iDao->criarGrauInstrucao($iModel);
	}
}

function inserirListaMunicipios($listaMunicipios, $limparTabela){
	global $db;
	include "../site/dao/MunicipioDao.php";
	include "../site/model/Municipio.php";

	$iDao = new MunicipioDao($db);
	$iModel = new Municipio();
    if ($limparTabela)
	    $iDao->excluirMunicipio();
	foreach ($listaMunicipios as $elem) {
		try {
			$iModel->Cidade = utf8_decode($elem->getAttribute('CIDADE'));
			$iModel->UF = utf8_decode($elem->getAttribute('UF'));
			$iModel->CodigoMunicipioRAIS = utf8_decode($elem->getAttribute('CODIGOMUNICIPIORAIS'));
            $iModel->Descricao80 = utf8_decode($elem->getAttribute('DESCRICAO80'));

			$iDao->criarMunicipio($iModel);
		} catch (Exception $e) {
		}
	}
}

function inserirListaNacionalidades($listaNacionalidades, $limparTabela){
	global $db;
	include "../site/dao/NacionalidadeDao.php";
	include "../site/model/Nacionalidade.php";

	$iDao = new NacionalidadeDao($db);
	$iModel = new Nacionalidade();
    if ($limparTabela)
	    $iDao->excluirNacionalidade();
	foreach ($listaNacionalidades as $elem) {
		$iModel->Nacionalidade = utf8_decode($elem->getAttribute('NACIONALIDADE'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->NacionalidadeRAIS = utf8_decode($elem->getAttribute('NACIONALIDADERAIS'));

		$iDao->criarNacionalidade($iModel);
	}
}

function inserirListaPalavrasChave($listaPalavrasChave, $limparTabela){
	global $db;
	include "../site/dao/PalavraChaveDao.php";
	include "../site/model/PalavraChave.php";

	$iDao = new PalavraChaveDao($db);
	$iModel = new PalavraChave();
    if ($limparTabela)
	    $iDao->excluirPalavrasChave();
	foreach ($listaPalavrasChave as $elem) {
		$iModel->PalavraChave = utf8_decode($elem->getAttribute('PALAVRACHAVE'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));
		$iModel->AtivaDesativada = utf8_decode($elem->getAttribute('ATIVADESATIVADA'));

		$iDao->criarPalavrasChave($iModel);
	}
}

function inserirListaTiposResidencia($listaTiposResidencia, $limparTabela){
	global $db;
	include "../site/dao/TipoResidenciaDao.php";
	include "../site/model/TipoResidencia.php";

	$iDao = new TipoResidenciaDao($db);
	$iModel = new TipoResidencia();
    if ($limparTabela)
	    $iDao->excluirTiposResidencia();
	foreach ($listaTiposResidencia as $elem) {
		$iModel->TipoResidencia = utf8_decode($elem->getAttribute('TIPORESIDENCIA'));
		$iModel->Descricao20 = utf8_decode($elem->getAttribute('DESCRICAO20'));
		$iModel->ClasseResidencia = utf8_decode($elem->getAttribute('CLASSERESIDENCIA'));

		$iDao->criarTiposResidencia($iModel);
	}
}

function inserirListaCamposWebObr($listaCamposWebObr, $limparTabela){
	global $db;
	include "../site/dao/CampoWebObrDao.php";
	include "../site/model/CampoWebObr.php";

	$iDao = new CampoWebObrDao($db);
	$iModel = new CampoWebObr();
    if ($limparTabela)
        $iDao->excluirCampoWebObr();

	foreach ($listaCamposWebObr as $elem) {

        if (trim($elem->getAttribute('EMPRESA')) <> '' and (trim($elem->getAttribute('IDCAMPOOBR')) <> ''))
        {
            $iModel->Empresa = utf8_decode($elem->getAttribute('EMPRESA'));
		    $iModel->IdCampoObr = utf8_decode($elem->getAttribute('IDCAMPOOBR'));
		    $iDao->criarCampoWebObr($iModel);
        }
	}
}

function inserirListaCamposWebInv($listaCamposWebÏnv, $limparTabela){
	global $db;
	include "../site/dao/CampoWebInvDao.php";
	include "../site/model/CampoWebInv.php";
	$iDao = new CampoWebInvDao($db);
	$iModel = new CampoWebInv();
    if ($limparTabela)
        $iDao->excluirCampoWebInv();

	foreach ($listaCamposWebÏnv as $elem) {

        if (trim($elem->getAttribute('EMPRESA')) <> '' and (trim($elem->getAttribute('IDCAMPOINV')) <> ''))
        {
            $iModel->Empresa = utf8_decode($elem->getAttribute('EMPRESA'));
		    $iModel->IdCampoInv = utf8_decode($elem->getAttribute('IDCAMPOINV'));
		    $iDao->criarCampoWebInv($iModel);
        }
	}
}

function inserirListaDicionarioCampoObr($listaDicionarioCampoObr, $limparTabela){
	global $db;
	include "../site/dao/DicionarioCampoObrDao.php";
	include "../site/model/DicionarioCampoObr.php";

	$iDao = new DicionarioCampoObrDao($db);
	$iModel = new DicionarioCampoObr();
    if ($limparTabela)
	    $iDao->excluirDicionarioCampoObr();
	foreach ($listaDicionarioCampoObr as $elem) {
		$iModel->IdCampoObr = utf8_decode($elem->getAttribute('IDCAMPOOBR'));
		$iModel->Tabela = utf8_decode($elem->getAttribute('TABELA'));
		$iModel->CampoTabela = utf8_decode($elem->getAttribute('CAMPOTABELA'));
		$iModel->Descricao60 = utf8_decode($elem->getAttribute('DESCRICAO60'));

		$iDao->criarDicionarioCampoObr($iModel);
	}
}

function inserirListaTiposCurso($listaTipoCurso, $limparTabela){
	global $db;
	include "../site/dao/TipoCursoDao.php";
	include "../site/model/TipoCurso.php";

	$iDao = new TipoCursoDao($db);
	$iModel = new TipoCurso();
    if ($limparTabela)
	    $iDao->excluirTipoCurso();
	foreach ($listaTipoCurso as $elem) {
		$iModel->TipoCurso = utf8_decode($elem->getAttribute('TIPOCURSO'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));

		$iDao->criarTipoCurso($iModel);
	}
}

function inserirListaDiretrizCVWebDef($listaDiretrizCVWebDef, $limparTabela){
	global $db;
	include "../site/dao/DiretrizCVWebDefDao.php";
	include "../site/model/DiretrizCVWebDef.php";

	$iDao = new DiretrizCVWebDefDao($db);
	$iModel = new DiretrizCVWebDef();
    if ($limparTabela)
	    $iDao->excluirDiretrizCVWebDef();
	foreach ($listaDiretrizCVWebDef as $elem) {
		$iModel->DiretrizWeb = utf8_decode($elem->getAttribute('DIRETRIZWEB'));
		$iModel->Descricao80 = utf8_decode($elem->getAttribute('DESCRICAO80'));
		$iModel->TipoDiretrizWeb = utf8_decode($elem->getAttribute('TIPODIRETRIZWEB'));

		$iDao->criarDiretrizCVWebDef($iModel);
	}
}

function inserirListaDiretrizCVWebOpc($listaDiretrizCVWebOpc, $limparTabela){
	global $db;
	include "../site/dao/DiretrizCVWebOpcDao.php";
	include "../site/model/DiretrizCVWebOpc.php";

	$iDao = new DiretrizCVWebOpcDao($db);
	$iModel = new DiretrizCVWebOpc();
    if ($limparTabela)
	    $iDao->excluirDiretrizCVWebOpc();
	foreach ($listaDiretrizCVWebOpc as $elem) {
		$iModel->DiretrizWeb = utf8_decode($elem->getAttribute('DIRETRIZWEB'));
		$iModel->NroOrdem = utf8_decode($elem->getAttribute('NROORDEM'));
		$iModel->Descricao40 = utf8_decode($elem->getAttribute('DESCRICAO40'));

		$iDao->criarDiretrizCVWebOpc($iModel);
	}
}

function inserirListaCandidatoWebDir($listaCandidatoWebDir, $limparTabela){
	global $db;
	include "../site/dao/CandidatoWebDirDao.php";
	include "../site/model/CandidatoWebDir.php";

	$iDao = new CandidatoWebDirDao($db);
	$iModel = new CandidatoWebDir();
    if ($limparTabela)
	    $iDao->excluirCandidatoWebDir();
	foreach ($listaCandidatoWebDir as $elem) {
		$iModel->Empresa = utf8_decode($elem->getAttribute('EMPRESA'));
		$iModel->DiretrizWeb = utf8_decode($elem->getAttribute('DIRETRIZWEB'));
		$iModel->ConteudoData = utf8_decode($elem->getAttribute('CONTEUDODATA'));
		$iModel->ConteudoMemo = utf8_decode($elem->getAttribute('CONTEUDOMEMO'));
		$iModel->ConteudoNumero = utf8_decode($elem->getAttribute('CONTEUDONUMERO'));
		$iModel->ConteudoOpcao = utf8_decode($elem->getAttribute('CONTEUDOOPCAO'));

		$iDao->criarCandidatoWebDir($iModel);
	}
}

function atualizarEmailCandidato($empresa,$cpf,$email){
    global $db;
	include "../site/dao/PessoaDao.php";

	$iDao = new PessoaDao($db); 
    $iDao->atualizaEmail($empresa,$cpf,$email);
}

?>