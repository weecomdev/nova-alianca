<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.QueryString("Id"))

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM produto_linha WHERE produto_linha_id LIKE '" & Id & "';"
	RS.Open SQL,Conn,3,2

Set fso = CreateObject("Scripting.FileSystemObject")
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>produto_linha Administrativo</title>
<link href="../interface/innerStyle.css" rel="stylesheet" type="text/css">
<script src="../includes/java/checkForm.js"></script>
<script src="../includes/java/inner.js"></script>
<script language="JavaScript" type="text/JavaScript">

// CHECK FORM

function formCheck() {

formArray[0] = new Array ('nome', 1);

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
              <td><input name="nome" type="text" class="inputEditar" value="<%= RS("produto_linha_nome") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_arquivo" class="itemEditar">Foto:</td>
              <td id="fotoCel">
<%
If fso.fileExists(Server.MapPath("../../imagens/produto_linha/" & Id & ".jpg")) = True Then

	Set arquivo = FSO.GetFolder(Server.MapPath("../../imagens/produto_linha/")).files.item(Id & ".jpg")
				
		zoomImg = "../../imagens/produto_linha/" & Id & ".jpg"
				
		Response.Write "<div id='divEdit'>"
		Response.Write "<div id='desc'><strong>Adicionada em:</strong> " & arquivo.datelastmodified & "</div>"
		Response.Write "<a id='del' href='../includes/msgPop.asp?Id=" & Id & "&Engine=delFoto' target='innerFrame' onClick='showPop()' title='Excluir foto'></a>"
		Response.Write "<a id='zoom' href='../includes/showImage.asp?Imagem=" & zoomImg & "&Tamanho=100' target='innerFrame' onClick='showPop()' title='Vizualizar foto'></a>"
		Response.Write "<a id='change' href='javascript:fotoChange()' title='Alterar foto'></a>"
		Response.Write "</div>"
			
	Set arquivo = Nothing
	
Else

	Response.Write "<input name='arquivo' type='file' class='inputEditar' size='58' />"

End If
%>              </td>
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