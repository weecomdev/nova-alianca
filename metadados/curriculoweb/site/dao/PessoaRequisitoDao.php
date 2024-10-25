<?php

class PessoaRequisitoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarPessoaRequisitosPorParametros(Pessoa $pessoa) {
        $sql = "select * from rhpessoarequisitos where ";
        $sql .= " rhpessoarequisitos.empresa = ?";
        $sql .= " and rhpessoarequisitos.pessoa = ?";		
		
        $query = $this->db->prepare($sql);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));	
	}
	
	
	function buscarPessoaRequisitoPorPK(PessoaRequisito $pessoaRequisito) {
		
		$ListaQuery = array();
		$sql = "SELECT * FROM rhpessoarequisitos ";
		$sql .= " INNER JOIN rhrequisitos ON (rhrequisitos.Requisito = rhpessoarequisitos.Requisito) ";
		$sql .= " WHERE rhpessoarequisitos.Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaRequisito->Pessoa))."";
		
		if (!is_null($pessoaRequisito->Requisito))
		{
			$sql .= " AND rhpessoarequisitos.Requisito = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaRequisito->Requisito))."";
		}
		$query = $this->db->prepare($sql);
		
		return $this->db->Execute($query);
	}
	
	function buscarRequisito($requisito) {
		
		$sql = "SELECT * FROM rhrequisitos ";
		$sql .= " WHERE rhrequisitos.Requisito = ? ";
		$query = $this->db->prepare($sql);
		$pRequisito = preg_replace('#[^\pL\pN./\' -]+# ', '', $requisito); 		
		return $this->db->Execute($query,$pRequisito)->fields['TipoRequisito'];
	}
	
	
	private function prepareStatement(PessoaRequisito $pessoaRequisito) {
		$statement = array();
		$c=0;
		$v=0;
		
		$columns[$c++] = "Empresa";
		$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaRequisito->Empresa));
		
		$columns[$c++] = "Pessoa";
		$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaRequisito->Pessoa));
		
		if (!is_null($pessoaRequisito->Requisito)){
			$columns[$c++] = "Requisito";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaRequisito->Requisito));
		}
		
		if (!is_null($pessoaRequisito->QuantidadeRequisito)){
			$columns[$c++] = "QuantidadeRequisito";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaRequisito->QuantidadeRequisito));
		}
		
		if (!is_null($pessoaRequisito->TextoRequisito)){
			$columns[$c++] = "TextoRequisito";
			if (trim($this->buscarRequisito($pessoaRequisito->Requisito)) == 'TX')
			{
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'', $this->db->qstr($pessoaRequisito->TextoRequisito));
			}
			else
		    {
			$values[$v++] = $this->db->qstr($pessoaRequisito->TextoRequisito);
			}	
         }
		 
		if (!is_null($pessoaRequisito->Item_Avaliacao)){
			$columns[$c++] = "Item_Avaliacao";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaRequisito->Item_Avaliacao));
		}

		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	function criarPessoaRequisito(PessoaRequisito $pessoaRequisito) {
		
		$statement = $this->prepareStatement($pessoaRequisito);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhpessoarequisitos (";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";

		return $this->db->Execute($sql);		
	}
	
	function alterarPessoaRequisito(PessoaRequisito $pessoaRequisito) {
		$sql = "UPDATE rhpessoarequisitos SET ";

		if (!is_null($pessoaRequisito->QuantidadeRequisito)){
			$sql .= " QuantidadeRequisito = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaRequisito->QuantidadeRequisito))."";
		}
		
		if (!is_null($pessoaRequisito->TextoRequisito)){
			$sql .= " TextoRequisito = ". preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaRequisito->TextoRequisito))."";
		}
		
		if (!is_null($pessoaRequisito->Item_Avaliacao)){
			$sql .= " Item_Avaliacao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaRequisito->Item_Avaliacao))."";
		}
		
		$sql .= " WHERE Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaRequisito->Pessoa))." AND Requisito = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaRequisito->Requisito))."";
		
		
		$query = $this->db->prepare($sql);
		
		return $this->db->Execute($query);	

	}
}
?>