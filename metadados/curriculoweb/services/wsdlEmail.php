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
require_once("lib/class.simetric.php");
$server = new soap_server(); 							// Create the server instance
$server->configureWSDL('wsdlEmail', 'urn:wsdlEmail');	// Initialize WSDL support


// Registra o MÃ©todo retornaVersaoCVWebDao
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
	  "emailTeste" => "xsd:string"),
array("return" => "xsd:string"),
	'urn:wsdlEmail',				// namespace
	'urn:wsdlEmail#enviaEmailCVWeb',		// soapaction
	"rpc",
	"encoded");


function enviaEmailCVWeb($empresa, $ticketLogin, $configurarEmailPor, $smtpEmail, $smtpServidor, $smtpPorta, $smtpRequerAutenticacao, $smtpConexaoSegura, $stmpUsuario, $smtpSenha, $padraoServEmailDe, $emailTeste){
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
	} catch (Exception $e) {
		return $e->getMessage();
	}	
	return "Email enviado com sucesso";	
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);
$server->service(file_get_contents("php://input"));

?>