<?php

class MetaMail {
	private $conexaoSegura;
	private $porta;
	private $host;
	private $hostName;
	private $helo;
	private $usuario;
	private $senha;
	private $de;
	private $configurarEmailPor;
    private $requerAutenticacao;
	function __construct($conexaoSegura, $porta, $host, $hostName, $helo, $usuario, $senha, $requerAutenticacao, $de, $configurarEmailPor){
		$this->conexaoSegura = $conexaoSegura;
		$this->porta = $porta;
		$this->host = $host;
		$this->hostName = $hostName;
		$this->helo = $helo;
		$this->usuario = $usuario;
		$this->senha = $senha;
        $this->requerAutenticacao = $requerAutenticacao;
		$this->de = $de;
		$this->configurarEmailPor = $configurarEmailPor;
	}
    
	function configuraSMTP() {		
		$simetric = new key_simetric();
        $simetric->set_key(hash('sha256',"#CHAVECRIPT#",true));
        $msg = base64_decode($this->senha);
        $simetric->set_crypt($msg);
        $simetric->decrypt();
        $senhaSMTP = $simetric->get_decrypt();
        $senhaSMTP = substr($senhaSMTP, strpos($senhaSMTP,'<S>') + 3);
        $senhaSMTP = substr($senhaSMTP, 0, strpos($senhaSMTP,'</S>'));

			
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		
		if ($this->requerAutenticacao == "1")
            $mail->SMTPAuth = true;
        else
            $mail->SMTPAuth = false;
			
		if ($this->conexaoSegura == "2")
			$mail->SMTPSecure = 'tls';
        if ($this->conexaoSegura == "3")
			$mail->SMTPSecure = 'ssl';
			
		$mail->Port = $this->porta;
		$mail->Host = $this->host;
		        
        $mail->Username = $this->usuario;
        $mail->Password = $senhaSMTP;
		

		
		$mail->setFrom($this->de, 'Currículo Web');
		
		$mail->isHTML(true);	
		
		return $mail;
	}
	
	function sendMail($to, $subject, $mensagem, $copia = false) {        
									
		$html = '
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
		    <body>';
		    	
		    $html .= $mensagem;
		    $html .= '</body></html>';
								
		if($this->configurarEmailPor == '1'){		
		    try {
                $mail = $this->configuraSMTP();
			
			    $body = $html; 
			    $body = preg_replace('/\\\\/','', $body);
			
			    for ($i = 0; $i < sizeof($to); $i++) {					
				    $mail->addAddress($to[$i]);
			    }				
				
			    $mail->Subject = $subject;
			
			    $mail->Body = $body;

			    $mail->Send();
				
			    return true;
				
		    } catch (phpmailerException $e) {		
			    throw new Exception($e->errorMessage());
		    }
		}
		
		if($this->configurarEmailPor == '2'){			
			try {						
				
				$headers = 'From: '.$this->de. "\r\n" .
                'Reply-To: '.$this->de. "\r\n" .
                'X-Mailer: PHP/' . phpversion(). "\r\n" .
				'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				if(@mail($to[0], $subject, $html, $headers)){                
					return true;
				}
				else
				{
					return false;
				}
                
			} catch (phpmailerException $e) {				
				throw  new Exception($e->errorMessage());
			}            
		}
	}	
}

?>