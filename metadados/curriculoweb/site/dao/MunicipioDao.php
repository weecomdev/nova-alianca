<?php

class MunicipioDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {           
		$this->db = $db;
	}
	
	private function prepareStatement(Municipio $municipio) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($municipio->Cidade)){
                $columns[$c++] = "Cidade";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($municipio->Cidade));
        }
        
        if (!is_null($municipio->UF)){
                $columns[$c++] = "UF";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($municipio->UF));
        }
        if (!is_null($municipio->CodigoMunicipioRAIS)){
                $columns[$c++] = "CodigoMunicipioRAIS";
				$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($municipio->CodigoMunicipioRAIS));
        }
        if (!is_null($municipio->Descricao80)){
            $columns[$c++] = "Descricao80";
			$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($municipio->Descricao80));
        }        
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
    }
	
	
	
	function criarMunicipio(Municipio $municipio) {
		$statement = $this->prepareStatement($municipio);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT INTO rhmunicipios(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
    
    function buscarCidadesPorUF($uf){
		$sql = "SELECT * FROM rhmunicipios WHERE Descricao80 is not null and UF = ? Order By Descricao80";
	
		$query = $this->db->prepare($sql);
		$uf = preg_replace('#[^\pL\pN./\' -]+#' , '',$uf);	
		return $this->db->Execute($query,$uf);   
    }
    
	function excluirMunicipio() {
		$sql = "delete from rhmunicipios ";
		return $this->db->Execute($sql);
	}
}

?>