<?php

session_start();

global $configObj;

?>

<head>
  <link rel="stylesheet" type="text/css" href="style/TermoConsentimento.css" />
</head>

<div class="content-interna">
<div class="cabecalho">
		<div style="width: 180px; float: left;">&nbsp;</div>
		<div class="menu" align="center">
              <div style="width: 80px ;float:left;">
                <a href="?modulo=home&amp;acao=inicial">Página Inicial</a>&nbsp; |</div>
            <div style="width: 80px; float: left;">
                <a tabindex="0" style="cursor: pointer;" onclick="curriculoWebUtil.openMenu({modulo: 'pessoa', entidade:'informacoesPessoais'});">Meu Currículo</a>&nbsp; |</div>
            <div style="width: 95px; float: left;"><a tabindex="0" style="cursor: pointer;" onclick="curriculoWebUtil.openMenu({modulo: 'vagas', entidade:'pesquisar'});">Pesquisar Vagas</a>&nbsp; |</div>
            <div style="width: 85px; float: left;"><a tabindex="0" href="?modulo=login&amp;acao=alterarSenha">Alterar Senha</a>&nbsp;&nbsp;|&nbsp;</div>
            <div style="width: 36px; float: left;"><a tabindex="0" style="cursor: pointer;" onclick="curriculoWebUtil.TermoConsentimento()">Termo</a>&nbsp;&nbsp;|</div>
            <div style="width: 34px; float: left;">  <a class="sair" style="cursor: pointer;" onclick="curriculoWebUtil.sair({modulo: 'informacoesIncompletas', entidade:'informacoesIncompletas'});">Sair </a>
            </div>
		</div>	 
	
		<div>
	      <?php 
	      
	      echo "<a class=\"logotipo\" "; 
	         if($configObj->getValorDiretriz('home') != ""){ 
	         	echo "href='". $configObj->getValorDiretriz('home')."'";
	         }
	         echo "></a>" 		  
	      ?>
		</div>
        <div id="alerta"></div>	
	</div>	
</div>