<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

arrayLocal = Split(Upload.Form("local"), "#")

Set add = new cmsEngine

	add.Tabela = "representante"
	add.Campos = Array("nome", "endereco", "email", "fone", "desc")
	add.Valores = Array( Upload.Form("nome"), Upload.Form("endereco"), Upload.Form("email"), Upload.Form("fone"), Upload.Form("descricao") )

	add.Adicionar
	
	novoId = add.novoId

'----------------------------------------------------------------------'
		
	add.Tabela = "representante_local"

	For i = 1 To uBound(arrayLocal)
	
		add.Campos = Array("[representante_id]", "[cep_cidade_id]")
		add.Valores = Array(novoId, arrayLocal(i))
		add.Adicionar
	
	Next

Set add = Nothing

%>

<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>