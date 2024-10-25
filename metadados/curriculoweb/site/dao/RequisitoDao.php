<?php
class RequisitoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = NULL) {
		$this->db = $db;
	}
	
	function buscarRequisitosPorParametros($requisito = NULL) {
		$sql = " SELECT * FROM rhrequisitos ";
		$sql .= " LEFT JOIN rhmedidas ON (rhrequisitos.Medida = rhmedidas.Medida)  ";
		$sql .= " WHERE 1=1 ";
		if (!is_null($requisito))
		{    
			$sql .= " AND rhrequisitos.Requisito = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisito))."";	
		}
			
		
		$query = $this->db->prepare($sql);
		return $this->db->Execute($query);
	}
	
	private function prepareStatement(Requisito $requisito) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($requisito->Requisito)){
                $columns[$c++] = "Requisito";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($requisito->Requisito)); 
        }
        if (!is_null($requisito->Descricao80)){
                $columns[$c++] = "Descricao80";
				$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($requisito->Descricao80)); 
        }
        if (!is_null($requisito->TipoRequisito)){
                $columns[$c++] = "TipoRequisito";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisito->TipoRequisito)); 
        }
        if (!is_null($requisito->ImprimirCurriculo)){
                $columns[$c++] = "ImprimirCurriculo";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisito->ImprimirCurriculo)); 
        }
        if (!is_null($requisito->SolicitarFicha)){
                $columns[$c++] = "SolicitarFicha";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisito->SolicitarFicha)); 
        }
        if (!is_null($requisito->Avaliacao)){
                $columns[$c++] = "Avaliacao";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisito->Avaliacao)); 
        }
        if (!is_null($requisito->Medida)){
                $columns[$c++] = "Medida";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisito->Medida)); 
        }
        if (!is_null($requisito->ClasseRequisito)){
                $columns[$c++] = "ClasseRequisito";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisito->ClasseRequisito)); 
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;
        
        return $statement;
   }

   function criarRequisito(Requisito $requisito) {
		$statement = $this->prepareStatement($requisito);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhrequisitos(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
	}
	function excluirRequisito() {
		$sql = "delete from rhrequisitos ";
		return $this->db->Execute($sql);
	}
}
?>