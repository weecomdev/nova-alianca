<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

call connOpen

	SQL = "SELECT COUNT(produto_id) AS total FROM produto WHERE produto_tipo_id = " & Upload.Form("tipo") & ";"
	RS.Open SQL,Conn
	
		Total = cInt(RS("total"))

	RS.Close

call connClose


Set add = new cmsEngine

	add.Tabela = "produto"
	add.Campos = Array("nome", "tipo_id", "desc", "post","ordem")
	add.Valores = Array( Upload.Form("nome"), Upload.Form("tipo"), Upload.Form("editBox"), Tempo(Now()), Total + 1 )
	
	add.Adicionar
	
	novoId = add.novoId
	
Set add = Nothing

Set img = new cmsImagem

	img.addImg 3, 940, 450, "../../imagens/produto/", novoId
	img.addImg 1, 150, 240, "../../imagens/produto/", "thumb_" & novoId
		
Set img = Nothing

%>

<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
