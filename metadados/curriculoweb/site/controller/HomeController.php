<?php
/**
 * Classe respons�vel por tratar as requisi��es de entrada no sistema.
 *
 *  - Formul�rio de cadastro de um novo usu?rio.
 *  - Formul�rio para login no sistema.
 */
class HomeController {

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
			case "cadastrar":
				$this->cadastrar();
				break;
			case "salvar":
				$this->salvar();
				break;
			case "inicial":
				$this->inicial();
				break;
			case "buscarPessoaTermoConsentimento":
                $this->buscarPessoaTermoConsentimento();
				break;
            case "buscarTermoHtml":
                $this->buscarTermoHtml();
				break;
            case "setTermoConsentimento":
                $this->setTermoConsentimento();
				break;
            case "buscarPoliticaSenha":
                $this->buscarPoliticaSenha();
				break;
			default:
				$this->entrada();
		}		
	}	

	/**
	 * Carrega a p�gina com o formul�rio para entrada dos dados.
	 */
	private function cadastrar() {
		include 'pages/cadastrar.php';		
	}
	
	/**
	 * Carrega a p�gina que ser� poss�vel escolher entre cadastro e login.
	 */
	private function entrada() {
	
		$cwcDao = new CandidatosWebConfDao($this->db);
		$candidatoWebConf = $cwcDao->buscarCandidatosWebConfPorParametros();
		$_SESSION["NroMaximoInteresses"] = $candidatoWebConf->fields['NroMaximoInteresses'];
		$_SESSION["NroMaximoPlvChave"] = $candidatoWebConf->fields['NroMaximoPlvChave'];
		$_SESSION["ExibirPretensaoSal"] = $candidatoWebConf->fields['ExibirPretensaoSal'];		
		$_SESSION["ExibirDeficiente"] = $candidatoWebConf->fields['ExibirDeficiente'];
		$_SESSION["ExibirEmpAnteriores"] = $candidatoWebConf->fields['ExibirEmpAnteriores'];
		$_SESSION["ExibirDadosCompl"] = $candidatoWebConf->fields['ExibirDadosCompl'];
		$_SESSION["ExibirCursos"] = $candidatoWebConf->fields['ExibirCursos'];
		$_SESSION["ExibirIdiomas"] = $candidatoWebConf->fields['ExibirIdiomas'];
		$_SESSION["ExibirPalavrasChave"] = $candidatoWebConf->fields['ExibirPalavrasChave'];
		$_SESSION["ExibirRequisitos"] = $candidatoWebConf->fields['ExibirRequisitos'];
		$_SESSION["ExibirInteresse"] = $candidatoWebConf->fields['ExibirInteresse'];
		$_SESSION["CargoSel"] = $candidatoWebConf->fields['CargoSel'];
		$_SESSION["FuncaoSel"] = $candidatoWebConf->fields['FuncaoSel'];
		$_SESSION["AreaAtuacaoSel"] = $candidatoWebConf->fields['AreaAtuacaoSel'];
		$_SESSION["PalavraChaveSel"] = $candidatoWebConf->fields['PalavraChaveSel'];
		$_SESSION["RequisitoSel"] = $candidatoWebConf->fields['RequisitoSel'];
		
		$_SESSION["ChaveCriptografia"] = $candidatoWebConf->fields['ChaveCriptografia'];
		$_SESSION["DataUltimaImportacao"] = $candidatoWebConf->fields['DataUltimaImportacao'];
		$_SESSION["UsaProxy"] = $candidatoWebConf->fields['UsaProxy'];
		$_SESSION["Servidor"] = $candidatoWebConf->fields['Servidor'];
		$_SESSION["Porta"] = $candidatoWebConf->fields['Porta'];
		$_SESSION["RequerAutenticacao"] = $candidatoWebConf->fields['RequerAutenticacao'];
		$_SESSION["UsuarioProxy"] = $candidatoWebConf->fields['UsuarioProxy'];
		$_SESSION["SenhaProxy"] = $candidatoWebConf->fields['SenhaProxy'];
		$_SESSION["Email"] = $candidatoWebConf->fields['Email'];
		$_SESSION["ServidorEmail"] = $candidatoWebConf->fields['ServidorEmail'];
		$_SESSION["PortaSMTP"] = $candidatoWebConf->fields['PortaSMTP'];
		$_SESSION["UsuarioSMTP"] = $candidatoWebConf->fields['UsuarioSMTP'];
		$_SESSION["RequerAutenticacaoEmail"] = $candidatoWebConf->fields['RequerAutenticacaoEmail'];
		$_SESSION["ConexaoSegura"] = $candidatoWebConf->fields['ConexaoSegura'];
		$_SESSION["SenhaSMTP"] = $candidatoWebConf->fields['SenhaSMTP'];
		$_SESSION["OrdemPlvChave"] = $candidatoWebConf->fields['OrdemPlvChave'];
        $_SESSION["OrdemInteresses"] = $candidatoWebConf->fields['OrdemInteresses'];
        $_SESSION["ConfigurarEmailPor"] = $candidatoWebConf->fields['ConfigurarEmailPor'];
        $_SESSION["EmailDe"] = $candidatoWebConf->fields['EmailDe'];

		
		include 'pages/entrada.php';		
	}
	
	/**
	 * M�todo que ser� chamado para direcionar para a HOME do sistema.
	 * Faz a valida��o se o usu�rio est� devidamente logado.
	 */
	private function inicial() {

            if (LoginController::isUsuarioLogado()){		
                
                $webConfDao = new CandidatosWebConfDao($this->db);
                $configObj = new Config($this->db, $webConfDao->buscaEmpresaPrincipal());
                $diretrizTipoDeFiltro = $configObj->getValorDiretriz('filtrarVagasPorAreaOuRegiao');
                
                if($diretrizTipoDeFiltro == 1){
                    $aaDao = new AreaAtuacaoDao($this->db);
                    $listaAreaAtuacao = $aaDao->buscarAreaAtuacaoVinculadaPorParametros($_REQUEST['modulo']);                       
                }
                else
                    if($diretrizTipoDeFiltro == 2){
                        $rDao = new RegiaoDao($this->db);                
                        $listaRegiao = $rDao->buscarRegiaoVinculadaPorParametros($_REQUEST['modulo']);	                
                    }

                $uDao = new UsuarioDao($this->db);
                $pessoaexclusao = $uDao->buscarUsuarioPorCpf(LoginController::usuarioCpf());						
                $infoIncompletas = new InfoIncompletas($this->db); 
                include 'pages/home.php';
            } 
            else 
            {
                include 'pages/login.php';
            }
	}
	
	/**
	 * Este m�todo recebe as informa��o b�sica para criar uma pessoa e um usu�rio.
	 * Deve-se chamar esse metodo atrav�s de requisi��o ajax, pois 
	 * 	os erros e a responsta esta no formato JSON.
	 *
	 */
	private function salvar() {
		
		// valida os campos do form
		$this->validadeForm();
		
		// preenche a classe Pessoa com os dados do form
		$pessoa = $this->populatePessoa();
		
		$pessoaDao = new PessoaDao($this->db);
		
		$pessoa = $this->populatePessoa();
		if ($pessoa->validaTamanhoCampos()){
		    // cria a pessoa	


		    $pessoaDao->criarPessoa($pessoa);
			
		    // busca a pessoa pelo CPF para pegar o codigo da pessoa 
		    $pessoa = $pessoaDao->buscarPessoaPorCPF($pessoa->CPF);
	         
		    $senha = $_POST['Senha'];
		    // preenche a classe Usuario
		    $usuario = new Usuario();
		    $usuario->Cpf = $pessoa->CPF;
						
		    $usuario->Senha = md5($senha);
		    $usuario->Pessoa = $pessoa->Pessoa;
										
            
		    // cria um usuario para a pessoa cadastrada
		    $usuarioDao = new UsuarioDao($this->db);
		    if ($usuario->validaTamanhoCampos()){				
		        $usuarioDao->criarUsuario($usuario);
				
		        $cwcDao = new CandidatosWebConfDao($this->db);
		        $candidatoWebConf = $cwcDao->buscarCandidatosWebConfPorParametros();
		        $_SESSION["NroMaximoInteresses"] = $candidatoWebConf->fields['NroMaximoInteresses'];
		        $_SESSION["NroMaximoPlvChave"] = $candidatoWebConf->fields['NroMaximoPlvChave'];
		        $_SESSION["ExibirPretensaoSal"] = $candidatoWebConf->fields['ExibirPretensaoSal'];
		        $_SESSION["ExibirDeficiente"] = $candidatoWebConf->fields['ExibirDeficiente'];
		        $_SESSION["ExibirEmpAnteriores"] = $candidatoWebConf->fields['ExibirEmpAnteriores'];
		        $_SESSION["ExibirDadosCompl"] = $candidatoWebConf->fields['ExibirDadosCompl'];
		        $_SESSION["ExibirCursos"] = $candidatoWebConf->fields['ExibirCursos'];
		        $_SESSION["ExibirIdiomas"] = $candidatoWebConf->fields['ExibirIdiomas'];
		        $_SESSION["ExibirPalavrasChave"] = $candidatoWebConf->fields['ExibirPalavrasChave'];
		        $_SESSION["ExibirRequisitos"] = $candidatoWebConf->fields['ExibirRequisitos'];
		        $_SESSION["ExibirInteresse"] = $candidatoWebConf->fields['ExibirInteresse'];
		        $_SESSION["CargoSel"] = $candidatoWebConf->fields['CargoSel'];
		        $_SESSION["FuncaoSel"] = $candidatoWebConf->fields['FuncaoSel'];
		        $_SESSION["AreaAtuacaoSel"] = $candidatoWebConf->fields['AreaAtuacaoSel'];
		        $_SESSION["PalavraChaveSel"] = $candidatoWebConf->fields['PalavraChaveSel'];
		        $_SESSION["RequisitoSel"] = $candidatoWebConf->fields['RequisitoSel'];
                
		        $_SESSION["ChaveCriptografia"] = $candidatoWebConf->fields['ChaveCriptografia'];
		        $_SESSION["DataUltimaImportacao"] = $candidatoWebConf->fields['DataUltimaImportacao'];
		        $_SESSION["UsaProxy"] = $candidatoWebConf->fields['UsaProxy'];
		        $_SESSION["Servidor"] = $candidatoWebConf->fields['Servidor'];
		        $_SESSION["Porta"] = $candidatoWebConf->fields['Porta'];
		        $_SESSION["RequerAutenticacao"] = $candidatoWebConf->fields['RequerAutenticacao'];
		        $_SESSION["UsuarioProxy"] = $candidatoWebConf->fields['UsuarioProxy'];
		        $_SESSION["SenhaProxy"] = $candidatoWebConf->fields['SenhaProxy'];
		        $_SESSION["Email"] = $candidatoWebConf->fields['Email'];
		        $_SESSION["ServidorEmail"] = $candidatoWebConf->fields['ServidorEmail'];
		        $_SESSION["PortaSMTP"] = $candidatoWebConf->fields['PortaSMTP'];
		        $_SESSION["UsuarioSMTP"] = $candidatoWebConf->fields['UsuarioSMTP'];
		        $_SESSION["RequerAutenticacaoEmail"] = $candidatoWebConf->fields['RequerAutenticacaoEmail'];
		        $_SESSION["ConexaoSegura"] = $candidatoWebConf->fields['ConexaoSegura'];
		        $_SESSION["SenhaSMTP"] = $candidatoWebConf->fields['SenhaSMTP'];
		        $_SESSION["OrdemPlvChave"] = $candidatoWebConf->fields['OrdemPlvChave'];
                $_SESSION["OrdemInteresses"] = $candidatoWebConf->fields['OrdemInteresses'];
		        // executa o login no sistema
		        $login = new LoginModel($this->db);
		        $login->setUsuario($usuario->Cpf);

				
		        $login->setSenha($senha);

		        $login->login();

				
            }
        }
	}
    
      public function buscarTermoHtml()
    {
       $pCw = new CandidatosWebConfDao($this->db);
       echo json_encode(utf8_encode($pCw->buscarTermoHtmlCandidatosWebConf()));
       exit;
    }
       public function setTermoConsentimento()
    {     
        $cpf = $_POST['CPF'];
        $cpf = str_replace(".","",$cpf);
		$cpf = str_replace("-","",$cpf);
        $termoConsentimento = $_POST['TermoConsentimento'];
        $pessoaDao = new PessoaDao($this->db);
        echo json_encode($pessoaDao->atualizaTermo($cpf,$termoConsentimento));
        exit;
    }

    public function buscarPoliticaSenha()
    {
        $cwcDao = new CandidatosWebConfDao($this->db);
        $candidatoWebConf = $cwcDao->buscarPoliticaDeSenhas();

        if ($candidatoWebConf != null)
        {        
            $candidato = new CandidatosWebConf();
            $candidato->MinimoCaracteres = utf8_encode($candidatoWebConf->MinimoCaracteres);
            $candidato->UsaLetrasNumeros = utf8_encode($candidatoWebConf->UsaLetrasNumeros);
            $candidato->UsaCaracteresEspeciais = utf8_encode($candidatoWebConf->UsaCaracteresEspeciais);
            $candidato->UsaMaiusculasMinusculas = utf8_encode($candidatoWebConf->UsaMaiusculasMinusculas);
            echo json_encode($candidato);      
            exit;
        }
        else
        {
            echo json_encode(null);      
            exit;
        }
    }

       public function buscarPessoaTermoConsentimento()
    {
         
        $cpf = $_GET['CPF'];
        $cpf = str_replace(".","",$cpf);
	    $cpf = str_replace("-","",$cpf);

        $pessoaDao = new PessoaDao($this->db);
        $pessoa = $pessoaDao->buscarPessoaPorCPF($cpf);
        if ($pessoa != null)
        {        
            $pessoaAux = new Pessoa();
            $pessoaAux->Pessoa = utf8_encode($pessoa->Pessoa);
            $pessoaAux->Nome = utf8_encode($pessoa->Nome);
            $pessoaAux->CPF = utf8_encode($pessoa->CPF);
            $pessoaAux->AceiteTermo = utf8_encode($pessoa->AceiteTermo);
            echo json_encode($pessoaAux);      
            exit;
        }
        else
        {
            echo json_encode(null);      
            exit;
        }
                           
      }   

	/**
	 * Verifica se os campos que vieram na REQUEST est?o vazio.
	 * Envia para a response uma String em JSON.	 
	 *
	 */
	private function validadeForm() {
		
		$nome = $_POST['Nome'];
		$cpf = $_POST['Cpf'];		
		$senha = $_POST['Senha'];
		
		if ($this->isEmpty($nome)) {
			echo json_encode(array('login' => false, 'message' => utf8_encode('Informe seu nome.')));
			exit;	
		}
		
		if ($this->isEmpty($cpf)) {
			echo json_encode(array('login' => false, 'message' => utf8_encode('Informe seu CPF.')));
			exit;	
		}
			
		if ($this->isEmpty($senha)) {
			echo json_encode(array('login' => false, 'message' => utf8_encode('Informe uma senha.')));
			exit;	
		}

	}
	
	/**
	 * Preencha uma classe Pessoa com as informa��es que vieram na REQUEST.
	 * @return Pessoa
	 */
	private function populatePessoa(){
		$webConfDao = new CandidatosWebConfDao($this->db);
		$cpf = $_POST['Cpf'];
		$cpf = str_replace(".","",$cpf);
		$cpf = str_replace("-","",$cpf);
		
		$pessoa = new Pessoa();
		$pessoa->Nome = utf8_decode($_POST['Nome']);
		$pessoa->Email = utf8_decode($_POST['Email']);
		$pessoa->DataCadastramento = date("Y-m-d H:i:s");
		$pessoa->CPF = $cpf;
        $termoHtml = $webConfDao->buscarTermoHtmlCandidatosWebConf();
        if (trim($termoHtml) != "")
            $pessoa->AceiteTermo = "S";
        $pessoa->Excluir = "N";
		$pessoa->Empresa = $webConfDao->buscaEmpresaPrincipal();
		$pessoa->UltAlteracao = date("Y-m-d H:i:s");
		$campoWebObrDao = new CampoWebObrDao($this->db);
		$campoPISObr = $campoWebObrDao->buscarCamposObr("RHPESSOAS", " rhdicionariocampoobr.CampoTabela =  " . preg_replace('/[^\p{L}\'0-9\-. ]/u', '', $this->db->qstr("PIS")) . "");        
        $pessoa->PossuiPIS = "N";
        if ($campoPISObr->fields['CampoTabela'] == "PIS"){
            $pessoa->PossuiPIS = "S";
        }
		return $pessoa;
	}
	
	// Verifica se uma vari�vel est� vazia ou nula. 
	private function isEmpty($val){
		return $val == "" || $val == NULL;
	}
	
}
?>