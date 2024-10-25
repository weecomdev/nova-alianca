<?php


// Report simple running errors
ini_set('error_reporting', E_ALL ^ ~E_NOTICE);
// Set the display_errors directive to Off
ini_set('display_errors', 1);
// Log errors to the web server's error log
ini_set('log_errors', 1);

$globalEmpresa = "0";
$ticket = "";
//$arq = fopen("LogErrosCurriculo.txt", 'w');

require_once('padraoServicos.php');
require_once('lib/nusoap.php');
require_once("lib/class.simetric.php");
$server = new soap_server(); 							// Create the server instance
$server->configureWSDL('wsdlEmail', 'urn:wsdlEmail');	// Initialize WSDL support


// Registra o mï¿½todo retornaVersaoCVWebDao
$server->register(
	"enviaEmailCVWeb", 
array("empresa" => "xsd:string",
	  "ticketLogin" => "xsd:string",
	  "configurarEmailPor" => "xsd:string",
	  "smtpEmail" => "xsd:string",
	  "smtpServidor" => "xsd:string",
	  "smtpPorta" => "xsd:string",
	  "smtpRequerAutenticacao" => "xsd:string",
	  "smtpConexaoSegura" => "xsd:string",
	  "stmpUsuario" => "xsd:string",
	  "smtpSenha" => "xsd:string",
	  "padraoServEmailDe" => "xsd:string",
	  "emailTeste" => "xsd:string",
      "versaoSirh" => "xsd:string"),
array("return" => "xsd:string"),
	'urn:wsdlDiagnosticoReceber',				// namespace
	'urn:wsdlDiagnosticoReceber#enviaEmailCVWeb',		// soapaction
	"rpc",
	"encoded");

$server->register(
		"limpaDiagnostico",
array("empresa" => "xsd:string",
	"ticketLogin" => "xsd:string",
	"configurarEmailPor" => "xsd:string",
	"smtpEmail" => "xsd:string",
	"smtpServidor" => "xsd:string",
	"smtpPorta" => "xsd:string",
	"smtpRequerAutenticacao" => "xsd:string",
	"smtpConexaoSegura" => "xsd:string",
	"stmpUsuario" => "xsd:string",
	"smtpSenha" => "xsd:string",
	"padraoServEmailDe" => "xsd:string",
	"emailTeste" => "xsd:string"),
array("return" => "xsd:string"),		
		'urn:wsdlDiagnosticoReceber',				// namespace
		'urn:wsdlDiagnosticoReceber#limpaDiagnostico',		// soapaction
		"rpc",
		"encoded");

$server->register(
"verificaChaveDeCriptografia",
array("empresa" => "xsd:string",
      "chave" => "xsd:string"),
array("return" => "xsd:string"),
	'urn:wsdlDiagnosticoReceber',				// namespace
	'urn:wsdlDiagnosticoReceber#verificaChaveDeCriptografia',		// soapaction
	"rpc",
	"encoded");

$server->register(
"verificaConfiguracaoMySql",
array("empresa" => "xsd:string"),
array("return" => "xsd:string"),
	'urn:wsdlDiagnosticoReceber',				// namespace
	'urn:wsdlDiagnosticoReceber#verificaConfiguracaoMySql',		// soapaction
	"rpc",
	"encoded");

$server->register(
"verificaLogin",
array("ticketLogin" => "xsd:string"),
array("return" => "xsd:string"),
	'urn:wsdlDiagnosticoReceber',				// namespace
	'urn:wsdlDiagnosticoReceber#verificaLogin',		// soapaction
	"rpc",
	"encoded");	

$server->register(
"insereEspecificacoesCvWeb",
array("versaoSirh" => "xsd:string"),
array("return" => "xsd:string"),
	'urn:wsdlDiagnosticoReceber',				// namespace
	'urn:wsdlDiagnosticoReceber#insereEspecificacoesCvWeb',		// soapaction
	"rpc",
	"encoded");


function limpaDiagnostico(){
	global $db;
	include_once "../site/dao/DiagnosticosDao.php";
	include_once "../site/model/Diagnostico.php";

	$iDao = new DiagnosticosDao($db);
	
	$iDao->excluiDiagnosticos();
}


function insereListaDiagnostico($log, $tipo){
	global $db;
	include_once "../site/model/Diagnostico.php";
	include_once "../site/dao/DiagnosticosDao.php";	
	
	$iDao = new DiagnosticosDao($db);
	$iModel = new Diagnostico();	
	
	$iModel->Id = ($iDao->ultimoId()+1);
	$iModel->Log = $log;
	$iModel->Tipo = $tipo;
	
	$iDao->criarDiagnostico($iModel);
	
}

function insereEspecificacoesCvWeb($versaoSirh){
	global $db;
	include_once "../site/dao/VersaoCVWebDao.php";
	include_once "../site/util/DataUtil.php";

	$iDao = new VersaoCVWebDao($db);
	$registros = $iDao->buscaRegistroVersaoCVWeb();
	$dataVersao = new DateTime($registros->fields["DataVersao"]);
	$dataScript = new DateTime($registros->fields["UltimoScript"]);
	
	
	insereListaDiagnostico(date("d/m/y H:m:s") . " - Acesso ao WebService de integração - êxito ", "1");
	if (!$registros->fields["VersaoSistema"] == " "){
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Versão do Curriculo Web: " . $registros->fields["VersaoSistema"] . " - Falhou" , "2");
	}
	else{
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Versão do Curriculo Web: " . $registros->fields["VersaoSistema"] . " - êxito", "1");
	}
	
	if (!$registros->fields["DataVersao"] == " "){
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Data da Versão do Curriculo Web: - Falhou " , "2");
	}
	else{
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Data da Versão do Curriculo Web: " . $dataVersao->format("d/m/y") . " - êxito", "1");
	}
	
	if ($registros->fields["VersaoSistema"] == $versaoSirh){
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Versão do Currículo Web Compatível com SIRH  - êxito ", "1");
	}
	else{
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Versão do Currículo Web Compatível com SIRH  - Falhou ", "2");
	}
	
	
	if (!$registros->fields["UltimoScript"] == " "){
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Data do último Script Atualizado: - Falhou", "2");
	}
	else{
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Data do último Script Atualizado: " . $dataScript->format("d/m/y H:m:s") . " - êxito", "1");
	}
	
	return "teste";
}


function enviaEmailCVWeb($empresa, $ticketLogin, $configurarEmailPor, $smtpEmail, $smtpServidor, $smtpPorta, $smtpRequerAutenticacao, $smtpConexaoSegura, $stmpUsuario, $smtpSenha, $padraoServEmailDe, $emailTeste, $versaoSirh){
	//mail("micael@metadados.com.br", "kkkk", "uhoihu");
	insereEspecificacoesCvWeb($versaoSirh);
    require_once("../site/lib/phpmailer/PHPMailerAutoload.php");
	require_once("../site/model/MetaMail.php");
	
	$simetricKey = pegarChave($empresa);
	if(!tentaExcluirTicket($ticketLogin)){
		return "Login inválido!";
	} 
	if($padraoServEmailDe==""){
		$padraoServEmailDe = $smtpEmail;
	}
	$email = new MetaMail($smtpConexaoSegura, $smtpPorta, $smtpServidor, '', '', $stmpUsuario, $smtpSenha, $smtpRequerAutenticacao, $padraoServEmailDe, $configurarEmailPor);
	$arrayEmail = array($emailTeste);	
	try {
		$email->sendMail($arrayEmail,"Teste de email","Teste de mensagem de email");
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Teste de e-mail realizado com sucesso - êxito", "1");
	} catch (Exception $e) {
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Teste de e-mail. Erro:" . $e->getMessage() . " - Falhou", "2");
	}		
	
	
}

function verificaChaveDeCriptografia($empresa, $chave){
	require_once('padraoServicos.php');
	
	$simetricKey = pegarChave($empresa);
	
	if (!$simetricKey == " "){
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Verificação da Existência do Arquivo da Chave de Criptografia  - Falhou ", "2");
	}
	else {
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Verificação da Existência do Arquivo da Chave de Criptografia  - êxito ", "1");
	}
	
	if (($chave == $simetricKey) && (!empty($chave)) && (!empty($simetricKey))){
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Chave de Criptografia - êxito", "1");
	}
	else{
		insereListaDiagnostico(date("d/m/y H:m:s") . " - Chave de Criptografia - Falhou", "2");
	}

}

function verificaConfiguracaoMySql(){
	global $db;
	include_once "../site/dao/DiagnosticosDao.php";
	include_once "../site/model/Diagnostico.php";
	
	$iDao = new DiagnosticosDao($db);
	$registros = $iDao->configuracaoMySqlEspecifica('character_set_server');
	
	if ($registros->fields["Value"] == "latin1"){
		insereListaDiagnostico(date("d/m/y H:m:s") . ' - MySQL Character Set (' . $registros->fields["Variable_name"] . ') - ' . $registros->fields["Value"] . " - êxito", "1");
	}
	else{
		insereListaDiagnostico(date("d/m/y H:m:s") . ' - MySQL Character Set (' . $registros->fields["Variable_name"] . ') - ' . $registros->fields["Value"] . " - Falhou", "2");
	}
}

function verificaLogin($ticketLogin){
	require_once('padraoServicos.php');
	require_once('lib/nusoap.php');	
	
	if(!tentaExcluirTicket($ticketLogin)){
		insereListaDiagnostico(date("d/m/y H:m:s") . ' - Dados de Autenticação para os Serviços  - Falhou', "2");
	}
	else{
		insereListaDiagnostico(date("d/m/y H:m:s") . ' - Dados de Autenticação para os Serviços  - êxito', "1");
	}
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);
$server->service(file_get_contents("php://input"));
?>
