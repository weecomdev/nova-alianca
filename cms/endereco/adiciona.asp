<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set add = new cmsEngine

	add.Tabela = "endereco"
	add.Campos = Array("nome", "rua", "bairro", "fone")
	add.Valores = Array( Request.Form("nome"), Request.Form("rua"), Request.Form("bairro"), Request.Form("fone") )
	
	add.Adicionar
	
Set add = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
