<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<% Set listRS = Server.CreateObject("Adodb.recordset") %>
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
	
	var cidade = document.getElementById("cidade");
	var estado = document.getElementById("estado").options[document.getElementById("estado").selectedIndex].title;
	var local = document.getElementById("local");
	var target = document.getElementById("divList").getElementsByTagName("ul")[0] ;
	
	if (cidade.value > 0 && !document.getElementById(cidade.value)) {
		
		//cria texto do item
		var novoB = document.createElement("b");
			novoB.appendChild(document.createTextNode(estado + " | " + cidade.options[cidade.selectedIndex].text));
	
		//cria link para deletar
		var novoA = document.createElement("a");
			novoA.setAttribute("onclick","delCidade(this, " + cidade.value + ")");
			novoA.appendChild(document.createTextNode("remover"));
			
		//cria novo item
		var novoLi = document.createElement("li");
			novoLi.setAttribute("id", cidade.value)
			novoLi.appendChild(novoB);
			novoLi.appendChild(novoA);
		
		//insere item
		target.appendChild(novoLi);
		
		//salva cidade
		local.value += "#" + cidade.value;

	}
	
}

function delCidade(quem, cidade) {
	
	var local = document.getElementById("local");
	
	quem.parentNode.parentNode.removeChild(quem.parentNode);
	local.value = local.value.replace("#" + cidade, "");
	
	
}

</script>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
<tr>
<td id="inicio"></td>
  <td>Adicionar novo ítem</td>
  <td id="fim"></td>
  <td id="icon" width="40"><img src="../interface/icons_less.jpg" title="Voltar" onClick="parent.itemAdd()"></td>
</tr>
</table>
<form name="form" action="adiciona.asp" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this);">
      
 <table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_nome" class="itemEditar">Nome:</td>
              <td><input name="nome" type="text" class="inputEditar" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_endereco" class="itemEditar">Endereco:</td>
                <td><input name="endereco" type="text" class="inputEditar" /></td>
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
		
			Response.Write "<option value='" & listRS("cep_estado_id") & "' title='" & listRS("cep_estado_uf") & "'>" & listRS("cep_estado_nome") & "</option>"

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
            	<td><div id="divList"><ul></ul></div></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_email" class="itemEditar">E-mail:</td>
                <td><input name="email" type="text" class="inputEditar" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_fone" class="itemEditar">Fone:</td>
                <td><input name="fone" type="text" class="inputEditar" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_descricao" class="itemEditar">Descrição:</td>
                <td><textarea name="descricao" class="inputEditar" style="height: 100px;"></textarea></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
			</tr>
            <tr>
            <td>&nbsp;</td>
              <td><input name="alterar" type="submit" id="botao" value="adicionar dados" /></td>
            </tr>
      </table> 
	  <input type="hidden" name="local" id="local" />
</form>
</body>
</html>
<%
Set listRS = nothing

Conn.Close
Set Conn=nothing
%>