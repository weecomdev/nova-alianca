<?php

class LoginController {

	private $db;
	private $entidade;
	private $acao;
	
	public function __construct($db, $entidade, $acao = null) {
		$this->db = $db;
		$this->entidade = $entidade;
		$this->acao = $acao;
		
		$this->webpage();
	}
	
	private function webpage() {
		switch ($this->acao) {
			case "login":
				$this->login();
				break;
			case "logout":
				$this->logout();
				break;		
			case "alterarSenha":
				$this->alterarSenha();
				break;
			case "salvarSenha":
				$this->salvarSenha();
				break;
			case "esqueceuSenha":
				$this->esqueceuSenha();
				break;
			default:
				$this->home();
		}
	}
	
	/**
	 * Carrega a página com os campos para alterar a senha
	 *
	 */
	private function alterarSenha() {
		include 'pages/senha.php';
	}
	
	private function esqueceuSenha() {
		$cpf = $_POST['cpf'];		
		$cpf = str_replace(".","",$cpf);
		$cpf = str_replace("-","",$cpf);

		try {
			$login = new LoginModel($this->db);
			$msg = $login->esqueceuSenha($cpf);
			
			echo utf8_encode($msg);
		} catch (Exception $e) {
			echo utf8_encode($e->getMessage());
		}
			
		exit;
		
	}
	
	private function salvarSenha() {
		
		$cpf = $_POST['cpf'];		
		$cpf = str_replace(".","",$cpf);
		$cpf = str_replace("-","",$cpf);
		
		$senhaAtual = $_POST['senhaAtual'];
		$senhaNova = $_POST['senhaNova'];
		$senhaConfirma = $_POST['senhaConfirma'];
		try {
			$login = new LoginModel($this->db);              
			$msg = $login->alterarSenha($cpf,$senhaAtual,$senhaNova,$senhaConfirma);
			echo json_encode(array("login" => true, "code" => 1, "mensagem" => utf8_encode($msg)));
		} catch (Exception $e) {
			echo json_encode(array("login" => true, "code" => 0, "mensagem" => utf8_encode($e->getMessage())));
		}
			
		exit;
		
	}
	
	private function home() {
		
		include 'pages/login.php';
	}
	
	private function logout() {
		$login = new LoginModel($this->db);
		$login->logout();
	}
	
	private function login() {
		
		$cpf = isset($_POST["cpf"]) ? addslashes(trim($_POST["cpf"])) : FALSE;
		$senha = isset($_POST["senha"]) ? addslashes(trim($_POST["senha"])) : FALSE;
		
		$cpf = str_replace(".","",$cpf);
		$cpf = str_replace("-","",$cpf);

		// usuário não forneceu a senha ou o login		
		$login = new LoginModel($this->db);
		$login->setUsuario($cpf);
		$login->setSenha($senha);
		
		$login->login();
		
		exit;		
	}
	
	public function isUsuarioLogado() {
		return $_SESSION["PessoaLogada"];
	}

    public function usuarioCpf() {
		return $_SESSION["CPF"];
	}
}
?>