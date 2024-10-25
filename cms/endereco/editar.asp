<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.QueryString("Id"))

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT endereco.*, cep_cidade.cep_cidade_nome AS endereco_cidade, cep_estado.cep_estado_uf " &_
		  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
		  "INNER JOIN endereco ON cep_cidade.cep_cidade_id = endereco.cep_cidade_id " &_
		  "WHERE endereco_id LIKE '" & Id & "';"
	RS.Open SQL,Conn,3,2
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/innerStyle.css" rel="stylesheet" type="text/css">
<script src="../includes/java/checkForm.js"></script>
<script src="../includes/java/inner.js"></script>
<script language="JavaScript" type="text/JavaScript">

// CHECK FORM

function formCheck() {

formArray[0] = new Array ('nome', 1);
formArray[1] = new Array ('rua', 1);
formArray[2] = new Array ('bairro', 1);
formArray[3] = new Array ('cidade', 1);
formArray[4] = new Array ('fone', 1);

}

</script>
</head>

<body>
<form name="form" action="alterar.asp" method="post" onSubmit="return validateForm(this);">
<input type="hidden" name="id" value="<%= RS("endereco_id") %>">
<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td id="td_nome" class="itemEditar">Nome:</td>
              <td><input name="nome" type="text" class="inputEditar" value="<%= RS("endereco_nome") %>" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_rua" class="itemEditar">Endereço:</td>
              <td><input name="rua" type="text" class="inputEditar" value="<%= RS("endereco_rua") %>" /></td>
            </tr>
<!-- Estados -->
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_estado" class="itemEditar">Estado:</td>
              <td><select name="estado" onChange="findCidade(this.value)">
                  <option value="0">Selecione o estado</option>
<%

	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT * FROM cep_estado ORDER BY cep_estado_nome;"
		listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
		
			If listRS("cep_estado_uf") = RS("cep_estado_uf") Then
				check = " selected"
			Else
				check = ""
			End If
			
			Response.Write "<option value='" & listRS("cep_estado_id") & "'" & check & ">"
			Response.Write listRS("cep_estado_nome")
			Response.Write "</option>"

			listRS.MoveNext
	
		Loop

		listRS.Close
	Set listRS = nothing

%>
                </select></td>
            </tr>
<!-- Cidades -->
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_cidade" class="itemEditar">Cidade:</td>
              <td><select name="cidade" id="cidade">
                  <option value="0">Selecione a cidade</option>
<%

	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT * FROM cep_cidade WHERE cep_estado_id = (SELECT cep_estado_id FROM cep_cidade WHERE cep_cidade_id = " & RS("cep_cidade_id") & ");"

		listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
		
			If listRS("cep_cidade_id") = RS("cep_cidade_id") Then
				check = " selected"
			Else
				check = ""
			End If
			
			Response.Write "<option value='" & listRS("cep_cidade_id") & "'" & check & ">"
			Response.Write listRS("cep_cidade_nome")
			Response.Write "</option>"

			listRS.MoveNext
	
		Loop

		listRS.Close
	Set listRS = nothing

%>
                </select></td>
            </tr>

            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_bairro" class="itemEditar">Bairro:</td>
              <td><input name="bairro" type="text" class="inputEditar" value="<%= RS("endereco_bairro") %>" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_fone" class="itemEditar">Fone:</td>
              <td><input name="fone" type="text" class="inputEditar" value="<%= RS("endereco_fone") %>" /></td>
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
RS.Close
Set RS = nothing

Conn.Close
Set Conn=nothing
%>