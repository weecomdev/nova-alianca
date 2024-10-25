<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/incList.asp" -->
<%
RegMax = 10

If Palavra <> "" then
	Busca = "WHERE formulario_nome LIKE '%" & Palavra & "%' OR formulario_email LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY formulario_nome"
	Case 1
		Ordenar = "ORDER BY formulario_nome"
	Case 2
		Ordenar = "ORDER BY formulario_nome DESC"
End Select

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM formulario " & Busca & Ordenar
	RS.cursorlocation = 3
	RS.Open SQL,Conn

%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/style.css" rel="stylesheet" type="text/css">
<script src="../includes/java/scripts.js"></script>
<script src="../includes/java/makePop.js"></script>
<script>
	helpTXT =	'Esta sessão altera os endereços de e-mail que receberão as mensagens dos formulários do portal.<br>';

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
    <td>Formulário</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
      <option value="1">Formulário (a-z)</option>
      <option value="2">Formulário (z-a)</option>
    </select>
    </td>
    <td id="fim"></td>
  </tr>
</table>
<%
If RS.EOF Then
	Response.Write "Não há ítens para listar."
Else

RS.PageSize = RegMax
RS.AbsolutePage = Pagina

contador = 0
Do While Not RS.EOF And contador < RegMax
%>
<table border="0" cellspacing="0" cellpadding="0" id="tableLine">
  <tr>
    <td id="inicio"></td>
    <td><a class="infoTitle"><%= RS("formulario_nome") %></a></td>
    <td id="divisor"></td>
    <td width="300"><a class="infoSub"><%= RS("formulario_email") %></a></td>
    <td id="fim"></td>
    <td id="icon" width="40"><a href="javascript:subEditar(<%= contador %>,<%= RS("formulario_id") %>)"><img src="../interface/icons_edit.jpg" title="Editar"></a></td>
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
RS.close
Set RS = nothing

Conn.close
Set Conn = nothing
%>
