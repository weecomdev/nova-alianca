<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/checkUser.asp" -->
<!--#include file="../includes/conecta.asp" -->
<%
Msg = Trim(Request.QueryString("Msg"))
Id = Session("userId")

Set RS=Server.CreateObject("Adodb.recordset")
SQL = "SELECT * FROM usuario WHERE usuario_id LIKE '" & Id & "'"
RS.Open SQL,Conn,3,2
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/style.css" rel="stylesheet" type="text/css">
<script src="../includes/java/scripts.js"></script>
<script src="../includes/java/checkForm.js"></script>
<script language="JavaScript" type="text/JavaScript">

// CHECK FORM
function formCheck() {

formArray[0] = new Array ('login', 1);
formArray[1] = new Array ('senha', 'f.senha.value.length < 1 || f.senha.value.length != f.senha2.value.length');
formArray[2] = new Array ('senha2', 'f.senha2.value.length < 1 || f.senha.value.length != f.senha2.value.length');
formArray[3] = new Array ('nome', 1);
formArray[4] = new Array ('email', 2);

}

</script>
<script>
	helpTXT =	'Esta sessão altera os dados de acesso ao painel administrativo do portal. É possível editar seu "login" e "senha".<br>' +
				'Preencha corretamente seu e-mail pois este será usado caso a senha seja esquecida.';
</script>
</head>
<body>

<!--#include file="../includes/ssi/topo.asp" -->
<table id="layout" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="esquerda"><!--#include file="../includes/ssi/menu.asp" --></td>
    <td id="centro">
    
<form name="form" action="alterar.asp" method="post" onSubmit="return validateForm(this);">
<div id="divAdd"></div>
<table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
  <tr>
  	<td id="inicio"></td>
    <td>Identificação de usuário</td>
<%
If Msg <> "" Then 
	Response.Write "<td id='divisor'></td>"
    Response.Write "<td align='center' width='140'><b>" & Msg & "</b></td>"
End If
%>
    <td id="fim"></td>
  </tr>
</table>

<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td id="td_login" class="itemEditar">Login:</td>
              <td><input name="login" type="text" class="inputEditar" value="<%= RS("usuario_login") %>" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_senha" class="itemEditar">Senha:</td>
              <td><input name="senha" type="password" class="inputEditar" value="<%= RS("usuario_senha") %>" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_senha2" class="itemEditar">Repita a senha:</td>
              <td><input name="senha2" type="password" class="inputEditar" value="<%= RS("usuario_senha") %>" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
            </tr>
            <tr>
              <td id="td_nome" class="itemEditar">Nome:</td>
              <td><input name="nome" type="text" class="inputEditar" value="<%= RS("usuario_nome") %>" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_email" class="itemEditar">Email:</td>
              <td><input name="email" type="text" class="inputEditar" value="<%= RS("usuario_email") %>" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
            </tr>
<tr>			
				<td>&nbsp;</td>
              <td> <input name="alterar" type="submit" id="botao" value="alterar dados" /></td>
            </tr>
      </table>


</form>
    </td>
    <td id="direita"><div></div></td>
  </tr>
</table>
<!--#include file="../includes/ssi/base.asp" -->
</body>
</html>
<%
RS.Close
Set RS = nothing

Conn.Close
Set Conn=nothing
%>
