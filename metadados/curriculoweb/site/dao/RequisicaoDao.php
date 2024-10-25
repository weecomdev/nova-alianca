<?php

class RequisicaoDao {

	private $db;
	private $ListaQuery;
	
	function __construct($db = null) {
		$this->db = $db;
	}
	
	function buscarRequisicaoPorPk($Requisicao) {
		$sql = " SELECT rhrequisicoes.*, rhfuncoes.Descricao40 as nomeFuncao, 
			rhfuncoes.Descricao20 as apelidoFuncao, 
			rhcargos.Descricao40 as nomeCargo, rhcargos.Descricao20 as apelidoCargo,
			rhareasatuacao.Descricao60 as nomeAreaAtuacao,
			rhregioes.Descricao60 as nomeRegiao,
			rhvincempregaticios.Descricao40 as nomeVinculoEmpregaticio, rhvincempregaticios.Descricao20 as apelidoVinculoEmpregaticio

			FROM rhrequisicoes  
			
			LEFT JOIN rhfuncoes ON (rhfuncoes.Funcao = rhrequisicoes.Funcao)
			LEFT JOIN rhcargos ON (rhcargos.Cargo = rhrequisicoes.Cargo)
			LEFT JOIN rhareasatuacao ON (rhareasatuacao.AreaAtuacao = rhrequisicoes.AreaAtuacao)
			LEFT JOIN rhregioes ON (rhregioes.regiao = rhrequisicoes.regiao)
			LEFT JOIN rhvincempregaticios ON (rhvincempregaticios.VinculoEmpregaticio = rhrequisicoes.VinculoEmpregaticio)
			
			WHERE rhrequisicoes.abririnscricao = 'S' and rhrequisicoes.divulgarvagaext = 'S' ";
		 
		
		if (!is_null($Requisicao)) {
			$sql .= " AND (Requisicao = ".( $this->db->qstr($Requisicao)).")";
		}
		
		$query = $this->db->prepare($sql);
		
		return $this->db->Execute($query);
	}
	
	function buscarRequisicaoPorParametros(Requisicao $requisicao, $local = NULL, $acao = NULL) {
        $String = NULL; 

		$sql = " SELECT DISTINCT rhrequisicoes.*, rhfuncoes.Descricao40 as nomeFuncao, rhfuncoes.Descricao20 as apelidoFuncao, 
			rhcargos.Descricao40 as nomeCargo, rhcargos.Descricao20 as apelidoCargo,
			rhareasatuacao.Descricao60 as nomeAreaAtuacao,
			rhregioes.Descricao60 as nomeRegiao,
			rhvincempregaticios.Descricao40 as nomeVinculoEmpregaticio, rhvincempregaticios.Descricao20 as apelidoVinculoEmpregaticio,
			COALESCE( rhfuncoes.Descricao20, rhcargos.Descricao20) as Descricao

			FROM rhrequisicoes  
			
			LEFT JOIN rhfuncoes ON (rhfuncoes.Funcao = rhrequisicoes.Funcao)
			LEFT JOIN rhcargos ON (rhcargos.Cargo = rhrequisicoes.Cargo)
			LEFT JOIN rhareasatuacao ON (rhareasatuacao.AreaAtuacao = rhrequisicoes.AreaAtuacao)
			LEFT JOIN rhregioes ON (rhregioes.regiao = rhrequisicoes.regiao)			
			LEFT JOIN rhvincempregaticios ON (rhvincempregaticios.VinculoEmpregaticio = rhrequisicoes.VinculoEmpregaticio)
			
			WHERE rhrequisicoes.abririnscricao = 'S' and rhrequisicoes.divulgarvagaext = 'S' ";
			
			
		 
		if (!is_null($requisicao->Funcao)) {
			$sql .= " AND (rhrequisicoes.Funcao = ".( $this->db->qstr($requisicao->Funcao)).")";
		}
		if (!is_null($requisicao->Cargo)) {
			$sql .= " AND (rhrequisicoes.Cargo = ".( $this->db->qstr($requisicao->Cargo)).")";
		}
		if (!is_null($requisicao->AreaAtuacao)) {
			$sql .= " AND (rhrequisicoes.AreaAtuacao = ".( $this->db->qstr($requisicao->AreaAtuacao)).")";
		}
		if (!is_null($requisicao->Regiao)) {
			$sql .= " AND (rhrequisicoes.Regiao = ".( $this->db->qstr($requisicao->Regiao)).")";
		}		
		if (!is_null($requisicao->VinculoEmpregaticio)) {
			$sql .= " AND (rhrequisicoes.VinculoEmpregaticio = ".( $this->db->qstr($requisicao->VinculoEmpregaticio)).")";
		}
		if ( (!is_null($requisicao->SalarioInicio)) && (!is_null( ( $this->db->qstr($requisicao->SalarioFim))) )) {
			$sql .= " AND (rhrequisicoes.SalarioMaximo >= ".( $this->db->qstr($requisicao->SalarioInicio)).")";
			$sql .= " AND (rhrequisicoes.SalarioMaximo <= ".( $this->db->qstr($requisicao->SalarioFim)).")";
		} else if ( !is_null($requisicao->SalarioInicio)) {
			$sql .= " AND (rhrequisicoes.SalarioMaximo = ".( $this->db->qstr($requisicao->SalarioInicio)).")";
		}
	
		if  (!is_null($requisicao->SituacaoRequisicaoAberta)){
			$String = " AND (rhrequisicoes.SituacaoRequisicao in (".( $this->db->qstr($requisicao->SituacaoRequisicaoAberta))."";
		}
		if (!is_null($requisicao->SituacaoRequisicaoSuspensa)){
			if (!is_null($String)){
				$String .= ", ".( $this->db->qstr($requisicao->SituacaoRequisicaoSuspensa))."";
			}else{
				$String = " AND (rhrequisicoes.SituacaoRequisicao in (".( $this->db->qstr($requisicao->SituacaoRequisicaoSuspensa))."";
			}			
		}
		if (!is_null($requisicao->SituacaoRequisicaoEncerrada)){
			if (!is_null($String)){
				$String .= ", ".( $this->db->qstr($requisicao->SituacaoRequisicaoEncerrada))."";
			}else{
				$String = " AND (rhrequisicoes.SituacaoRequisicao in (".( $this->db->qstr($requisicao->SituacaoRequisicaoEncerrada))."";
			}
		}
		
		if (!is_null($String)){
			$String .= "))";
			$sql .= $String;
		}
				
		if ($local == "home"){
			$sql .= " AND rhrequisicoes.SituacaoRequisicao = 'N' " 
			." AND ( rhrequisicoes.DataRequisicao<= Now() or rhrequisicoes.DataRequisicao ='00000000') ";
            
            if ($acao != "pesquisarConsulta"){
			    $sql .= " AND (not exists (select empresa, pessoa from rhrequisicoesturma where rhrequisicoes.requisicao = rhrequisicoesturma.requisicao 
			            and rhrequisicoesturma.empresa = ".( $this->db->qstr(LoginModel::getEmpresaLogada()))." and 
                        rhrequisicoesturma.pessoa = ".( $this->db->qstr(LoginModel::getPessoaLogada()))." and rhrequisicoesturma.candidatoinscrito = 'S') Or 
                        exists (select empresa, pessoa from rhrequisicoesturma where rhrequisicoes.requisicao = rhrequisicoesturma.requisicao 
			            and rhrequisicoesturma.empresa = ".( $this->db->qstr(LoginModel::getEmpresaLogada()))." and 
                        rhrequisicoesturma.pessoa = ".( $this->db->qstr(LoginModel::getPessoaLogada()))." and rhrequisicoesturma.candidatoinscrito = 'N')                        
                        )";
            }   
		}
		
		if ($local == "home"){
			$sql .= " ORDER BY Descricao, rhrequisicoes.DATAREQUISICAO desc ";
		}
		else{
			$sql .= " ORDER BY rhrequisicoes.DATAREQUISICAO desc ";
		}
				
		$query = $this->db->prepare($sql);
		
		return $this->db->Execute($query);
	}

	private function prepareStatement(Requisicao $requisicao) {
        $statement = array();
        $c = 0;
        $v = 0;

        if (!is_null($requisicao->Requisicao)){
                $columns[$c++] = "Requisicao";
				$values[$v++] = ($this->db->qstr($requisicao->Requisicao));
        }

        if (!is_null($requisicao->DataRequisicao)){
                $columns[$c++] = "DataRequisicao";
				$values[$v++] = preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($requisicao->DataRequisicao));
        }

        if (!is_null($requisicao->SituacaoRequisicao)){
                $columns[$c++] = "SituacaoRequisicao";
				$values[$v++] = ($this->db->qstr($requisicao->SituacaoRequisicao));
        }

        if (!is_null($requisicao->QuantidadeVagas)){
                $columns[$c++] = "QuantidadeVagas";
				$values[$v++] = ($this->db->qstr($requisicao->QuantidadeVagas));
        }

        if (!is_null($requisicao->Observacoes)){
                $columns[$c++] = "Observacoes";
				$values[$v++] = $this->db->qstr($requisicao->Observacoes);
        }

        if (!is_null($requisicao->SalarioMaximo)){
                $columns[$c++] = "SalarioMaximo";
				$values[$v++] = preg_replace('#[^\pL\pN./\'., -]+#', '', $this->db->qstr($requisicao->SalarioMaximo));
        }

        if (!is_null($requisicao->VinculoEmpregaticio)){
                $columns[$c++] = "VinculoEmpregaticio";
				$values[$v++] = ($this->db->qstr($requisicao->VinculoEmpregaticio));
        }

        if (!is_null($requisicao->Funcao)){
                $columns[$c++] = "Funcao";
				$values[$v++] = ($this->db->qstr($requisicao->Funcao));
        }

        if (!is_null($requisicao->Cargo)){
                $columns[$c++] = "Cargo";
				$values[$v++] = ($this->db->qstr($requisicao->Cargo));
        }

        if (!is_null($requisicao->AreaAtuacao)){
                $columns[$c++] = "AreaAtuacao";
				$values[$v++] = ($this->db->qstr($requisicao->AreaAtuacao));
        }
        
        if (!is_null($requisicao->Regiao)){
                $columns[$c++] = "Regiao";
				$values[$v++] = ($this->db->qstr($requisicao->Regiao));
        }        

        if (!is_null($requisicao->Empresa)){
                $columns[$c++] = "Empresa";
				$values[$v++] = ($this->db->qstr($requisicao->Empresa));
        }
        
        if (!is_null($requisicao->DescricaoAtividades)){
                $columns[$c++] = "DescricaoAtividades";
				$values[$v++] = ($this->db->qstr($requisicao->DescricaoAtividades));
        }

        if (!is_null($requisicao->AbrirInscricao)){
                $columns[$c++] = "AbrirInscricao";
				$values[$v++] = ($this->db->qstr($requisicao->AbrirInscricao));
        }

        if (!is_null($requisicao->DivulgarVagaExt)){
                $columns[$c++] = "DivulgarVagaExt";
				$values[$v++] = ($this->db->qstr($requisicao->DivulgarVagaExt));
        }
        
	    if (!is_null($requisicao->InicioSelecao)){
                $columns[$c++] = "InicioSelecao";
				$values[$v++] = ($this->db->qstr($requisicao->InicioSelecao));
        }
        
	    if (!is_null($requisicao->PrazoEncerramento)){
                $columns[$c++] = "PrazoEncerramento";
				$values[$v++] = ($this->db->qstr($requisicao->PrazoEncerramento));
        }
        
		if (!is_null($requisicao->Dt_Encerra)){
                $columns[$c++] = "Dt_Encerra";
				$values[$v++] = preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($requisicao->Dt_Encerra));
        }
        
        $statement[0] = $columns;
        $statement[1] = $values;

        return $statement;
	}
	
    function criarRequisicao(Requisicao $requisicao) {
		$statement = $this->prepareStatement($requisicao);
		
		$columns = $statement[0]; 
		$values = $statement[1];
		
		$sql = "INSERT IGNORE INTO rhrequisicoes(";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";
		
		return $this->db->Execute($sql);		
	}
	
	function excluirRequisicao() {
		$sql = "delete from rhrequisicoes ";
		return $this->db->Execute($sql);
	}
			
}

?>