<?php
class LoginModel {

	public $db;
	public $configuration;

	public $usuario;
	public $senha;
	public $sistema;
	private $empresa;

	const SENHA_INVALIDA = 1;
	const USUARIO_INEXISTENTE = 2;
	const PERMISSAO_NEGADA = 3;
	const USUARIO_BLOQUEADO = 4;
	const USUARIO_VAZIO = 5;
	const SENHA_VAZIO = 6;
    const ERRO_EXCLUIR = 7;

	function __construct($db) {
		$this->db = $db;
		$candidatosWebConfDao = new CandidatosWebConfDao($db);
		$this->empresa = $candidatosWebConfDao->buscaEmpresaPrincipal();
	}

    /*function validaTamanhoCampos(){
		if (!is_numeric($this->usuario))
		    return false;
        else if (strlen($this->senha) > 120)
		    return false;
        else if (strlen($this->empresa) > 4)
		    return false;
        else
            return true;
	}*/

    function MandaEmailExclusao($cpf,$empresa,$email) {

    $configObj = new Config($this->db, $empresa);	   
    $valorDiretrizExclusao = $configObj->getValorDiretriz('mensagemExclusaoEmail');
       
    $cwcDao = new CandidatosWebConfDao($this->db);
	$candidatoWebConf = $cwcDao->buscarCandidatosWebConfPorParametrosEmpresa($empresa);
    $metaMail = new MetaMail($candidatoWebConf->fields['ConexaoSegura'], $candidatoWebConf->fields['PortaSMTP'],$candidatoWebConf->fields['ServidorEmail'], '', '',
                             $candidatoWebConf->fields['UsuarioSMTP'],$candidatoWebConf->fields['SenhaSMTP'],$candidatoWebConf->fields['RequerAutenticacaoEmail'], $candidatoWebConf->fields['Email'],$candidatoWebConf->fields['ConfigurarEmailPor']);
	$arrayEmail = array($email);
	$mensagem = $valorDiretrizExclusao;
	$metaMail->sendMail($arrayEmail,"Currículo Web - Solicitação de Exclusão de Currículo",$mensagem);

	}

	function esqueceuSenha($cpf) {
		$uDao = new UsuarioDao($this->db);
		$usuarioLogado = new Usuario;
		$listaUsuario = $uDao->buscarUsuarioPorCpf($cpf);

		if ($listaUsuario->RecordCount() == 1) {
			$listaUsuario->MoveFirst();

			$novaSenha = substr(($cpf*2),0,8);

			// ENVIAR A SENHA POR EMAIL
			$metaMail = new MetaMail($_SESSION["ConexaoSegura"], $_SESSION["PortaSMTP"], $_SESSION["ServidorEmail"], '', '',
                $_SESSION["UsuarioSMTP"], $_SESSION["SenhaSMTP"], $_SESSION["RequerAutenticacaoEmail"], $_SESSION["Email"], $_SESSION["ConfigurarEmailPor"]);
			$arrayEmail = array($listaUsuario->fields['Email']);

			$mensagem = '<p>Olá Sua nova senha para acesso ao Currículo Web é '.$novaSenha.'</p><p>Obrigado.</p>';

			if ($metaMail->sendMail($arrayEmail,"Currículo Web - Esqueceu sua senha",$mensagem)) {
				$usuario = new Usuario();
				$usuario->Usuario = $listaUsuario->fields['Usuario'];
				$usuario->Senha = md5($novaSenha);
                if ($usuario->validaTamanhoCampos())
                {
				    $uDao->alterarSenha($usuario);
				    return "Sua senha foi enviada por e-mail!";
                }
                //else
                //    echo "Valores inválidos.";
			} else {
				throw new Exception("Não foi possível enviar sua senha! Contate o administrador do site.");
			}

		}
	}

    function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }


    function solicitarExclusao($cpf) {

        global $configObj;

		$uDao = new UsuarioDao($this->db);
        $pessoaDao = new PessoaDao($this->db);
		$listaUsuario = $uDao->buscarUsuarioPorCpf($cpf);

		if ($listaUsuario->RecordCount() == 1) {
			$listaUsuario->MoveFirst();

          //  $arquivo = fopen('meuarquivo.txt','w');
          //  if ($arquivo == false) die('Não foi possível criar o arquivo.');
          //  $texto = $listaUsuario->fields['Nascimento'];
           // fwrite($arquivo, $listaUsuario);
           // fclose($arquivo);

         if ((trim($listaUsuario->fields['Pessoa']) == "") or
			(trim($listaUsuario->fields['Nome']) == "") or 
			(trim($listaUsuario->fields['CPF']) == "") or
            (trim($listaUsuario->fields['Nascimento']) == "") or
            (trim($listaUsuario->fields['Sexo']) == "") or
            (trim($listaUsuario->fields['Email']) == "")) 
            {                   
                try
                {
                    $Excluiu = $pessoaDao->DeletarCurriculo($listaUsuario->fields['CPF'],$listaUsuario->fields['Empresa'],$listaUsuario->fields['Pessoa']);
                    if ($Excluiu == 1)
                    {
                        session_destroy();
		                unset($_SESSION);
                        return "1";
                    }
                    else
                    {
                     return "0";
         
                    }	            
                }
                catch(Exception $e)
                {
                   return "0";
 
                }                          
            }
            else
            {  
                try
                {
                    $pessoaDao->atualizaExcluir($cpf);
                    $metaMail = new MetaMail($_SESSION["ConexaoSegura"], $_SESSION["PortaSMTP"], $_SESSION["ServidorEmail"], '', '',
                                              $_SESSION["UsuarioSMTP"], $_SESSION["SenhaSMTP"], $_SESSION["RequerAutenticacaoEmail"], $_SESSION["Email"], $_SESSION["ConfigurarEmailPor"]);

			        $arrayEmail = array($_SESSION["Email"]);
			        $mensagem = '<p> O candidato abaixo solicitou a exclusão do seu currículo:</p><p><b>CPF:</b> '.$this->mask($listaUsuario->fields['CPF'],'###.###.###-##').'</p><p><b>Nome:</b> '.$listaUsuario->fields['Nome'].'</p><p><b>Nome da Mãe:</b> '.$listaUsuario->fields['Mae'].'</p><p><b>Data de Nascimento:</b> '.date('d/m/Y',strtotime($listaUsuario->fields['Nascimento'])).'</p><p><b>E-mail:</b> '.$listaUsuario->fields['Email'].'</p><p><b>Telefone:</b> '.$listaUsuario->fields['DDDCelular'].''.$listaUsuario->fields['TelefoneCelular'].'</p>';  
			        $metaMail->sendMail($arrayEmail,"Solicitação de Exclusão de Currículo",$mensagem);
                    return "2";
                }
                catch(Exception $e)
                {
                return "0";
                }
			}			
		}
	}

	function alterarSenha($cpf,$senhaAtual,$senhaNova,$senhaConfirma) {

		if ($senhaAtual == "")
			throw new Exception("Informe a senha atual!");
		if ($senhaNova == "")
			throw new Exception("Informe a nova senha!");
		if ($senhaConfirma == "")
			throw new Exception("Confirme a nova senha!");

		$uDao = new UsuarioDao($this->db);
		$usuarioLogado = new Usuario;
		$listaUsuario = $uDao->buscarUsuarioPorCpf($cpf);

		if ($listaUsuario->RecordCount() == 1) {
			$listaUsuario->MoveFirst();

			if(strcmp(md5($senhaAtual), trim($listaUsuario->fields['Senha'])) == 0) {

				if ($senhaNova == $senhaConfirma) {

					$usuario = new Usuario();
					$usuario->Usuario = $listaUsuario->fields['Usuario'];
					$usuario->Senha = md5($senhaConfirma);

                    if ($usuario->validaTamanhoCampos())
                    {
					    $uDao->alterarSenha($usuario);
					    return "Senha alterada com sucesso!";
                    }
                    //else
                     //   echo "Valores inválidos.";
				} else {
					throw new Exception("As senhas digitadas não conferem!");
				}
			} else {
				throw new Exception("A senha atual está incorreta!");
			}
		}
	}

	function login () {
		if(!$this->getUsuario()){
			echo json_encode(array('message' => utf8_encode('Você deve digitar seu login!'), 'code' => 5));
			exit;
		} else if(!$this->getSenha()){
			echo json_encode(array('message' => utf8_encode('Você deve digitar sua senha!'), 'code' => 6));
			exit;
		}

		$uDao = new UsuarioDao($this->db);
		$usuarioLogado = new Usuario;
		$listaUsuario = $uDao->buscarUsuarioPorCpf($this->getUsuario());




		// Caso o usuï¿½rio tenha digitado um login vï¿½lido o nï¿½mero de linhas serï¿½ 1..
		if ($listaUsuario->RecordCount() == 1) {
			$listaUsuario->MoveFirst();
			$isSenhaInvalida = false;
			// Agora verifica a senha

			if(strcmp(md5($this->getSenha()), trim($listaUsuario->fields['Senha'])) == 0) {
				$_SESSION["PessoaLogada"] = $listaUsuario->fields['Pessoa'];
				$_SESSION["NomePessoaLogada"] = $listaUsuario->fields['Nome'];
				$_SESSION["CPF"] = $listaUsuario->fields['CPF'];
                $_SESSION["Excluir"] = $listaUsuario->fields['Excluir'];
				$_SESSION["UltAlteracao"] = $listaUsuario->fields['UltAlteracao'];
				$_SESSION["EmailUsuario"] = $listaUsuario->fields['Email'];
				$_SESSION["Empresa"] = $this->empresa;
				$_SESSION["isUsuarioLogado"] = "TRUE";

				echo json_encode(array('login' => true));
			} else {
				$isSenhaInvalida = true;
			}

			if ($isSenhaInvalida){
				echo json_encode(array('login' => false, 'code' => self::SENHA_INVALIDA, 'message' => utf8_encode('CPF ou senha inválida!')));
				exit;
			}

		} else {
			echo json_encode(array('login' => false, 'code' => self::USUARIO_INEXISTENTE, 'message' => utf8_encode('CPF ou senha inválida!')));
			exit;
		}
	}

	static function getPessoaLogada(){
		return $_SESSION["PessoaLogada"];
	}

	static function getEmpresaLogada(){
		return $_SESSION["Empresa"];
	}

	function logout () {
		session_destroy();
		unset($_SESSION);
		echo json_encode(array('logout' => true));
		exit;
	}

	function getUsuario() {
		return $this->usuario;
	}

	function setUsuario($usuario) {
		$this->usuario = $usuario;
	}

	function getSenha() {
		return $this->senha;
	}

	function setSenha($senha) {
		$this->senha = $senha;
	}

	function getSistema() {
		return $this->sistema;
	}

	function setSistema($sistema) {
		$this->sistema = $sistema;
	}
}
?>