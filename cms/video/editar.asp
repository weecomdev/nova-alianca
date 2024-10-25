<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.QueryString("Id"))

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM video WHERE video_id LIKE '" & Id & "';"
	RS.Open SQL,Conn,3,2

Set fso = CreateObject("Scripting.FileSystemObject")

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
formArray[1] = new Array ('url', 1);

}

</script>
</head>

<body>
<form name="form" action="alterar.asp" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this);">
<input type="hidden" name="id" value="<%= Id %>">
<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_nome" class="itemEditar">Nome:</td>
              <td><input name="nome" type="text" class="inputEditar" value="<%= RS("video_nome") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_url" class="itemEditar">URL:</td>
                <td><input name="url" type="text" class="inputEditar" value="http://www.youtube.com/watch?v=<%= RS("video_url") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_descricao" class="itemEditar">Descrição:</td>
                <td><textarea name="descricao" class="inputEditar" style="height: 100px;"><%= RS("video_desc") %></textarea></td>
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