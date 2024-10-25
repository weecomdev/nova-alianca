<?php

/* Report simple running errors */
ini_set('error_reporting', E_ALL ^ E_NOTICE);
/* Set the display_errors directive to Off */
ini_set('display_errors', 1);
/* Log errors to the web server's error log */
ini_set('log_errors', 1);
/* Sets the memory usage limit of the process */
ini_set('memory_limit', '1600M');
/* Sets the execution time limit of the running process */
//ini_set('max_execution_time', '3600');
/* Define a quantidade de pessoas por pacote. */
define('TAMANHO_PACOTE', 200);

require_once('padraoServicos.php');
require_once('lib/nusoap.php');
require_once("lib/class.simetric.php");
require_once("../site/lib/phpmailer/PHPMailerAutoload.php");
require_once('../site/model/MetaMail.php');
require_once("../site/lib/config.php");
require_once("../site/dao/CandidatoWebDirDao.php");
require_once("../site/dao/PessoaDao.php");
require_once("../site/model/Pessoa.php");
require_once("../site/dao/UsuarioDao.php");
require_once("../site/dao/PessoaIdiomaDao.php");
require_once("../site/dao/PessoaDadoComplementarDao.php");
require_once("../site/dao/PessoaRequisitoDao.php");
require_once("../site/dao/PessoaAreaInteresseDao.php");
require_once("../site/dao/PessoaCargPretendDao.php");
require_once("../site/dao/PessoaCursoDao.php");
require_once("../site/dao/EmpresaAnteriorDao.php");
require_once("../site/dao/PessoaFuncPretendDao.php");
require_once("../site/dao/PessoaPalavraChaveDao.php");
require_once("../site/dao/RequisicaoTurmaDao.php");
require_once("../site/dao/PessoaEmpresaAnteriorExpDao.php");
require_once("../site/dao/PessoaFotoDao.php");
require_once("../site/dao/PessoaAnexoDao.php");

function enviar($empresa, $dataCorte, $ticketLogin) {
    global $server;
    global $db;
        
    $simetricKey = pegarChave($empresa);
    if(!tentaExcluirTicket($ticketLogin)){
        return "Login inválido!";
    }
    
    /* Busca os candidatos. */
    $pDao = new PessoaDao($db);
	$pModel = new Pessoa();
    
    /* Usado para limitar o número registros retornados pelo SQL ao tamanho do pacote,
     * é inclusa uma margem de segurança de 50 registros devido ao teste da última 
     * alteração da pessoa ser igual a da pessoa anterior. Se este parâmetro for null
     * então são retornados todos os registros o que pode diminuir a performance do SQL */
    $limit = constant('TAMANHO_PACOTE') + 50;
        
    /* Cria cabeçalho do XML. */
    $dom    = new DomDocument("1.0", "UTF-8");
    $pacote = $dom->createElement('Pacote');    
    
    $quantidadePessoas = $pDao->countPessoas($empresa, $dataCorte);    
    if ($quantidadePessoas > 0){ 
        
        $numeroPacotesRestantes = ceil($quantidadePessoas / constant('TAMANHO_PACOTE'));
        $numeroPessoasCorrente  = 0;
        $dataCandidatoCorrente  = null;
        
        $listaPessoa = $pDao->buscarPessoas($empresa, $dataCorte, $limit);        
        while (!$listaPessoa->EOF) {
            $numeroPessoasCorrente++;
            
            $pModel->Empresa = $listaPessoa->fields['Empresa'];
            $pModel->Pessoa = $listaPessoa->fields['Pessoa'];
            
            $dataCandidatoCorrente = $listaPessoa->fields['UltAlteracao'];
			   
            /* Geração de Dados da Pessoa Corrente - Início. */
            
            criarElementoPessoa($dom, $pacote, $listaPessoa);  
            
            criarElementosUsuarioPorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosIdiomaPorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosDadosComplementaresPorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosRequisitoPorPessoa($dom, $pacote, $pModel, $db);           
            
            criarElementosAreasInteressePorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosCursosRsPorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosEmpresasAnterioresPorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosEmpresasAnterioresExpPorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosPalavraChavePorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosRequisicaoTurmaPorPessoa($dom, $pacote, $pModel, $db);     
            
            criarElementosFotosPorPessoa($dom, $pacote, $pModel, $db);
            
            criarElementosAnexoPorPessoa($dom, $pacote, $pModel, $db);
            
            /* Geração de Dados da Pessoa Corrente - Fim. */
            
            $listaPessoa-> MoveNext();
            
            if ($numeroPessoasCorrente >= constant('TAMANHO_PACOTE')){
                if (!$listaPessoa->EOF){                             
                    /* Caso a pessoa corrente tenha a mesma data de última alteração da
                     * pessoa anterior é permitido que o pacote continue a crescer, porém,
                     * se for diferente o pacote é encerrado. Isto é feito pois o controle
                     * de início do pacote é dado pela data da última alteração, ou seja,
                     * a última pessoa alterada, sendo feito então este teste para que 
                     * nenhum candidato acabe ficando de fora. */
                    if ($listaPessoa->fields['UltAlteracao'] != $dataCandidatoCorrente)
                        break;
                }
                else{
                    break;
                }
            }
        }
        
        $pacote->setAttribute('ULTIMADATA', utf8_encode($dataCandidatoCorrente));
        $pacote->setAttribute('PACOTESRESTANTES', utf8_encode($numeroPacotesRestantes));
        $pacote->setAttribute('PESSOASPACOTE', utf8_encode($numeroPessoasCorrente));
    } else {        
        $now = date('Y-m-d H:i:s');
        $pacote->setAttribute('ULTIMADATA', utf8_encode($now));
        $pacote->setAttribute('PACOTESRESTANTES', utf8_encode(0));
        $pacote->setAttribute('PESSOASPACOTE', utf8_encode(0));
    }
      
    $dom->appendChild($pacote);
    $dom->formatOutput = true;
       
    return criptografarXML($dom->saveXML(), $simetricKey);    
}

function criptografarXML($xml, $key){        	
	$simetric = new key_simetric();		
	$xml = "FFFFFFFFFFFFFFFF" . $xml;    
	$simetric->set_key(hash('sha256', $key, true));
	$simetric->set_text($xml);
	$simetric->encrypt();    
	$crypt = $simetric->get_hex_crypt();	
	return $crypt;
}

function criarElementoPessoa(DOMDocument $dom, DOMElement $pacote, $pessoaCorrente){    
    $elemento = $dom->createElement('RHPESSOAS');   
    $elemento->setAttribute('EMPRESA', getTextoValido($pessoaCorrente->fields['Empresa']));
    $elemento->setAttribute('PESSOA', utf8_encode($pessoaCorrente->fields['Pessoa']));
	$elemento->setAttribute('NOME', getTextoValido($pessoaCorrente->fields['Nome']));
	$elemento->setAttribute('NOMECOMPLETO', getTextoValido($pessoaCorrente->fields['NomeCompleto']));
	$elemento->setAttribute('APELIDO', getTextoValido($pessoaCorrente->fields['Apelido']));
	$elemento->setAttribute('DATACADASTRAMENTO', utf8_encode($pessoaCorrente->fields['DataCadastramento']));
	$elemento->setAttribute('NOMEARQUIVOFOTO',getTextoValido($pessoaCorrente->fields['NomeArquivoFoto']));
	$elemento->setAttribute('FOTO', utf8_encode($pessoaCorrente->fields['Foto']));
	$elemento->setAttribute('PAI', getTextoValido($pessoaCorrente->fields['Pai']));
	$elemento->setAttribute('MAE', getTextoValido($pessoaCorrente->fields['Mae']));
	$elemento->setAttribute('NASCIMENTO', utf8_encode($pessoaCorrente->fields['Nascimento']));
	$elemento->setAttribute('LOCALNASCIMENTO',getTextoValido($pessoaCorrente->fields['LocalNascimento']));
	$elemento->setAttribute('UFNASCIMENTO', getTextoValido($pessoaCorrente->fields['UFNascimento']));
	$elemento->setAttribute('SEXO', getTextoValido($pessoaCorrente->fields['Sexo']));
	$elemento->setAttribute('RACACOR', getTextoValido($pessoaCorrente->fields['RacaCor']));
	$elemento->setAttribute('DEFICIENTEFISICO', getTextoValido($pessoaCorrente->fields['DeficienteFisico']));
	$elemento->setAttribute('BENEREABILITADO', getTextoValido($pessoaCorrente->fields['BenefReabilitado']));
	$elemento->setAttribute('ESTUDANDO', getTextoValido($pessoaCorrente->fields['Estudando']));
	$elemento->setAttribute('CONSELHOCLASSE', getTextoValido($pessoaCorrente->fields['ConselhoClasse']));
	$elemento->setAttribute('REGISTROCONSELHO', getTextoValido($pessoaCorrente->fields['RegistroConselho']));
	$elemento->setAttribute('DATAREGISTRO', utf8_encode($pessoaCorrente->fields['DataRegistro']));
	$elemento->setAttribute('INSCRICAOSINDICATO',getTextoValido($pessoaCorrente->fields['InscricaoSindicato']));
	$elemento->setAttribute('RUA', getTextoValido($pessoaCorrente->fields['Rua']));
	$elemento->setAttribute('NRORUA', getTextoValido($pessoaCorrente->fields['NroRua']));
	$elemento->setAttribute('COMPLEMENTO', getTextoValido($pessoaCorrente->fields['Complemento']));
	$elemento->setAttribute('BAIRRO', getTextoValido($pessoaCorrente->fields['Bairro']));
	$elemento->setAttribute('CIDADE', getTextoValido($pessoaCorrente->fields['Cidade']));
	$elemento->setAttribute('CEP', getTextoValido($pessoaCorrente->fields['Cep']));
	$elemento->setAttribute('UF', getTextoValido($pessoaCorrente->fields['UF']));
	$elemento->setAttribute('DDD', getTextoValido($pessoaCorrente->fields['DDD']));
	$elemento->setAttribute('TELEFONE', getTextoValido($pessoaCorrente->fields['Telefone']));
	$elemento->setAttribute('RAMAL', getTextoValido($pessoaCorrente->fields['Ramal']));
	$elemento->setAttribute('TELEFONERECADOS',getTextoValido($pessoaCorrente->fields['TelefoneRecados']));
	$elemento->setAttribute('DDDCELULAR', getTextoValido($pessoaCorrente->fields['DDDCelular']));
	$elemento->setAttribute('TELEFONECELULAR',getTextoValido($pessoaCorrente->fields['TelefoneCelular']));
	$elemento->setAttribute('EMAIL', getTextoValido($pessoaCorrente->fields['Email']));
	$elemento->setAttribute('INICIORESIDENCIA',utf8_encode($pessoaCorrente->fields['InicioResidencia']));
	$elemento->setAttribute('ULALTENDERECO',utf8_encode($pessoaCorrente->fields['UltAltEndereco']));
	$elemento->setAttribute('NROCARTTRAB', getTextoValido($pessoaCorrente->fields['NroCartTrab']));
	$elemento->setAttribute('SERIECARTTRABALHO',getTextoValido($pessoaCorrente->fields['SerieCartTrab']));
	$elemento->setAttribute('DATACARTTRAB', utf8_encode($pessoaCorrente->fields['DataCartTrab']));
	$elemento->setAttribute('UFCARTTRAB', getTextoValido($pessoaCorrente->fields['UFCartTrab']));
	$elemento->setAttribute('PIS', getTextoValido($pessoaCorrente->fields['PIS']));
	$elemento->setAttribute('DATAPIS', utf8_encode($pessoaCorrente->fields['DataPIS']));
	$elemento->setAttribute('CPF', getTextoValido($pessoaCorrente->fields['CPF']));
	$elemento->setAttribute('TIPOIDENTIDADE',getTextoValido($pessoaCorrente->fields['TipoIdentidade']));
	$elemento->setAttribute('IDENTIDADE', getTextoValido($pessoaCorrente->fields['Identidade']));
	$elemento->setAttribute('DATAIDENTIDADE',utf8_encode($pessoaCorrente->fields['DataIdentidade']));
	$elemento->setAttribute('ORGAOEMISSOR', getTextoValido($pessoaCorrente->fields['OrgaoEmissor']));
	$elemento->setAttribute('UFIDENTIDADE', getTextoValido($pessoaCorrente->fields['UFIdentidade']));
	$elemento->setAttribute('ANOCHEGADABRASIL',utf8_encode($pessoaCorrente->fields['AnoChegadaBrasil']));
	$elemento->setAttribute('TIPOVISTO', getTextoValido($pessoaCorrente->fields['TipoVisto']));
	$elemento->setAttribute('VALIDADEVISTO',utf8_encode($pessoaCorrente->fields['ValidadeVisto']));
	$elemento->setAttribute('TITULOELEITORAL',getTextoValido($pessoaCorrente->fields['TituloEleitoral']));
	$elemento->setAttribute('ZONAELEITORAL',getTextoValido($pessoaCorrente->fields['ZonaEleitoral']));
	$elemento->setAttribute('SECAOELEITORAL',getTextoValido($pessoaCorrente->fields['SecaoEleitoral']));
	$elemento->setAttribute('TIPOSANGUINEO',getTextoValido($pessoaCorrente->fields['TipoSanguineo']));
	$elemento->setAttribute('DOADORSANGUE', getTextoValido($pessoaCorrente->fields['DoadorSangue']));
	$elemento->setAttribute('DATADOACAO', utf8_encode($pessoaCorrente->fields['DataDoacao']));
	$elemento->setAttribute('APOSENTADO', getTextoValido($pessoaCorrente->fields['Aposentado']));
	$elemento->setAttribute('DATAAPOSENTADORIA',utf8_encode($pessoaCorrente->fields['DataAposentadoria']));
	$elemento->setAttribute('EMITEGRCI', getTextoValido($pessoaCorrente->fields['EmiteGRCI']));
	$elemento->setAttribute('MATRICULAINSS',getTextoValido($pessoaCorrente->fields['MatriculaINSS']));
	$elemento->setAttribute('CODIGOPGTOGPS',getTextoValido($pessoaCorrente->fields['CodigoPagtoGPS']));
	$elemento->setAttribute('CLASSEINSS', getTextoValido($pessoaCorrente->fields['ClasseINSS']));
	$elemento->setAttribute('TROCACLASSE', getTextoValido($pessoaCorrente->fields['TrocaClasse']));
	$elemento->setAttribute('ULTTROCACLASSE',utf8_encode($pessoaCorrente->fields['UltTrocaClasse']));
	$elemento->setAttribute('DESCONTAINSSPAGTO',getTextoValido($pessoaCorrente->fields['DescontaINSSPagto']));
	$elemento->setAttribute('USADEDUCAOGRCI',getTextoValido($pessoaCorrente->fields['UsaDeducaoGRCI']));
	$elemento->setAttribute('ULTALTERACAO', utf8_encode($pessoaCorrente->fields['UltAlteracao']));
	$elemento->setAttribute('CONTRATOSATIVOS',utf8_encode($pessoaCorrente->fields['ContratosAtivos']));
	$elemento->setAttribute('CONTRATOSRESCINDIDOS',utf8_encode($pessoaCorrente->fields['ContratosRescindidos']));
	$elemento->setAttribute('CONTRATOSAUTONOMOS',utf8_encode($pessoaCorrente->fields['ContratosAutonomos']));
	$elemento->setAttribute('FAMILIARESCADASTRADOS',utf8_encode($pessoaCorrente->fields['FamiliaresCadastrados']));
	$elemento->setAttribute('PENSIONISTASCADASTRADOS',utf8_encode($pessoaCorrente->fields['PensionistasCadastrados']));
	$elemento->setAttribute('USAFOLHA', getTextoValido($pessoaCorrente->fields['UsaFolha']));
	$elemento->setAttribute('USAPONTO', getTextoValido($pessoaCorrente->fields['UsaPonto']));
	$elemento->setAttribute('USARECRUTAMENTO',getTextoValido($pessoaCorrente->fields['UsaRecrutamento']));
	$elemento->setAttribute('USATREINAMETO',getTextoValido($pessoaCorrente->fields['UsaTreinamento']));
	$elemento->setAttribute('USACARGOSSALARIOS',getTextoValido($pessoaCorrente->fields['UsaCargosSalarios']));
	$elemento->setAttribute('USAGESTAOSALARIAL',getTextoValido($pessoaCorrente->fields['UsaGestaoSalarial']));
	$elemento->setAttribute('USASEGURANCA', getTextoValido($pessoaCorrente->fields['UsaSeguranca']));
	$elemento->setAttribute('USAPCMSO', getTextoValido($pessoaCorrente->fields['UsaPCMSO']));
	$elemento->setAttribute('USAVALETRANSP',getTextoValido($pessoaCorrente->fields['UsaValeTransp']));
	$elemento->setAttribute('CANDIDATOREJEITADO',getTextoValido($pessoaCorrente->fields['CandidatoRejeitado']));
	$elemento->setAttribute('ESTATRABALHANDO',getTextoValido($pessoaCorrente->fields['EstaTrabalhando']));
	$elemento->setAttribute('PRETENSAOSALARIAL',utf8_encode($pessoaCorrente->fields['PretensaoSalarial']));
	$elemento->setAttribute('PROXIMAAVALIACAO',utf8_encode($pessoaCorrente->fields['ProximaAvaliacao']));
	$elemento->setAttribute('TEMPOMEDIOEMPREGO',utf8_encode($pessoaCorrente->fields['TempoMedioEmprego']));
	$elemento->setAttribute('ULTALTERACAOCV',utf8_encode($pessoaCorrente->fields['UltAlteracaoCV']));
	$elemento->setAttribute('DATACARENCIASELECAO',utf8_encode($pessoaCorrente->fields['DataCarenciaSelecao']));
	$elemento->setAttribute('ESTADOCIVIL', getTextoValido($pessoaCorrente->fields['EstadoCivil']));
	$elemento->setAttribute('GRAUINSTRUCAO',getTextoValido($pessoaCorrente->fields['GrauInstrucao']));
	$elemento->setAttribute('NACIONALIDADE',getTextoValido($pessoaCorrente->fields['Nacionalidade']));
	$elemento->setAttribute('HABILITACAOPROFISSIONAL',getTextoValido($pessoaCorrente->fields['HabilitacaoProfissional']));
	$elemento->setAttribute('TIPORESIDENCIA',getTextoValido($pessoaCorrente->fields['TipoResidencia']));
	$elemento->setAttribute('SINDICATO', getTextoValido($pessoaCorrente->fields['Sindicato']));
	$elemento->setAttribute('CNAE', getTextoValido($pessoaCorrente->fields['CNAE']));
	$elemento->setAttribute('CHAVEOUTROSISTEMA',utf8_encode($pessoaCorrente->fields['ChaveOutroSistema']));
	$elemento->setAttribute('BASEINSSFOLHAFERIASOE',utf8_encode($pessoaCorrente->fields['BaseINSSFolhaFeriasOE']));
	$elemento->setAttribute('BASEINSS13SALARIOOE',utf8_encode($pessoaCorrente->fields['BaseINSS13SalarioOE']));
	$elemento->setAttribute('USAMODULO01', getTextoValido($pessoaCorrente->fields['UsaModulo01']));
	$elemento->setAttribute('USAMODULO02', getTextoValido($pessoaCorrente->fields['UsaModulo02']));
	$elemento->setAttribute('USAMODULO03', getTextoValido($pessoaCorrente->fields['UsaModulo03']));
	$elemento->setAttribute('USAMODULO04', getTextoValido($pessoaCorrente->fields['UsaModulo04']));
	$elemento->setAttribute('USAMODULO05', getTextoValido($pessoaCorrente->fields['UsaModulo05']));
	$elemento->setAttribute('USAMODULO06', getTextoValido($pessoaCorrente->fields['UsaModulo06']));
	$elemento->setAttribute('USAMODULO07', getTextoValido($pessoaCorrente->fields['UsaModulo07']));
	$elemento->setAttribute('USAMODULO08', getTextoValido($pessoaCorrente->fields['UsaModulo08']));
	$elemento->setAttribute('USAMODULO09', getTextoValido($pessoaCorrente->fields['UsaModulo09']));
	$elemento->setAttribute('USAMODULO10', getTextoValido($pessoaCorrente->fields['UsaModulo10']));
	$elemento->setAttribute('USAMODULO11', getTextoValido($pessoaCorrente->fields['UsaModulo11']));
	$elemento->setAttribute('USAMODULO12', getTextoValido($pessoaCorrente->fields['UsaModulo12']));
	$elemento->setAttribute('USAMODULO13', getTextoValido($pessoaCorrente->fields['UsaModulo13']));
	$elemento->setAttribute('USAMODULO14', getTextoValido($pessoaCorrente->fields['UsaModulo14']));
	$elemento->setAttribute('USAMODULO15', getTextoValido($pessoaCorrente->fields['UsaModulo15']));
	$elemento->setAttribute('USAMODULO16', getTextoValido($pessoaCorrente->fields['UsaModulo16']));
	$elemento->setAttribute('USAMODULO17', getTextoValido($pessoaCorrente->fields['UsaModulo17']));
	$elemento->setAttribute('USAMODULO18', getTextoValido($pessoaCorrente->fields['UsaModulo18']));
	$elemento->setAttribute('USAMODULO19', getTextoValido($pessoaCorrente->fields['UsaModulo19']));
	$elemento->setAttribute('USAMODULO20', getTextoValido($pessoaCorrente->fields['UsaModulo20']));	
	$elemento->setAttribute('REGISTROHABILITACAO', getTextoValido($pessoaCorrente->fields['RegistroHabilitacao']));
	$elemento->setAttribute('CATEGORIAHABILITACAO', getTextoValido($pessoaCorrente->fields['CategoriaHabilitacao']));
	$elemento->setAttribute('VALIDADEHABILITACAO', utf8_encode($pessoaCorrente->fields['ValidadeHabilitacao']));        
    $elemento->setAttribute('PIS', getTextoValido($pessoaCorrente->fields['PIS']));    
    $elemento->setAttribute('DATAPIS', utf8_encode($pessoaCorrente->fields['DataPIS']));
    $elemento->setAttribute('ACEITETERMO', utf8_encode($pessoaCorrente->fields['AceiteTermo']));
    $elemento->setAttribute('EXCLUIR', utf8_encode($pessoaCorrente->fields['Excluir']));
    $pacote->appendChild($elemento);
}

function criarElementosUsuarioPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){    
    $uDao = new UsuarioDao($db);
    
    $listaUsuario = $uDao->buscarUsuarioPorParametros($pModel);
    while (!$listaUsuario->EOF){
        
        $elemento = $dom->createElement('BF2USUARIOS');
        $elemento->setAttribute('USUARIO', utf8_encode($listaUsuario->fields['Usuario']));
        $elemento->setAttribute('CPF', getTextoValido($listaUsuario->fields['Cpf']));	
        $elemento->setAttribute('PESSOA', utf8_encode($listaUsuario->fields['Pessoa']));
        $pacote->appendChild($elemento);
         
        $listaUsuario->MoveNext();
    }
}

function criarElementosIdiomaPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    $iDao = new PessoaIdiomaDao($db);    
    
    $listaPessoaIdioma = $iDao->buscarPessoaIdiomaPorParametros($pModel);
    while (!$listaPessoaIdioma->EOF) {
        
        $elemento = $dom->createElement('RHPESSOAIDIOMAS');
        $elemento->setAttribute('EMPRESA', getTextoValido($listaPessoaIdioma->fields['Empresa']));
        $elemento->setAttribute('PESSOA', utf8_encode($listaPessoaIdioma->fields['Pessoa']));
        $elemento->setAttribute('IDIOMA', getTextoValido($listaPessoaIdioma->fields['Idioma']));
        $elemento->setAttribute('NIVELIDIOMA', getTextoValido($listaPessoaIdioma->fields['NivelIdioma']));
        $elemento->setAttribute('ORIGEMCURRICULO', getTextoValido($listaPessoaIdioma->fields['OrigemCurriculo']));
        $pacote->appendChild($elemento);
        
        $listaPessoaIdioma->MoveNext();
    }   
}

function criarElementosDadosComplementaresPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){    
    $pdcDao = new PessoaDadoComplementarDao($db);
    
    $listaPessoasDadosCompl = $pdcDao->buscarPessoasDadosComplIdiomaPorParametros($pModel);
    while (!$listaPessoasDadosCompl->EOF) {
        
        $elemento = $dom->createElement('RHPESSOASDADOSCOMPL');
        $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoasDadosCompl->fields['Empresa']));
        $elemento->setAttribute('PESSOA',utf8_encode($listaPessoasDadosCompl->fields['Pessoa']));
        $elemento->setAttribute('OPCAOLIVRE1',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre1']));
        $elemento->setAttribute('OPCAOLIVRE2',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre2']));
        $elemento->setAttribute('OPCAOLIVRE3',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre3']));
        $elemento->setAttribute('OPCAOLIVRE4',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre4']));
        $elemento->setAttribute('OPCAOLIVRE5',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre5']));
        $elemento->setAttribute('OPCAOLIVRE6',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre6']));
        $elemento->setAttribute('OPCAOLIVRE7',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre7']));
        $elemento->setAttribute('OPCAOLIVRE8',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre8']));
        $elemento->setAttribute('OPCAOLIVRE9',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre9']));
        $elemento->setAttribute('OPCAOLIVRE10',getTextoValido($listaPessoasDadosCompl->fields['OpcaoLivre10']));
        $elemento->setAttribute('NUMEROLIVRE1',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre1']));
        $elemento->setAttribute('NUMEROLIVRE2',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre2']));
        $elemento->setAttribute('NUMEROLIVRE3',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre3']));
        $elemento->setAttribute('NUMEROLIVRE4',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre4']));
        $elemento->setAttribute('NUMEROLIVRE5',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre5']));
        $elemento->setAttribute('NUMEROLIVRE6',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre6']));
        $elemento->setAttribute('NUMEROLIVRE7',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre7']));
        $elemento->setAttribute('NUMEROLIVRE8',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre8']));
        $elemento->setAttribute('NUMEROLIVRE9',utf8_encode($listaPessoasDadosCompl->fields['NumeroLivre9']));
        $elemento->setAttribute('CODIGOLIVRE1',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre1']));
        $elemento->setAttribute('CODIGOLIVRE2',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre2']));
        $elemento->setAttribute('CODIGOLIVRE3',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre3']));
        $elemento->setAttribute('CODIGOLIVRE4',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre4']));
        $elemento->setAttribute('CODIGOLIVRE5',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre5']));
        $elemento->setAttribute('CODIGOLIVRE6',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre6']));
        $elemento->setAttribute('CODIGOLIVRE7',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre7']));
        $elemento->setAttribute('CODIGOLIVRE8',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre8']));
        $elemento->setAttribute('CODIGOLIVRE9',getTextoValido($listaPessoasDadosCompl->fields['CodigoLivre9']));
        $elemento->setAttribute('DATALIVRE1',utf8_encode($listaPessoasDadosCompl->fields['DataLivre1']));
        $elemento->setAttribute('DATALIVRE2',utf8_encode($listaPessoasDadosCompl->fields['DataLivre2']));
        $elemento->setAttribute('DATALIVRE3',utf8_encode($listaPessoasDadosCompl->fields['DataLivre3']));
        $elemento->setAttribute('DATALIVRE4',utf8_encode($listaPessoasDadosCompl->fields['DataLivre4']));
        $elemento->setAttribute('DATALIVRE5',utf8_encode($listaPessoasDadosCompl->fields['DataLivre5']));
        $elemento->setAttribute('DATALIVRE6',utf8_encode($listaPessoasDadosCompl->fields['DataLivre6']));
        $elemento->setAttribute('DATALIVRE7',utf8_encode($listaPessoasDadosCompl->fields['DataLivre7']));
        $elemento->setAttribute('DATALIVRE8',utf8_encode($listaPessoasDadosCompl->fields['DataLivre8']));
        $elemento->setAttribute('DATALIVRE9',utf8_encode($listaPessoasDadosCompl->fields['DataLivre9']));
        $elemento->setAttribute('VALORLIVRE1',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre1']));
        $elemento->setAttribute('VALORLIVRE2',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre2']));
        $elemento->setAttribute('VALORLIVRE3',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre3']));
        $elemento->setAttribute('VALORLIVRE4',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre4']));
        $elemento->setAttribute('VALORLIVRE5',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre5']));
        $elemento->setAttribute('VALORLIVRE6',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre6']));
        $elemento->setAttribute('VALORLIVRE7',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre7']));
        $elemento->setAttribute('VALORLIVRE8',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre8']));
        $elemento->setAttribute('VALORLIVRE9',utf8_encode($listaPessoasDadosCompl->fields['ValorLivre9']));
        $elemento->setAttribute('TEXTOLIVRE1',getTextoValido($listaPessoasDadosCompl->fields['TextoLivre1']));
        $elemento->setAttribute('TEXTOLIVRE2',getTextoValido($listaPessoasDadosCompl->fields['TextoLivre2']));
        $elemento->setAttribute('TEXTOLIVRE3',getTextoValido($listaPessoasDadosCompl->fields['TextoLivre3']));
        $elemento->setAttribute('TEXTOLIVRE4',getTextoValido($listaPessoasDadosCompl->fields['TextoLivre4']));
        $elemento->setAttribute('TEXTOLIVRE5',getTextoValido($listaPessoasDadosCompl->fields['TextoLivre5']));
        $elemento->setAttribute('TEXTOLIVRE6',getTextoValido($listaPessoasDadosCompl->fields['TextoLivre6']));
        $elemento->setAttribute('MEMOLIVRE1',getTextoValido($listaPessoasDadosCompl->fields['MemoLivre1']));
        $elemento->setAttribute('MEMOLIVRE2',getTextoValido($listaPessoasDadosCompl->fields['MemoLivre2']));
        $elemento->setAttribute('MEMOLIVRE3',getTextoValido($listaPessoasDadosCompl->fields['MemoLivre3']));
        $elemento->setAttribute('MEMOLIVRE4',getTextoValido($listaPessoasDadosCompl->fields['MemoLivre4']));
        $elemento->setAttribute('MEMOLIVRE5',getTextoValido($listaPessoasDadosCompl->fields['MemoLivre5']));
        $elemento->setAttribute('MEMOLIVRE6',getTextoValido($listaPessoasDadosCompl->fields['MemoLivre6']));
        $pacote->appendChild($elemento);
                
        $listaPessoasDadosCompl->MoveNext();
    }
}

function criarElementosRequisitoPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    $prDao = new PessoaRequisitoDao($db);
    
    $listaPessoaRequisito = $prDao->buscarPessoaRequisitosPorParametros($pModel);
    while (!$listaPessoaRequisito->EOF) {
        
        $elemento = $dom->createElement('RHPESSOAREQUISITOS');
        $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoaRequisito->fields['Empresa']));
        $elemento->setAttribute('PESSOA',utf8_encode($listaPessoaRequisito->fields['Pessoa']));
        $elemento->setAttribute('REQUISITO',getTextoValido($listaPessoaRequisito->fields['Requisito']));
        $elemento->setAttribute('QUANTIDADEREQUISITO',utf8_encode($listaPessoaRequisito->fields['QuantidadeRequisito']));
        $elemento->setAttribute('TEXTOREQUISITO',getTextoValido($listaPessoaRequisito->fields['TextoRequisito']));
        $elemento->setAttribute('INDICEAVALIACAO',utf8_encode($listaPessoaRequisito->fields['IndiceAvaliacao']));
        $elemento->setAttribute('ITEM_AVALIACAO',getTextoValido($listaPessoaRequisito->fields['Item_Avaliacao']));
        $elemento->setAttribute('ORIGEMCURRICULO',getTextoValido($listaPessoaRequisito->fields['OrigemCurriculo']));
        $pacote->appendChild($elemento);        
        
        $listaPessoaRequisito->MoveNext();
    }
}

function criarElementosAreasInteressePorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    $paiDao = new PessoaAreaInteresseDao($db);
    
    $listaPessoaAreasInteres = $paiDao->buscarPessoaAreaInteresPorParametros($pModel);
    while (!$listaPessoaAreasInteres->EOF) {
        
        $elemento = $dom->createElement('RHPESSOAAREASINTERES');
        $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoaAreasInteres->fields['Empresa']));
        $elemento->setAttribute('PESSOA',utf8_encode($listaPessoaAreasInteres->fields['Pessoa']));
        $elemento->setAttribute('NROORDEM',utf8_encode($listaPessoaAreasInteres->fields['NroOrdem']));
        $elemento->setAttribute('EXIBIREXPERIENCIA',getTextoValido($listaPessoaAreasInteres->fields['ExibirExperiencia']));
        $elemento->setAttribute('CARGO',getTextoValido($listaPessoaAreasInteres->fields['Cargo']));
        $elemento->setAttribute('FUNCAO',getTextoValido($listaPessoaAreasInteres->fields['Funcao']));
        $elemento->setAttribute('AREAATUACAO',getTextoValido($listaPessoaAreasInteres->fields['AreaAtuacao']));
        $elemento->setAttribute('ORIGEMCURRICULO',getTextoValido($listaPessoaAreasInteres->fields['OrigemCurriculo']));
        $pacote->appendChild($elemento);        
        
        $listaPessoaAreasInteres->MoveNext();
    }
}

function criarElementosCursosRsPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    
    $pcDao = new PessoaCursoDao($db);
    $listaPessoaCursosRs = $pcDao->buscarPessoaCursosRsParametros($pModel);
    while (!$listaPessoaCursosRs->EOF) {
        
        $elemento = $dom->createElement('RHPESSOACURSOSRS');        
        $elemento->setAttribute('EMPRESA', getTextoValido($listaPessoaCursosRs->fields['Empresa']));
        $elemento->setAttribute('PESSOA', utf8_encode($listaPessoaCursosRs->fields['Pessoa']));
        $elemento->setAttribute('NROORDEM', utf8_encode($listaPessoaCursosRs->fields['NroOrdem']));
        $elemento->setAttribute('CURSO',getTextoValido($listaPessoaCursosRs->fields['Curso']));
        $elemento->setAttribute('DESCRICAO50',getTextoValido($listaPessoaCursosRs->fields['Descricao50']));
        $elemento->setAttribute('CARHORARIA',utf8_encode($listaPessoaCursosRs->fields['Car_Horaria']));
        $elemento->setAttribute('DTINICIO',utf8_encode($listaPessoaCursosRs->fields['Dt_Inicio']));
        $elemento->setAttribute('DTENCERRA',utf8_encode($listaPessoaCursosRs->fields['Dt_Encerra']));
        $elemento->setAttribute('DESCRICAO40',getTextoValido($listaPessoaCursosRs->fields['Descricao40']));
        $elemento->setAttribute('PROGRAMACURSO',getTextoValido($listaPessoaCursosRs->fields['ProgramaCurso']));
        $elemento->setAttribute('ORIGEMCURRICULO',getTextoValido($listaPessoaCursosRs->fields['OrigemCurriculo']));
        $pacote->appendChild($elemento);
        
        $listaPessoaCursosRs->MoveNext();
    }   
}

function criarElementosEmpresasAnterioresPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    
    $eaDao = new EmpresaAnteriorDao($db);    
    $listaEmpresasAnteriores = $eaDao->buscarEmpresasAnterioresPorParametros($pModel);
    while (!$listaEmpresasAnteriores->EOF) {
        
        $elemento = $dom->createElement('RHEMPRESASANTERIORES');
        $elemento->setAttribute('EMPRESA',getTextoValido($listaEmpresasAnteriores->fields['Empresa']));
        $elemento->setAttribute('PESSOA',utf8_encode($listaEmpresasAnteriores->fields['Pessoa']));
        $elemento->setAttribute('NROSEQUENCIA',utf8_encode($listaEmpresasAnteriores->fields['NroSequencia']));
        $elemento->setAttribute('DATAADMISSAO',utf8_encode($listaEmpresasAnteriores->fields['DataAdmissao']));
        $elemento->setAttribute('DATARESCISAO',utf8_encode($listaEmpresasAnteriores->fields['DataRescisao']));
        $elemento->setAttribute('EMPRESAANTERIOR',getTextoValido($listaEmpresasAnteriores->fields['EmpresaAnterior']));
        $elemento->setAttribute('SALARIOFINAL',utf8_encode($listaEmpresasAnteriores->fields['SalarioFinal']));
        $elemento->setAttribute('TIPOTRABALHO',getTextoValido($listaEmpresasAnteriores->fields['TipoTrabalho']));
        $elemento->setAttribute('MOTIVOSAIDA',getTextoValido($listaEmpresasAnteriores->fields['MotivoSaida']));
        $elemento->setAttribute('OBSERVACOES',getTextoValido($listaEmpresasAnteriores->fields['Observacoes']));
        $elemento->setAttribute('ESTATRABALHANDO',getTextoValido($listaEmpresasAnteriores->fields['EstaTrabalhando']));
        $elemento->setAttribute('PRIMEIROEMPREGO',getTextoValido($listaEmpresasAnteriores->fields['PrimeiroEmprego']));
        $elemento->setAttribute('ORIGEMCURRICULO',getTextoValido($listaEmpresasAnteriores->fields['OrigemCurriculo']));
        $pacote->appendChild($elemento);
                
        $listaEmpresasAnteriores->MoveNext();
    }
}

function criarElementosEmpresasAnterioresExpPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){        
    $peaDao = new PessoaEmpresaAnteriorExpDao($db);	
    $listaPessoaEmpantexp = $peaDao->buscarPessoaEmpresaAnteriorExpPorParametros($pModel);
    while (!$listaPessoaEmpantexp->EOF) {
        
        $elemento = $dom->createElement('RHPESSOAEMPANTEXP');
        $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoaEmpantexp->fields['Empresa']));
        $elemento->setAttribute('PESSOA',utf8_encode($listaPessoaEmpantexp->fields['Pessoa']));
        $elemento->setAttribute('NROSEQUENCIA',utf8_encode($listaPessoaEmpantexp->fields['NroSequencia']));
        $elemento->setAttribute('NROORDEM',utf8_encode($listaPessoaEmpantexp->fields['NroOrdem']));
        $elemento->setAttribute('CARGO',getTextoValido($listaPessoaEmpantexp->fields['Cargo']));
        $elemento->setAttribute('FUNCAO',getTextoValido($listaPessoaEmpantexp->fields['Funcao']));
        $elemento->setAttribute('AREAATUACAO',getTextoValido($listaPessoaEmpantexp->fields['AreaAtuacao']));
        $elemento->setAttribute('DESCRICAO40',getTextoValido($listaPessoaEmpantexp->fields['Descricao40']));
        $elemento->setAttribute('ANOSCASA',utf8_encode($listaPessoaEmpantexp->fields['AnosCasa']));
        $elemento->setAttribute('MESESCASA',utf8_encode($listaPessoaEmpantexp->fields['MesesCasa']));
        $elemento->setAttribute('EXIBIREXPERIENCIA',getTextoValido($listaPessoaEmpantexp->fields['ExibirExperiencia']));
        $elemento->setAttribute('ORIGEMCURRICULO',getTextoValido($listaPessoaEmpantexp->fields['OrigemCurriculo']));
        $pacote->appendChild($elemento);
        
        $listaPessoaEmpantexp->MoveNext();
    }
}

function criarElementosPalavraChavePorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    
    $ppcDao = new PessoaPalavraChaveDao($db);    
    $listaPessoaPalavraChave = $ppcDao->buscarPessoaPalavraChavePorParametros($pModel);
    while (!$listaPessoaPalavraChave->EOF) {
        
        $elemento = $dom->createElement('RHPESSOAPALAVRACHAVE');
        $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoaPalavraChave->fields['Empresa']));
        $elemento->setAttribute('PESSOA',utf8_encode($listaPessoaPalavraChave->fields['Pessoa']));
        $elemento->setAttribute('PALAVRACHAVE',getTextoValido($listaPessoaPalavraChave->fields['PalavraChave']));
        $elemento->setAttribute('ORIGEMCURRICULO',getTextoValido($listaPessoaPalavraChave->fields['OrigemCurriculo']));
        $pacote->appendChild($elemento);
        
        $listaPessoaPalavraChave->MoveNext();
    }
}

function criarElementosRequisicaoTurmaPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){

    $rtDao = new RequisicaoTurmaDao($db);
    $listaRequisicoesTurma = $rtDao->buscarRequisicoesTurmaPorParametros(null, $pModel);
    while (!$listaRequisicoesTurma->EOF) {
        
        $elemento = $dom->createElement('RHREQUISICOESTURMA');
        $elemento->setAttribute('EMPRESA',getTextoValido($listaRequisicoesTurma->fields['Empresa']));
        $elemento->setAttribute('PESSOA',utf8_encode($listaRequisicoesTurma->fields['Pessoa']));
        $elemento->setAttribute('REQUISICAO',getTextoValido($listaRequisicoesTurma->fields['Requisicao']));
        $elemento->setAttribute('DATAINSCRICAO',utf8_encode($listaRequisicoesTurma->fields['DataInscricao']));        
        $elemento->setAttribute('CANDIDATOINSCRITO',utf8_encode($listaRequisicoesTurma->fields['CandidatoInscrito']));        
        $pacote->appendChild($elemento);
        
        $listaRequisicoesTurma->MoveNext();
    }
}

function criarElementosFotosPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    
   $configObj = new Config($db, $pModel->Empresa);	   
   $valorDiretriz = $configObj->getValorDiretriz('localPessoaFoto');
   
   $pfDao = new PessoaFotoDao($db);	   
   $listaPessoasFotos = $pfDao->buscarPessoaFotoParametros($pModel);
   while (!$listaPessoasFotos->EOF) {
       
       if ($valorDiretriz == 1){		
           $elemento = $dom->createElement('RHPESSOASFOTOS');
           $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoasFotos->fields['Empresa']));
           $elemento->setAttribute('PESSOA',utf8_encode($listaPessoasFotos->fields['Pessoa']));
           $contents = $pfDao->buscarFotoDaPessoa($listaPessoasFotos->fields['Empresa'], $listaPessoasFotos->fields['Pessoa']);		
           $elemento->setAttribute('FOTO', base64_encode($contents));
           $pacote->appendChild($elemento);           		
       }
       else
       {	
           $elemento = $dom->createElement('RHPESSOASFOTOS');
           $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoasFotos->fields['Empresa']));
           $elemento->setAttribute('PESSOA',utf8_encode($listaPessoasFotos->fields['Pessoa']));
           $empresaPessoa = $listaPessoasFotos->fields['Empresa'].$listaPessoasFotos->fields['Pessoa'];
           $filename = "../Upload/Fotos/".$empresaPessoa.".jpg";
           $handle = fopen($filename, "rb");
           $contents = fread($handle, filesize($filename));
           fclose($handle);
           $elemento->setAttribute('FOTO',base64_encode($contents));       
           $pacote->appendChild($elemento);  
       }
       
       $listaPessoasFotos->MoveNext();
   }
}

function criarElementosAnexoPorPessoa(DomDocument $dom, DOMElement $pacote, Pessoa $pModel, $db){
    
    $configObj = new Config($db, $pModel->Empresa);	   
    
    $pfDao = new PessoaAnexoDao($db);	   
    $listaPessoasAnexos = $pfDao->buscarAnexoDaPessoa($pModel->Empresa, $pModel->Pessoa);
    while (!$listaPessoasAnexos->EOF) {
        	
            $elemento = $dom->createElement('RHPESSOASANEXOS');
            $elemento->setAttribute('EMPRESA',getTextoValido($listaPessoasAnexos->fields['Empresa']));
            $elemento->setAttribute('PESSOA',utf8_encode($listaPessoasAnexos->fields['Pessoa']));
            $elemento->setAttribute('ARQUIVOBLOB', base64_encode($listaPessoasAnexos->fields['ArquivoBlob']));
            $elemento->setAttribute('NOMEARQUIVO',getTextoValido($listaPessoasAnexos->fields['NomeArquivo']));
            $elemento->setAttribute('TIPOARQUIVO',getTextoValido($listaPessoasAnexos->fields['TipoArquivo']));            
            $pacote->appendChild($elemento);           		
        
            $listaPessoasAnexos->MoveNext();
    }
}

function getTextoValido($texto){
	$resultado = $texto;
    
    $caracteresaceitos = array(
        /* ==== maiúsculas ==== */
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O',
        'P','Q','R','S','T','U','V','X','Y','W','Z', 'Ç',
    
        /* ==== minúsculas ==== */
        'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o',
        'p','q','r','s','t','u','v','x','y','w','z', 'ç',
        
        /* ==== acentuados ==== */
        'á','ã','â','à','é','ê','í','î','ì','ó','õ','ô','ò','ú','ù','û',
        'Á','Ã','Â','À','É','Ê','Í','Î','Ì','Ó','Õ','Ô','Ò','Ú','Ù','Û',
        
        /* ==== caracteres especiais ==== */
        '\'','"','!','@','#','$','£','%','¢','¨','¬','&','*','(',')','-',
        '_','+','=','§','¹','²','³','\\','/','{','[','ª','}',']','º','<',',','>','.',
        ';','?','°','|', ' ',
        
        /* ==== números ==== */
        '0','1','2','3','4','5','6','7','8','9'
    );
    
    for ($y = 0; $y < strlen($resultado); $y++)
    {   
        $remover = true;
        for ($i = 0; $i < count($caracteresaceitos); $i++)
        {
            if ($caracteresaceitos[$i] == $resultado[$y])
                $remover = false;
        }
        if ($remover == true)
            $resultado = str_replace($resultado[$y], ' ', $resultado);
    }

    $resultado = utf8_encode($resultado);
    
	return $resultado;
}

if(isset($_REQUEST['semwebservice'])){
    echo '<?xml version="1.0" encoding="ISO-8859-1"?><SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" 
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body><ns1:loginResponse xmlns:ns1="urn:wsdlServerBF2Enviar"><return xsi:type="xsd:string">'.enviar($_REQUEST['empresa'], 
    $_REQUEST['dataCorte'], $_REQUEST['ticketLogin']).'</return></ns1:loginResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>';
}

?>
