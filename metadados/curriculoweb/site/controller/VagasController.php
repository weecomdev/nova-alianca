<?php

class VagasController{

	private $db;
	private $acao;
	private $entidade;

	public function VagasController($db, $entidade, $acao) {
		$this->db = $db;
		$this->entidade = $entidade;		
		if ($acao)
			$this->$acao();
		else
			$this->abrir();
	}

	public function webpage(){
		switch($this->entidade){
			case "pesquisar":
				$this->pesquisar();	
			break;
			case "listar":
				//$this->salvarInformacoesPessoais();
				include 'site/web/Vagas/listar.php';
			break;
			case "detalharVaga":
				$this->detalharVaga();
			break;            
			case "detalharVagaConsulta":
				$this->detalharVagaConsulta();
                break;            
			
			case "buscarVagasConcorridas":
				$this->buscarVagasConcorridas();	
			break;
		}
	}
	
	function abrir() {
		$aaDao = new AreaAtuacaoDao($this->db);
		$cDao = new CargoDao($this->db);
		$fDao = new FuncaoDao($this->db);
		$veDao = new VinculoEmpregaticioDao($this->db);
		$rDao = new RegiaoDao($this->db);
		
		$listaAreaAtuacao = $aaDao->buscarAreaAtuacaoVinculadaPorParametros($_REQUEST['modulo']);
		$listaCargo = $cDao->buscarCargoPorParametros();
		$listaFuncao = $fDao->buscarFuncaoPorParametros();
		$listaVinculoEmpregaticio = $veDao->buscarVinculoEmpregaticioPorParametros();
		$listaRegiao = $rDao->buscarRegiaoVinculadaPorParametros($_REQUEST['modulo']);
		
		include 'site/web/Vagas/pesquisarVagas.php';
	}	
	
	private function toJSON($result) {
		$json = array();
		$dateUtil = new DataUtil();
        
		$json['Empresa'] = $result->fields['Empresa'];
		$json['Requisicao'] = $result->fields['Requisicao'];
		$json['DataRequisicao'] = $dateUtil->formatar($result->fields['DataRequisicao']);
		
		$json['SituacaoRequisicao'] = $result->fields['SituacaoRequisicao'];
		$json['QuantidadeVagas'] = utf8_encode($result->fields['QuantidadeVagas']);
		
		$json['SalarioMaximo'] = utf8_encode($result->fields['SalarioMaximo']);			
		$json['Funcao'] = $result->fields['Funcao'];
		$json['NomeFuncao'] = utf8_encode($result->fields['nomeFuncao']);
		$json['Cargo'] = $result->fields['Cargo'];
		$json['NomeCargo'] = utf8_encode($result->fields['nomeCargo']);
		$json['AreaAtuacao'] = $result->fields['AreaAtuacao'];
		$json['NomeAreaAtuacao'] = utf8_encode($result->fields['nomeAreaAtuacao']);
		$json['VinculoEmpregaticio'] = $result->fields['VinculoEmpregaticio'];
		$json['NomeVinculoEmpregaticio'] = utf8_encode($result->fields['nomeVinculoEmpregaticio']);
		$json['Regiao'] = $result->fields['Regiao'];
		$json['NomeRegiao'] = $result->fields['NomeRegiao'];
		
		return $json;
	}
	
	function pesquisar() {
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();
		$requisicao = new Requisicao();
		
		$requisicao->Funcao = $_POST['Funcao'];
		$requisicao->Cargo = $_POST['Cargo'];
		$requisicao->AreaAtuacao = $_POST['AreaAtuacao'];
		$requisicao->Regiao = $_POST['Regiao'];
		$requisicao->VinculoEmpregaticio = $_POST['VinculoEmpregaticio'];
		if (isset($_POST['SalarioInicio']))
		$requisicao->SalarioInicio = $numberUtil->formatarSql($_POST['SalarioInicio']);
		if (isset($_POST['SalarioFim']))
		$requisicao->SalarioFim = $numberUtil->formatarSql($_POST['SalarioFim']);		
		
		if (isset($_POST['SituacaoRequisicaoAberta']))
		$requisicao->SituacaoRequisicaoAberta = $_POST['SituacaoRequisicaoAberta']; 
		if (isset($_POST['SituacaoRequisicaoSuspensa']))
		$requisicao->SituacaoRequisicaoSuspensa = $_POST['SituacaoRequisicaoSuspensa']; 
		if (isset($_POST['SituacaoRequisicaoEncerrada']))
		$requisicao->SituacaoRequisicaoEncerrada = $_POST['SituacaoRequisicaoEncerrada']; 
				
		$dao = new RequisicaoDao($this->db);		
		$result = $dao->buscarRequisicaoPorParametros($requisicao, $_REQUEST['local'], $this->entidade);
		$lista = array();	
		
		if (!is_null($result)){
			$i = 0;
			while (!$result->EOF) {
				
				$json = $this->toJSON($result);
				
				$lista[$i++] = $json;
				$result->MoveNext(); 
			}
		}
		
		echo json_encode($lista);
		
		exit;
	}
	
	function buscarVagasConcorridas() {
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();
		$requisicaoTurma = new RequisicaoTurma();
		$dao = new RequisicaoTurmaDao($this->db);
		
        $requisicaoTurma->Empresa = LoginModel::getEmpresaLogada();
		$requisicaoTurma->Pessoa = LoginModel::getPessoaLogada();
		
		$result = $dao->buscarRequisicoesTurmaPorParametros($requisicaoTurma, NULL, "buscarVagasConcorridas", "S");
		$lista = array();	
		
		if (!is_null($result)){
			$i = 0;
			while (!$result->EOF) {
				
				$json = $this->toJSON($result);
				
				$lista[$i++] = $json;
				$result->MoveNext(); 
			}
		}
		
		echo json_encode($lista);
		
		exit;
	}
    
	function detalharVagaConsulta() {
		$requisicao = new Requisicao();
		
		$dao = new RequisicaoDao($this->db);		
		$requisicao = $dao->buscarRequisicaoPorPk($_POST['Requisicao']);
		$requisicao->MoveFirst();
		
		$requisicaoTurma = new RequisicaoTurma();
		$dao = new RequisicaoTurmaDao($this->db);
		
		$requisicaoTurma->Empresa = LoginModel::getEmpresaLogada();
		$requisicaoTurma->Pessoa = LoginModel::getPessoaLogada();
		$requisicaoTurma->Requisicao = $requisicao->fields['Requisicao'];
		
		$requisicoesTurma = $dao->buscarRequisicoesTurmaPorParametros($requisicaoTurma);       
		
		if ($requisicoesTurma != null) $requisicoesTurma->MoveFirst();       
		
		include 'site/web/Vagas/detalheVagasConsulta.php';
		
		exit;
	}    

	function detalharVaga() {
		$requisicao = new Requisicao();
		
		$dao = new RequisicaoDao($this->db);		
		$requisicao = $dao->buscarRequisicaoPorPk($_POST['Requisicao']);
		$requisicao->MoveFirst();
		
		$requisicaoTurma = new RequisicaoTurma();
		$dao = new RequisicaoTurmaDao($this->db);
		
		$requisicaoTurma->Empresa = LoginModel::getEmpresaLogada();
		$requisicaoTurma->Pessoa = LoginModel::getPessoaLogada();
		$requisicaoTurma->Requisicao = $requisicao->fields['Requisicao'];
		
		$requisicoesTurma = $dao->buscarRequisicoesTurmaPorParametros($requisicaoTurma, null, null, $_POST['CandidatoInscrito']);       
		
		if ($requisicoesTurma != null) $requisicoesTurma->MoveFirst();
        
        $vagasConcorridas = $dao->getQuantidadeVagasConcorridas($requisicaoTurma);
		
		include 'site/web/Vagas/detalheVagas.php';
		
		exit;
	}
	
	function registrar(){
		$requisicaoTurma = new RequisicaoTurma();
		$dao = new RequisicaoTurmaDao($this->db);
		
		$requisicaoTurma->Empresa = LoginModel::getEmpresaLogada();
		$requisicaoTurma->Pessoa = LoginModel::getPessoaLogada();
		$requisicaoTurma->Requisicao = $_POST['requisicao'];
        $requisicaoTurma->DataInscricao = date("Y-m-d");           
        $requisicaoTurma->CandidatoInscrito = "S";           
				
        if ($requisicaoTurma->validaTamanhoCampos()){     
            if ($dao->candidatoExiste($requisicaoTurma)){
                $requisicaoTurma = $dao->atualizarRequisicaoTurma($requisicaoTurma);		                
            }
            else{
		        $requisicaoTurma = $dao->criarRequisicaoTurma($requisicaoTurma);		
            }
		    echo "Obrigado! Sua candidatura foi registrada com sucesso.";
        }
	}
    
    function remover(){
		$dao = new RequisicaoTurmaDao($this->db);
		$dao->removerCandidatoInscrito(LoginModel::getEmpresaLogada(), LoginModel::getPessoaLogada(), $_POST['requisicao']);             
	}
	
}
?>