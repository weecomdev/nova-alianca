<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set add = new cmsEngine

	add.Tabela = "confraria"
	add.Campos = Array("nome","desc","post")
	add.Valores = Array( Upload.Form("nome"), Upload.Form("editBox"), Tempo(Now()) )
	
	add.Adicionar
	
	novoId = add.novoId
	
Set add = Nothing

Set img = new cmsImagem

	img.addImg 1, 440, 440, "../../imagens/confraria/", novoId
		
Set img = Nothing

%>

<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
