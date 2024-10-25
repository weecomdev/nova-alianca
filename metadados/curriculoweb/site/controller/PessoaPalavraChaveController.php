<?php

class PessoaPalavraChaveController {

	public function __construct($db, $entidade, $metodo) {
		$this->db = $db;
		if ($metodo)
			$this->$metodo();
		else
			$this->abrir();
	}

	function abrir() {
        $_SESSION["GUIA"] = "PalavrasChave";
		$iDao = new PalavraChaveDao($this->db);
		$piDao = new PessoaPalavraChaveDao($this->db);
		$listaPalavrasChave = $iDao->buscarPalavraChavePorParametros();
		$listaPalavrasChavePessoa =  $piDao->buscarPalavraChavePorPessoa($_SESSION["Empresa"], $_SESSION["PessoaLogada"]);
		include 'site/web/MeuCurriculo/palavrasChaves.php';
	}

	function salvar() {
		try {
			$piDao = new PessoaPalavraChaveDao($this->db);

			$pessoaPalavraChave = new PessoaPalavraChave();
			$pessoaPalavraChave->Empresa = $_SESSION["Empresa"];
			$pessoaPalavraChave->Pessoa = $_SESSION["PessoaLogada"];
			$pessoaPalavraChave->OrigemCurriculo = $_POST['OrigemCurriculo'];

			$listaPalavraChavesExcluidos = $_POST['removepalavrasChave'];
			if (!is_null($listaPalavraChavesExcluidos)){
				foreach ($listaPalavraChavesExcluidos as $key => $value) {
					$pessoaPalavraChave->PalavraChave = $value;

					$piDao->excluirPessoaPalavraChave($pessoaPalavraChave);
				}
			}

			$listaPalavraChaves = $_POST['palavrasChave'];
			print_r($listaPalavraChaves);
			if (!is_null($listaPalavraChaves)){

				foreach ($listaPalavraChaves as $key => $value) {
					$pessoaPalavraChave->PalavraChave = $value;

                    if ($pessoaPalavraChave->validaTamanhoCampos())
					    $piDao->criarPessoaPalavraChave($pessoaPalavraChave);
				}
			}

			echo "PalavraChave adicionado a pessoa!";

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

	private function populatePessoaPalavraChave() {

		$pessoaPalavraChave = new PessoaPalavraChave();

		$pessoaPalavraChave->Empresa = $_POST['Empresa'];
		$pessoaPalavraChave->Pessoa = $_POST['Pessoa'];
		$pessoaPalavraChave->PalavraChave = $_POST['PalavraChave'];

		$pessoaPalavraChave->OrigemCurriculo = $_POST['OrigemCurriculo'];

		return $pessoaPalavraChave;
	}

}

?>