<?

// conexão ao bco de dados com ADOBD5
include_once('adodb5/adodb.inc.php');

function conectar() {

//	$testabd = 1;

	// Testando Bco de Dados
	$sys_db_server 		= "mysql.vinhos-alianca.com.br"; 	// Host
	$sys_db_user 		= "vinhosalianca"; 					// User
	$sys_db_pass 		= "123456";							// Pass
	$sys_db_database	= "vinhosalianca";					// BcoDados
	
	$con = &ADONewConnection('mysql');  	# create a connection
	$db_server 		= $sys_db_server; 		// Host
	$db_user 		= $sys_db_user; 		// User
	$db_pass 		= $sys_db_pass;			// Pass
	$db_database	= $sys_db_database; 	// BcoDados

	$con = &ADONewConnection('mysql');
	$con->connect($db_server, $db_user, $db_pass, $db_database);
   
	//$con->connect($dsn, $userdb, $passdb); // para odbc

	if ($testabd) $con->debug = true;
	else $con->debug = false;

	return $con;
}

// -----------------------------------------
// conexão com o banco de dados
$con = conectar();






// Carregando E-MAILS de destino
$query = "SELECT * FROM	formulario ORDER BY formulario_id";
$rs = $con->execute($query) or die ($con->errormsg());
$dados_array = $rs->GetArray();
$email_cadastro 	= $dados_array[0]['formulario_email'];
$email_duvida		= $dados_array[1]['formulario_email'];
$email_ondecomprar	= $dados_array[2]['formulario_email'];


$raiz = 	'http://www.vinhos-alianca.com.br/web/';

$form		= $_POST['form'];

// Resgatando Formulário
$nome		= $_POST['nome'];
$email		= $_POST['email'];
$telefone	= $_POST['telefone'];
$cidade		= $_POST['cidade'];
$setor		= $_POST['setor'];
$mensagem	= $_POST['mensagem'];

switch ($setor) {
	case "1" : $setor_nome = 'Atendimento'; break;
	default : $setor_nome = 'Contato'; break;
}

$date		= date("d/m/Y");
$hora		= date("h\hi");



if ($form=='confraria') {

	$tipo_contato = 'Cadastro na Confraria';
	$corpo_conteudo = '
	NOME: <b>'.$nome.'</b><br />
	E-MAIL: <b>'.$email.'</b><br />
	CIDADE: <b>'.$cidade.'</b><br />
	TELEFONE: <b>'.$telefone.'</b><br />
	MENSAGEM: <b>'.$mensagem.'</b><br />
	';
	$location = $raiz."default.asp?Engine=confraria&subEngine=cadastro&Msg=OK";
	$mailer_para_email = $email_cadastro;


} elseif ($form=='duvida') {

	$tipo_contato = 'Dúvida';
	$corpo_conteudo = '
	NOME: <b>'.$nome.'</b><br />
	E-MAIL: <b>'.$email.'</b><br />
	CIDADE: <b>'.$cidade.'</b><br />
	TELEFONE: <b>'.$telefone.'</b><br />
	PERGUNTA: <b>'.$mensagem.'</b><br />
	';
	$location = $raiz."default.asp?Engine=faq&subEngine=pergunta&Msg=OK";
	$mailer_para_email = $email_duvida;

} else {

	// Carregando SETOR
	$query = "SELECT * FROM	contato WHERE contato_id=".$setor."";
	$rs = $con->execute($query) or die ($con->errormsg());
	$dados_array = $rs->GetArray();

	$email_destimo = $dados_array[0]['contato_email'];
	$setor_destino = $dados_array[0]['contato_nome'];
	$tipo_contato = 'Contato com '.$setor_destino;
	$corpo_conteudo = '
	NOME: <b>'.$nome.'</b><br />
	E-MAIL: <b>'.$email.'</b><br />
	SETOR: <b>'.$setor_nome.'</b><br />
	TELEFONE: <b>'.$telefone.'</b><br />
	MENSAGEM: <b>'.$mensagem.'</b><br />
	';
	$location = $raiz."default.asp?Engine=contato&Msg=OK";
	$mailer_para_email = $email_destimo;

}



// *****************************************
// Montando Sistema de Confirmação de Envio

include('class.phpmailer.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SMTP
//$mail->IsMail(); // telling the class to use Mail()

// Carregando Variáveis para Mailer

$mailer_para_nome 		= 'Nova Aliança'; // Nome do Remetente
//$mailer_para_email		= 'novaalianca@novaalianca.coop.br'; // E-mail selecionado
//$mailer_para_email		= 'web@cdinteligente.com.br'; 	// E-mail do remetente
//$mailer_para_email		= 'prog@cdinteligente.com.br'; 	// E-mail do remetente

$mailer_de_nome 		= $nome;// Nome do Remetente
$mailer_de_email		= $email; // E-mail do remetente

// Separando 1º Nome
$mailer_para_1nome 		= explode(" ", $mailer_para_nome);
$mailer_para_1nome 		= $mailer_para_1nome[0];

$mailer_data			= date("d/m/Y");
$mailer_ip 				= "$_SERVER[REMOTE_ADDR]";

$mailer_assunto			= $tipo_contato.' - Site novaalianca.coop.br';
$mailer_corpo 			= '
	<html>
	<head>
	<title>Contato</title> 
	<style>
		body {
			font-family: "Arial", Helvetica, sans-serif;
			font-size: 10pt;
			margin-left: 50 px;
			margin-top: 110 px;
			background:url() no-repeat top left;
			line-height:20px;
		}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>

'.$corpo_conteudo.'

	<br /><br />EMAIL DESTINO: '.$mailer_para_email.'<br /><br />

	<br />Enviado em <b>'.$date.'</b>, <b>'.$hora.'</b><br />
	
	</body>';





// *** EMAIL TESTE ***
$mailer_para_email		= 'prog@cdinteligente.com.br'; 	// E-mail do remetente





//$mailer_assunto 		= utf8_decode($mailer_assunto);
//$mailer_corpo 		= utf8_decode($mailer_corpo);
//$mailer_para_nome		= utf8_decode($mailer_para_nome);
//$mailer_para_1nome 	= utf8_decode($mailer_para_1nome);

try {
	$mail->Host       	= "smtp.poa.terra.com.br";	// SMTP server
	$mail->SMTPDebug  	= 0;                     	// enables SMTP debug information (for testing) (usar "2" para teste)
	$mail->SMTPAuth   	= true;                  	// enable SMTP authentication
	$mail->Host       	= "smtp.poa.terra.com.br";	// sets the SMTP server
	$mail->Port       	= 587;                    	// set the SMTP port for the GMAIL server
	$mail->Username   	= "cdinteligente";			// SMTP account username
	$mail->Password   	= "12cdi3";					// SMTP account password

	$mail->Charset		= 'utf-8';
	$mail->AddAddress	($mailer_para_email, $mailer_para_nome);
/*
	$mail->AddAddress	('doug@terra.com.br', $mailer_para_nome);
	$mail->AddCC		('douglas@oultimopagamais.com.br', $mailer_para_nome);
*/
	$mail->AddReplyTo	($mailer_de_email, $mailer_de_nome);
	$mail->SetFrom		('cdinteligente@terra.com.br', $tipo_contato.' - Site novaalianca.coop.br');
	$mail->Subject 		= $mailer_assunto;
	$mail->AltBody 		= 'Para ver esta mensagem, favor utilizar um visualizar de e-mail compatível com HTML'; // opcional - MsgHTML will create an alternate automatically
	$mail->MsgHTML		($mailer_corpo);
	$mail->Send();

//	echo "Enviando mensagem...";
	
} catch (phpmailerException $e) {
	$msg_aviso = str_ireplace('%0A','',nl2br($e->errorMessage())); // Erros emitidos pelo PHPMailer
} catch (Exception $e) {
	$msg_aviso = str_ireplace('%0A','',nl2br($e->getMessage())); // Erros emitidos pelo PHPMailer
}

// Validando Dados
if ($msg_aviso) {
	$msg_aviso = urlencode('Falha ao tentar processar formulário:<br /><br />'.$msg_aviso);
	echo($msg_aviso);
//	header("Location: ".$raiz."contato?aviso=$msg_aviso");
	exit;
} else {
	header("Location: ".$location."");
/*	echo("<script>window.location='".$location."'</script>");*/
	exit;
}

?>