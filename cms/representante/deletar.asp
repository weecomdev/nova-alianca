<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set del = new cmsEngine

	del.Tabela = "representante"
	del.Id = Request.Form("id")
	
	del.Deletar
	
Set del = Nothing

call connOpen

	SQL = "DELETE FROM representante_local WHERE representante_id = " & Request.Form("id") & ";"
	RS = Conn.Execute(SQL)
	
call connClose

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>