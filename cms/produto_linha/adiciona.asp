<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set add = new cmsEngine

	add.Tabela = "produto_linha"
	add.Campos = Array("nome","ordem")
	add.Valores = Array(Upload.Form("nome"), add.totalRS + 1 )
	
	add.Adicionar
	
	novoId = add.novoId
	
Set add = Nothing

Set img = new cmsImagem

	img.addImg 1, 440, 440, "../../imagens/produto_linha/", novoId
		
Set img = Nothing

%>

<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
