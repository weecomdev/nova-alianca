<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set edit = new cmsEngine

	edit.Tabela = "cor"
	edit.Id = Request.Form("id")
	edit.Campos = Array("hexa")
	edit.Valores = Array( Request.Form("cor") )
	
	edit.Editar
	
Set edit = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
