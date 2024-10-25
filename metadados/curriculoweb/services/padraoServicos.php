<?php
include_once ("../site/lib/adodb/adodb-exceptions.inc.php");
require_once ("../site/lib/adodb/adodb.inc.php");
include "../site/lib/conexao.php";

function pegarChave($empresa){	
	$arquivo = file("CK.cwm");
	$c = "0001";
	for($i = 0; $i < count($arquivo); $i++) {
		if ( (substr($arquivo[$i], 0, strpos($arquivo[$i], '='))) == $empresa ){
			$c = substr($arquivo[$i],strpos($arquivo[$i], '=')+1,strlen($arquivo[$i])-7);
			$c = base64_decode($c);
		}
	}
	$globalEmpresa = $empresa;
	
	return trim($c);
}

function CompletaDireita($pString,$pCaracter,$pTamanho){
	$Result = '';
	if (strlen($pString) < $pTamanho) {
	    for ($i = 0;$i < ($pTamanho - strlen($pString));$i++) {
	      $Result = $pCaracter . $Result;
	    }
	    $Result = $pString . $Result;
	}
	else $Result = $pString;

	return $Result;
}

function calcularSenha($pOperador, $pUsuario,  $pRazaoSocial = 'Curriculo Web') {
   $Telalf = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $Telanu = '31547690977414223311885134';
   $CodUsu = $pUsuario;
   $NomUsu = CompletaDireita($pRazaoSocial, ' ', 40);
   $pOperador = CompletaDireita($pOperador, ' ', 6);

   $Nomope = $pOperador;
   $indice = 0;

   $ind[1] = 1;
   $ind[2] = 7;
   $ind[3] = 16;
   $ind[4] = 17;
   $ind[5] = 42;
   $acum[1] = 0;
   $acum[2] = 0;
   $acum[3] = 0;
   $acum[4] = 0;
   $acum[5] = 0;
   $acum[6] = 0;

   $Senha = $CodUsu . $Nomope . $NomUsu;
   while ($indice < 50) {
      if ( ($Senha[$indice] < '0') || ($Senha[$indice] > '9') ) {
         for ($indice1 = 0;$indice1<=25;$indice1++) {
            if ($Telalf[$indice1] == $Senha[$indice]){
            	$Senha[$indice] = $Telanu[$indice1];
	    }	
         }
         if ( ($Senha[$indice] >= '0') && ($Senha[$indice] <= '9') )
            $indice = $indice;
         else
            $Senha[$indice] = '7';
      }
      $indice++;
   }

   $indice = 0;
   while ($indice < 3) {
      $indice++;
      $livre1 = $ind[$indice] - 1;
      $livre2 = 0;
      while ($livre2 < 12) {
         $livre2++;
         if ( ($Senha[$livre1] >= 0) && ($Senha[$livre1] <= 9) ) {
            $acum[$indice] = $acum[$indice] + ($Senha[$livre1] * $livre2);
         }
         $livre1++;
      }
   }

   while ($indice < 5) {
      $indice++;
      $livre1 = $ind[$indice] - 1;
      $livre2 = 14;
      while ($livre2 > 0) {
         $livre2--;

         if ( ($Senha[$livre1] >= 0) && ($Senha[$livre1] <= 9) ) {
            $acum[$indice] = $acum[$indice] + ($Senha[$livre1] * $livre2);
         }
         $livre1--;
      }
   }

	$codsen = ($acum[1] * $acum[4]) + $acum[2] + $acum[3] - $acum[5] + 90712;
	return $codsen;
}

function login($empresa, $operador, $usuario, $senha) {
	global $db;

	$simetricKey = pegarChave($empresa);
	$senhaCalculada = calcularSenha($operador,$usuario);
	if ($senha == $senhaCalculada) {
		$ticket = md5(uniqid());

		include "../site/dao/TicketDao.php";
		$iDao = new TicketDao($db);
		$iDao->criarTicket($ticket);

		// Criptografia
		require_once("lib/class.simetric.php");
		$simetric = new key_simetric();

		$simetric->set_key($simetricKey);
		$simetric->set_text($ticket);
		$simetric->encrypt();
		$crypt = $simetric->get_hex_crypt();

		return $ticket;
	} else {
		return "401: Usuário ou senha inválidos: " . $senhaCalculada;
	}
}

function decrypt($msg,$simetricKey){
	require_once("lib/class.simetric.php");
	$simetric = new key_simetric();
	$simetric->set_key(hash('sha256',$simetricKey,true));
	$msg = base64_decode($msg);
	$simetric->set_crypt($msg);
	$simetric->decrypt();
	$text = $simetric->get_decrypt();
	return trim($text);
}

function tentaExcluirTicket($ticketLogin){
	global $db;
	include_once "../site/dao/TicketDao.php";
	$iDao = new TicketDao($db);
	$listaTicket = $iDao->buscarTicketPorParametros($ticketLogin);
	
	if ($listaTicket->NumRows() < 1) {
		$iDao->excluirTicket($ticketLogin);
		return false;
	}
	
	$iDao->excluirTicket($ticketLogin);
	return true;
}

function retornaVersaoCVWebDao(){
	global $db;
	include_once "../site/dao/VersaoCVWebDao.php";
	$versao = new VersaoCVWebDao($db);
	$ret = $versao->buscaRegistroVersaoCVWeb();
	return $ret->fields['VersaoSistema'];
}
?>