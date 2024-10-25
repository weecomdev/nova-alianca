<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set edit = new cmsEngine

	edit.Tabela = "video_home"
	edit.Id = 1
	edit.Campos = Array("nome","desc")
	edit.Valores = Array( Upload.Form("nome"), Upload.Form("descricao") )
	
	edit.Editar
	
Set edit = Nothing

Set img = new cmsImagem

	img.addImg 2, 100, 80, "../../imagens/geral/", "video"
		
Set img = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
