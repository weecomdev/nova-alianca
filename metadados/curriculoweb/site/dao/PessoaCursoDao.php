<?php

class PessoaCursoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarProximaSequencia(PessoaCurso $pessoaCurso) {
		
		$sql = "select max(NroOrdem) + 1 as proxima from rhpessoacursosrs ";
		$sql .= "where Empresa = ?";
		$sql .= " and Pessoa = ?";
			
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->Empresa);

		$result = $this->db->Execute($query,array($pEmpresa,$pPessoa));
		
		if ($result->fields['proxima'] != "")		
			return $result->fields['proxima'];
			
		return 1;       
        
		/*$sql = "select max(NroOrdem) + 1 as proxima from rhpessoacursosrs ";
		$sql .= "where Empresa = ? ";
		$sql .= " and Pessoa = ? ";        
        
        $result = $this->db->execute($sql, [$pessoaCurso->Empresa, $pessoaCurso->Pessoa]);   
        
        //$stmt = mysqli_prepare($con, $sql);
        //mysqli_stmt_bind_param($stmt, "si", $pessoaCurso->Empresa, $pessoaCurso->Pessoa);
        //$result = mysqli_stmt_execute($stmt);
        $query = $this->db->query($sql);
        $dados = $query->mysqli_fetch_array();
		
		if ($result->fields['proxima'] != "")		
			return $result->fields['proxima'];
        
		return 1;       */
	}
	
	function buscarPessoaCursoPorPK(PessoaCurso $pessoaCurso) {
		
		$sql = "select  pc.*,c.descricao50 as Nm_Curso , tp.TipoCurso , tp.descricao40 as DescTpCurso from rhpessoacursosrs pc ";		
		$sql .= " 	left join rhcursos c on pc.Curso = c.Curso ";
		$sql .= "   left join rhtiposcurso  tp on tp.tipocurso = c.tipocurso ";
		$sql .= "where empresa = ? ";
		$sql .= " and pessoa = ? ";
		$sql .= " and nroordem = ? ";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '',$pessoaCurso->Empresa);
		$pNumeroOrdem =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->NroOrdem);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pNumeroOrdem));
	}
	
	function buscarPessoaCursoPorParametros(PessoaCurso $pessoaCurso) {
				
		$sql .= " select pc.*, c.descricao50 as Nm_Curso ,tp.TipoCurso , tp.descricao40 as DescTpCurso "; 
		$sql .= " from rhpessoacursosrs pc ";
		$sql .= " 	left join rhcursos c on pc.Curso = c.Curso ";
		$sql .= "   left join rhtiposcurso  tp on tp.tipocurso = c.tipocurso ";
		$sql .= " where empresa = ? ";
		$sql .= " 	and pessoa = ? ";
		
		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->Empresa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));
	}
	
	function buscarPessoaCursosRsParametros(Pessoa $pessoa) {
        $sql = "select * from rhpessoacursosrs ";		
		$sql .= " where ";
        $sql .= " rhpessoacursosrs.empresa = ?";
        $sql .= " and rhpessoacursosrs.pessoa = ?";

		$query = $this->db->prepare($sql);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Pessoa);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoa->Empresa);
		
		return $this->db->Execute($query,array($pEmpresa,$pPessoa));        
		
	}
	

	private function prepareStatement(PessoaCurso $pessoaCurso) {
		
		$statement = array();
		$c = 0;
		$v = 0;
				
		if (!is_null($pessoaCurso->Empresa)) {
			$columns[$c++] = "Empresa";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoaCurso->Empresa));
		}
			
		if (!is_null($pessoaCurso->Pessoa)) {
			$columns[$c++] = "Pessoa";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaCurso->Pessoa));
		}
			
		if (!is_null($pessoaCurso->NroOrdem)) {
			$columns[$c++] = "NroOrdem";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaCurso->NroOrdem));
		}
			
		if (!is_null($pessoaCurso->Curso)) {
			$columns[$c++] = "Curso";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaCurso->Curso));
		}
		
		// se o curso for 0000 é um curso que não existe
		if ($pessoaCurso->Curso == "" || $pessoaCurso->Curso == null) {
			// grava o valor do campo que o usuario digitar 
			if (!is_null($pessoaCurso->Descricao50)) {
				$columns[$c++] = "Descricao50";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaCurso->Descricao50));
			}				
		}
		
		if (!is_null($pessoaCurso->Descricao40)) {
			$columns[$c++] = "Descricao40";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaCurso->Descricao40));
		}
			
		if (!is_null($pessoaCurso->Car_Horaria)) {
			$columns[$c++] = "Car_Horaria";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaCurso->Car_Horaria));
		}
			
		if (!is_null($pessoaCurso->Dt_Inicio)) {
			$columns[$c++] = "Dt_Inicio";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($pessoaCurso->Dt_Inicio));
		}
		
		if (!is_null($pessoaCurso->Dt_Encerra)) {
			$columns[$c++] = "Dt_Encerra";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($pessoaCurso->Dt_Encerra));
		}
			
		$columns[$c++] = "OrigemCurriculo";
		$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($pessoaCurso->OrigemCurriculo));
		
		$statement[0] = $columns;
		$statement[1] = $values;
		
		return $statement;
		
	}
	
	function criarPessoaCurso(PessoaCurso $pessoaCurso) {
		
		$statement = $this->prepareStatement($pessoaCurso);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhpessoacursosrs(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	
	function alterarPessoaCurso(PessoaCurso $pessoaCurso) {
		$sql = " update rhpessoacursosrs set ";		
		if ($pessoaCurso->Curso != "" &&  $pessoaCurso->Curso != null)
		{
			$sql .= " curso = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaCurso->Curso)).",";
		}	
		$sql .= " descricao50 = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaCurso->Descricao50))." ";
		$sql .= " ,descricao40 = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaCurso->Descricao40))." ";
		$sql .= " ,car_horaria = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaCurso->Car_Horaria))."";
		if (trim($pessoaCurso->Dt_Inicio) != "") {
			$sql .= " ,dt_inicio = ".preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoaCurso->Dt_Inicio))."";
		}
		else{
			$sql .= " ,dt_inicio = null ";
		}
		if (trim($pessoaCurso->Dt_Encerra) != "") {
			$sql .= " ,dt_encerra = ".preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoaCurso->Dt_Encerra))."";
		}
		else{
			$sql .= " ,dt_encerra = null ";
		}
		$sql .= " where empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaCurso->Empresa))." ";	
		$sql .= " and pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaCurso->Pessoa))." ";
		$sql .= " and nroordem = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoaCurso->NroOrdem))." ";
			
		$query = $this->db->prepare($sql);
		
        return $this->db->Execute($query);
	}
	
	function excluirPessoaCurso(PessoaCurso $pessoaCurso) {

		$sql = "DELETE FROM rhpessoacursosrs WHERE 1=1 ";
		$sql .= " and empresa = ?";
		$sql .= " and pessoa = ? ";
		$sql .= " and nroordem = ? ";
		
		$query = $this->db->prepare($sql);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->Empresa);
		$pPessoa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->Pessoa);
		$pNumeroOrdem =  preg_replace('#[^\pL\pN./\' -]+# ', '', $pessoaCurso->NroOrdem);
		
        return $this->db->Execute($query,array($pEmpresa,$pPessoa,$pNumeroOrdem));
		
	}
			
}

?>