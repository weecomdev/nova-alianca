<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/incList.asp" -->
<%
RegMax = 10

If Palavra <> "" then
	Busca = "WHERE cor_nome LIKE '%" & Palavra & "%' OR cor_desc LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY cor_nome"
	Case 1
		Ordenar = "ORDER BY cor_nome"
	Case 2
		Ordenar = "ORDER BY cor_nome DESC"
End Select

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM cor " & Busca & Ordenar
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
	helpTXT =	'Esta sess�o altera cores princiais do portal.<br>';

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
    <td>Cores do portal</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
      <option value="1">Nome (a-z)</option>
      <option value="2">Nome (z-a)</option>
    </select>
    </td>
    <td id="fim"></td>
  </tr>
</table>
<%
If RS.EOF Then
	Response.Write "N�o h� �tens para listar."
Else

RS.PageSize = RegMax
RS.AbsolutePage = Pagina

contador = 0
Do While Not RS.EOF And contador < RegMax
%>
<table border="0" cellspacing="0" cellpadding="0" id="tableLine">
  <tr>
  	<td width="40" bgcolor="#<%= RS("cor_hexa") %>"><img src="../interface/icons_cor.png" title="Editar"></td>
    <td id="inicio"></td>
    <td width="100"><a class="infoTitle"><%= RS("cor_nome") %></a></td>
    <td id="divisor"></td>
    <td><a class="infoSub"><%= RS("cor_desc") %></a></td>
    <td id="fim"></td>
    <td id="icon" width="40"><a href="javascript:subEditar(<%= contador %>,<%= RS("cor_id") %>)"><img src="../interface/icons_edit.jpg" title="Editar"></a></td>
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
