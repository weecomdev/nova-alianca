<?php

class PessoaIdiomaController {

	public function __construct($db, $entidade, $metodo) {
		$this->db = $db;

		if ($metodo)
			$this->$metodo();
		else
			$this->abrir();
	}

	function carregar() {
		$pcDao = new PessoaCursoDao($this->db);
		$result = $pcDao->buscarPessoaCursoPorParametros();
		$lista = array();
		$json = array();
		$i = 0;
		while (!$result->EOF) {
			$json['Empresa'] = $result->fields['Empresa'];
			$json['Pessoa'] = $result->fields['Pessoa'];
			$json['NroOrdem'] = $result->fields['NroOrdem'];

			$json['Descricao50'] = $result->fields['Descricao50'];
			$result->MoveNext();

			$lista[$i++] = $json;
		}

		echo json_encode($lista);

		exit;
	}

	function abrir() {
        $_SESSION["GUIA"] = "Idiomas";
		$iDao = new IdiomaDao($this->db);
		$piDao = new PessoaIdiomaDao($this->db);
		$inDao = new IdiomaNivelDao($this->db);

		$listaIdiomas = $iDao->buscarIdiomaPorParametros();
		$listaIdiomasPessoa =  $piDao->buscarIdiomasPorPessoa($_SESSION["Empresa"], $_SESSION["PessoaLogada"]);
		$listaIdiomaNivel = $inDao->buscarIdiomaNivelPorParametros();

		include 'site/web/MeuCurriculo/idiomas.php';
	}

	function salvar() {
		try {
			$piDao = new PessoaIdiomaDao($this->db);

			$pessoaIdioma = new PessoaIdioma();
			$pessoaIdioma->Empresa = $_SESSION["Empresa"];
			$pessoaIdioma->Pessoa = $_SESSION["PessoaLogada"];
			$pessoaIdioma->OrigemCurriculo = $_POST['OrigemCurriculo'];


			$listaIdiomasExcluidos = $_POST['removeidiomas'];
			if (!is_null($listaIdiomasExcluidos)){
				foreach ($listaIdiomasExcluidos as $key => $value) {
					$pessoaIdioma->Idioma = $value;

					$piDao->excluirPessoaIdioma($pessoaIdioma);
				}
			}

			$listaIdiomas = $_POST['idiomas'];
			if (!is_null($listaIdiomas)){
				foreach ($listaIdiomas as $key => $value) {
					$pessoaIdioma->Idioma = $value;
					$pessoaIdioma->NivelIdioma = $_POST['nivel'.$value];

					$piDao->excluirPessoaIdioma($pessoaIdioma);
                    if ($pessoaIdioma->validaTamanhoCampos())
					    $piDao->criarPessoaIdioma($pessoaIdioma);
				}
			}

			echo "Idioma adicionado a pessoa!";

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

	private function populatePessoaIdioma() {

		$pessoaIdioma = new PessoaIdioma();

		$pessoaIdioma->Empresa = $_POST['Empresa'];
		$pessoaIdioma->Pessoa = $_POST['Pessoa'];
		$pessoaIdioma->Idioma = $_POST['Idioma'];
		$pessoaIdioma->NivelIdioma = $_POST['NivelIdioma'];

		$pessoaIdioma->OrigemCurriculo = $_POST['OrigemCurriculo'];

		return $pessoaIdioma;
	}

}

?>