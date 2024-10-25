<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set edit = new cmsEngine

	edit.Tabela = "endereco"
	edit.Id = Request.Form("id")
	edit.Campos = Array("nome", "rua", "bairro", "fone")
	edit.Valores = Array( Request.Form("nome"), Request.Form("rua"), Request.Form("bairro"), Request.Form("fone") )
	
	edit.Editar
	
Set edit = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
