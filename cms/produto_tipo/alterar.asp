<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

If Request.Form("linha") <> Request.Form("checkLinha") Then

	call connOpen
	
		SQL = "SELECT COUNT(produto_tipo_id) AS total FROM produto_tipo WHERE produto_linha_id = " & Request.Form("linha") & ";"
		RS.Open SQL,Conn
		
			Total = cInt(RS("total")) + 1
	
		RS.Close
	
	call connClose
	
	arrayCampos = Array("nome", "[produto_linha_id]", "ordem")
	arrayValores = Array(Request.Form("nome"), Request.Form("linha"), Total)
	
Else

	arrayCampos = Array("nome", "[produto_linha_id]")
	arrayValores = Array(Request.Form("nome"), Request.Form("linha"))
	
End If

Set edit = new cmsEngine

	edit.Tabela = "produto_tipo"
	edit.Id = Request.Form("id")
	edit.Campos = arrayCampos
	edit.Valores = arrayValores
	
	edit.Editar
	
Set edit = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
