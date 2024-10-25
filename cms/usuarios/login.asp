<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%

Msg = Trim(Request.QueryString("Msg"))

%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/style.css" rel="stylesheet" type="text/css">
<script src="../includes/java/scripts.js"></script>
<script language="JavaScript" type="text/JavaScript">

function senha(quem) {

	checkTab = document.getElementById("centro").getElementsByTagName("table");

	for (var i = 0; i < checkTab.length; i++) {
		checkTab[i].style.display = (i == quem) ? "none" : "" ;
	}
	
	checkTab[quem].parentNode.action = (quem == 1) ? "senha.asp" : "logar.asp" ;
	
}

function validateForm(quem) {

	if (quem.action.search("senha.asp") == -1) {
		if (quem.login.value.length == 0 || quem.senha.value.length == 0) { return false; }
	}
	else {
		if (quem.email.value.length == 0) { return false; }
	}	

}

<%
If Trim(Request.QueryString("F")) <> "" Then
	Response.Write "onload = function() { senha(1) }"
End If
%>

</script>
</head>
<body>

<!--#include file="../includes/ssi/topo.asp" -->
<table id="layout" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="esquerda"><!--#include file="../includes/ssi/menu.asp" --></td>
    <td id="centro">
    
<form name="form" action="logar.asp" method="post" onSubmit="return validateForm(this);">
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
              <td><input name="login" type="text" class="inputEditar" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_senha" class="itemEditar">Senha:</td>
              <td><input name="senha" type="password" class="inputEditar" /></td>
            </tr>
                        <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
            </tr>
<tr>			
				<td id="td_botao"><a class="botao" href="javascript:senha(1)" title="Clique aqui para receber sua senha por e-mail">lembrar senha</a></td>
              <td> <input name="alterar" type="submit" id="botao" value="efetuar login" /></td>
            </tr>
      </table>

<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0" style="display: none;">
            <tr>
              <td id="td_email" class="itemEditar">Email:</td>
              <td><input name="email" type="text" class="inputEditar" /></td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
            </tr>
<tr>			
				<td id="td_botao"><a class="botao" href="javascript:senha(2)">voltar</a></td>
              <td> <input name="alterar" type="submit" id="botao" value="enviar senha por email" /></td>
            </tr>
      </table>

</form>
    </td>
    <td id="direita"><div></div></td>
  </tr>
</table>
<!--#include file="../includes/ssi/base.asp" -->
<bb1><!---1448657758---><bb2></body>
</html>
