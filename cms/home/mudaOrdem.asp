<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set edit = new cmsEngine

	edit.Tabela = "home"
	edit.Id = Request.Form("id")
	
	edit.Ordenar Request.QueryString("Acao")
	
Set edit = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>