<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set edit = new cmsEngine

	edit.Tabela = "loja"
	edit.Id = Upload.Form("id")
	edit.Campos = Array("nome", "endereco", "[cep_cidade_id]", "email", "fone", "desc")
	edit.Valores = Array( Upload.Form("nome"), Upload.Form("endereco"), Upload.Form("cidade"), Upload.Form("email"), Upload.Form("fone"), Upload.Form("descricao") )
	
	edit.Editar
	
Set edit = Nothing

Set img = new cmsImagem

	img.addImg 1, 200, 160, "../../imagens/loja/", Upload.Form("id")
		
Set img = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
