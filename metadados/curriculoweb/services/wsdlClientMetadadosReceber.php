<?php
// Report simple running errors
ini_set('error_reporting', E_ALL ^ E_NOTICE);
// Set the display_errors directive to Off
ini_set('display_errors', 0);
// Log errors to the web server's error log
ini_set('log_errors', 1);


// Pull in the NuSOAP code
require_once('lib/nusoap.php');
//require_once('imports.php');
function pegarChave($empresa){
	$arquivo = file("ck.ddd");
	$c = "";
	for($i = 0; $i < count($arquivo); $i++) {
		if ( (substr($arquivo[$i], 0,4)) == $empresa ){
			$c = substr($arquivo[$i],4,strlen($arquivo[$i])-4); 
		}
	} 
	
	return $c;
}
// CHAVE SIMETRICA
//$simetricKey = pegarChave("0001");
//$simetricKey = "bf2";

// Funcao para decriptografia
function decrypt($msg,$simetricKey){
	require_once("lib/class.simetric.php");
	$simetric = new key_simetric();
	$simetric->set_key($simetricKey);
	$msg = base64_decode($msg);
	$simetric->set_crypt($msg);
	$simetric->decrypt();
	$text = $simetric->get_decrypt();
	return trim($text);
}

// Create the client instance
$url = "http://localhost/curriculoweb/services/wsdlServerBF2Enviar.php";
$client = new nusoap_client($url);

//$client->soap_defencoding = 'ISO-8859-1';
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = true;

$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

require_once("lib/class.simetric.php");
$simetric = new key_simetric();
// 9021 MASTER 295904
$simetric->set_key($simetricKey);
$simetric->set_text(utf8_encode("0001"));
$simetric->encrypt();
$empresa = $simetric->get_hex_crypt();

$simetric->set_key($simetricKey);
$simetric->set_text(utf8_encode("9021"));
$simetric->encrypt();
$usuario = $simetric->get_hex_crypt();

$simetric->set_text(utf8_encode("MASTER"));
$simetric->encrypt();
$operador = $simetric->get_hex_crypt();

$simetric->set_text(utf8_encode("248038"));
$simetric->encrypt();
$senha = $simetric->get_hex_crypt();

// Call the SOAP method
$result = $client->call('login',array("0001","9021","MASTER","248038"));
$checarLogin = false;
// Check for a fault
if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		//echo '<h2>Result</h2><pre>';
		$result = decrypt($result,$simetricKey);
		if (substr($result, 0,3) != '401'){
			$checarLogin = true;
		} else {
			echo '<h2>Erro</h2><pre>';
			print_r($result);
			echo '</pre>';
		}
		
		//echo '</pre>';
	}
}
if ($checarLogin) {
	$simetric = new key_simetric();
	$simetric->set_key($simetricKey);
	$simetric->set_text("ola");
	$simetric->encrypt();
	$crypt = $simetric->get_hex_crypt();
	
	$result = $client->call('enviar',array($crypt));

	// Check for a fault
	if ($client->fault) {
		echo '<h2>Fault</h2><pre>';
		print_r($result);
		echo '</pre>';
	} else {
		// Check for errors
		$err = $client->getError();
		if ($err) {
			echo '<h2>Erro</h2><pre>' . $err . '</pre>';
		} else {
			echo '<h2>Resultado!</h2><pre>';
			
			$result1 = decrypt($result,$simetricKey);
			
			echo $result1;
	/*
			$doc = new DOMDocument("1.0", "UTF-8");
			$doc->loadXML($result);
			
			$listaIdiomas = $doc->getElementsByTagName('Idioma');
			
			foreach ($listaIdiomas as $elem) {
				echo "<ul>";
				echo "<li>Nome: " . utf8_decode($elem->getAttribute('nome')) . "</li>";
				echo "</ul>";
			}
		*/	
			echo '</pre>';
		}
	}


}



// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
