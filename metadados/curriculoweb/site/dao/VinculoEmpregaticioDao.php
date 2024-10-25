<?php

class VinculoEmpregaticioDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarVinculoEmpregaticioPorParametros() {
		
		$sql = "SELECT * FROM rhvincempregaticios order by descricao40 ";

		return $this->db->Execute($sql);
	}

	private function prepareStatement(VinculoEmpregaticio $vincEmpregaticios) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($vincEmpregaticios->VinculoEmpregaticio)){
                $columns[$c++] = "VinculoEmpregaticio";
			    $values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->VinculoEmpregaticio));
        }

        if (!is_null($vincEmpregaticios->Descricao40)){
                $columns[$c++] = "Descricao40";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($vincEmpregaticios->Descricao40));

        }

        if (!is_null($vincEmpregaticios->Descricao20)){
                $columns[$c++] = "Descricao20";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($vincEmpregaticios->Descricao20));
        }

        if (!is_null($vincEmpregaticios->VinculoEmpregaticioRAIS)){
                $columns[$c++] = "VinculoEmpregaticioRAIS";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->VinculoEmpregaticioRAIS));
        }

        if (!is_null($vincEmpregaticios->CategoriaSEFIP)){
                $columns[$c++] = "CategoriaSEFIP";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->CategoriaSEFIP));
        }

        if (!is_null($vincEmpregaticios->OpcaoPrevidencia)){
                $columns[$c++] = "OpcaoPrevidencia";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->OpcaoPrevidencia));
        }

        if (!is_null($vincEmpregaticios->VinculoPrevidencia)){
                $columns[$c++] = "VinculoPrevidencia";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->VinculoPrevidencia));
        }

        if (!is_null($vincEmpregaticios->RecolheFGTS)){
                $columns[$c++] = "RecolheFGTS";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->RecolheFGTS));
        }

        if (!is_null($vincEmpregaticios->VinculoSindicato)){
                $columns[$c++] = "VinculoSindicato";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->VinculoSindicato));
        }

        if (!is_null($vincEmpregaticios->RecebeFerias)){
                $columns[$c++] = "RecebeFerias";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->RecebeFerias));
        }

        if (!is_null($vincEmpregaticios->RegimeTempoParcial)){
                $columns[$c++] = "RegimeTempoParcial";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->RegimeTempoParcial));
        }

        if (!is_null($vincEmpregaticios->Recebe13Salario)){
                $columns[$c++] = "Recebe13Salario";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->Recebe13Salario));
        }

        if (!is_null($vincEmpregaticios->CodigoRetencao)){
                $columns[$c++] = "CodigoRetencao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($vincEmpregaticios->CodigoRetencao));
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
   }
	
    function criarVincEmpregaticio(VinculoEmpregaticio $vincempregaticio) {
   		$statement = $this->prepareStatement($vincempregaticio);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhvincempregaticios(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
	}

	function excluirVincEmpregaticio() {
		$sql = "delete from rhvincempregaticios ";
		return $this->db->Execute($sql);
	}
}

?>