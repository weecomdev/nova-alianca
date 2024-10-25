<?php

class InformacaoAdicionalDao{
	
	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL){
		$this->db = $db;
	}
	
	function buscaVariaveisPorParametros(Variavel $variavel = NULL){
		$sql = " SELECT * FROM rhvariaveis ";
		
		return $this->db->Execute($sql);
	}
	
	function buscaRequisitosPorParametros($requisito = NULL){
		$sql = " SELECT * FROM rhrequisitos ";
		$sql .= " LEFT JOIN rhmedidas ON (rhrequisitos.Medida = rhredidas.Medida) ";
		$sql .= " WHERE 1=1 ";
		
		if(!is_null($requisito)){
			$sql .= " AND rhrequisitos.Requisito = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito));
		}
		
		$query = $this->db->prepare($sql);	
		return $this->db->Execute($query);
		
	}
	
	function buscaVariaveisRequisitos(){
				
		
		$sql = "SELECT '1' Tipo ,'' Requisito, Variavel, Descricao80, TipoCampo, '' TipoRequisito, TamanhoCampo, NroDecimais, TabelaOrigem, '' Avaliacao, TabelaDescricao, CampoChave, CampoDescricao, TabelaOrigemFutura, CampoTabela, CampoTabelaFutura
			    FROM rhvariaveis
				UNION SELECT '2' Tipo, rhrequisitos.Requisito, '' Variavel, rhrequisitos.Descricao80, '', rhrequisitos.TipoRequisito, rhrequisitos.ImprimirCurriculo, rhmedidas.NroDecimais, rhrequisitos.SolicitarFicha, rhrequisitos.Avaliacao, rhrequisitos.Medida, rhrequisitos.ClasseRequisito, '', '', '', ''
				FROM rhrequisitos
				LEFT OUTER JOIN rhmedidas on 
				 	rhrequisitos.Medida = rhmedidas.Medida		
				ORDER BY 4";		
				
		return $this->db->Execute($sql);
		
	}
	
    private function prepareStatementVariavel(Variavel $variavel) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($variavel->Variavel)){
                $columns[$c++] = "Variavel";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->Variavel));
        }

        if (!is_null($variavel->Descricao40)){
                $columns[$c++] = "Descricao40";
                $values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($variavel->Descricao40));				
        }

        if (!is_null($variavel->TipoCampo)){
                $columns[$c++] = "TipoCampo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TipoCampo));
        }

        if (!is_null($variavel->TamanhoCampo)){
                $columns[$c++] = "TamanhoCampo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TamanhoCampo));
        }

        if (!is_null($variavel->NroDecimais)){
                $columns[$c++] = "NroDecimais";
				$values[$v++] = preg_replace('#[^\pL\pN./\'., -]+#', '', $this->db->qstr($variavel->NroDecimais));
        }

        if (!is_null($variavel->TabelaOrigem)){
                $columns[$c++] = "TabelaOrigem";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TabelaOrigem));
        }

        if (!is_null($variavel->TabelaDescricao)){
                $columns[$c++] = "TabelaDescricao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TabelaDescricao));
        }

        if (!is_null($variavel->CampoChave)){
                $columns[$c++] = "CampoChave";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoChave));
        }

        if (!is_null($variavel->CampoDescricao)){
                $columns[$c++] = "CampoDescricao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoDescricao));
        }

        if (!is_null($variavel->TabelaOrigemFutura)){
                $columns[$c++] = "TabelaOrigemFutura";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->TabelaOrigemFutura));
        }

        if (!is_null($variavel->CampoTabela)){
                $columns[$c++] = "CampoTabela";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoTabela));
        }


        if (!is_null($variavel->CampoTabelaFutura)){
                $columns[$c++] = "CampoTabelaFutura";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->CampoTabelaFutura));
        }
        
        if (!is_null($variavel->Descricao80)){
            $columns[$c++] = "Descricao80";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($variavel->Descricao80));			
        }        

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
    private function prepareStatementRequisito(Requisito $requisito) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($requisito->Requisito)){
                $columns[$c++] = "Requisito";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->Requisito));
        }
        if (!is_null($requisito->Descricao80)){
                $columns[$c++] = "Descricao80";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->Descricao80));
        }
        if (!is_null($requisito->TipoRequisito)){
                $columns[$c++] = "TipoRequisito";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->TipoRequisito));
        }
        if (!is_null($requisito->ImprimirCurriculo)){
                $columns[$c++] = "ImprimirCurriculo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->ImprimirCurriculo));
        }
        if (!is_null($requisito->SolicitarFicha)){
                $columns[$c++] = "SolicitarFicha";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->SolicitarFicha));
        }
        if (!is_null($requisito->Avaliacao)){
                $columns[$c++] = "Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->Avaliacao));
        }
        if (!is_null($requisito->Medida)){
                $columns[$c++] = "Medida";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->Medida));
        }
        if (!is_null($requisito->ClasseRequisito)){
                $columns[$c++] = "ClasseRequisito";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito->ClasseRequisito));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;
        
        return $statement;
   } 
	
	function criaVariavel(Variavel $variavel= NULL){
		$statement = $this->prepareStatementVariavel($variavel);
		
		$columns = $statement[0];
		$values = $statement[1];
		
		$sql = " INSERT IGNORE INTO rhvariaveis (";
		$sql .= implode(', ', $columns) . ") VALUES ( ";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);
	}
	
	function criaRequisito(Requisito $requisito = NULL){
		$statement = $this->prepareStatementRequisito($requisito);
		
		$columns = $statement[0];
		$values = $statement[1];
		
		$sql = " INSERT IGNORE INTO rhrequisitos (";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);
	}
	
	function excluirVariavel(){
		$sql = " DELETE FROM rhvariaveis ";
		return $this->db->Execute($sql);
	}
	
	function excluirRequisito(){
		$sql = " DELETE FROM rhrequisitos ";
		return $this->db->Execute($sql);
	}
}
?>