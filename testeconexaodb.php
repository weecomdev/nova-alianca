<?php
$servername = "177.234.154.35";
$username = "simplesa_novaalianca03";
$password = "3D8e4V5wX628s";
$dbname = "simplesa_novaalianca03";

// Cria uma conexão
$conn = mysql_connect($servername, $username, $password);

// Verifica se ocorreu algum erro na conexão
if (!$conn) {
    die("Erro na conexão: " . mysql_error());
}

// Seleciona o banco de dados
if (!mysql_select_db($dbname, $conn)) {
    die("Erro na seleção do banco de dados: " . mysql_error());
}

echo "Conexão bem-sucedida!";

// Fecha a conexão
mysql_close($conn);
?>
