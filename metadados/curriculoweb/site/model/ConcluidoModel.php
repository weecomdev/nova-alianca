<?php

class ConcluidoModel {
	var $db;
	function __construct($db){
		$this->db = $db;
	}
	function enviarConcluido() {


		global $configObj;
		if ($_SESSION["EmailUsuario"] != "") {

			if ($configObj->getValorDiretriz('indicadorEmailConcluido') == "S"){
				$metaMail = new MetaMail($_SESSION["ConexaoSegura"], $_SESSION["PortaSMTP"], $_SESSION["ServidorEmail"], '', '',
                    $_SESSION["UsuarioSMTP"], $_SESSION["SenhaSMTP"], $_SESSION["RequerAutenticacaoEmail"], $_SESSION["Email"], $_SESSION["ConfigurarEmailPor"]);
				$arrayEmail = array($_SESSION["EmailUsuario"]);
				$infoIncompletas = new InfoIncompletas($this->db);
				if($infoIncompletas->existeCampoVazio()){
					$mensagem = $configObj->getValorDiretriz('mensagemCurriculoIncompletoConcluido').
								"</br></br>".
								$infoIncompletas->getCamposVaziosHTML();
				}
				else{
					$mensagem = $configObj->getValorDiretriz('mensagemEmailConcluido');
				}
				if ($metaMail->sendMail($arrayEmail,"Currículo Web - Concluído",$mensagem)) {
					return "" . $configObj->getValorDiretriz('alertaEmailConcluido');
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return "" . $configObj->getValorDiretriz('alertaEmailConcluido');
		}
	}
}

?>