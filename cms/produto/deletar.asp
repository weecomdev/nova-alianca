<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set del = new cmsEngine

	del.Tabela = "produto"
	del.Id = Request.Form("id")
	
	del.Deletar
	
	del.ordemFiltro = "produto_tipo_id = " & Request.Form("linha")
	del.Ordenar "refazer"
	
Set del = Nothing

call delArquivo("../../imagens/produto/" & Request.Form("id") & ".jpg")


%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>