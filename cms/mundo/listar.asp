<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/incList.asp" -->
<%

RegMax = 10

If Palavra <> "" then
	Busca = "WHERE mundo_nome LIKE '%" & Palavra & "%' OR mundo_desc LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY mundo_post DESC"
	Case 1
		Ordenar = "ORDER BY mundo_post DESC"
	Case 2
		Ordenar = "ORDER BY mundo_nome"
	Case 3
		Ordenar = "ORDER BY mundo_nome DESC"
End Select

Set RS = Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM mundo " & Busca & Ordenar & ";"
	RS.cursorlocation = 3
	RS.Open SQL,Conn

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
	helpTXT =	'Esta sessão gerencia o "Delicioso mundo do vinho" listados no portal. ' +
				'É possível adicionar diversos arquivos, de qualquer tipo, para download. ' +
				'Os itens em destaque será os primeiros a serem listados.';
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
    <td>Mundo do vinho</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
      <option value="1">Data de postagem</option>
      <option value="2">Nome (a-z)</option>
      <option value="3">Nome (z-a)</option>
    </select></td>
    <td id="fim"></td>
    <td width="40" id="icon"><img src="../interface/icons_add.jpg" title="Adicionar imóvel" onClick="itemAdd();"></td>
  </tr>
</table>
<%
If RS.EOF Then
	Response.Write "Não há relatórios para listar."
Else

RS.PageSize = RegMax
RS.AbsolutePage = Pagina

contador = 0
Do While Not RS.EOF And contador < RegMax

%>
<table border="0" cellspacing="0" cellpadding="0" id="tableLine">
  <tr>
    <td id="inicio"></td>
    <td><a class="infoTitle"><%= RS("mundo_nome") %></a></td>
    <td id="fim"></td>
    <td id="icon" width="120"><a href="../includes/msgPop.asp?Id=<% =RS("mundo_id") %>&Engine=destaque" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_destaque_<% =RS("mundo_destaque") %>.jpg" alt="Habilitar/Desabilitar"></a><a href="javascript:subEditar(<%= contador %>,<%= RS("mundo_id") %>)"><img src="../interface/icons_edit.jpg" title="Editar"></a><a href="../includes/msgPop.asp?Id=<% =RS("mundo_id") %>" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_del.jpg" title="Deletar"></a></td>
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
