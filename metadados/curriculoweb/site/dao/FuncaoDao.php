<?php

class FuncaoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarFuncaoPorParametros() {
		
		$sql = "select * from rhfuncoes order by descricao40 ";

		return $this->db->Execute($sql);
		
	}	
	
	private function prepareStatement(Funcao $funcao) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($funcao->Funcao)){
                $columns[$c++] = "Funcao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->Funcao));
        }

        if (!is_null($funcao->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($funcao->Descricao40));
        }

        if (!is_null($funcao->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($funcao->Descricao20));
        }

        if (!is_null($funcao->Cargo)){
                $columns[$c++] = "Cargo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->Cargo));
        }
        if (!is_null($funcao->CBO)){
                $columns[$c++] = "CBO";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->CBO));
        }

        if (!is_null($funcao->CBONovo)){
                $columns[$c++] = "CBONovo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->CBONovo));
        }
        if (!is_null($funcao->PlanoCargo)){
                $columns[$c++] = "PlanoCargo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->PlanoCargo));
        }

        if (!is_null($funcao->FaixaSalarial)){
                $columns[$c++] = "FaixaSalarial";
				$values[$v++] = preg_replace('/[^\p{L}\'0-9\-.,: ]/u', '', $this->db->qstr($funcao->FaixaSalarial));
        }
        if (!is_null($funcao->ClasseSalarial)){
                $columns[$c++] = "ClasseSalarial";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->ClasseSalarial));
        }

        if (!is_null($funcao->RequisitosFuncaoPPP)){
                $columns[$c++] = "RequisitosFuncaoPPP";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->RequisitosFuncaoPPP));
        }
        if (!is_null($funcao->DescAtividadesPPP)){
                $columns[$c++] = "DescAtividadesPPP";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->DescAtividadesPPP));
        }

        if (!is_null($funcao->ConstarPPP)){
                $columns[$c++] = "ConstarPPP";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->ConstarPPP));
        }
        if (!is_null($funcao->FatorRequisito)){
                $columns[$c++] = "FatorRequisito";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->FatorRequisito));
        }

        if (!is_null($funcao->FatorDescricao)){
                $columns[$c++] = "FatorDescricao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->FatorDescricao));
        }
        if (!is_null($funcao->TextoOLE)){
                $columns[$c++] = "TextoOLE";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->TextoOLE));
        }

        if (!is_null($funcao->GrauInstrucao)){
                $columns[$c++] = "GrauInstrucao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->GrauInstrucao));
        }
        if (!is_null($funcao->AtivaDesativada)){
                $columns[$c++] = "AtivaDesativada";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->AtivaDesativada));
        }

        if (!is_null($funcao->GrauInstrucaoMaximo)){
                $columns[$c++] = "GrauInstrucaoMaximo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->GrauInstrucaoMaximo));
        }
        if (!is_null($funcao->MaodeObra)){
                $columns[$c++] = "MaodeObra";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($funcao->MaodeObra));
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
	function criarFuncao(Funcao $funcao) {
		$statement = $this->prepareStatement($funcao);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhfuncoes(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);	
	}	
	function excluirFuncao() {
		$sql = "delete from rhfuncoes ";
		return $this->db->Execute($sql);
	}
}
?>