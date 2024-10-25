<?php

class InformacoesAdicionaisController{

	public function __construct($db, $metodo){
		$this->db = $db;

		if($metodo)
		   $this->$metodo();
		else
		   $this->abrir();

	}

    function abrir() {
        $_SESSION["GUIA"] = "InformacoesAdicionais";
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();

		$escalaRequisitoDao = new EscalaRequisitoDao($this->db);

        $requisitoDao = new RequisitoDao($this->db);
		$listaRequisitos = $requisitoDao->buscarRequisitosPorParametros();

		$requisitosWebObr = new RequisitoWebObrDao($this->db);
		$listaRequisitosObr = $requisitosWebObr->buscarRequisitoObr();
//		include 'site/web/MeuCurriculo/requisitos.php';

		$informacaoDao = new InformacaoAdicionalDao($this->db);
		$result = $informacaoDao->buscaVariaveisRequisitos();
		//echo $result;
		//exit(1);

		//$variavelDao = new VariavelDao($this->db);
		//$result = $variavelDao->buscarVariaveisPorParametros();

		$pessoaRequisito = new PessoaRequisito();
		$pessoaRequisito->Pessoa = $_SESSION["PessoaLogada"]; //dados da sessão


		$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
		$listaRequisitosPessoa = $pessoaRequisitoDao->buscarPessoaRequisitoPorPK($pessoaRequisito);



		$codigoDao = new CodigoComplementarDao($this->db);
		$opcaoDao = new OpcaoComplementarDao($this->db);

		$pessoaDadoComplementar = new PessoaDadoComplementar();
		$pessoaDadoComplementar->Empresa = LoginModel::getEmpresaLogada();
		$pessoaDadoComplementar->Pessoa = LoginModel::getPessoaLogada();


		$pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
		$resultDados = $pessoaDadoComplementarDao->buscarPessoaDadoComplementarPorPK($pessoaDadoComplementar);

		$variavelObr = new VariavelWebObrDao($this->db);
		$listaDadosComplementaresObr = $variavelObr->buscarVariavelObr();

		//Incluir a tela nova que irei criar
		//include 'site/web/MeuCurriculo/dadosComplementares.php';
		include 'site/web/MeuCurriculo/informacoesAdicionais.php';


	}


    function salvar() {
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();

		$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
		$requisitoDao = new RequisitoDao($this->db);


		foreach ($_POST as $key => $value) {
			echo $key . "=" . $value."<BR>";
			$pessoaRequisito = new PessoaRequisito();
			$pessoaRequisito->Empresa = $_SESSION["Empresa"]; //dados da sessão
			$pessoaRequisito->Pessoa = $_SESSION["PessoaLogada"]; //dados da sessão

			if ( ($pos = strpos($key, "requisito") ) > -1 ){
				$keyRequisito = substr($key, $pos+9, strlen($key));
				$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);

				$pessoaRequisito->Requisito = $keyRequisito;
				$teste1 = $pessoaRequisitoDao->buscarPessoaRequisitoPorPK($pessoaRequisito);

				if ($teste1->RecordCount() == 1) {
					echo "alterar";
					if ($teste1->fields['TipoRequisito'] == "AV"){
						$pessoaRequisito->Item_Avaliacao = $value;
					} else if ($teste1->fields['TipoRequisito'] == "TX"){
						$pessoaRequisito->TextoRequisito = utf8_decode($value);
					} else if ($teste1->fields['TipoRequisito'] == "QT"){
						$pessoaRequisito->QuantidadeRequisito = $numberUtil->formatarSql($value);
					}

                    if ($pessoaRequisito->validaTamanhoCampos())
					    $this->alterarRequisito($pessoaRequisito);
				} else {

					$listaRequisito = $requisitoDao->buscarRequisitosPorParametros($keyRequisito);
					$listaRequisito->MoveFirst();
					echo "criar".$listaRequisito->fields['TipoRequisito'] ;
					if ($listaRequisito->fields['TipoRequisito'] == "AV"){
						$pessoaRequisito->Item_Avaliacao = $value;

					} else if ($listaRequisito->fields['TipoRequisito'] == "TX"){
						$pessoaRequisito->TextoRequisito = utf8_decode($value);
					} else if ($listaRequisito->fields['TipoRequisito'] == "QT"){
						$pessoaRequisito->QuantidadeRequisito = str_replace(",", ".", $value);
					}

                    if ($pessoaRequisito->validaTamanhoCampos())
					    $this->criarRequisito($pessoaRequisito);
				}
			} else {
				$pessoaDadoComplementar = $this->populatePessoaDadoComplementar();
				$pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
				$teste2 = $pessoaDadoComplementarDao->buscarPessoaDadoComplementarPorPK($pessoaDadoComplementar);

                if ($pessoaDadoComplementar->validaTamanhoCampos()){
				    if ($teste2->RecordCount() == 1) {
					    $this->alterarComplementar($pessoaDadoComplementar);
				    } else {
					    $this->criarComplementar($pessoaDadoComplementar);
				    }
                }
			}
		}


	}








	function criarRequisito(PessoaRequisito $pessoaRequisito) {


		$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
        $pessoaRequisitoDao->criarPessoaRequisito($pessoaRequisito);

		//exit;

	}

    function criarComplementar(PessoaDadoComplementar $pessoaDadoComplementar) {

        $pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
	    $pessoaDadoComplementarDao->criarPessoaDadoComplementar($pessoaDadoComplementar);


		//exit;

	}

	function alterarRequisito(PessoaRequisito $pessoaRequisito) {


        $pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
        $pessoaRequisitoDao->alterarPessoaRequisito($pessoaRequisito);


		//exit;

	}

	function alterarComplementar(PessoaDadoComplementar $pessoaDadoComplementar) {


		$pessoaDadoComplementarDao = new PessoaDadoComplementarDao($this->db);
		$pessoaDadoComplementarDao->alterarPessoaDadoComplementar($pessoaDadoComplementar);


		//exit;

	}


    private function populatePessoaDadoComplementar() {

		$variavelDao = new VariavelDao($this->db);
		$result = $variavelDao->buscarVariaveisPorParametros();

		//$informacaoDao = new InformacaoAdicionalDao($this->db);
		//$result = $informacaoDao->buscaVariaveisRequisitos();

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