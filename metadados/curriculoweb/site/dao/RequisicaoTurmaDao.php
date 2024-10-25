<?php

class RequisicaoTurmaDao {

	private $db;
	private $ListaQuery;

	function __construct($db = NULL) {
		$this->db = $db;
	}

	function buscarRequisicoesTurmaPorParametros(RequisicaoTurma $requisicaoTurma = null, Pessoa $pessoa = null, $local = null, $candidatoInscrito = null) {
		$ListaQuery = array();
        $sql = "select
                distinct rhrequisicoesturma.Pessoa, rhrequisicoesturma.Requisicao, rhrequisicoesturma.DataInscricao,
                rhrequisicoesturma.Empresa, rhrequisicoesturma.CandidatoInscrito, rhfuncoes.Descricao40 as nomeFuncao,
                rhfuncoes.Descricao20 as apelidoFuncao, rhcargos.Cargo, rhfuncoes.Funcao,
                rhcargos.Descricao40 as nomeCargo, rhcargos.Descricao20 as apelidoCargo,
                rhrequisicoes.QuantidadeVagas, rhrequisicoes.DataRequisicao from rhrequisicoesturma
                inner join rhrequisicoes on (rhrequisicoes.requisicao = rhrequisicoesturma.requisicao)
                left join rhfuncoes on (rhfuncoes.funcao = rhrequisicoes.funcao)
                left join rhcargos on (rhcargos.cargo = rhrequisicoes.cargo)
                inner join rhpessoas on rhpessoas.pessoa = rhrequisicoesturma.pessoa
                where 1=1 ";

		if (!is_null($requisicaoTurma->Pessoa)){
			$sql .= " and rhrequisicoesturma.Empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Empresa))."";
            $sql .= " and rhrequisicoesturma.Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Pessoa))."";
		}
        else if (!is_null($pessoa->Pessoa))
        {
            $sql .= " and rhrequisicoesturma.Empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Empresa))."";
            $sql .= " and rhrequisicoesturma.Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Pessoa))."";
        }

		if (!is_null($requisicaoTurma->Requisicao)){
			$sql .= " and rhrequisicoesturma.Requisicao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Requisicao))."";
		}

		//Na busca das vagas concorrida somente deve aparecer as que est�o abertas
		if ($local =="buscarVagasConcorridas" ){
			$sql .= " and rhrequisicoes.SituacaoRequisicao = 'N' ";
		}

        if ($candidatoInscrito == "S"){
            $sql .= " and rhrequisicoesturma.CandidatoInscrito = 'S' ";
        }
        else if ($candidatoInscrito == "N"){
            $sql .= " and ( rhrequisicoesturma.CandidatoInscrito = 'N' or rhrequisicoesturma.CandidatoInscrito Is Null') ";
        }


		$sql .= " order by rhrequisicoes.DataRequisicao desc ";

       	$query = $this->db->prepare($sql);


		return $this->db->Execute($query);
	}

    function getQuantidadeVagasConcorridas(RequisicaoTurma $requisicaoTurma){
        $ListaQuery = array();
        $sql = "SELECT
                  count(rhrequisicoesturma.Requisicao) qtdVagas
                FROM
                  rhrequisicoesturma
                inner join rhrequisicoes on
                  ( rhrequisicoesturma.Requisicao = rhrequisicoes.Requisicao )
                where
                  rhrequisicoes.SituacaoRequisicao in ('N', 'A') and
                  rhrequisicoes.SituacaoRequisicao in ('N', 'A') and
                  rhrequisicoesturma.CandidatoInscrito = 'S' and
                  rhrequisicoesturma.Empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Empresa))." and
                  rhrequisicoesturma.Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Pessoa))." ";


	    $query = $this->db->prepare($sql);

        return $this->db->Execute($query)->fields['qtdVagas'];
    }

    function candidatoExiste(RequisicaoTurma $requisicaoTurma){
        $ListaQuery = array();
        $sql = "SELECT
                  rhrequisicoesturma.Requisicao
                FROM
                  rhrequisicoesturma
                where
                  rhrequisicoesturma.Requisicao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Requisicao))." and
                  rhrequisicoesturma.Empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Empresa))." and
                  rhrequisicoesturma.Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Pessoa))."";


	    $query = $this->db->prepare($sql);
        $requisicao = $this->db->Execute($query)->fields['Requisicao'];
        return $requisicao != null;
    }


	private function prepareStatement(RequisicaoTurma $requisicaoTurma) {
		$statement = array();
		$c=0;
		$v=0;

		$columns[$c++] = "Empresa";
		$values[$v++] = str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($requisicaoTurma->Empresa));

		$columns[$c++] = "Pessoa";
		$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisicaoTurma->Pessoa));

		if (!is_null($requisicaoTurma->Requisicao)){
			$columns[$c++] = "Requisicao";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisicaoTurma->Requisicao));
		}

		if (!is_null($requisicaoTurma->DataInscricao)){
			$columns[$c++] = "DataInscricao";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+#', '', $this->db->qstr($requisicaoTurma->DataInscricao));
		}

        if (!is_null($requisicaoTurma->CandidatoInscrito)){
			$columns[$c++] = "CandidatoInscrito";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+#' , '', $this->db->qstr($requisicaoTurma->CandidatoInscrito));
		}

		$statement[0] = $columns;
		$statement[1] = $values;

		return $statement;
	}

	function criarRequisicaoTurma(RequisicaoTurma $requisicaoTurma) {
		$statement = $this->prepareStatement($requisicaoTurma);

		$columns = $statement[0];
		$values = $statement[1];

		$sql = "INSERT IGNORE INTO rhrequisicoesturma (";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";

		return $this->db->Execute($sql);
	}

	function atualizarRequisicaoTurma(RequisicaoTurma $requisicaoTurma) {
        $sql = "update rhrequisicoesturma set CandidatoInscrito = 'S', DataInscricao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->DataInscricao))." Where ";

		if (!is_null($requisicaoTurma->Empresa)){
			$sql .= " rhrequisicoesturma.Empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Empresa))."";
		}
        $sql .= " and rhrequisicoesturma.Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Pessoa))."";
		if (!is_null($requisicaoTurma->Requisicao)){
			$sql .= " and rhrequisicoesturma.Requisicao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicaoTurma->Requisicao))."";
		}

        $query = $this->db->prepare($sql);

        return $this->db->Execute($query);
	}

    function removerCandidatoInscrito($empresa, $pessoa, $requisicao){
		$ListaQuery = array();
        $sql = "update rhrequisicoesturma set CandidatoInscrito = 'N' where ";

		if (!is_null($empresa)){
			$sql .= " rhrequisicoesturma.Empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresa))."";
		}
        $sql .= " and rhrequisicoesturma.Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa))."";
		if (!is_null($requisicao)){
			$sql .= " and rhrequisicoesturma.Requisicao = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($requisicao))."";
		}

         $query = $this->db->prepare($sql);

         return $this->db->Execute($query);
    }
}
?>