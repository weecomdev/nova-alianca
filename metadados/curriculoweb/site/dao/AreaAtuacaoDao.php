<?php

class AreaAtuacaoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarAreaAtuacaoPorParametros() {
		
		$sql = "select * from rhareasatuacao ";
	
		if ($_SESSION["OrdemInteresses"] == '1'){
			$sql .= " Order By AREAATUACAO ";
		}
		else{
		    $sql .= " Order By DESCRICAO60 ";	
		}
		
						
		return $this->db->Execute($sql);
	}

	function buscarAreaAtuacaoVinculadaPorParametros($modulo = NULL) {
		
		//Só retorna regiões que estejam vinculadas a requisições que podem 
		//ser visualizadas pelo Currículo Web.
        $sql = "Select * From rhareasatuacao Where 
                        Exists(
                            Select rhrequisicoes.requisicao From  rhrequisicoes Where 
                                rhrequisicoes.areaatuacao = rhareasatuacao.areaatuacao and 
                                (rhrequisicoes.DataRequisicao <= Now() or 
                                rhrequisicoes.DataRequisicao ='00000000') ";
        if ($modulo == "home"){                                
            $sql .= " and rhrequisicoes.situacaorequisicao = 'N' "; 
        }
        
        $sql .= "and rhrequisicoes.abririnscricao = 'S' and 
        rhrequisicoes.divulgarvagaext = 'S')";                                      
	
		if ($_SESSION["OrdemInteresses"] == '1'){
			$sql .= " Order By AREAATUACAO ";
		}
		else{
		    $sql .= " Order By DESCRICAO60 ";	
		}
		
		return $this->db->Execute($sql);
	}        
        
	private function prepareStatement(AreaAtuacao $areasAtuacao) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($areasAtuacao->AreaAtuacao)){
                $columns[$c++] = "AreaAtuacao";
                $values[$v++] =  $this->db->qstr($areasAtuacao->AreaAtuacao);
        }

        if (!is_null($areasAtuacao->Descricao60)){
                $columns[$c++] = "Descricao60";
                $values[$v++] =  $this->db->qstr($areasAtuacao->Descricao60);
				
        }


        if (!is_null($areasAtuacao->AtivaDesativa)){
                $columns[$c++] = "AtivaDesativa";
                $values[$v++] =  $this->db->qstr($areasAtuacao->AtivaDesativa);
        }

        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
    function criarAreaAtuacao(AreaAtuacao $areasatuacao) {
    
		$statement = $this->prepareStatement($areasatuacao);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhareasatuacao(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
        
        return $this->db->Execute($sql);
	}
	
	function excluirAreaAtuacao() {
		$sql = "delete from rhareasatuacao ";
		return $this->db->Execute($sql);
	}
}

?>