<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.QueryString("Id"))

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM representante WHERE representante_id LIKE '" & Id & "';"

	RS.Open SQL,Conn,3,2

Set fso = CreateObject("Scripting.FileSystemObject")
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/innerStyle.css" rel="stylesheet" type="text/css">
<style>

#tableForm Select { float: left; width: 160px; }
#tableForm A.add {
	float: left;
	display: block;
	width: 60px;
	height: 23px;
	line-height: 23px;
	font-size: 10px;
	font-weight: bold;
	color: #FFF;
	text-align: center;
	background: url(../interface/page_botao_bg.jpg) center no-repeat;
}

/*--------------------------------------------------------------------------------------------*/

#tableForm #divList {
	height: 120px;
	overflow-y: scroll;
}
#tableForm #divList * {
	margin: 0;
	padding: 0;
}
#tableForm #divList Ul {
	width: 350px;
	list-style: none;
	margin: 5px;
}
#tableForm #divList Ul Li {
	clear: both;
	display: block;
	width: 100%;
	height: 20px;
	line-height: 20px;
	font-size: 10px;
	border-bottom: 1px solid #999;
}
#tableForm #divList Ul Li B { float: left; width: 320px; overflow: hidden; }
#tableForm #divList Ul Li A {
	float: right;
	display: block;
	width: 15px;
	height: 15px;
	background: url(../interface/edit_foto_del.gif) center no-repeat;
	text-indent: -1000px;
	overflow: hidden;
	cursor: pointer;
}

</style>
<script src="../includes/java/checkForm.js"></script>
<script src="../includes/java/inner.js"></script>
<script language="JavaScript" type="text/JavaScript">

// CHECK FORM

function formCheck() {

formArray[0] = new Array ('nome', 1);
formArray[1] = new Array ('fone', 1);

}

</script>
<script language="JavaScript" type="text/JavaScript">

function addCidade() {
	
	var cidade = document.getElementById("cidade").value;
	var repId = document.getElementById("repId").value;
	
	if (cidade > 0 && !document.getElementById(cidade)) {
		
		xmlHttp = GetXmlHttpObject();
		xmlHttp.onreadystatechange = showAdd;
		xmlHttp.open("GET","ajaxLocal.asp?Id=" + repId + "&Cidade=" + cidade,true);
		xmlHttp.send(null);

	}
	
}

function delCidade(quem, local) {
	
	xmlHttp = GetXmlHttpObject();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
			quem.parentNode.parentNode.removeChild(quem.parentNode);
		}
	}
	xmlHttp.open("GET","ajaxLocal.asp?Local=" + local,true);
	xmlHttp.send(null);
	
}

function showAdd() {
	
	//div do painel
	var target = document.getElementById("divList").getElementsByTagName("ul")[0] ;
	
	//resposta do servidor
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		
		//busca resposta em XML		
		var resposta = xmlHttp.responseXML.documentElement;
		var local = resposta.getElementsByTagName('local');
		
		//caso haja local
		if (local.length > 0) {
			
			//valores dos nós
			var localId = local[0].getAttribute("id");
			var localCidade = local[0].getAttribute("cidade");
			var localTxt = local[0].firstChild.nodeValue;
			
			//cria texto do item
			var novoB = document.createElement("b");
				novoB.appendChild(document.createTextNode(localTxt));

			//cria link para deletar
			var novoA = document.createElement("a");
				novoA.setAttribute("onclick","delCidade(this, " + localId + ")");
				novoA.appendChild(document.createTextNode("remover"));
				
			//cria novo item
			var novoLi = document.createElement("li");
				novoLi.setAttribute("id", localCidade)
				novoLi.appendChild(novoB);
				novoLi.appendChild(novoA);
			
			//insere item
			target.appendChild(novoLi);
				
		}

	}

}


</script>
</head>

<body>
<form name="form" action="alterar.asp" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this);">
<input type="hidden" name="id" id="repId" value="<%= Id %>">
<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_nome" class="itemEditar">Nome:</td>
              <td><input name="nome" type="text" class="inputEditar" value="<%= RS("representante_nome") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_endereco" class="itemEditar">Endereco:</td>
                <td><input name="endereco" type="text" class="inputEditar" value="<%= RS("representante_endereco") %>" /></td>
            </tr>
<!-- Estados -->
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_cep" class="itemEditar">Locais:</td>
              <td><select name="estado" id="estado" onChange="findCidade(this.value)">
                  <option value="0">Selecione o estado</option>
<%

	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT * FROM cep_estado ORDER BY cep_estado_nome;"
		listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
		
			Response.Write "<option value='" & listRS("cep_estado_id") & "'>"
			Response.Write listRS("cep_estado_nome")
			Response.Write "</option>"

			listRS.MoveNext
	
		Loop

		listRS.Close
	Set listRS = nothing

%>
                </select>
				<select name="cidade" id="cidade">
                  <option value="0">Selecione a cidade</option>
                </select><a class="add" href="javascript:addCidade();">Adicionar</a></td>
            </tr>
			<tr>
				<td>&nbsp;</td>
            	<td>
<%
		
	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT representante_local.*, cep_estado.*, cep_cidade.*" &_
				  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
				  "INNER JOIN representante_local ON cep_cidade.cep_cidade_id = representante_local.cep_cidade_id " &_
				  "WHERE representante_local.representante_id = " & Id & " ORDER BY cep_estado_uf;"
		listRS.Open listSQL,Conn,3,2
		
		Response.Write "<div id='divList'>"
		Response.Write "<ul>"
		
		If Not listRS.EOF Then
					
			Do While Not listRS.EOF
				
				Response.Write "<li id='" & listRS("cep_cidade_id") &"'>"
				Response.Write "<b>" & listRS("cep_estado_uf") & " | " & listRS("cep_cidade_nome") & "</b>"
				Response.Write "<a onclick='delCidade(this, " & listRS("representante_local_id") &")'>remover</a>"
				Response.Write "</li>"
	
				listRS.MoveNext
			
			Loop
				
		End IF

		Response.Write "</ul>"		
		Response.Write "</div>"
			
		listRS.Close
	Set listRS = nothing

%>
				</td>
            </tr>

			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_email" class="itemEditar">E-mail:</td>
                <td><input name="email" type="text" class="inputEditar" value="<%= RS("representante_email") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_fone" class="itemEditar">Fone:</td>
                <td><input name="fone" type="text" class="inputEditar" value="<%= RS("representante_fone") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_descricao" class="itemEditar">Descrição:</td>
                <td><textarea name="descricao" class="inputEditar" style="height: 100px;"><%= RS("representante_desc") %></textarea></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
    </tr>
            <tr>
            <td>&nbsp;</td>
              <td><input name="alterar" type="submit" id="botao" value="alterar dados" /></td>
            </tr>
      </table> 
</form>
</body>
</html>
<%
Set fso = nothing
Set listRS = nothing

RS.Close
Set RS = nothing

Conn.Close
Set Conn=nothing
%>