<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.QueryString("Id"))

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM premio WHERE premio_id LIKE '" & Id & "';"
	RS.Open SQL,Conn,3,2

Set fso = CreateObject("Scripting.FileSystemObject")
%>
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
formArray[1] = new Array ('editBox', 6);

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
              <td id="td_nome" class="itemEditar">Título:</td>
              <td><input name="nome" type="text" class="inputEditar" value="<%= RS("premio_nome") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_data" class="itemEditar">Data:</td>
              <td id="dataIn"><a href="../includes/calendar.asp" target="innerFrame" onClick="showPop()"><input name="data" type="text" class="inputEditar" value="<%= RS("premio_data") %>" readonly /><input name="dataDesc" id="dataDesc" type="text" class="inputEditar" value="clique no botão ao lado para adiconar data" readonly /><img src="../interface/page_addDate.jpg" align="absmiddle" title="Inserir data"></a></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_editBox" class="itemEditar">Descrição:</td>
                <td>
            <div id="divEdit"></div>
            <iframe id="editorFrame" name="editor" frameborder="0"></iframe>                </td>
            </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_arquivo" class="itemEditar">Foto:</td>
              <td id="fotoCel">
<%
If fso.fileExists(Server.MapPath("../../imagens/premio/" & Id & ".jpg")) = True Then

	Set arquivo = FSO.GetFolder(Server.MapPath("../../imagens/premio/")).files.item(Id & ".jpg")
				
		zoomImg = "../../imagens/premio/" & Id & ".jpg"
				
		Response.Write "<div id='divEdit'>"
		Response.Write "<div id='desc'><strong>Adicionada em:</strong> " & arquivo.datelastmodified & "</div>"
		Response.Write "<a id='del' href='../includes/msgPop.asp?Id=" & Id & "&Engine=delFoto' target='innerFrame' onClick='showPop()' title='Excluir foto'></a>"
		Response.Write "<a id='zoom' href='../includes/showImage.asp?Imagem=" & zoomImg & "&Tamanho=340' target='innerFrame' onClick='showPop()' title='Vizualizar foto'></a>"
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
<div id="hideEdit"><textarea name="editBox"><%= RS("premio_desc") %></textarea></div>
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