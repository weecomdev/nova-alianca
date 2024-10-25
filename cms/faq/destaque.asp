<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set dest = new cmsEngine

	dest.Tabela = "faq"
	dest.Id = Trim(Request.Form("id"))
	
	dest.Destaque
	
Set dest = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
