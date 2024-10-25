<?php

class EmpresaAnteriorController {

	public function __construct($db, $metodo) {
		$this->db = $db;

		if ($metodo)
			$this->$metodo();
		else
			$this->abrir();
	}

	private function toJSON($result) {

		$json = array();

		$json['Empresa'] = $result->fields['Empresa'];
		$json['Pessoa'] = $result->fields['Pessoa'];
		$json['NroSequencia'] = $result->fields['NroSequencia'];

		$json['EmpresaAnterior'] = utf8_encode($result->fields['EmpresaAnterior']);
		$json['EstaTrabalhando'] = $result->fields['EstaTrabalhando'];
		$json['PrimeiroEmprego'] = $result->fields['PrimeiroEmprego'];

		$json['DataAdmissao'] = DataUtil::formatDate($result->fields['DataAdmissao']);
		$json['DataRescisao'] = DataUtil::formatDate($result->fields['DataRescisao']);
		$json['SalarioFinal'] = NumberUtil::formatar($result->fields['SalarioFinal']);
		$json['Observacoes'] = utf8_encode($result->fields['Observacoes']);

		return $json;
	}

	function carregar() {

		$empresaAnterior = new EmpresaAnterior();
		$empresaAnterior->Empresa = LoginModel::getEmpresaLogada();
		$empresaAnterior->Pessoa = LoginModel::getPessoaLogada();
		if (isset($_POST["PrimeiroEmprego"])){
			$empresaAnterior->PrimeiroEmprego = $_POST["PrimeiroEmprego"];
		}

		$pcDao = new EmpresaAnteriorDao($this->db);

		$result = $pcDao->buscarEmpresaAnteriorPorParametros($empresaAnterior);
		$lista = array();
		$json = array();
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
		$_SESSION["GUIA"] = "Experiencia";
		$aaDao = new AreaAtuacaoDao($this->db);
		$result = $aaDao->buscarAreaAtuacaoPorParametros();

		$camposObr = new CampoWebObrDao($this->db);
		$listaCamposObr = $camposObr->buscarCamposObr("RHEMPRESASANTERIORES");

        //Campos Invisíveis
        $camposInv = new CampoWebInvDao($this->db);
		$listaCamposInv = $camposInv->buscarCamposInv("RHEMPRESASANTERIORES");



		include 'site/web/MeuCurriculo/historicoProfissional.php';
	}

	function criar() {

		try {
			$giDao = new EmpresaAnteriorDao($this->db);
			$peaeDao = new PessoaEmpresaAnteriorExpDao($this->db);

			$empresaAnterior = $this->populateEmpresaAnterior();

			$NroSequencia = $giDao->buscarProximaSequencia($empresaAnterior);

			$empresaAnterior->NroSequencia = $NroSequencia;

            if ($empresaAnterior->validaTamanhoCampos())
            {
			    $giDao->criarEmpresaAnterior($empresaAnterior);

			    // Experiencias na Empresa

			    $lista = $this->populatePessoaEmpresaAnteriorExp($NroSequencia);
			    for ($i = 0; $i < count($lista); $i++)
                {
                    if ($lista[$i]->validaTamanhoCampos()){
				        $peaeDao->criarPessoaEmpresaAnteriorExp($lista[$i]);
                    }
                }


			    echo "Empresa adicionada com sucesso!";
            }

		} catch (Exception $e) {
			echo "Erro ao incluir a empresa!\n " . $e->getMessage();
		}
	}

	function alterar() {

		try {
			$giDao = new EmpresaAnteriorDao($this->db);

			$empresaAnterior = $this->populateEmpresaAnterior();

            if ($empresaAnterior->validaTamanhoCampos())
            {
                $giDao->alterarEmpresaAnterior($empresaAnterior);

			    $peaeDao = new PessoaEmpresaAnteriorExpDao($this->db);
			    $peaeDao->excluirPessoaEmpresaAnteriorExp($empresaAnterior);

			    $lista = $this->populatePessoaEmpresaAnteriorExp($empresaAnterior->NroSequencia);
			    for ($i = 0; $i < count($lista); $i++)
                {
                    if ($lista[$i]->validaTamanhoCampos())
				        $peaeDao->criarPessoaEmpresaAnteriorExp($lista[$i]);
                }

			    echo "Empresa alterada com sucesso!";
                return true;
            }
		} catch (Exception $e) {
			echo "Erro ao alterar a empresa!\n " . $e->getMessage();
		}
	}

	function editar() {

		$pcDao = new EmpresaAnteriorDao($this->db);

		$empresaAnterior = $this->populateEmpresaAnterior();

		$result = $pcDao->buscarEmpresaAnteriorPorPK($empresaAnterior);

		$json = $this->toJSON($result);

		echo json_encode($json);
		exit;
	}

	function editarExperiencias() {

		$peaeDao = new PessoaEmpresaAnteriorExpDao($this->db);

		$pessoaEmpresaAnteriorExp = new PessoaEmpresaAnteriorExp();

		$pessoaEmpresaAnteriorExp->Empresa = LoginModel::getEmpresaLogada();
		$pessoaEmpresaAnteriorExp->Pessoa = LoginModel::getPessoaLogada();
		$pessoaEmpresaAnteriorExp->NroSequencia = $_POST["NroSequencia"];
		$pessoaEmpresaAnteriorExp->NroOrdem = $_POST["NroOrdem"];

		$result = $peaeDao->buscarPessoaEmpresaAnteriorExpPorPK($pessoaEmpresaAnteriorExp);

		$json = array();

		$json['AreaAtuacao'] = $result->fields['AreaAtuacao'];
		$json['Descricao40'] = utf8_encode($result->fields['Descricao40']);
		$json['AnosCasa'] = $result->fields['AnosCasa'];
		$json['MesesCasa'] = $result->fields['MesesCasa'];

		echo json_encode($json);
		exit;
	}

	function excluir() {
		$giDao = new EmpresaAnteriorDao($this->db);

		$empresaAnterior = $this->populateEmpresaAnterior();

		$giDao->excluirEmpresaAnterior($empresaAnterior);

		$peaeDao = new PessoaEmpresaAnteriorExpDao($this->db);
		$peaeDao->excluirPessoaEmpresaAnteriorExp($empresaAnterior);

		$status =  array("status" => "true");

		echo json_encode($status);
		exit;
	}

	private function populateEmpresaAnterior() {
		$empresaAnterior = new EmpresaAnterior();

		$empresaAnterior->Empresa = LoginModel::getEmpresaLogada();
		$empresaAnterior->Pessoa = LoginModel::getPessoaLogada();

		$empresaAnterior->NroSequencia = $_POST['NroSequencia'];

		$empresaAnterior->EmpresaAnterior = utf8_decode($_POST['EmpresaAnterior']);
		$empresaAnterior->EstaTrabalhando = $_POST['EstaTrabalhando'] != "S" ? "N" : "S";
		$empresaAnterior->PrimeiroEmprego = $_POST['PrimeiroEmprego'] != "S" ? "N" : "S";

		$empresaAnterior->DataAdmissao = DataUtil::toTimestamp($_POST['DataAdmissao']);
		if (trim($_POST['DataRescisao']) != "")
			$empresaAnterior->DataRescisao = DataUtil::toTimestamp($_POST['DataRescisao']);
		if ($_POST['SalarioFinal'] != "")
			$empresaAnterior->SalarioFinal = NumberUtil::formatarSql($_POST['SalarioFinal']);
		$empresaAnterior->Observacoes = utf8_decode(substr($_POST['Observacoes'],0,800));

		return $empresaAnterior;
	}

	private function populatePessoaEmpresaAnteriorExp($sequencia) {

		$lista = array();
		$j = 0;
		for ($i = 1; $i <= 3; $i++) {
			$pessoaEmpresaAnteriorExp = new PessoaEmpresaAnteriorExp();

			$pessoaEmpresaAnteriorExp->Empresa = LoginModel::getEmpresaLogada();
			$pessoaEmpresaAnteriorExp->Pessoa = LoginModel::getPessoaLogada();
			$pessoaEmpresaAnteriorExp->NroSequencia = $sequencia;
			$pessoaEmpresaAnteriorExp->NroOrdem = $i;

			if ($_POST['AreaAtuacao' . $i] != "") {
				if ($_POST['AreaAtuacao' . $i] != "outro")
					$pessoaEmpresaAnteriorExp->AreaAtuacao = $_POST['AreaAtuacao' . $i];
				else
					$pessoaEmpresaAnteriorExp->AreaAtuacao = NULL;

				if ($_POST['Descricao40' . $i] != "")
					$pessoaEmpresaAnteriorExp->Descricao40 = utf8_decode($_POST['Descricao40' . $i]);

				$pessoaEmpresaAnteriorExp->AnosCasa = $_POST['AnosCasa' . $i];
				$pessoaEmpresaAnteriorExp->MesesCasa = $_POST['MesesCasa' . $i];

				$lista[$j] =  $pessoaEmpresaAnteriorExp;

				$j++;
			}
		}

		return $lista;

	}
}

?>