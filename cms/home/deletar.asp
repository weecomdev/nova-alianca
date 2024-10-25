<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set del = new cmsEngine

	del.Tabela = "home"
	del.Id = Request.Form("id")
	
	del.Deletar
	del.Ordenar "refazer"
	
Set del = Nothing

call delArquivo("../../imagens/home/" & Request.Form("id") & ".jpg")

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>