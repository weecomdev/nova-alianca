<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/incList.asp" -->
<%
'=======================================================================
'VARIÁVEIS DE FILTRO

idCat = Request.QueryString("idCat")

If idCat = "" Then
	idCat = 0
End If

navQuery = Array("idCat")
navValue = Array(idCat)

'=======================================================================

RegMax = 10

If Palavra <> "" then
	Busca = "WHERE produto_tipo_nome LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY produto_linha_nome, produto_tipo_ordem"
	Case 1
		Ordenar = "ORDER BY produto_linha_nome, produto_tipo_ordem"
	Case 2
		Ordenar = "ORDER BY produto_linha_nome DESC, produto_tipo_nome"
End Select

Set RS=Server.CreateObject("Adodb.recordset")
SQL = "SELECT produto_tipo.*, produto_linha.* FROM produto_tipo INNER JOIN produto_linha ON produto_tipo.produto_linha_id = produto_linha.produto_linha_id " & Busca & Ordenar
	  
	RS.cursorlocation = 3
	RS.Open SQL,Conn

	'FILTRAR
	If idCat <> 0 Then
		RS.Filter = "produto_linha_id LIKE '" & idCat & "'"
	End If

%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/style.css" rel="stylesheet" type="text/css">
<script src="../includes/java/scripts.js"></script>
<script src="../includes/java/makePop.js"></script>
<script>
	helpTXT =	'Gerencia os "Tipos de produto" listados no portal. É possível adicionar, excluir ou editar estas informações.<br>' +
				'As categorias listadas aqui estarão disponíveis no fomulário de inserção dos links.';
</script>
<script language="javascript" type="text/javascript">

function filtrar(quem) {

	if (quem != "0") {
		
		window.location.href = (quem != "todas") ? 
		"listar.asp?Palavra=<%= Palavra %>&Ordem=<%= Ordem %>&idCat=" + quem :
		"listar.asp?Palavra=<%= Palavra %>&Ordem=<%= Ordem %>&idCat=";
		
	}

}	

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
    <td>Tipos de produto</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
      <option value="1">Linha (a-z)</option>
      <option value="2">Linha (z-a)</option>
    </select>
<%

Set listRS = Server.CreateObject("Adodb.recordset")

	'FILTRO DE CATEGORIAS
	Response.Write "<select onChange='filtrar(this.value)' style='width: 180px;'>"
	Response.Write "<option value='0'>Filtrar por:</option>"
	
	listSQL = "SELECT * FROM produto_linha ORDER BY produto_linha_nome;"
	listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
			
			If listRS("produto_linha_id") = cInt(idCat) Then
				check = " selected style='background: #999999;'"
			Else
				check = ""
			End If
			
			Response.Write "<option value='" & listRS("produto_linha_id") & "'" & check & ">" & listRS("produto_linha_nome") & "</option>"
			
			listRS.MoveNext
		
		Loop
	
	listRS.Close
	
	Response.Write "<option value='todas'>Listar todas</option>"
	Response.Write "</select>"

Set listRS = Nothing

%></td>
    <td id="fim"></td>
    <td width="40" id="icon"><img src="../interface/icons_add.jpg" title="Adicionar item" onClick="itemAdd();"></td>
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
    <td><a class="infoTitle"><%= RS("produto_tipo_nome") %></a></td>
	<td id="divisor"></td>
	<td width="220"><a class="infoSub"><%= RS("produto_linha_nome") %></a></td>
    <td id="fim"></td>
    <td id="icon" width="120"><a href="ordem.asp?Id=<% =RS("produto_tipo_id") %>&Linha=<% =RS("produto_linha_id") %>&Ordem=<% =RS("produto_tipo_ordem") %>" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_ordem.jpg" title="Alterar ordem"></a><a href="javascript:subEditar(<%= contador %>,<%= RS("produto_tipo_id") %>)"><img src="../interface/icons_edit.jpg" title="Editar"></a><a href="../includes/msgPop.asp?Id=<% =RS("produto_tipo_id") %>&Linha=<% =RS("produto_linha_id") %>" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_del.jpg" title="Deletar"></a></td>
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
