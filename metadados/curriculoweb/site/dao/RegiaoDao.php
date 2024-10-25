<?php

class RegiaoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarRegiaoPorParametros() {
		
		//Só retorna regiões que estejam vinculadas a requisições que podem 
		//ser visualizadas pelo Currículo Web.
		$sql = "select * from rhregioes ";
	
		if ($_SESSION["OrdemInteresses"] == '1'){
			$sql .= " Order By REGIAO ";
		}
		else{
		    $sql .= " Order By DESCRICAO60 ";	
		}
		
		return $this->db->Execute($sql);
	}
	
	function buscarRegiaoVinculadaPorParametros($modulo = NULL) {
		
		//Só retorna regiões que estejam vinculadas a requisições que podem 
		//ser visualizadas pelo Currículo Web.
 		$sql = "Select * From rhregioes Where 
                        Exists(
                            Select rhrequisicoes.requisicao From  rhrequisicoes Where 
                                rhrequisicoes.regiao = rhregioes.regiao and 
                                (rhrequisicoes.DataRequisicao <= Now() or 
                                rhrequisicoes.DataRequisicao ='00000000') ";
         if ($modulo == "home"){                                
             $sql .= " and rhrequisicoes.situacaorequisicao = 'N' "; 
        }
        
         $sql .= "and rhrequisicoes.abririnscricao = 'S' and 
        rhrequisicoes.divulgarvagaext = 'S')";
	
		if ($_SESSION["OrdemInteresses"] == '1'){
			$sql .= " Order By REGIAO ";
		}
		else{
		    $sql .= " Order By DESCRICAO60 ";	
		}
		
		return $this->db->Execute($sql);
	}

	private function prepareStatement(Regiao $regioes) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($regioes->Regiao)){
                $columns[$c++] = "Regiao";
                $values[$v++] = "'" . $regioes->Regiao . "'";
        }

        if (!is_null($regioes->Descricao60)){
                $columns[$c++] = "Descricao60";
                $values[$v++] = "'" . $regioes->Descricao60 . "'";
        }


        if (!is_null($regioes->AtivaDesativa)){
                $columns[$c++] = "AtivaDesativa";
                $values[$v++] = "'" . $regioes->AtivaDesativa . "'";
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
    function criarRegiao(Regiao $regiao) {
    
		$statement = $this->prepareStatement($regiao);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhregioes(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
	}
	
	function excluirRegiao() {
		$sql = "delete from rhregioes ";
		return $this->db->Execute($sql);
	}
}

?>