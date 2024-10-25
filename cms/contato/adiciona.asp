<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set add = new cmsEngine

	add.Tabela = "contato"
	add.Campos = Array("nome", "email")
	add.Valores = Array(Request.Form("nome"), Request.Form("email"))
	
	add.Adicionar
	
Set add = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
