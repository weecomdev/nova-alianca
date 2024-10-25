<?php
class PessoaDao {

	private $db;
	private $lumineConfig;
	private $rupertConfig;
	private $configuration;
	private $ListaQuery;

	function __construct($db = null) {
		$this->db = $db;
	}
	function pessoaEhBrasileira($empresa, $pessoa){
		$sql = "select nacionalidade from rhpessoas WHERE Empresa = '$empresa' and Pessoa = $pessoa ";
		$resultado = $this->db->Execute($sql);
		return $resultado->fields['nacionalidade'] == "10";
	}

	function buscarPessoas($empresa, $ultAlteracao, $limit = null) {
		$sql = "select * from rhpessoas where ";
        $sql .= " rhpessoas.empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresa));
        $sql .= " and rhpessoas.pessoa is not null ";
        $sql .= " and rhpessoas.ultalteracao is not null ";
		if (!is_null($ultAlteracao)){
			$sql .= " and rhpessoas.ultalteracao > ".preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($ultAlteracao));
		}

        $sql .= " order by rhpessoas.ultalteracao ";

        if (!is_null($limit)){
            $sql .= " Limit " . $limit;
        }

		$query = $this->db->prepare($sql);

		return $this->db->Execute($query);
	}

    function countPessoas($empresa, $ultAlteracao){
        $sql = "select count(rhpessoas.pessoa) as quantidade from rhpessoas where ";
        $sql .= " rhpessoas.empresa = ".preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($empresa));
        $sql .= " and rhpessoas.pessoa is not null ";
        $sql .= " and rhpessoas.ultalteracao is not null ";

		if (!is_null($ultAlteracao)){
			$sql .= " and rhpessoas.ultalteracao > ".preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($ultAlteracao));
		}



		$query = $this->db->prepare($sql);

		return $this->db->Execute($query)->fields['quantidade'];
    }

	function buscarPessoaPorCPF($cpf){
		$sql = "SELECT * FROM rhpessoas WHERE CPF =? limit 1";

		$query = $this->db->prepare($sql);
		$pCpf =  preg_replace('#[^\pL\pN./\' -]+# ', '', $cpf);

		$p = $this->db->Execute($query,$pCpf);


		if ($p->fields['CPF'] != "") {

			$pessoa = new Pessoa();
			$pessoa->Pessoa = $p->fields['Pessoa'];
			$pessoa->Nome = $p->fields['Nome'];
			$pessoa->CPF = $p->fields['CPF'];
            $pessoa->AceiteTermo = $p->fields['AceiteTermo'];
			return $pessoa;
		}
	}

    function buscarPessoaPorCPFEmpresa($cpf,$empresa){
		$sql = "SELECT * FROM rhpessoas WHERE CPF =? and Empresa =? limit 1";

		$query = $this->db->prepare($sql);
		$pCpf =  preg_replace('#[^\pL\pN./\' -]+# ', '', $cpf);
        $pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);

		$p = $this->db->Execute($query,array($pCpf,$pEmpresa));

		if ($p->fields['CPF'] != "") {

			$pessoa = new Pessoa();
			$pessoa->Pessoa = $p->fields['Pessoa'];
            $pessoa->Empresa = $p->fields['Empresa'];
			$pessoa->Nome = $p->fields['Nome'];
			$pessoa->CPF = $p->fields['CPF'];
            $pessoa->Email = $p->fields['Email'];
			return $pessoa;
		}
        return null;
	}

       function DeletarCurriculo($cpf,$empresa,$pessoa){

       try
       {    $this->db->BeginTrans();

            $sql = "DELETE FROM bf2usuarios WHERE Cpf = " .$cpf." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhempresasanteriores WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoaareasinteres WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoacursosrs WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoaempantexp WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoaidiomas WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoapalavrachave WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoarequisitos WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoasanexos WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoasdadoscompl WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoasfotos WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            $sql = "DELETE FROM rhpessoas WHERE Empresa = ".$empresa." AND Pessoa = ".$pessoa.";";
            $query = $this->db->prepare($sql);
            $this->db->Execute($query);

            return $this->db->CommitTrans();
       }
       catch (exception $e) {
            $this->db->RollbackTrans();
			return false;
        }
    }

        function atualizaTermo($cpf,$termo){

        $sql = "UPDATE rhpessoas SET AceiteTermo = ?,UltAlteracao =? WHERE Cpf = ?" ;

		$query = $this->db->prepare($sql);
        $pTermo = preg_replace('#[^\pL\pN./\' -]+# ', '', $termo);
		$pCpf =  preg_replace('#[^\pL\pN./\' -]+# ', '', $cpf);
        $pDataUltimaAlt = date("Y-m-d H:i:s");


        return $this->db->Execute($query,array($pTermo,$pDataUltimaAlt,$pCpf));
    }

       function atualizaExcluir($cpf){

        $sql = "UPDATE rhpessoas SET Excluir = 'S',UltAlteracao =? WHERE Cpf = ?" ;

		$query = $this->db->prepare($sql);
		$pCpf =  preg_replace('#[^\pL\pN./\' -]+# ', '', $cpf);
        $pDataUltimaAlt = date("Y-m-d H:i:s");
        $_SESSION["UltAlteracao"] = $pDataUltimaAlt;

        return $this->db->Execute($query,array($pDataUltimaAlt,$pCpf));
    }

	function buscarPessoaPorPk($codigoPessoa){
		$sql = "SELECT * FROM rhpessoas WHERE Pessoa = ?";

		$query = $this->db->prepare($sql);
		$pCodigoPessoa =  preg_replace('#[^\pL\pN./\' -]+#' , '', $codigoPessoa);

		return $this->db->Execute($query,$codigoPessoa);
	}

	private function prepareStatement(Pessoa $pessoa) {
		$statement = array();
		$c = 0;
		$v = 0;

		if (!is_null($pessoa->Empresa)){
			$columns[$c++] = "Empresa";
			$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoa->Empresa));
		}

		if (!is_null($pessoa->Nome)){
			$columns[$c++] = "Nome";
			$values[$v++] =  str_replace(array('{','}','[',']','<','>','=','"'),'',$this->db->qstr($pessoa->Nome));
		}

		if (!is_null($pessoa->Pai)){
			$columns[$c++] = "Pai";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Pai));
		}

		if (!is_null($pessoa->Mae)){
			$columns[$c++] = "Mae";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Mae));
		}

		if (!is_null($pessoa->Nascimento)){
			$columns[$c++] = "Nascimento";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->Nascimento));
		}

		if (!is_null($pessoa->LocalNascimento)){
			$columns[$c++] = "LocalNascimento";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->LocalNascimento));
		}

		if (!is_null($pessoa->UFNascimento)){
			$columns[$c++] = "UFNascimento";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->UFNascimento));
		}

		if (!is_null($pessoa->Sexo)){
			$columns[$c++] = "Sexo";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Sexo));
		}

		if (!is_null($pessoa->DeficienteFisico)){
			$columns[$c++] = "DeficienteFisico";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->DeficienteFisico));
		}

		if (!is_null($pessoa->BenefReabilitado)){
			$columns[$c++] = "BenefReabilitado";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->BenefReabilitado));
		}

		if (!is_null($pessoa->Estudando)){
			$columns[$c++] = "Estudando";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Estudando));
		}

		if (!is_null($pessoa->EstaTrabalhando)){
			$columns[$c++] = "EstaTrabalhando";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->EstaTrabalhando));
		}

		if (!is_null($pessoa->Nacionalidade)){
			$columns[$c++] = "Nacionalidade";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Nacionalidade));
		}

		if (!is_null($pessoa->ValidadeVisto)){
			$columns[$c++] = "ValidadeVisto";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->ValidadeVisto));
		}

		if (!is_null($pessoa->AnoChegadaBrasil)){
			$columns[$c++] = "AnoChegadaBrasil";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->AnoChegadaBrasil));
		}

		if (!is_null($pessoa->Visto)){
			$columns[$c++] = "Visto";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->Visto));
		}

		if (!is_null($pessoa->TipoIdentidade)){
			$columns[$c++] = "TipoIdentidade";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->TipoIdentidade));
		}

		if (!is_null($pessoa->ConselhoClasse)){
			$columns[$c++] = "ConselhoClasse";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->ConselhoClasse));
		}

		if (!is_null($pessoa->RegistroConselho)){
			$columns[$c++] = "RegistroConselho";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->RegistroConselho));
		}

		if (!is_null($pessoa->DataRegistro)){
			$columns[$c++] = "DataRegistro";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->DataRegistro));
		}

		if (!is_null($pessoa->Cep)){
			$columns[$c++] = "Cep";
			$values[$v++] = preg_replace('#[^\pL\pN./\'. -]+# ', '', $this->db->qstr($pessoa->Cep));
		}

		if (!is_null($pessoa->Rua)){
			$columns[$c++] = "Rua";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Rua));
		}

		if (!is_null($pessoa->NroRua)){
			$columns[$c++] = "NroRua";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->NroRua));
		}

		if (!is_null($pessoa->Complemento)){
			$columns[$c++] = "Complemento";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Complemento));
		}

		if (!is_null($pessoa->Cidade)){
			$columns[$c++] = "Cidade";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Cidade));
		}

		if (!is_null($pessoa->UF)){
			$columns[$c++] = "UF";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->UF));
		}

		if (!is_null($pessoa->DDD)){
			$columns[$c++] = "DDD";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->DDD));
		}

		if (!is_null($pessoa->Telefone)){
			$columns[$c++] = "Telefone";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Telefone));
		}

		if (!is_null($pessoa->DDDCelular)){
			$columns[$c++] = "DDDCelular";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->DDDCelular));
		}

		if (!is_null($pessoa->TelefoneCelular)){
			$columns[$c++] = "TelefoneCelular";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->TelefoneCelular));
		}

		if (!is_null($pessoa->Email)){
			$columns[$c++] = "Email";
			$values[$v++] = preg_replace('#[^\pL\pN./\'@:_ -]+# ', '', $this->db->qstr($pessoa->Email));
		}

		if (!is_null($pessoa->UltAlteracao)){
			$columns[$c++] = "UltAlteracao";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->UltAlteracao));
		}

		if (!is_null($pessoa->DataCadastramento)){
			$columns[$c++] = "DataCadastramento";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->DataCadastramento));
		}

		if (!is_null($pessoa->CPF)){
			$columns[$c++] = "CPF";
			$values[$v++] = preg_replace('#[^\pL\pN./\'. -]+# ', '', $this->db->qstr($pessoa->CPF));
		}

		if (!is_null($pessoa->Bairro)){
			$columns[$c++] = "Bairro";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Bairro));
		}

		if (!is_null($pessoa->RegistroHabilitacao)){
			$columns[$c++] = "RegistroHabilitacao";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->RegistroHabilitacao));
		}

		if (!is_null($pessoa->CategoriaHabilitacao)){
			$columns[$c++] = "CategoriaHabilitacao";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->CategoriaHabilitacao));
		}

		if (!is_null($pessoa->ValidadeHabilitacao)){
			$columns[$c++] = "ValidadeHabilitacao";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->ValidadeHabilitacao));
		}

        if (!is_null($pessoa->PIS)){
			$columns[$c++] = "PIS";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->PIS));
		}

        if (!is_null($pessoa->DataPIS)){
			$columns[$c++] = "DataPIS";
			$values[$v++] = preg_replace('#[^\pL\pN./\': -]+# ', '', $this->db->qstr($pessoa->DataPIS));
		}

        if (!is_null($pessoa->PossuiPIS)){
			$columns[$c++] = "PossuiPIS";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->PossuiPIS));
		}

        if (!is_null($pessoa->AceiteTermo)){
			$columns[$c++] = "AceiteTermo";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->AceiteTermo));
		}

        if (!is_null($pessoa->Excluir)){
			$columns[$c++] = "Excluir";
			$values[$v++] = preg_replace('#[^\pL\pN./\' -]+# ', '', $this->db->qstr($pessoa->Excluir));
		}

		$statement[0] = $columns;
		$statement[1] = $values;

		return $statement;
	}

	function criarPessoa(Pessoa $pessoa){
		$statement = $this->prepareStatement($pessoa);

		$columns = $statement[0];
		$values = $statement[1];

		$sql = "INSERT INTO rhpessoas (";
		$sql .= implode(', ', $columns) . ") VALUES (";
		$sql .= implode(', ', $values) . ")";

		return $this->db->Execute($sql);
	}

    function atualizaEmail($empresa,$cpf,$email){
        $sql = "UPDATE rhpessoas SET Email = ?, UltAlteracao = '". date("Y-m-d H:i:s") ."' WHERE Empresa = ? And Cpf = ?" ;

		$query = $this->db->prepare($sql);
		$pCpf =  preg_replace('#[^\pL\pN./\' -]+# ', '', $cpf);
		$pEmpresa =  preg_replace('#[^\pL\pN./\' -]+# ', '', $empresa);
		$pEmail =  preg_replace('#[^\pL\pN./\'@_ -]+# ', '', $email);

        return $this->db->Execute($query,array($pEmail,$pEmpresa,$pCpf));
    }

	function salvar(Pessoa $pessoa){
        $ListaQuery = array();
		$sql = "UPDATE rhpessoas SET ";

		$columns = array();
		$statement = array();
		$c = 0;
		$v = 0;

		if (!is_null($pessoa->Nome)){
			$columns[$c++] = "Nome = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Nome));
		}

		if (!is_null($pessoa->Pai)){
			$columns[$c++] = "Pai = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Pai));
		}

		if (!is_null($pessoa->Mae)){
		    $columns[$c++] = "Mae = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Mae));
		}

		if (!is_null($pessoa->Nascimento)){
			$columns[$c++] = "Nascimento = ".preg_replace('#[^\pL\pN./\': -]+# ', '',$this->db->qstr($pessoa->Nascimento));
		}

		if (!is_null($pessoa->LocalNascimento)){
			$columns[$c++] = "LocalNascimento = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->LocalNascimento));
		}

		if (!is_null($pessoa->UFNascimento)){
			$columns[$c++] = "UFNascimento = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->UFNascimento));
		}

		if (!is_null($pessoa->Sexo)){
			$columns[$c++] = "Sexo = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Sexo));
		}

		if (!is_null($pessoa->EstadoCivil)){
			$columns[$c++] = "EstadoCivil = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->EstadoCivil));
		}

		if (!is_null($pessoa->GrauInstrucao)){
			$columns[$c++] = "GrauInstrucao = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->GrauInstrucao));
		}

		if (!is_null($pessoa->PretensaoSalarial)){
			$columns[$c++] = "PretensaoSalarial = ".preg_replace('#[^\pL\pN./\'., -]+# ', '',$this->db->qstr($pessoa->PretensaoSalarial));
		}

		if (!is_null($pessoa->DeficienteFisico)){
			$columns[$c++] = "DeficienteFisico = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->DeficienteFisico));
		}

		if (!is_null($pessoa->BenefReabilitado)){
			$columns[$c++] = "BenefReabilitado = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->BenefReabilitado));
		}

		if (!is_null($pessoa->Estudando)){
			$columns[$c++] = "Estudando = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Estudando));
		}

		if (!is_null($pessoa->EstaTrabalhando)){
			$columns[$c++] = "EstaTrabalhando = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->EstaTrabalhando));
		}

		if (!is_null($pessoa->Nacionalidade)){
			$columns[$c++] = "Nacionalidade = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Nacionalidade));
		}

		if (!is_null($pessoa->ValidadeVisto)){
			if (trim($pessoa->ValidadeVisto) != ''){
				$columns[$c++] = "ValidadeVisto = ".preg_replace('#[^\pL\pN./\': -]+# ', '',$this->db->qstr($pessoa->ValidadeVisto));
			}else{
				$columns[$c++] = "ValidadeVisto = null " ;
			}
		}

		if (!is_null($pessoa->AnoChegadaBrasil)){
			if(trim($pessoa->AnoChegadaBrasil) != ''){
				$columns[$c++] = "AnoChegadaBrasil = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->AnoChegadaBrasil));
			} else{
				$columns[$c++] = "AnoChegadaBrasil = null " ;
			}
		}

		if (!is_null($pessoa->TipoVisto)){
			$columns[$c++] = "TipoVisto = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->TipoVisto));
		}

		if (!is_null($pessoa->Identidade)){
			$columns[$c++] = "Identidade = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Identidade));
		}

		if (!is_null($pessoa->TipoIdentidade)){
			$columns[$c++] = "TipoIdentidade = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->TipoIdentidade));
		}

		if (!is_null($pessoa->ConselhoClasse)){
			$columns[$c++] = "ConselhoClasse = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->ConselhoClasse));
		}

		if (!is_null($pessoa->RegistroConselho)){
			$columns[$c++] = "RegistroConselho = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->RegistroConselho));
		}

		if (!is_null($pessoa->DataRegistro)){
			if(trim($pessoa->DataRegistro) != ''){
				$columns[$c++] = "DataRegistro = ".preg_replace('#[^\pL\pN./\': -]+# ', '',$this->db->qstr($pessoa->DataRegistro));
			} else{
				$columns[$c++] = "DataRegistro = null " ;
			}
		}

		if (!is_null($pessoa->Cep)){
			$columns[$c++] = "Cep = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Cep));
		}

		if (!is_null($pessoa->Rua)){
			$columns[$c++] = "Rua = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Rua));
		}

		if (!is_null($pessoa->NroRua)){
			$columns[$c++] = "NroRua = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->NroRua));
		}

		if (!is_null($pessoa->Complemento)){
			$columns[$c++] = "Complemento = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Complemento));
		}

		if (!is_null($pessoa->Cidade)){
			$columns[$c++] = "Cidade = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Cidade));
		}

		if (!is_null($pessoa->UF)){
			$columns[$c++] = "UF = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->UF));
		}

		if (!is_null($pessoa->DDD)){
			$columns[$c++] = "DDD = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->DDD));
		}

		if (!is_null($pessoa->Telefone)){
			$columns[$c++] = "Telefone = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Telefone));
		}

		if (!is_null($pessoa->DDDCelular)){
			$columns[$c++] = "DDDCelular = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->DDDCelular));
		}

		if (!is_null($pessoa->TelefoneCelular)){
			$columns[$c++] = "TelefoneCelular = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->TelefoneCelular));
		}
        
		if (!is_null($pessoa->Email)){
			$columns[$c++] = "Email = ".preg_replace('#[^\pL\pN./\'@_. -]+# ', '',$this->db->qstr($pessoa->Email));
		}

		if (!is_null($pessoa->UltAlteracao)){
			$columns[$c++] = "UltAlteracao = ".preg_replace('#[^\pL\pN./\': -]+# ', '',$this->db->qstr($pessoa->UltAlteracao));
			$_SESSION["UltAlteracao"] = $pessoa->UltAlteracao;
		}

		if (!is_null($pessoa->Bairro)){
			$columns[$c++] = "Bairro = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Bairro));
		}

		if (!is_null($pessoa->RegistroHabilitacao)){
			$columns[$c++] = "RegistroHabilitacao = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->RegistroHabilitacao));
		}

		if (!is_null($pessoa->CategoriaHabilitacao)){
			$columns[$c++] = "CategoriaHabilitacao = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->CategoriaHabilitacao));
		}

		if (!is_null($pessoa->ValidadeHabilitacao)){
			if(trim($pessoa->ValidadeHabilitacao) != ''){
				$columns[$c++] = "ValidadeHabilitacao = ".preg_replace('#[^\pL\pN./\': -]+# ', '',$this->db->qstr($pessoa->ValidadeHabilitacao));
			}else{
				$columns[$c++] = "ValidadeHabilitacao = null " ;
			}
		}

        if (!is_null($pessoa->PIS)){
			$columns[$c++] = "PIS = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->PIS));
		}

		if (!is_null($pessoa->DataPIS)){
			if(trim($pessoa->DataPIS) != ''){
				$columns[$c++] = "DataPIS = ".preg_replace('#[^\pL\pN./\': -]+# ', '',$this->db->qstr($pessoa->DataPIS));
			} else{
				$columns[$c++] = "DataPIS = null " ;
			}
		}

        if (!is_null($pessoa->PossuiPIS)){
			$columns[$c++] = "PossuiPIS = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->PossuiPIS));
		}

		$sql .= implode(',', $columns);
		$sql .= " WHERE Pessoa = ".preg_replace('#[^\pL\pN./\' -]+# ', '',$this->db->qstr($pessoa->Pessoa)).";";

        $query = $this->db->prepare($sql);

		return  $this->db->Execute($query);

	}
}

?>