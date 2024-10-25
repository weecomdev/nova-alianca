<?php
// Report simple running errors
ini_set('error_reporting', E_ALL ^ E_NOTICE);
// Set the display_errors directive to Off
ini_set('display_errors', 0);
// Log errors to the web server's error log
ini_set('log_errors', 1);


require_once('lib/nusoap.php');
//require_once('imports.php');

$server = new soap_server(); 							// Create the server instance
$server->configureWSDL('hellowsdl2', 'urn:hellowsdl2');	// Initialize WSDL support

$server->register(
	'hello',								// method name:
	array('name'=>'xsd:string'),			// parameter list:
	array('return'=>'xsd:string'),			// retorno = string contendo XML
	'urn:hellowsdl2',						// namespace
	'urn:hellowsdl2#hello',					// soapaction
	'rpc',									// style: rpc or document
	'encoded',								// use: encoded or literal
	'Simple Hello World Method');			// description: documentation for the method

function hello($msg) {
	global $server;
	$dom = new DomDocument("1.0", "ISO-8859-1");
	
	// Criamos o Elemento automoveis
	$inicio = $dom->createElement('Inicio');
	$listaIdiomas = $dom->createElement('Idiomas');
	$listaAreasAtuacao = $dom->createElement('AreasAtuacao');
		
	// Criamos o Elemento Idioma
	$elementoIdioma = $dom->createElement('Idioma');
	// Definimos os atributos do Elemento Idioma
	$elementoIdioma->setAttribute('codigo', '1');
	$elementoIdioma->setAttribute('nome', 'Portugues');
	
	// Adiciona os Elementos carro ao no <automoveis>
	$listaIdiomas->appendChild( $elementoIdioma );
		
	$inicio->appendChild( $listaIdiomas );

	$dom->appendChild( $inicio );
	
	// Adiciona espaço e quebras de linha deixando o XML mais legÃ­vel
	$dom->formatOutput = true;
	
	// Saving all the document
	$msg = $dom->saveXML();
	
	// Criptografia
	require_once("lib/class.simetric.php");
	$simetric = new key_simetric();
	
	// CHAVE SIMETRICA
	$simetricKey = "a92a9a9991876002011e71fc2a255c17034d82b5db2cbed1e4597a95ce318f00";
	//$simetricKey = "bf2";
	
	$simetric->set_key($simetricKey);
	$simetric->set_text($msg);
	$simetric->encrypt();
	$crypt = $simetric->get_hex_crypt();
	
	return $crypt;
/*
    $msg='<Inicio><AreasAtuacao><AreaAtuacao codigo="1" nome="'.$nome.'" /><AreaAtuacao codigo="2" nome="'.$nome.'" /></AreasAtuacao><Idiomas><Idioma codigo="1" nome="Portugues" />
<Idioma codigo="2" nome="Ingles" /></Idiomas></Inicio>';
 */  
    //return $msg;
}
	
	
// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$server->service($HTTP_RAW_POST_DATA);
$server->service(file_get_contents("php://input"));
?>
