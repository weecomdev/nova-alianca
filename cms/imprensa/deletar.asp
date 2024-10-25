<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set del = new cmsEngine

	del.Tabela = "imprensa"
	del.Id = Request.Form("id")
	
	del.Deletar
	
Set del = Nothing

call delArquivo("../../imagens/imprensa/" & Request.Form("id") & ".jpg")


%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>