<?php
/**
 * Classe responsável por tratar as requisições de entrada no sistema para consulta de vagas.
 *
 *  - Formulário de consulta.
 */
class EntradaConsultaController {

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
		if ($this->acao == "inicial"){
			$this->inicial();
        }
		else{
			$this->entradaConsulta();
        }           		
	}	

    
    private function entradaConsulta() {     
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
        
        $webConfDao = new CandidatosWebConfDao($this->db);
        $configObj = new Config($this->db, $webConfDao->buscaEmpresaPrincipal());                
        $diretrizTipoDeFiltro = $configObj->getValorDiretriz('filtrarVagasPorAreaOuRegiao');
        
        if($diretrizTipoDeFiltro == 1){
            $aaDao = new AreaAtuacaoDao($this->db);
            $listaAreaAtuacao = $aaDao->buscarAreaAtuacaoVinculadaPorParametros($_REQUEST['modulo']);                       
        }
        else if($diretrizTipoDeFiltro == 2){
            $rDao = new RegiaoDao($this->db);                
            $listaRegiao = $rDao->buscarRegiaoVinculadaPorParametros($_REQUEST['modulo']);	                
        }

		include 'pages/entradaConsulta.php';
	}		
	
	/**
     * Método que será chamado para direcionar para a Entrada do sistema.
     */
	private function inicial() {        
        include 'pages/entrada.php';
	}
}
?>