<?php

class PessoaCursoController {

	public function __construct($db, $metodo) {
		$this->db = $db;

		if ($metodo)
			$this->$metodo();
		else
			$this->abrir();
	}
	function validaPessoaCurso(PessoaCurso $pessoa){
		if(trim($pessoa->Curso) == "" && trim($pessoa->Descricao50) == ""){
			throw new Exception("Favor digitar seu curso.");
		}
	}
	private function toJSON($result) {
		$dateUtil = new DataUtil();
		$json = array();

		$json['Empresa'] = $result->fields['Empresa'];
		$json['Pessoa'] = $result->fields['Pessoa'];
		$json['NroOrdem'] = $result->fields['NroOrdem'];

		$json['Curso'] = $result->fields['Curso'];
		$json['Descricao50'] = utf8_encode($result->fields['Descricao50']);
		$json['Nm_Curso'] = utf8_encode($result->fields['Nm_Curso']);

		$json['Descricao40'] = utf8_encode($result->fields['Descricao40']);
		$json['Car_Horaria'] = NumberUtil::formatar($result->fields['Car_Horaria']);
		$json['Dt_Inicio'] = $dateUtil->formatDate($result->fields['Dt_Inicio']);
		$json['Dt_Encerra'] = $dateUtil->formatDate($result->fields['Dt_Encerra']);
		$json['DescTpCurso'] =  utf8_encode($result->fields['DescTpCurso']);
		$json['TipoCurso'] =  $result->fields['TipoCurso'];

		return $json;
	}

	function carregar() {

		$pessoaCurso = new PessoaCurso();
		$pessoaCurso->Empresa = LoginModel::getEmpresaLogada();
		$pessoaCurso->Pessoa = LoginModel::getPessoaLogada();

		$pcDao = new PessoaCursoDao($this->db);
		$result = $pcDao->buscarPessoaCursoPorParametros($pessoaCurso);


		$lista = array();

		$i = 0;
		while (!$result->EOF) {

			$json = $this->toJSON($result);

			$lista[$i++] = $json;
			$result->MoveNext();
		}

		echo json_encode($lista);

		exit;
	}

	function abrir() {
		$_SESSION["GUIA"] = "Formacao";
		$cursoDao = new CursoDao($this->db);
		$result = $cursoDao->buscarCursoPorParametros(null);

		$camposObr = new CampoWebObrDao($this->db);
		$listaCamposObr = $camposObr->buscarCamposObr("RHPESSOACURSOSRS");

        //Campos Invisíveis
        $camposInv = new CampoWebInvDao($this->db);
		$listaCamposInv = $camposInv->buscarCamposInv("RHPESSOACURSOSRS");

        


		$tipoCursoDao = new TipoCursoDao($this->db);
		$tipoCurso = $tipoCursoDao->buscaTipoCursoPorParametros();


		include 'site/web/MeuCurriculo/informacoesAcademicas.php';

	}

	function criar() {

		try {
			$giDao = new PessoaCursoDao($this->db);

			$pessoaCurso = $this->populatePessoaCurso();
			$this->validaPessoaCurso($pessoaCurso);
			$NroOrdem = $giDao->buscarProximaSequencia($pessoaCurso);
			$pessoaCurso->NroOrdem = $NroOrdem;

            if ($pessoaCurso->validaTamanhoCampos()){
                $giDao->criarPessoaCurso($pessoaCurso);
			    echo "Curso adicionado!";
            }

		} catch (Exception $e) {
			echo "Erro ao incluir curso!\n " . $e->getMessage();
		}
	}

	function alterar() {

		try {
			$giDao = new PessoaCursoDao($this->db);

			$pessoaCurso = $this->populatePessoaCurso();
			$this->validaPessoaCurso($pessoaCurso);
            if ($pessoaCurso->validaTamanhoCampos()){
			    $giDao->alterarPessoaCurso($pessoaCurso);
			    echo "Curso alterado!";
            }

		} catch (Exception $e) {
			echo "Erro ao alterar curso!\n " . $e->getMessage();
		}
	}

	function editar() {

		$pcDao = new PessoaCursoDao($this->db);

		$pessoaCurso = $this->populatePessoaCurso();

		$result = $pcDao->buscarPessoaCursoPorPK($pessoaCurso);

		$json = $this->toJSON($result);

		echo json_encode($json);
		exit;
	}

	function excluir() {
		$giDao = new PessoaCursoDao($this->db);

		$pessoaCurso = $this->populatePessoaCurso();

		$giDao->excluirPessoaCurso($pessoaCurso);

		$status =  array("status" => "true");

		echo json_encode($status);

		exit;
	}

	private function populatePessoaCurso() {
		$pessoaCurso = new PessoaCurso();

		$pessoaCurso->Empresa = LoginModel::getEmpresaLogada();
		$pessoaCurso->Pessoa = LoginModel::getPessoaLogada();
		$pessoaCurso->NroOrdem = $_POST['NroOrdem'];

		if ( ($_POST['Curso'] != "outro") && ($_POST['Curso'] != "") )
			$pessoaCurso->Curso = $_POST['Curso'];

		$pessoaCurso->Descricao50 = substr(utf8_decode($_POST['Descricao50']), 0, 50);
		$pessoaCurso->Descricao40 = substr(utf8_decode($_POST['Descricao40']),0 ,40);
		$pessoaCurso->Car_Horaria = substr(NumberUtil::formatarSql($_POST['Car_Horaria']), 0, 9);
		if ($_POST['Dt_Inicio'] != "")
			$pessoaCurso->Dt_Inicio = DataUtil::toTimestamp($_POST['Dt_Inicio']);
		if ($_POST['Dt_Encerra'] != "")
			$pessoaCurso->Dt_Encerra = DataUtil::toTimestamp($_POST['Dt_Encerra']);

		return $pessoaCurso;
	}

}

?>