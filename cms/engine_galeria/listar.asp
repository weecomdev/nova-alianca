<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/incList.asp" -->
<%

RegMax = 10

If Palavra <> "" then
	Busca = "WHERE nome LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY engine_galeria_nome"
	Case 1
		Ordenar = "ORDER BY engine_galeria_nome"
	Case 2
		Ordenar = "ORDER BY engine_galeria_nome DESC"
End Select

Set RS = Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM engine_galeria " & Busca & Ordenar & ";"
	RS.cursorlocation = 3
	RS.Open SQL,Conn,3,2

Set fso = CreateObject("Scripting.FileSystemObject")

%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/style.css" rel="stylesheet" type="text/css">
<script src="../includes/java/scripts.js"></script>
<script src="../includes/java/makePop.js"></script>
<script>
	helpTXT =	'Esta sess�o gerencia a sess�o de "galeria de eventos" listada no portal. � poss�vel adicionar, excluir ou editar estas informa��es. ' +
				'Caso opte pela inser��o de uma imagem, esta ser� redimencionada automaticamente.<br>' +
				'O �cone de l�mpada determina se a galeria estr� ou n�o vis�vel no portal.';
</script>
</head>
<body>

<!--#include file="../includes/ssi/topo.asp" -->
<table id="layout" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="esquerda"><!--#include file="../includes/ssi/menu.asp" --></td>
    <td id="centro">

<form name="form">
<div id="divAdd"></div>
<table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
  <tr>
  	<td id="inicio"></td>
    <td>Listagem de galerias</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
        <option value="1">T�tulo (a-z)</option>
        <option value="2">T�tulo (z-a)</option>
    </select></td>
    <td id="fim"></td>
    <!--<td width="40" id="icon"><img src="../interface/icons_add.jpg" title="Adicionar item" onClick="itemAdd();"></td>-->
  </tr>
</table>
<%
If RS.EOF Then
	Response.Write "N�o h� galerias para listar."
Else

RS.PageSize = RegMax
RS.AbsolutePage = Pagina

contador = 0
Do While Not RS.EOF And contador < RegMax

%>
<table border="0" cellspacing="0" cellpadding="0" id="tableLine">
  <tr>
    <td id="inicio"></td>
    <td id="desc"><a class="infoTitle"><%= RS("engine_galeria_nome")%></a></td>
    <td id="fim"></td>
    <td id="icon" width="40"><a href="javascript:subEditar(<%= contador %>,<%= cStr(RS("engine_galeria_id")) %>,'setup')"><img src="../interface/icons_setup.jpg" title="Adicionar/Excluir fotos"></a></td>
  </tr>
</table>
<center id="hideCel"></center>
<%
contador = contador + 1
RS.MoveNext
Loop

End If
%>

<% navBar() %>


</form>

    </td>
    <td id="direita"><div></div></td>
  </tr>
</table>
<!--#include file="../includes/ssi/base.asp" -->
</body>
</html>
<%
Set fso = nothing

RS.close
Set RS = nothing

Conn.close
Set Conn = nothing
%>
