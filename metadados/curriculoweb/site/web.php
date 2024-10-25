<?php

class Web {

	private $db;

	public function __construct($db, $modulo, $entidade, $acao) {

		$this->db = $db;

        $cwcDao = new CandidatosWebConfDao($this->db);
		$candidatoWebConf = $cwcDao->buscarCandidatosWebConfPorParametros();
        if ($candidatoWebConf->fields['UsaHttps'] == "1"){
            $_SESSION["UsaHttps"] = "https";
        }
        else{
            $_SESSION["UsaHttps"] = "http";
        }

		if ($modulo != "" && $modulo != "home" && $modulo != "login" && $modulo != "vagas" && $modulo != "vagasConsulta" && $modulo != "entradaConsulta") {
			if (!LoginController::isUsuarioLogado()){
				header("Location: ?modulo=home");
			}
		}

		if ($modulo == "concluidoInicial") {
			header("Location: ?modulo=home");
		}

		switch($modulo) {
			case "login":
				$lController = new LoginController($this->db, $entidade, $acao);
				break;
			case "meucurriculo":
				$mcController = new MeuCurriculoController($this->db, $entidade, $acao);
				break;
			case "informacaoAcademica":
				$ia = new PessoaCursoController($this->db, $acao);
				break;
			case "informacoesAdicionais":
				$iad = new InformacoesAdicionaisController($this->db, $acao);
				break;
			case "historicoProfissional":
				$hp = new EmpresaAnteriorController($this->db, $acao);
				break;
			case "dadosComplementares":
				$hp = new DadosComplementaresController($this->db, $acao);
				break;
			case "pessoaIdioma":
				$pi = new PessoaIdiomaController($this->db, $entidade, $acao);
				break;
			case "pessoaPalavraChave":
				$ppc = new PessoaPalavraChaveController($this->db, $entidade, $acao);
				break;
			case "pessoaAreaInteresse":
				$ppc = new PessoaAreaInteresseController($this->db, $entidade, $acao);
				break;
			case "vagas":
				$mcController = new VagasController($this->db, $entidade, $acao);
				break;
			case "vagasConsulta":
				$mcController = new VagasController($this->db, "pesquisarConsulta", $acao);
				break;
			case "pessoa":
				$pController = new PessoaController($this->db, $entidade, $acao);
				break;
			case "requisitos":
				$hp = new PessoaRequisitoController($this->db, $acao);
				break;
			case "upload":
				$upload = new UploadController($db, $acao);
				break;
			case "anexo":
				$upload = new UploadController($db, $acao);
				break;
			case "imagem":
				$imagem = new MostraImagem($db, $acao);
            case "entradaConsulta":
                $lController = new EntradaConsultaController($this->db, $entidade, $acao);
				break;
            case "informacoesIncompletas":
                $infoIncompletas = new InfoIncompletas($this->db);
				$existeCampos = $infoIncompletas->existeCampoVazio();
                $json = array();
                $json['ExisteCampos'] = $existeCampos;
                echo json_encode($json);

                break;
			default:
				$lController = new HomeController($this->db, $entidade, $acao);
				break;
		}
	}
}

?>