<?php

class EmpresaDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	private function prepareStatement(Empresa $empresa) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($empresa->Empresa)){
                $columns[$c++] = "Empresa";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($empresa->Empresa));
        }

        if (!is_null($empresa->RazaoSocial)){
                $columns[$c++] = "RazaoSocial";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($empresa->RazaoSocial));
        }


        if (!is_null($empresa->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($empresa->Descricao20));
        }


        if (!is_null($empresa->TipoEmpresa)){
                $columns[$c++] = "TipoEmpresa";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->TipoEmpresa));
        }

        if (!is_null($empresa->UsaFolha)){
                $columns[$c++] = "UsaFolha";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaFolha));
        }


        if (!is_null($empresa->UsaPonto)){
                $columns[$c++] = "UsaPonto";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaPonto));
        }


        if (!is_null($empresa->UsaRecrutamento)){
                $columns[$c++] = "UsaRecrutamento";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaRecrutamento));
        }

        if (!is_null($empresa->UsaTreinamento)){
                $columns[$c++] = "UsaTreinamento";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaTreinamento));
        }


        if (!is_null($empresa->UsaCargosSalarios)){
                $columns[$c++] = "UsaCargosSalarios";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaCargosSalarios));
        }


        if (!is_null($empresa->UsaGestaoSalarial)){
                $columns[$c++] = "UsaGestaoSalarial";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaGestaoSalarial));
        }

        if (!is_null($empresa->UsaSeguranca)){
                $columns[$c++] = "UsaSeguranca";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaSeguranca));
        }


        if (!is_null($empresa->UsaPCMSO)){
                $columns[$c++] = "UsaPCMSO";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaPCMSO));
        }


        if (!is_null($empresa->UsaValeTransp)){
                $columns[$c++] = "UsaValeTransp";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaValeTransp));
        }

        if (!is_null($empresa->UsaModulo01)){
                $columns[$c++] = "UsaModulo01";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo01));
        }


        if (!is_null($empresa->UsaModulo02)){
                $columns[$c++] = "UsaModulo02";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo02));
        }


        if (!is_null($empresa->UsaModulo03)){
                $columns[$c++] = "UsaModulo03";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo03));
        }


        if (!is_null($empresa->UsaModulo04)){
                $columns[$c++] = "UsaModulo04";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo04));
        }


        if (!is_null($empresa->UsaModulo05)){
                $columns[$c++] = "UsaModulo05";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo05));
        }


        if (!is_null($empresa->UsaModulo06)){
                $columns[$c++] = "UsaModulo06";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo06));
        }


        if (!is_null($empresa->UsaModulo07)){
                $columns[$c++] = "UsaModulo07";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo07));
        }


        if (!is_null($empresa->UsaModulo08)){
                $columns[$c++] = "UsaModulo08";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo08));
        }


        if (!is_null($empresa->UsaModulo09)){
                $columns[$c++] = "UsaModulo09";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo09));
        }


        if (!is_null($empresa->UsaModulo10)){
                $columns[$c++] = "UsaModulo10";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo10));
        }


        if (!is_null($empresa->UsaModulo11)){
                $columns[$c++] = "UsaModulo11";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo11));
        }


        if (!is_null($empresa->UsaModulo12)){
                $columns[$c++] = "UsaModulo12";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo12));
        }


        if (!is_null($empresa->UsaModulo13)){
                $columns[$c++] = "UsaModulo13";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo13));
        }


        if (!is_null($empresa->UsaModulo14)){
                $columns[$c++] = "UsaModulo14";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo14));
        }


        if (!is_null($empresa->UsaModulo15)){
                $columns[$c++] = "UsaModulo15";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo15));
        }


        if (!is_null($empresa->UsaModulo16)){
                $columns[$c++] = "UsaModulo16";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo16));
        }


        if (!is_null($empresa->UsaModulo17)){
                $columns[$c++] = "UsaModulo17";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo17));
        }


        if (!is_null($empresa->UsaModulo18)){
                $columns[$c++] = "UsaModulo18";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo18));
        }


        if (!is_null($empresa->UsaModulo19)){
                $columns[$c++] = "UsaModulo19";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo19));
        }


        if (!is_null($empresa->UsaModulo20)){
                $columns[$c++] = "UsaModulo20";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->UsaModulo20));
        }


        if (!is_null($empresa->GrupoEmpresa)){
                $columns[$c++] = "GrupoEmpresa";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->GrupoEmpresa));
        }

        if (!is_null($empresa->Usuario)){
                $columns[$c++] = "Usuario";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->Usuario));
        }


        if (!is_null($empresa->AtivaDesativada)){
                $columns[$c++] = "AtivaDesativada";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($empresa->AtivaDesativada));
        }        


        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
    }
		
	function criarEmpresa(Empresa $empresa) {
		
		$statement = $this->prepareStatement($empresa);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhempresas(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}

	function excluirEmpresa() {
		$sql = "delete from rhempresas ";

		return $this->db->Execute($sql);
	}
}

?>