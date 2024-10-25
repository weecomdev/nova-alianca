<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/incList.asp" -->
<%

RegMax = 10

If Palavra <> "" then
	Busca = "WHERE representante_nome LIKE '%" & Palavra & "%' OR representante_email LIKE '%" & Palavra & "%' OR representante_desc LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY representante_nome"
	Case 1
		Ordenar = "ORDER BY representante_nome"
	Case 2
		Ordenar = "ORDER BY representante_nome DESC"
End Select

Set RS = Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM representante " & Busca & Ordenar

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
	helpTXT =	'Gerencia a sessão "representantes" listada no portal. É possível adicionar, excluir ou editar estas informações. ' +
				'Caso opte pela inserção de uma imagem, esta será redimencionada automaticamente.<br>';
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
    <td>Representantes</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
      <option value="1">Nome (a-z)</option>
      <option value="2">Nome (z-a)</option>
    </select></td>
    <td id="fim"></td>
    <td width="40" id="icon"><img src="../interface/icons_add.jpg" title="Adicionar item" onClick="itemAdd();"></td>
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


If fso.fileExists(Server.MapPath("../../imagens/representante/" & cStr(RS("representante_id")) & ".jpg")) = True Then
	thumbImg = "../../imagens/representante/" & cStr(RS("representante_id")) & ".jpg"
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
    	<a class="infoTitle"><%
			If RS("representante_nome") <> "" Then
				Response.Write RS("representante_nome")
			Else
				Response.Write "Sem nome"
			End if
		%></a>
        <a class="infoSub"><strong><%= RS("representante_fone") %></strong><br><strong>E-mail:</strong> <% =RS("representante_email") %></a>
    </td>
    <td id="fim"></td>
    <td id="icon" width="40"><a href="javascript:subEditar(<%= contador %>,<%= RS("representante_id") %>)"><img src="../interface/icons_edit.jpg" title="Editar"></a><a href="../includes/msgPop.asp?Id=<% =RS("representante_id") %>" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_del.jpg" title="Deletar"></a></td>
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
