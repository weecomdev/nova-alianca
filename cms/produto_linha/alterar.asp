<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set edit = new cmsEngine

	edit.Tabela = "produto_linha"
	edit.Id = Upload.Form("id")
	edit.Campos = Array("nome")
	edit.Valores = Array(Upload.Form("nome"))
	
	edit.Editar
	
Set edit = Nothing

Set img = new cmsImagem

	img.addImg 1, 440, 440, "../../imagens/produto_linha/", Upload.Form("id")
		
Set img = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
