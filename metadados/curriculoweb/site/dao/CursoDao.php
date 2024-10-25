<?php

class CursoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarCursoPorParametros( ) {
		
		$sql = "select * from rhcursos  ORDER BY Descricao50";
		
		return $this->db->Execute($sql);
	}
	
	private function prepareStatement(Curso $curso) {
        $statement = array();
        $c = 0;
        $v = 0;
        
        if (!is_null($curso->Curso)){
                $columns[$c++] = "Curso";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->Curso));
        }
        
        if (!is_null($curso->Descricao50)){
                $columns[$c++] = "Descricao50";
				$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr(str_replace('#aspaSimples', '&lsquo;', $curso->Descricao50)));
        }
        
        if (!is_null($curso->ProgramaCurso)){
                $columns[$c++] = "ProgramaCurso";
				$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr(str_replace('#aspaSimples', '&lsquo;', $curso->ProgramaCurso)));
        }
        
        if (!is_null($curso->DataCriacao)){
                $columns[$c++] = "DataCriacao";
			    $values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($curso->DataCriacao));
        }
        
        if (!is_null($curso->DataDesativacao)){
                $columns[$c++] = "DataDesativacao";
			    $values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($curso->DataDesativacao));
        }
        
        if (!is_null($curso->Validade)){
                $columns[$c++] = "Validade";
				$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($curso->Validade));
        }
        
        if (!is_null($curso->CarHoraria)){
                $columns[$c++] = "Car_Horaria";
				$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($curso->CarHoraria));
        }
        
        if (!is_null($curso->TipoLocal)){
                $columns[$c++] = "Tipo_Local";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->TipoLocal));
        }
        
        if (!is_null($curso->TipoCurso)){
			    $columns[$c++] = "TipoCurso";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($curso->TipoCurso));
        }
        
        if (!is_null($curso->UltimaRevisaoExigida)){
                $columns[$c++] = "UltimaRevisaoExigida";
				$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($curso->UltimaRevisaoExigida));
        }
        
        if (!is_null($curso->UltDtRevisaoExigida)){
                $columns[$c++] = "UltDt_RevisaoExigida";				
				$values[$v++] =  preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($curso->UltDtRevisaoExigida));
        }
        
        if (!is_null($curso->ClassificacaoCurso)){
                $columns[$c++] = "ClassificacaoCurso";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->ClassificacaoCurso));
        }
        
        if (!is_null($curso->TextoOLE)){
                $columns[$c++] = "TextoOLE";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->TextoOLE));
        }
        
        if (!is_null($curso->UsaModulo10)){
                $columns[$c++] = "UsaModulo10";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->UsaModulo10));
        }
        
        if (!is_null($curso->AvaliarReacao)){
                $columns[$c++] = "AvaliarReacao";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->AvaliarReacao));
        }
        
        if (!is_null($curso->AvaliarPreTeste)){
                $columns[$c++] = "AvaliarPreTeste";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->AvaliarPreTeste));
        }
        
        if (!is_null($curso->AvaliarEficacia)){
                $columns[$c++] = "AvaliarEficacia";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->AvaliarEficacia));
        }
        
        if (!is_null($curso->AvaliarPosTeste)){
                $columns[$c++] = "AvaliarPosTeste";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->AvaliarPosTeste));
        }
        
        if (!is_null($curso->QuestionarioPre)){
                $columns[$c++] = "QuestionarioPre";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->QuestionarioPre));
        }
        
        if (!is_null($curso->QuestionarioPos)){
                $columns[$c++] = "QuestionarioPos";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->QuestionarioPos));
        }
        
        if (!is_null($curso->ObjetivoCurso)){
                $columns[$c++] = "ObjetivoCurso";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($curso->ObjetivoCurso));
        }
        
        if (!is_null($curso->GrauInstrucaoAndamento)){
                $columns[$c++] = "GrauInstrucaoAndamento";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->GrauInstrucaoAndamento));
        }
        
        if (!is_null($curso->GrauInstrucaoConcluido)){
                $columns[$c++] = "GrauInstrucaoConcluido";
				$values[$v++] =   preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->GrauInstrucaoConcluido));
        }
        
        if (!is_null($curso->Fornecedor)){
                $columns[$c++] = "Fornecedor";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($curso->Fornecedor));
        }

        $statement[0] = $columns;
        $statement[1] = $values;
        
        return $statement;
	}

    function criarCurso(Curso $curso) {
		$statement = $this->prepareStatement($curso);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhcursos(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";

        return $this->db->Execute($sql);
	}
	function excluirCurso() {
		$sql = "delete from rhcursos ";
		return $this->db->Execute($sql);
	}
}

?>