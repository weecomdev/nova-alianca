<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/incList.asp" -->
<%

RegMax = 10

If Palavra <> "" then
	Busca = "WHERE imprensa_nome LIKE '%" & Palavra & "%' OR imprensa_desc LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY imprensa_post"
	Case 1
		Ordenar = "ORDER BY imprensa_post DESC"
	Case 2
		Ordenar = "ORDER BY imprensa_nome"
	Case 3
		Ordenar = "ORDER BY imprensa_nome DESC"
End Select

Set RS = Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM imprensa " & Busca & Ordenar
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
	helpTXT =	'Gerencia a sessão "Imprensa" listada no portal. É possível adicionar, excluir ou editar estas informações. ' +
				'Caso opte pela inserção de uma imagem, esta será redimencionada automaticamente.<br>' +
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
    <td>Atualidades</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
      <option value="1">Data de postagem</option>
      <option value="2">Nome (a-z)</option>
      <option value="3">Nome (z-a)</option>
    </select></td>
    <td id="fim"></td>
    <td width="40" id="icon"><!-- <img src="../interface/icons_editEngine.jpg" title="Editar foto" onClick="itemAdd('../includes/engineEditar.asp');"> --><img src="../interface/icons_add.jpg" title="Adicionar item" onClick="itemAdd();"></td>
  </tr>
</table>
<%
If RS.EOF Then
	Response.Write "Não há itens para listar."
Else

RS.PageSize = RegMax
RS.AbsolutePage = Pagina

contador = 0
Do While Not RS.EOF And contador < RegMax


If fso.fileExists(Server.MapPath("../../imagens/imprensa/" & cStr(RS("imprensa_id")) & ".jpg")) = True Then
	thumbImg = "../../imagens/imprensa/" & cStr(RS("imprensa_id")) & ".jpg"
	thumbLink = "href='../includes/showImage.asp?Imagem=" & thumbImg & "&Tamanho=240' target='msgPop' onClick='showPop(event)' title='Zoom da imagem'"
Else
	thumbImg = "../interface/thumb.jpg"
	thumbLink = ""
End If

%>
<table border="0" cellspacing="0" cellpadding="0" id="tableList">
  <tr>
    <td id="inicio"></td>
    <td id="thumb"><a <%= thumbLink %>><img src="../includes/thumbImage.asp?Caminho=<%= thumbImg %>"></a></td>
    <td id="divisor"></td>
    <td id="desc">
    	<a class="infoTitle"><strong><%= FormatDateTime(RS("imprensa_data"), 2) %></strong> - <%= RS("imprensa_nome") %></a>
        <a class="infoSub"><strong>Data de postagem:</strong> <% =RS("imprensa_post") %></a>
    </td>
    <td id="fim"></td>
    <td id="icon" width="80"><a href="../includes/msgPop.asp?Id=<% =RS("imprensa_id") %>&Engine=destaque" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_destaque_<%= RS("imprensa_destaque") %>.jpg" title="Habilitar/Desabilitar destaque"></a><a href="javascript:subEditar(<%= contador %>,<%= RS("imprensa_id") %>)"><img src="../interface/icons_edit.jpg" title="Editar"></a><a><img src="../interface/icons_no.jpg"></a><a href="../includes/msgPop.asp?Id=<% =RS("imprensa_id") %>" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_del.jpg" title="Deletar"></a></td>
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
