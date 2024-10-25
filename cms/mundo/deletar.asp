<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set del = new cmsEngine

	del.Tabela = "mundo"
	del.Id = Request.Form("id")
	
	del.Deletar
	
Set del = Nothing

Set fso = Server.CreateObject("Scripting.FileSystemObject")

	fso.DeleteFolder Server.MapPath("../../arquivos/mundo/" & Request.Form("id")), True

Set fso = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>