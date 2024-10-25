<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
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
formArray[1] = new Array ('linha', 3);

}

</script>

<% If Trim(Request.QueryString("Msg")) <> "" Then %>

	<script>
    
        function errorItem() {
        
            document.getElementsByTagName("input")[0].value = "<%= Trim(Request.QueryString("Nome")) %>";
            showImage("nome", true);
            document.getElementById("botao").value = "Este tipo já existe no sitema";
            
        }
        
        onload = errorItem;
    
    </script>

<% End If %>

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
<!-- Linhas do produto -->
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_linha" class="itemEditar">Linha:</td>
              <td><select name="linha">
                  <option value="0">Selecione a linha do produto</option>
<%

	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT * FROM produto_linha ORDER BY produto_linha_nome;"
		listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
			
			Response.Write "<option value='" & listRS("produto_linha_id") & "'>"
			Response.Write listRS("produto_linha_nome")
			Response.Write "</option>"

			listRS.MoveNext
	
		Loop

		listRS.Close
	Set listRS = nothing

%>
                </select></td>
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
Conn.Close
Set Conn=nothing
%>