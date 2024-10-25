<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Id = Split(Request.ServerVariables("HTTP_REFERER"), "Id=")(1)
pastaUpload = "../../arquivos/download/" & Id

call upOpen

Set edit = new cmsEngine

	edit.Tabela = "download"
	edit.Id = Upload.Form("id")
	edit.Campos = Array("nome","desc")
	edit.Valores = Array( Upload.Form("nome"), Upload.Form("descricao") )
	
	edit.Editar
	
Set edit = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
