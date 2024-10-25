<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set add = new cmsEngine

	add.Tabela = "home"
	add.Campos = Array("nome","desc","ordem")
	add.Valores = Array( Upload.Form("nome"), Upload.Form("descricao"), add.totalRS + 1 )
	
	add.Adicionar
	
	novoId = add.novoId
	
Set add = Nothing

Set img = new cmsImagem

	img.addImg 2, 980, 420, "../../imagens/home/", novoId
		
Set img = Nothing

%>

<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
