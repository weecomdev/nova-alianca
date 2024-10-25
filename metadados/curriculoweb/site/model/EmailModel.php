<?php

class EmailModel {

	var $to;
	var $from;
	var $subject;
	var $body;
	var $rodape = true;
	var $anexo;
	var $copiaOculta = true;
	
	function sendMail() {
		if ($this->to == "") {
			//echo "Não foi encontrado destinatário para a mensagem!";
			return false;
		}
		$headers = $this->verificaAnexo();
		if (!@mail($this->to, $this->subject, $this->body, $headers)) {
			return false;
		}

		return true;
	}
	
	function verificaAnexo() {
		
		$arquivo = $this->anexo;
		
		if(file_exists($arquivo["tmp_name"]) && !empty($arquivo)){
		
			$fp = fopen($_FILES["arquivo"]["tmp_name"],"rb");
			$anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"])); 
			$anexo = base64_encode($anexo);
	
			fclose($fp);
	
			$anexo = chunk_split($anexo); 
			
			$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 
			
			$mens = "--$boundary\n";
			$mens .= "Content-Transfer-Encoding: 8bits\n";
			$mens .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n\n"; //plain
			$mens .= "".$this->body."\n";
			$mens .= "--$boundary\n";
			$mens .= "Content-Type: ".$arquivo["type"]."\n"; 
			$mens .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"\n"; 
			$mens .= "Content-Transfer-Encoding: base64\n\n"; 
			$mens .= "$anexo\n"; 
			$mens .= "--$boundary--\r\n"; 
			
			$headers = "MIME-Version: 1.0\n"; 
			$headers .= "From: " . $this->from . "\r\n";
			if ($this->copiaOculta) 
				$headers .= "Bcc: sites@bf2tecnologia.com.br\r\n";
			$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n"; 
			$headers .= "$boundary\n";
			
			$this->body = $mens;
			
		} else {
			
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= "From: " . $this->from . "\n";
			if ($this->copiaOculta)
				$headers .= "Bcc: sites@bf2tecnologia.com.br\r\n";
			
		}
		
		return $headers;
		
	}
	
	function setFrom($from) {
		$this->from = $from;
	}
	function getFrom() {
		return $this->from;
	}
	function setTo($to) {
		$this->to = $to;
	}
	function getTo() {
		return $this->to;
	}
	function setSubject($subject) {
		$this->subject = $subject;
	}
	function getSubject() {
		return $this->subject;
	}
	function setBody($body) {		
		$html = "
		<html>
			<head>
			<style>
			body {
				font-family: Arial; font-size: 12px;
			}
			a {
				color: #0074C5;
			}
			p {
				line-height: 20px;			
			}
			</style>
			</head>
			<body>
			$body";
			
			if ($this->rodape) {
				$html .= "<hr style=\"border-top: 1px solid #808080;\"/>";
			}
			
		$html .= "</body>
		</html>";
		
		$this->body = $html;
	}
	function getBody() {
		return $this->body;
	}
	
	function setAnexo($anexo) {
		$this->anexo = $anexo;
	}
	function getAnexo() {
		return $this->anexo;
	}
	function setCopiaOculta($copiaOculta) {
		$this->copiaOculta = $copiaOculta;
	}
	function setRodape($rodape) {
		$this->rodape = $rodape;
	}
}
	
?>