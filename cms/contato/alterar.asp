<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set edit = new cmsEngine

	edit.Tabela = "contato"
	edit.Id = Request.Form("id")
	edit.Campos = Array("nome", "email")
	edit.Valores = Array(Request.Form("nome"), Request.Form("email"))
	
	edit.Editar
	
Set edit = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
