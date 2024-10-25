<?php
// WebServices - iMasters.com.br
// Autor: Mauricio Reckziegel
// http://www.mauricioreckziegel.com
// Arquivo : class.simetric.php

// Report simple running errors
ini_set('error_reporting', E_ALL ^ E_NOTICE);
// Set the display_errors directive to Off
ini_set('display_errors', 0);
// Log errors to the web server's error log
ini_set('log_errors', 1);

class key_simetric{
 
	var $text; // Texto a ser criptografado
	var $key;  // Chave simétrica
	var $td = MCRYPT_RIJNDAEL_128;   // Encryption 
	var $_crypt; // Texto Criptografado
	var $hex_crypt; // Texto Criptografado Hexadecimal
	var $iv_size; 
	var $iv;
	var $_decrypt; // Texto Decriptografado
	 
	function __construct(){
		$this->iv_size = mcrypt_get_iv_size($this->td, MCRYPT_MODE_ECB); 
		//$this->iv = mcrypt_create_iv($this->iv_size, MCRYPT_RAND); 
		$this->iv = $this->hex2bin('FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF');
	} //end_construct
	
	function hex2bin($h)
	{
	  if (!is_string($h)) return null;
	  $r='';
	  for ($a=0; $a<strlen($h); $a+=2) {
	      $r.=chr(hexdec($h{$a}.$h{($a+1)}));
	  }
	  return $r;
	}
	
 	function set_text($text){
		$this->text = $text; 
	}//end
	function set_key($key){
		$this->key = $key;
	}//end
 	function encrypt(){
		$this->_crypt = mcrypt_encrypt($this->td, $this->key, $this->text, MCRYPT_MODE_CBC, $this->iv);
		$this->hex_crypt = base64_encode($this->_crypt);
	}//end
	function decrypt(){
		$this->_decrypt = mcrypt_decrypt($this->td, $this->key, $this->_crypt, MCRYPT_MODE_CBC, $this->iv); 
	}//end
	function get_text(){
		return $this->text;
	}//end
	// Pega 
	function get_crypt(){
		return $this->hex_crypt;
	}//end
	function get_decrypt(){
		return $this->_decrypt;
	}//end
	function get_hex_crypt(){
		return $this->hex_crypt;
	}//end
	function set_crypt($crypt){
		$this->_crypt = $crypt;
	}
} //end_class

?>
