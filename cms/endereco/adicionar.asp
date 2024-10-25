<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<% Set listRS = Server.CreateObject("Adodb.recordset") %>
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
<table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
<tr>
<td id="inicio"></td>
  <td>Adicionar novo ítem</td>
  <td id="fim"></td>
  <td id="icon" width="40"><img src="../interface/icons_less.jpg" title="Voltar" onClick="parent.itemAdd()"></td>
</tr>
</table>
<form name="form" action="adiciona.asp" method="post" onSubmit="return validateForm(this);">
      
      <table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td id="td_nome" class="itemEditar">Nome:</td>
              <td><input name="nome" type="text" class="inputEditar" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_rua" class="itemEditar">Endereço:</td>
              <td><input name="rua" type="text" class="inputEditar" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_bairro" class="itemEditar">Bairro:</td>
              <td><input name="bairro" type="text" class="inputEditar" /></td>
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
			
			Response.Write "<option value='" & listRS("cep_estado_id") & "'>"
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
                  </select></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_fone" class="itemEditar">Fone:</td>
              <td><input name="fone" type="text" class="inputEditar" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
 		   </tr>
<tr>			
				<td>&nbsp;</td>
              <td> <input name="alterar" type="submit" id="botao" value="adicionar dados" /></td>
            </tr>
      </table>
</form>
</body>
</html>
<%
Set listRS = nothing

Conn.Close
Set Conn=nothing
%>