<?php

class PessoaDadoComplementarDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarPessoasDadosComplIdiomaPorParametros(Pessoa $pessoa) {
        $sql = "select * from rhpessoasdadoscompl where ";		
		$sql .= " rhpessoasdadoscompl.empresa = ?";
        $sql .= " and rhpessoasdadoscompl.pessoa = ? ";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));
		
	}
		
	function buscarPessoaDadoComplementarPorPK(PessoaDadoComplementar $pessoaDadoComplementar) {
		
		$sql = "select * from rhpessoasdadoscompl ";
		$sql .= " where Empresa = ? and Pessoa = ?";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaDadoComplementar->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '',$pessoaDadoComplementar->Empresa);
				
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));	
	}
	
	function buscaListaVariavel($tipoVariavel) {
		
		$listaVariavel = array('TEXTOLIVRE1','TEXTOLIVRE2','TEXTOLIVRE3','TEXTOLIVRE4','TEXTOLIVRE5','TEXTOLIVRE6','MEMOLIVRE1','MEMOLIVRE2','MEMOLIVRE3','MEMOLIVRE4','MEMOLIVRE5','MEMOLIVRE6');
		
		if (in_array($tipoVariavel, $listaVariavel))
		{
			return true;
		}
		else
        {
			return false;
        }
	}
	
	private function prepareStatement(PessoaDadoComplementar $pessoaDadoComplementar) {
		
		$statement = array();
		
		$array = $pessoaDadoComplementar->Campos;
				
		for ($i = 0; $i < sizeof($array); $i++) {
		
			if ($this->buscaListaVariavel($array[$i][0]))
			{
				$values[$i] = "'".str_replace(array('{','}','[',']','<','>','=','"','\''),'',$array[$i][1])."'";
			}
			else
            {
				$values[$i] = "'".$array[$i][1]."'";	
            }
							
			$columns[$i] = $array[$i][0];
		}
		
		$columns[$i] = "Empresa";
		$values[$i] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaDadoComplementar->Empresa));
		
        $i = $i + 1;
		
		$columns[$i] = "Pessoa";
		$values[$i] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaDadoComplementar->Pessoa));

		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
	}
	
	function criarPessoaDadoComplementar(PessoaDadoComplementar $pessoaDadoComplementar) {
		
		$statement = $this->prepareStatement($pessoaDadoComplementar);
		$columns = $statement[0]; 
		$values = $statement[1];        
		
		$sql = "INSERT INTO rhpessoasdadoscompl(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
			
		return $this->db->Execute($sql);		
	}
	
	function alterarPessoaDadoComplementar(PessoaDadoComplementar $pessoaDadoComplementar) {
		
		$sql = "update rhpessoasdadoscompl set ";
				
		$array = $pessoaDadoComplementar->Campos;
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		for ($i = 0; $i < sizeof($array); $i++) {
					
			
			if(trim($array[$i][1]) == ""){
				$sql .= $array[$i][0] . " = null ";
			}
			Else
			{
				if ($this->buscaListaVariavel(strtoupper($array[$i][0])))
				{
					$sql .= $array[$i][0] . " = '" . str_replace(array('{','}','[',']','<','>','=','"','\''),'', $this->db->qstr($array[$i][1])) . "'";
				}
				else
                {
					$sql .= $array[$i][0] . " = " . $this->db->qstr($array[$i][1]) . "";
                }
			}
			if ($i < sizeof($array) - 1 ) {
				$sql .= ", ";
			}
		}		
		
		$sql .= " where empresa = ? ";
		$sql .= " and pessoa =  ? " ;
			
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaDadoComplementar->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaDadoComplementar->Empresa);
				
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));
			
	}
}
?>