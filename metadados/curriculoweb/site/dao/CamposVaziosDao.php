<?php
class CamposVaziosDao{
	private $db;
	private $ListaQuery;
	function __construct($db) {
		$this->db = $db;
	}
	function ConfereCamposVaziosPadrao($empresa, $pessoa, $tabela, $camposTabela){
		$sql = "SELECT ";
		$insereVirgula=false;
		foreach ($camposTabela as $campo){
			if($insereVirgula==true){
				$sql .= " , ";
			}
			$sql .= $campo["CampoTabela"];
			$insereVirgula = true;
		}
		$retorno=array();
		$i=0;
		$sql .= " FROM $tabela WHERE Empresa = '$empresa' AND Pessoa = $pessoa ";
		$resultado = $this->db->execute($sql);
		if(!$resultado->EOF){
			while(!$resultado->EOF){
				foreach($camposTabela as $campo){
					if($resultado->fields[$campo["CampoTabela"]] == ""){
						$retorno[$i]['CampoTabela'] = $campo["CampoTabela"];
						$retorno[$i]['Descricao'] = $campo["Descricao"];
						$i++;
					}
				}
				$resultado->MoveNext();
			}
		}
		else{
			foreach($camposTabela as $campo){
				$retorno[$i]['CampoTabela'] = $campo["CampoTabela"];
				$retorno[$i]['Descricao'] = $campo["Descricao"];
				$i++;
			}
		}
		return $retorno;
	}

	function ConfereCamposVaziosRequisitos($empresa, $pessoa, $camposTabela){
		$retorno=array();
		if(is_array($camposTabela) && count($camposTabela) > 0){
			$sql = "SELECT rhrequisitos.requisito, rhrequisitos.descricao80 FROM rhrequisitos
			WHERE rhrequisitos.requisito in ( ";			
			$insereVirgula=false;
			foreach($camposTabela as $campo){
				if($insereVirgula==true){
					$sql .= " , ";
				}
				$sql .= "'".$campo["CampoTabela"]."'";
				$insereVirgula = true;
			}
			$sql .=" ) and
			not exists ( select rhpessoarequisitos.empresa from rhpessoarequisitos 
					 	 where rhpessoarequisitos.empresa = '$empresa' and 
					     rhpessoarequisitos.pessoa = $pessoa and 
						 rhpessoarequisitos.requisito = rhrequisitos.requisito and 
						 (
							 ( rhrequisitos.tiporequisito='QT' and 
							   ( rhpessoarequisitos.QuantidadeRequisito is not null ) 
							 ) or 
							 ( rhrequisitos.tiporequisito='TX' and 
							   ( rhpessoarequisitos.TextoRequisito is not null and rhpessoarequisitos.TextoRequisito <> '' ) 
							 ) or 
							 ( rhrequisitos.tiporequisito='AV' and 						   
							   ( rhpessoarequisitos.Item_Avaliacao is not null and
							     rhpessoarequisitos.Item_Avaliacao <> '' ) 
							 ) 
						 )
					   )  ";
			$resultado = $this->db->execute($sql);
			$i=0;
			while(!$resultado->EOF){
				$retorno[$i]['CampoTabela'] = $resultado->fields["requisito"];
				$retorno[$i]['Descricao'] = $resultado->fields["descricao80"];
				$i++;
				$resultado->MoveNext();
			}
		}

		return $retorno;
	}

    function ConfereCamposVaziosInteresse($empresa, $pessoa, $tabela, $camposTabela){
		$sql = "SELECT ";
		$insereVirgula=false;
		foreach ($camposTabela as $campo){
			if($insereVirgula==true){
				$sql .= " , ";
			}
			$sql .= $campo["CampoTabela"];
			$insereVirgula = true;
		}
		$retorno=array();
		$i=0;
		$sql .= " FROM $tabela WHERE Empresa = '$empresa' AND Pessoa = $pessoa ";
		$resultado = $this->db->execute($sql);
		if(!$resultado->EOF){
			while(!$resultado->EOF){
				foreach($camposTabela as $campo){
					if($resultado->fields[$campo["CampoTabela"]] == ""){
						$retorno[$i]['CampoTabela'] = $campo["CampoTabela"];
						$retorno[$i]['Descricao'] = $campo["Descricao"];
						$i++;
					}
				}
				$resultado->MoveNext();
			}
		}
		else{
			foreach($camposTabela as $campo){
				$retorno[$i]['CampoTabela'] = $campo["CampoTabela"];
				$retorno[$i]['Descricao'] = $campo["Descricao"];
				$i++;
			}
		}
		return $retorno;
	}
	
}
?>