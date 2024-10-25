<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="engines/functions.asp" -->
<%

call upOpen

Set img = new cmsImagem

	img.addImg 1, 440, 440, "../../imagens/engine/", Trim(Request.QueryString("Engine"))
		
Set img = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
