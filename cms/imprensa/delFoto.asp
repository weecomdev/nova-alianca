<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call delArquivo("../../imagens/imprensa/" & Request.Form("id") & ".jpg")

%>
<script language="JavaScript" type="text/JavaScript">

	parent.fotoDel();

</script>