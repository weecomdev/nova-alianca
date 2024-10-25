<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set add = new cmsEngine

	add.Tabela = "loja"
	add.Campos = Array("nome", "endereco", "[cep_cidade_id]", "email", "fone", "desc")
	add.Valores = Array( Upload.Form("nome"), Upload.Form("endereco"), Upload.Form("cidade"), Upload.Form("email"), Upload.Form("fone"), Upload.Form("descricao") )

	add.Adicionar
	
	novoId = add.novoId
	
Set add = Nothing

Set img = new cmsImagem

	img.addImg 1, 200, 160, "../../imagens/loja/", novoId
		
Set img = Nothing

%>

<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
