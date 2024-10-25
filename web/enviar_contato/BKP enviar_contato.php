<?

// -----------------------------------------
// includes
//include 'include/acessobcodados.inc.php';
//include 'include/configpadrao.inc.php';

$raiz = 'http://www.vinhos-alianca.com.br/web/';

// Resgatando Formulário
$nome		= $_POST['nome'];
$email		= $_POST['email'];
$telefone	= $_POST['telefone'];
$setor		= $_POST['setor'];
$mensagem	= $_POST['mensagem'];

switch ($setor) {
	case "1" : $setor_nome = 'Atendimento'; break;
	default : $setor_nome = 'Contato'; break;
}

$date		= date("d/m/Y");
$hora		= date("h\hi");

// *****************************************
// Montando Sistema de Confirmação de Envio

include('class.phpmailer.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SMTP
//$mail->IsMail(); // telling the class to use Mail()

// Carregando Variáveis para Mailer

$mailer_para_nome 		= 'Nova Aliança'; // Nome do Remetente
$mailer_para_email		= 'novaalianca@novaalianca.coop.br'; // E-mail selecionado
//$mailer_para_email		= 'prog@cdinteligente.com.br'; 	// E-mail do remetente
//$mailer_para_email		= 'web@cdinteligente.com.br'; 	// E-mail do remetente

$mailer_de_nome 		= $nome;// Nome do Remetente
$mailer_de_email		= $email; // E-mail do remetente

// Separando 1º Nome
$mailer_para_1nome 		= explode(" ", $mailer_para_nome);
$mailer_para_1nome 		= $mailer_para_1nome[0];

$mailer_data			= date("d/m/Y");
$mailer_ip 				= "$_SERVER[REMOTE_ADDR]";

$mailer_assunto			= 'Contato - Nova Aliança';
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

	NOME: <b>'.$nome.'</b><br />
	E-MAIL: <b>'.$email.'</b><br />
	SETOR: <b>'.$setor_nome.'</b><br />
	TELEFONE: <b>'.$telefone.'</b><br />
	MENSAGEM: <b>'.$mensagem.'</b><br />
	
	<br />Enviado em <b>'.$date.'</b>, <b>'.$hora.'</b><br />
	
	</body>';

//$mailer_assunto 		= utf8_decode($mailer_assunto);
//$mailer_corpo 			= utf8_decode($mailer_corpo);
//$mailer_para_nome		= utf8_decode($mailer_para_nome);
//$mailer_para_1nome 		= utf8_decode($mailer_para_1nome);

try {
	$mail->Host       	= "smtp.poa.terra.com.br";	// SMTP server
	$mail->SMTPDebug  	= 0;                     	// enables SMTP debug information (for testing) (usar "2" para teste)
	$mail->SMTPAuth   	= true;                  	// enable SMTP authentication
	$mail->Host       	= "smtp.poa.terra.com.br";	// sets the SMTP server
	$mail->Port       	= 587;                    	// set the SMTP port for the GMAIL server
	$mail->Username   	= "cdinteligente";			// SMTP account username
	$mail->Password   	= "12cdi3";					// SMTP account password

//	$mail->Charset		= 'utf-8';
	$mail->AddAddress	($mailer_para_email, $mailer_para_nome);
	$mail->AddReplyTo	($mailer_de_email, $mailer_de_nome);
//	$mail->SetFrom		('contato@apliquim.com.br', utf8_decode('Contato '.$systitulo_simples));
	$mail->SetFrom		('cdinteligente@terra.com.br', utf8_decode('Contato Nova Aliança'));
//	$mail->SetFrom		('prog@cdinteligente.com.br', utf8_decode('Contato '.$systitulo_simples));
	$mail->Subject 		= $mailer_assunto;
	$mail->AltBody 		= 'Para ver esta mensagem, favor utilizar um visualizar de e-mail compatível com HTML'; // opcional - MsgHTML will create an alternate automatically
	$mail->MsgHTML		($mailer_corpo);
//	$mail->MsgHTML(file_get_contents('teste_contents.html'));
//	$mail->AddAttachment('images/phpmailer.gif');      // anexo
//	$mail->AddAttachment('images/phpmailer_mini.gif'); // anexo
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
	$location = $raiz."default.asp?Engine=contato&Msg=OK";
	header("Location: ".$location."");
/*	echo("<script>window.location='".$location."'</script>");*/
	exit;
}

?>