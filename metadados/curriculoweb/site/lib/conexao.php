<?php 
// CUIDADO !!! N�O DEIXE LINHAS EM BRANCO NO FINAL DESTE ARQUIVO

// create an object instance
// Configurar para uma conex�o tipo PostgreSQL
$db = NewADOConnection("mysqli"); // MySQL seria "mysql"

// Abrir uma conex�o com o banco de dados
// $db->Connect("servidor", "usuario", "senha", "banco")

$db->Connect("mysql.novaalianca.coop.br", "novaalianca04", "w3bm3t4", "novaalianca04") or die("Falha na conex�o!");

$db->Execute("SET NAMES 'latin1'");
$db->Execute('SET character_set_connection=latin1');
$db->Execute('SET character_set_client=latin1');
$db->Execute('SET character_set_results=latin1');
$db->Execute('SET character_set_server=latin1');
?>