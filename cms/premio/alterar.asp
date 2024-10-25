<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set edit = new cmsEngine

	edit.Tabela = "premio"
	edit.Id = Upload.Form("id")
	edit.Campos = Array("nome", "data", "desc")
	edit.Valores = Array( Upload.Form("nome"), Tempo(Upload.Form("data")), Upload.Form("editBox") )
	
	edit.Editar
	
Set edit = Nothing

Set img = new cmsImagem

	img.addImg 1, 440, 440, "../../imagens/premio/", Upload.Form("id")
		
Set img = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
