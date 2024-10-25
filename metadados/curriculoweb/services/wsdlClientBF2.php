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

// CHAVE SIMETRICA
$simetricKey = "a92a9a9991876002011e71fc2a255c17034d82b5db2cbed1e4597a95ce318f00";
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
$url = "http://localhost/curriculoweb/services/hellowsdl2.php";
$client = new nusoap_client($url);

//$client->soap_defencoding = 'ISO-8859-1';
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = true;

$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
// Call the SOAP method
//$person = array('firstname' => 'Willi', 'age' => 22, 'gender' => 'male');
//$client->call('hello', array('person' => $person));

$result = $client->call('hello',array('teste'));

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
		echo '<h2>Result</h2><pre>';
		$result = decrypt($result,$simetricKey);

		$doc = new DOMDocument("1.0", "UTF-8");
		$doc->loadXML($result);
		
		$listaIdiomas = $doc->getElementsByTagName('Idioma');
		
		foreach ($listaIdiomas as $elem) {
			echo "<ul>";
			echo "<li>Nome: " . utf8_decode($elem->getAttribute('nome')) . "</li>";
			echo "</ul>";
		}
		
	echo '</pre>';
	}
}
// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
