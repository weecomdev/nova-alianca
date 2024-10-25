<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call connOpen

	SQL = "SELECT COUNT(produto_tipo_id) AS total FROM produto_tipo WHERE produto_linha_id = " & Request.Form("linha") & ";"
	RS.Open SQL,Conn
	
		Total = cInt(RS("total"))

	RS.Close

call connClose


Set add = new cmsEngine

	add.Tabela = "produto_tipo"
	add.Campos = Array("nome", "[produto_linha_id]","ordem")
	add.Valores = Array(Request.Form("nome"), Request.Form("linha"), Total + 1)
	
	add.Adicionar
	
Set add = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
