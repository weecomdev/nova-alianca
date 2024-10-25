<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set del = new cmsEngine

	del.Tabela = "agenda"
	del.Id = Request.Form("id")
	
	del.Deletar
	
Set del = Nothing

Set fso = Server.CreateObject("Scripting.FileSystemObject")
	fso.DeleteFolder Server.MapPath("../../imagens/galeria/" & Id), True
Set fso = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
