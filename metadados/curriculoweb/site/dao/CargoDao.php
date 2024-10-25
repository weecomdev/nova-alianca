<?php

class CargoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarCargoPorParametros() {
		
		$sql = "select * from rhcargos order by descricao40 ";

		return $this->db->Execute($sql);
	}

	private function prepareStatement(Cargo $cargo) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($cargo->Cargo)){
                $columns[$c++] = "Cargo";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($cargo->Cargo));
        }

        if (!is_null($cargo->Descricao40)){
                $columns[$c++] = "Descricao40";
			    $values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($cargo->Descricao40));
        }

        if (!is_null($cargo->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($cargo->Descricao20));
        }

        if (!is_null($cargo->DescricaoOficial)){
                $columns[$c++] = "DescricaoOficial";
			    $values[$v++] =   str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($cargo->DescricaoOficial));
        }

        if (!is_null($cargo->CBO)){
                $columns[$c++] = "CBO";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($cargo->CBO));
        }

        if (!is_null($cargo->CBONovo)){
                $columns[$c++] = "CBONovo";
			    $values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->CBONovo));
        }

        if (!is_null($cargo->CodigoOcupacaoIR)){
                $columns[$c++] = "CodigoOcupacaoIR";
			    $values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->CodigoOcupacaoIR));
        }

        if (!is_null($cargo->PlanoCargo)){
                $columns[$c++] = "PlanoCargo";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->PlanoCargo));
        }

         if (!is_null($cargo->FaixaSalarial)){
                $columns[$c++] = "FaixaSalarial";
				$values[$v++] =  preg_replace('#[^\pL\pN./\'. -]+#', '', $this->db->qstr($cargo->FaixaSalarial));
        }

         if (!is_null($cargo->ClasseSalarial)){
                $columns[$c++] = "ClasseSalarial";
			   $values[$v++] =  preg_replace('#[^\pL\pN./\'. -]+#', '', $this->db->qstr($cargo->ClasseSalarial));
        }

         if (!is_null($cargo->TextoOLE)){
                $columns[$c++] = "TextoOLE";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->TextoOLE));
        }

        if (!is_null($cargo->NivelCargo)){
                $columns[$c++] = "NivelCargo";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->NivelCargo));
        }

        if (!is_null($cargo->GrauInstrucao)){
                $columns[$c++] = "GrauInstrucao";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->GrauInstrucao));
        }

        if (!is_null($cargo->FatorRequisito)){
                $columns[$c++] = "FatorRequisito";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->FatorRequisito));
        }

        if (!is_null($cargo->FatorDescricao)){
                $columns[$c++] = "FatorDescricao";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->FatorDescricao));
        }

        if (!is_null($cargo->AtivaDesativa)){
                $columns[$c++] = "AtivaDesativada";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->AtivaDesativa));
        }

         if (!is_null($cargo->GrauInstrucaoMaximo)){
                $columns[$c++] = "GrauInstrucaoMaximo";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->GrauInstrucaoMaximo));
        }

         if (!is_null($cargo->MaodeObra)){
                $columns[$c++] = "MaodeObra";
				$values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->MaodeObra));
        }

        if (!is_null($cargo->CargoDeProfessor)){
                $columns[$c++] = "CargoDeProfessor";
                $values[$v++] =  preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($cargo->CargoDeProfessor));
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
    function criarCargo(Cargo $cargo) {
		$statement = $this->prepareStatement($cargo);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhcargos(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";

		return $this->db->Execute($sql);
	}

	function excluirCargo() {
		$sql = "delete from rhcargos ";
		return $this->db->Execute($sql);
	}
}

?>