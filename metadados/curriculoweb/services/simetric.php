<?
// WebServices - iMasters.com.br
// Autor: Mauricio Reckziegel
// http://www.mauricioreckziegel.com
// Arquivo : simetric.php
// Report simple running errors
ini_set('error_reporting', E_ALL ^ E_NOTICE);
 
// Set the display_errors directive to Off
ini_set('display_errors', 0);
 
// Log errors to the web server's error log
ini_set('log_errors', 1);
include "lib/class.simetric.php";

$c = new key_simetric; // Instancia a Classe
$c->set_text("teste"); // Seta o texto a ser criptografado
$c->set_key("Secret"); // Seta a key
$c->encrypt(); // Criptografa o texto
$crypt = $c->get_hex_crypt(); // Pega a criptografia hexadecimal
$c->decrypt(); // Decriptografa o texto

$text = $c->get_text();
echo "<br>Texto normal: ".$text;
$cript = $c->get_crypt();
echo "<br>Texto criptografado: ".$cript;
$result = $c->get_decrypt();
echo "<br>Texto decriptografado: ".trim($result);
?>