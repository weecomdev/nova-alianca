<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<% Set listRS = Server.CreateObject("Adodb.recordset") %>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/innerStyle.css" rel="stylesheet" type="text/css">
<script src="../includes/java/editor.js"></script>
<script src="../includes/java/checkForm.js"></script>
<script src="../includes/java/inner.js"></script>
<script language="JavaScript" type="text/JavaScript">

// CHECK FORM

function formCheck() {

formArray[0] = new Array ('nome', 1);
formArray[1] = new Array ('tipo', 3);
formArray[2] = new Array ('editBox', 6);

}

</script>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
<tr>
<td id="inicio"></td>
  <td>Adicionar novo �tem</td>
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
              <td id="td_nome" class="itemEditar">T�tulo:</td>
              <td><input name="nome" type="text" class="inputEditar" /></td>
            </tr>
<!-- Tipos de produto -->
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_tipo" class="itemEditar">Linha/Tipo:</td>
              <td><select name="tipo">
                  <option value="0">Selecione o tipo do produto</option>
<%

	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT produto_tipo.*, produto_linha.* FROM produto_tipo INNER JOIN produto_linha ON produto_tipo.produto_linha_id = produto_linha.produto_linha_id;"
		listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
		
			Response.Write "<option value='" & listRS("produto_tipo_id") & "'>"
			Response.Write listRS("produto_linha_nome") & " > " & listRS("produto_tipo_nome")
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
                <td id="td_editBox" class="itemEditar">Descri��o:</td>
                <td>
            <div id="divEdit"></div>
            <iframe id="editorFrame" name="editor" frameborder="0"></iframe>                </td>
            </tr>
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_arquivo" class="itemEditar">Foto:</td>
              <td><input name="arquivo" type="file" class="inputEditar" size="58" /></td>
            </tr>

            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
    </tr>
            <tr>
            <td>&nbsp;</td>
              <td><input name="alterar" type="submit" id="botao" value="adicionar dados" /></td>
            </tr>
      </table> 
<div id="hideEdit"><textarea name="editBox"></textarea></div>
</form>
</body>
</html>
<%

Set listRS = nothing

Conn.Close
Set Conn=nothing
%>