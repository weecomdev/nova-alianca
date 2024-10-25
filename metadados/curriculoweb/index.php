<?php
	
	session_start();

	@header('Content-Type:text/html; charset=iso-8859-1');
	
	include_once 'imports.php';

	
	global $configObj;
	$webConfDao = new CandidatosWebConfDao($db);
	$configObj = new Config($db, $webConfDao->buscaEmpresaPrincipal());
	
	$modulo = $_REQUEST['modulo'];
	$entidade = $_REQUEST['entidade'];
	$acao = $_REQUEST['acao'];
	
	$web = new Web($db,$modulo,$entidade,$acao);
	
?>