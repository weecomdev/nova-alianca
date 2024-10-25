<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<% Engine = Split(Split(Request.ServerVariables("HTTP_REFERER"), "/listar.asp")(0), "cms/")(1) %>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/innerStyle.css" rel="stylesheet" type="text/css">
<script src="java/checkForm.js"></script>
<script src="java/inner.js"></script>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
<tr>
<td id="inicio"></td>
  <td>Alterar imagem da seção</td>
  <td id="fim"></td>
  <td id="icon" width="40"><img src="../interface/icons_less.jpg" title="Voltar" onClick="parent.itemAdd()"></td>
</tr>
</table>
<form name="form" action="engineAlterar.asp?Engine=<%= Engine %>" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this);">
<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_arquivo" class="itemEditar">Foto:</td>
              <td id="fotoCel">
<%
	Set fso = CreateObject("Scripting.FileSystemObject")
	
		If fso.fileExists(Server.MapPath("../../imagens/engine/" & Engine & ".jpg")) = True Then
		
			Set arquivo = FSO.GetFolder(Server.MapPath("../../imagens/engine/")).files.item(Engine & ".jpg")
						
				zoomImg = "../../imagens/engine/" & Engine & ".jpg"
						
				Response.Write "<div id='divEdit'>"
				Response.Write "<div id='desc'><strong>Adicionada em:</strong> " & arquivo.datelastmodified & "</div>"
				Response.Write "<a id='del' href='../includes/msgPop.asp?Id=" & Id & "&Engine=delFoto' target='innerFrame' onClick='showPop()' title='Excluir foto'></a>"
				Response.Write "<a id='zoom' href='../includes/showImage.asp?Imagem=" & zoomImg & "&Tamanho=120' target='innerFrame' onClick='showPop()' title='Vizualizar foto'></a>"
				Response.Write "<a id='change' href='javascript:fotoChange()' title='Alterar foto'></a>"
				Response.Write "</div>"
					
			Set arquivo = Nothing
			
		Else
		
			Response.Write "<input name='arquivo' type='file' class='inputEditar' size='58' />"
		
		End If
		
	Set fso = Nothing
%>
              </td>
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
