<?php

class PessoaAreaInteresseController {
	private $db;
	private $empresa;
	public function __construct($db, $entidade, $metodo) {
		$this->db = $db;
		$candidatosWebConfDao = new CandidatosWebConfDao($db);
		$this->empresa = $candidatosWebConfDao->buscaEmpresaPrincipal();
		if ($metodo)
			$this->$metodo();
		else
			$this->abrir();
	}

	function abrir() {
        $_SESSION["GUIA"] = "Interesses";
		$aaDao = new AreaAtuacaoDao($this->db);
		$aiDao = new PessoaAreaInteresseDao($this->db);
		$listaAreaAtuacao = $aaDao->buscarAreaAtuacaoPorParametros();
		$listaAreaInteressePessoa =  $aiDao->buscarAreaInteressePorPessoa($this->empresa, LoginModel::getPessoaLogada());
		include 'site/web/MeuCurriculo/interessesProfissionais.php';
	}

	function salvar() {
		try {
			$piDao = new PessoaAreaInteresseDao($this->db);

			$pessoaAreaInteresse = new PessoaAreaInteresse();
			$pessoaAreaInteresse->Empresa = $this->empresa;
			$pessoaAreaInteresse->Pessoa = LoginModel::getPessoaLogada();
			$pessoaAreaInteresse->OrigemCurriculo = $_POST['OrigemCurriculo'];
			$pessoaAreaInteresse->NroOrdem = $_POST['NroOrdem'];

			$listaAreaAtuacaosExcluidos = $_POST['removeareasInteresse'];
			if (!is_null($listaAreaAtuacaosExcluidos)){

				foreach ($listaAreaAtuacaosExcluidos as $key => $value) {
					$pessoaAreaInteresse->AreaAtuacao = $value;

					$piDao->excluirPessoaAreaInteresse($pessoaAreaInteresse);
				}
			}

			$listaAreaAtuacaos = $_POST['areasInteresse'];

			if (!is_null($listaAreaAtuacaos)){

				foreach ($listaAreaAtuacaos as $key => $value) {
					$pessoaAreaInteresse->NroOrdem++;
					$pessoaAreaInteresse->AreaAtuacao = $value;

                    if ($pessoaAreaInteresse->validaTamanhoCampos())
					    $piDao->criarPessoaAreaInteresse($pessoaAreaInteresse);
				}
			}

			echo "Area Atuacao adicionado a pessoa!";

		} catch (Exception $e) {
			echo "Erro ao incluir idioma!\n " . $e->getMessage();
		}
	}

	function editar() {

	}

	function alterar() {

	}

	function excluir() {
		$giDao = new PessoaCursoDao($this->db);

		$pessoaCurso = $this->populatePessoaCurso();

		$giDao->excluirPessoaCurso($pessoaCurso);

		$status =  array("status" => "true");

		echo json_encode($status);

		exit;
	}

	private function populatePessoaAreaInteresse() {
		$pessoaAreaInteresse = new PessoaAreaInteresse();

		$pessoaAreaInteresse->Empresa = $this->empresa;
		$pessoaAreaInteresse->Pessoa = $_POST['Pessoa'];
		$pessoaAreaInteresse->AreaAtuacao = $_POST['AreaAtuacao'];

		return $pessoaAreaInteresse;
	}

}

?>