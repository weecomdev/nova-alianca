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
	Busca = "WHERE produto_nome LIKE '%" & Palavra & "%' OR produto_desc LIKE '%" & Palavra & "%' "
End If

Select case Ordem
	Case 0
		Ordenar = "ORDER BY produto_tipo_nome, produto_ordem"
	Case 1
		Ordenar = "ORDER BY produto_tipo_nome, produto_ordem"
	Case 2
		Ordenar = "ORDER BY produto_tipo_nome DESC, produto_nome"
End Select

Set RS = Server.CreateObject("Adodb.recordset")
	SQL = "SELECT produto.*, produto_tipo.*, produto_linha.* " &_
		  "FROM (produto_tipo INNER JOIN produto_linha ON produto_tipo.produto_linha_id = produto_linha.produto_linha_id) " &_
		  "INNER JOIN produto ON produto_tipo.produto_tipo_id = produto.produto_tipo_id " &_
		  Busca & Ordenar
		  
	RS.cursorlocation = 3
	RS.Open SQL,Conn

	'FILTRAR
	If idCat <> 0 Then
		RS.Filter = "produto_tipo_id LIKE '" & idCat & "'"
	End If

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
	helpTXT =	'Gerencia a sessão "Produtos" listada no portal. É possível adicionar, excluir ou editar estas informações. ' +
				'Caso opte pela inserção de uma imagem, esta será redimencionada automaticamente.<br>' +
				'Os itens em destaque será os primeiros a serem listados.';
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
  	<!--<td width="80"><img src="../interface/icons_fotoEngine.jpg" width="80" height="40" title="Editar foto" onClick="itemAdd('../includes/engineEditar.asp');"></td>-->
  	<td id="inicio"></td>
    <td>Produtos</td>
    <td><select name="ordem" onChange="ordenar()">
      <option value="0" selected>Ordenar por:</option>
      <option value="1">Tipo (a-z)</option>
      <option value="2">Tipo (z-a)</option>
    </select><%

Set listRS = Server.CreateObject("Adodb.recordset")

	'FILTRO DE CATEGORIAS
	Response.Write "<select onChange='filtrar(this.value)' style='width: 180px;'>"
	Response.Write "<option value='0'>Filtrar por:</option>"
	
	listSQL = "SELECT produto_tipo.*, produto_linha.* FROM produto_tipo INNER JOIN produto_linha ON produto_tipo.produto_linha_id = produto_linha.produto_linha_id ORDER BY produto_linha_nome, produto_tipo_nome;"
	listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
			
			If listRS("produto_tipo_id") = cInt(idCat) Then
				check = " selected style='background: #999999;'"
			Else
				check = ""
			End If
			
			Response.Write "<option value='" & listRS("produto_tipo_id") & "'" & check & ">" & listRS("produto_linha_nome") & " > " & listRS("produto_tipo_nome") & "</option>"
			
			listRS.MoveNext
		
		Loop
	
	listRS.Close
	
	Response.Write "<option value='todas'>Listar todas</option>"
	Response.Write "</select>"

Set listRS = Nothing

%></td>
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


If fso.fileExists(Server.MapPath("../../imagens/produto/thumb_" & cStr(RS("produto_id")) & ".jpg")) = True Then
	thumbImg = "../../imagens/produto/thumb_" & cStr(RS("produto_id")) & ".jpg"
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
    	<a class="infoTitle"><strong><%= RS("produto_ordem")%>º</strong> - <%= RS("produto_nome")%></a>
        <a class="infoSub"><%= RS("produto_linha_nome") %> | <%= RS("produto_tipo_nome") %><br><strong>Data de postagem:</strong> <% =RS("produto_post") %></a>
    </td>
    <td id="fim"></td>
    <td id="icon" width="80"><a href="ordem.asp?Id=<% =RS("produto_id") %>&Linha=<% =RS("produto_tipo_id") %>&Ordem=<% =RS("produto_ordem") %>" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_ordem.jpg" title="Alterar ordem"></a><a href="javascript:subEditar(<%= contador %>,<%= RS("produto_id") %>)"><img src="../interface/icons_edit.jpg" title="Editar"></a><a><img src="../interface/icons_no.jpg"></a><a href="../includes/msgPop.asp?Id=<% =RS("produto_id") %>&Linha=<% =RS("produto_tipo_id") %>" target="msgPop" onClick="showPop(event)"><img src="../interface/icons_del.jpg" title="Deletar"></a></td>
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
