<?php

class DadosComplementaresController {

	public function __construct($db, $metodo) {
		$this->db = $db;

		if ($metodo)
		$this->$metodo();
		else
		$this->abrir();
	}

	private function toJSON($result) {
			
	}

	function abrir() {
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();

		$variavelDao = new VariavelDao($this->db);
		$result = $variavelDao->buscarVariaveisPorParametros();

		$codigoDao = new CodigoComplementarDao($this->db);
		$opcaoDao = new OpcaoComplementarDao($this->db);

		$pessoaDadoComplementar = new PessoaDadoComplementar();
		$pessoaDadoComplementar->Empresa = LoginModel::getEmpresaLogada();
		$pessoaDadoComplementar->Pessoa = LoginModel::getPessoaLogada();

		$pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
		$resultDados = $pessoaDadoComplementarDao->buscarPessoaDadoComplementarPorPK($pessoaDadoComplementar);

		$variavelObr = new VariavelWebObrDao($this->db);
		$listaDadosComplementaresObr = $variavelObr->buscarVariavelObr();
		
		include 'site/web/MeuCurriculo/dadosComplementares.php';
	}

	function salvar() {
		$pessoaDadoComplementar = $this->populatePessoaDadoComplementar();

		$pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
		$result = $pessoaDadoComplementarDao->buscarPessoaDadoComplementarPorPK($pessoaDadoComplementar);

        if ($pessoaDadoComplementar->validaTamanhoCampos()){
            if ($result->RecordCount() == 1) {
			    $this->alterar($pessoaDadoComplementar);
		    } else {
			    $this->criar($pessoaDadoComplementar);
		    }
        }
	}

	function criar(PessoaDadoComplementar $pessoaDadoComplementar) {

		$pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
        if ($pessoaDadoComplementar->validaTamanhoCampos()){
		    $pessoaDadoComplementarDao->criarPessoaDadoComplementar($pessoaDadoComplementar);
		    exit;
        }
	}

	function alterar(PessoaDadoComplementar $pessoaDadoComplementar) {

		$pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
        if ($pessoaDadoComplementar->validaTamanhoCampos()){ 
		    $pessoaDadoComplementarDao->alterarPessoaDadoComplementar($pessoaDadoComplementar);
		    exit;
        }
	}

	private function populatePessoaDadoComplementar() {

		$variavelDao = new VariavelDao($this->db);
		$result = $variavelDao->buscarVariaveisPorParametros();

		$pessoaDadoComplementar = new PessoaDadoComplementar();
		$i = 0;
		while (!$result->EOF) {
			$a = array();

			$a[0] = $result->fields['CampoTabelaFutura'];
			if(trim($_POST[$result->fields['Variavel']]) == ""){
				if ($result->fields['TipoCampo'] == "DAT"){
					$result->MoveNext();
					continue;
				}
				$a[1] = "";
			}
			Else if ($result->fields['TipoCampo'] == "DAT"){
				$a[1] = DataUtil::toTimestamp($_POST[$result->fields['Variavel']]);
			}
			else{
				$a[1] = utf8_decode(substr($_POST[$result->fields['Variavel']], 0, 800));
			}

			$array[$i++] = $a;
			$result->MoveNext();
		}		
		$pessoaDadoComplementar->Empresa = LoginModel::getEmpresaLogada();
		$pessoaDadoComplementar->Pessoa = LoginModel::getPessoaLogada();
		$pessoaDadoComplementar->Campos = $array;

		return $pessoaDadoComplementar;
	}
}

?>