<?php
class PessoaRequisitoController {
	
	public function __construct($db, $metodo) {
		$this->db = $db;
		
		if ($metodo)
			$this->$metodo();
		else
			$this->abrir();
	}
	
	function abrir() {
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();
		
		$escalaRequisitoDao = new EscalaRequisitoDao($this->db);
		$requisitoDao = new RequisitoDao($this->db);
		$listaRequisitos = $requisitoDao->buscarRequisitosPorParametros();
		
		$pessoaRequisito = new PessoaRequisito();
		//$pessoaRequisito->Empresa = 1; //dados da sessão
		$pessoaRequisito->Pessoa = $_SESSION["PessoaLogada"]; //dados da sessão
		
		$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
		$listaRequisitosPessoa = $pessoaRequisitoDao->buscarPessoaRequisitoPorPK($pessoaRequisito);
		
		
		$requisitosWebObr = new RequisitoWebObrDao($this->db); 
		$listaRequisitosObr = $requisitosWebObr->buscarRequisitoObr();
		
		include 'site/web/MeuCurriculo/requisitos.php';		
	}
	
	function salvar() {
		$numberUtil = new NumberUtil();
		$dateUtil = new DataUtil();
		
		$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
		$requisitoDao = new RequisitoDao($this->db);
		//$result = $requisitoDao->buscarRequisitosPorParametros();	
		
		foreach ($_POST as $key => $value) {
			echo $key . "=" . $value."<BR>";
			$pessoaRequisito = new PessoaRequisito();
			$pessoaRequisito->Empresa = $_SESSION["Empresa"]; //dados da sessão
			$pessoaRequisito->Pessoa = $_SESSION["PessoaLogada"]; //dados da sessão
			if ( ($pos = strpos($key, "requisito") ) > -1 ){
				$keyRequisito = substr($key, $pos+9, strlen($key));
				$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
				
				$pessoaRequisito->Requisito = $keyRequisito;
				$result = $pessoaRequisitoDao->buscarPessoaRequisitoPorPK($pessoaRequisito);
				
				if ($result->RecordCount() == 1) {
					echo "alterar";
					if ($result->fields['TipoRequisito'] == "AV"){
						$pessoaRequisito->Item_Avaliacao = $value;								
					} else if ($result->fields['TipoRequisito'] == "TX"){
						$pessoaRequisito->TextoRequisito = utf8_decode($value);
					} else if ($result->fields['TipoRequisito'] == "QT"){
						$pessoaRequisito->QuantidadeRequisito = $numberUtil->formatarSql($value);
					}
                    if ($pessoaRequisito->validaTamanhoCampos())
					    $this->alterar($pessoaRequisito);
				} else {
					
					$listaRequisito = $requisitoDao->buscarRequisitosPorParametros($keyRequisito);
					$listaRequisito->MoveFirst();
					echo "criar".$listaRequisito->fields['TipoRequisito'] ;
					if ($listaRequisito->fields['TipoRequisito'] == "AV"){
						$pessoaRequisito->Item_Avaliacao = $value;
				
					} else if ($listaRequisito->fields['TipoRequisito'] == "TX"){
						$pessoaRequisito->TextoRequisito = utf8_decode($value);
					} else if ($listaRequisito->fields['TipoRequisito'] == "QT"){
						$pessoaRequisito->QuantidadeRequisito = $value;
					}
                    if ($pessoaRequisito->validaTamanhoCampos())
					    $this->criar($pessoaRequisito);
				}
			}
		}
	}
	
	function criar(PessoaRequisito $pessoaRequisito) {
		
		$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
        if ($pessoaRequisito->validaTamanhoCampos())        
		    $pessoaRequisitoDao->criarPessoaRequisito($pessoaRequisito);

	}
	
	function alterar(PessoaRequisito $pessoaRequisito) {
		
		$pessoaRequisitoDao = new PessoaRequisitoDao($this->db);
        if ($pessoaRequisito->validaTamanhoCampos())      
		    $pessoaRequisitoDao->alterarPessoaRequisito($pessoaRequisito);
		
	}	
}

?>