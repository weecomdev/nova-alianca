<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Set edit = new cmsEngine

	edit.Tabela = "representante"
	edit.Id = Upload.Form("id")
	edit.Campos = Array("nome", "endereco", "email", "fone", "desc")
	edit.Valores = Array( Upload.Form("nome"), Upload.Form("endereco"), Upload.Form("email"), Upload.Form("fone"), Upload.Form("descricao") )
	
	edit.Editar
	
Set edit = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
