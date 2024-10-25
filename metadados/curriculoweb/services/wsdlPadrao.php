<?php

require_once('padraoServicos.php');
require_once('lib/nusoap.php');

$server = new soap_server(); 							// Create the server instance
$server->configureWSDL('wsdlPadrao', 'urn:wsdlPadrao');	// Initialize WSDL support

// Registra o Método login
$server->register(
	"login",
array("empresa" => "xsd:string",
		 "operador" => "xsd:string",
		  "usuario" => "xsd:string",
			"senha" => "xsd:string"),
array("return" => "xsd:string"),
	'urn:wsdlPadrao',				// namespace
	'urn:wsdlPadrao#login',		// soapaction
	"rpc",
	"encoded");

// Registra o Método retornaVersaoCVWebDao
$server->register(
	"retornaVersaoCVWebDao",
array(),
array("return" => "xsd:string"),
	'urn:wsdlPadrao',				// namespace
	'urn:wsdlPadrao#retornaVersaoCVWebDao',		// soapaction
	"rpc",
	"encoded");

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);
$server->service(file_get_contents("php://input"));
?>